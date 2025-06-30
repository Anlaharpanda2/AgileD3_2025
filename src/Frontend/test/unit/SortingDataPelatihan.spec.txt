import { describe, it, expect, vi } from 'vitest'
import { mount } from '@vue/test-utils'
import FormSortingDataPelatihan from '../../src/components/KelolaDataPelatihan/FormSortingDataPelatihan.vue'

const stubs = {
  'el-form': true,
  'el-form-item': true,
  'el-select': true,
  'el-option': true,
  'el-radio-group': true,
  'el-radio': true,
  'el-button': true,
}

describe('Integration Test: SortingDataPelatihan.vue', () => {
  const mockData = [
    { nama: 'Budi', umur: 30 },
    { nama: 'Andi', umur: 25 },
    { nama: 'Citra', umur: 35 },
  ]

  const factory = () =>
    mount(FormSortingDataPelatihan, {
      props: {
        visible: true,
        columns: ['nama', 'umur'],
        data: [...mockData],
      },
      global: {
        stubs,
      },
    })

  // TI-A: formatLabel → applySort → closeForm
  it('Format label sebelum sort', async () => {
    const wrapper = factory()
    const label = wrapper.vm.formatLabel('nama')
    expect(label).toBe('Nama')

    wrapper.vm.form.column = 'nama'
    wrapper.vm.form.order = 'asc'

    await wrapper.vm.applySort()
    expect(wrapper.emitted()['update:visible']).toBeTruthy()
    expect(wrapper.emitted()['update:visible']?.[0]).toEqual([false])

    expect(wrapper.emitted()['apply-sort']).toBeTruthy()
  })

  // TI-B: applySort gagal (no column) → cancelSort → closeForm
  it('Apply sort gagal lalu batal', async () => {
    const wrapper = factory()
    wrapper.vm.form.column = ''

    const warnSpy = vi.spyOn(console, 'warn').mockImplementation(() => {})
    await wrapper.vm.applySort()
    expect(warnSpy).toHaveBeenCalledWith('Kolom pengurutan belum dipilih.')

    await wrapper.vm.cancelSort()
    expect(wrapper.vm.form.column).toBe('')
    expect(wrapper.emitted()['cancel-sort']).toBeTruthy()
    expect(wrapper.emitted()['update:visible']?.[0][0]).toBe(false)

    warnSpy.mockRestore()
  })

  // TI-C: formatLabel → cancelSort → closeForm
  it('Format label, lalu batal', async () => {
    const wrapper = factory()
    const label = wrapper.vm.formatLabel('umur')
    expect(label).toBe('Umur')

    await wrapper.vm.cancelSort()
    expect(wrapper.vm.form.column).toBe('')
    expect(wrapper.emitted()['cancel-sort']).toBeTruthy()
    expect(wrapper.emitted()['update:visible']?.[0][0]).toBe(false)
  })
})
