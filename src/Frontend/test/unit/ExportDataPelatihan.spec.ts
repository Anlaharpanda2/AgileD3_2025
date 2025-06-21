import { describe, it, expect, vi, beforeEach } from 'vitest'
import { mount } from '@vue/test-utils'
import FormExportDataPelatihan from '../../src/components/KelolaDataPelatihan/FormExportDataPelatihan.vue'

// Mock eksternal dependencies

// Mock global fetch for Word export (bypass image fetch errors)
(global as any).fetch = vi.fn().mockResolvedValue({
  arrayBuffer: () => Promise.resolve(new Uint8Array([0]).buffer),
  ok: true
})
vi.mock('file-saver', () => ({ saveAs: vi.fn() }))
vi.mock('xlsx', async (importOriginal) => {
  const actual = await importOriginal()
  return {
    ...actual,
    write: vi.fn().mockReturnValue(new Uint8Array([1,2,3])),
    utils: {
      ...actual.utils,
      aoa_to_sheet: vi.fn(),
      book_new: vi.fn(),
      book_append_sheet: vi.fn(),
    }
  }
})
vi.mock('element-plus', () => ({ ElNotification: vi.fn() }))
// Fix parentheses count in jsPDF mock
vi.mock('jspdf', () => ({
  default: vi.fn().mockImplementation(() => ({
    internal: { pageSize: { getWidth: () => 100, getHeight: () => 50 } },
    text: vi.fn(),
    addImage: vi.fn(),
    save: vi.fn(),
    splitTextToSize: () => ['chunk']
  }))
}))
// Correct mock for jsPDF-AutoTable
vi.mock('jspdf-autotable', () => ({ default: vi.fn() }))
vi.mock('docx', async (importOriginal) => {
  const actual = await importOriginal()
  return {
    ...actual,
    Packer: { toBlob: vi.fn().mockResolvedValue(new Blob()) }
  }
})

describe('FormExportDataPelatihan.vue', () => {
  let wrapper: ReturnType<typeof mount>
  const sampleData = [{ nama: 'Alice', nik: '123' }]

  beforeEach(() => {
    wrapper = mount(FormExportDataPelatihan, { props: { data: sampleData } })
  })

  it('memanggil fungsi Excel export saat tombol Excel diklik', async () => {
    const buttons = wrapper.findAll('button')
    const excelBtn = buttons.find(btn => btn.text() === 'Export Excel')
    expect(excelBtn).toBeDefined()

    await excelBtn!.trigger('click')

    const { saveAs } = await import('file-saver')
    const xlsx = await import('xlsx')
    expect(xlsx.utils.aoa_to_sheet).toHaveBeenCalled()
    expect(xlsx.utils.book_new).toHaveBeenCalled()
    expect(xlsx.utils.book_append_sheet).toHaveBeenCalled()
    expect(xlsx.write).toHaveBeenCalled()
    expect(saveAs).toHaveBeenCalled()
  })

  it('menampilkan notifikasi ketika judul kosong saat export PDF', async () => {
    const buttons = wrapper.findAll('button')
    const pdfBtn = buttons.find(btn => btn.text() === 'Export PDF')
    expect(pdfBtn).toBeDefined()

    await pdfBtn!.trigger('click')

    const { ElNotification } = await import('element-plus')
    expect(ElNotification).toHaveBeenCalledWith({ message: 'Judul tidak boleh kosong!', type: 'warning', duration: 3000 })
  })

  it('memanggil pembuatan Word ketika judul diisi dan tombol Word diklik', async () => {
    // Set judul
    await wrapper.find('input#judul').setValue('Laporan')
    const buttons = wrapper.findAll('button')
    const wordBtn = buttons.find(btn => btn.text() === 'Export Word')
    expect(wordBtn).toBeDefined()

    await wordBtn!.trigger('click')

    const { saveAs } = await import('file-saver')
    const { Packer } = await import('docx')
    expect(Packer.toBlob).toHaveBeenCalled()
    expect(saveAs).toHaveBeenCalled()
  })
})
