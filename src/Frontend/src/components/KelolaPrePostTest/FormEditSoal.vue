<script setup>
import { reactive, ref, watch } from 'vue'
import api from '@/api.js'
import { ElNotification } from 'element-plus'

const props = defineProps({
  initialData: Object
})

const emit = defineEmits(['close'])

const formRef = ref(null)

const form = reactive({
  pertanyaan: '',
  pilihan: ['', '', '', ''], // 4 opsi
  jawaban_benar: '',
  jenis: '', // pretest atau postest
  ...props.initialData
})

watch(() => props.initialData, (newVal) => {
  if (newVal) {
    form.pertanyaan = newVal.pertanyaan || ''
    form.pilihan = JSON.parse(newVal.pilihan || '[]')
    form.jawaban_benar = newVal.jawaban_benar || ''
    form.jenis = newVal.jenis || ''
    form.id = newVal.id
  }
})

const rules = {
  pertanyaan: [{ required: true, message: 'Pertanyaan wajib diisi', trigger: 'blur' }],
  pilihan: [
    {
      validator: (rule, value, callback) => {
        if (value.some(v => !v)) callback(new Error('Semua opsi harus diisi'))
        else callback()
      },
      trigger: 'blur'
    }
  ],
  jawaban_benar: [{ required: true, message: 'Jawaban benar wajib diisi', trigger: 'blur' }],
  jenis: [{ required: true, message: 'Jenis soal wajib dipilih', trigger: 'change' }],
}

const submitForm = () => {
  formRef.value.validate(async (valid) => {
    if (!valid) {
      ElNotification({
        title: 'Validasi Gagal',
        message: 'Periksa kembali data input.',
        type: 'warning',
        duration: 3000,
      })
      return
    }

    try {
      const payload = {
        pertanyaan: form.pertanyaan,
        pilihan: form.pilihan,
        jawaban_benar: form.jawaban_benar,
        jenis: form.jenis
      }

      const response = await api.put(`/kelola/prepost/${form.id}`, payload)

      ElNotification({
        title: 'Berhasil',
        message: response.data.message || 'Soal berhasil diperbarui',
        type: 'success',
        duration: 3000,
      })

      window.location.reload()
      emit('close')
    } catch (error) {
      ElNotification({
        title: 'Gagal',
        message: error.response?.data?.message || 'Gagal memperbarui soal',
        type: 'error',
        duration: 0,
      })
    }
  })
}
</script>

<template>
  <div class="form-overlay">
    <transition name="popup">
      <div class="form-popup">
        <div class="form-header background text-center text-white py-3 rounded-top">
          <h3 class="mb-0">Form Edit Soal</h3>
        </div>

        <div class="form-body">
          <el-form
            :model="form"
            :rules="rules"
            ref="formRef"
            label-position="top"
            class="p-4"
          >
            <el-form-item label="Jenis Soal" prop="jenis" required>
              <el-select v-model="form.jenis" placeholder="Pilih jenis soal" class="w-100">
                <el-option label="Pretest" value="pretest" />
                <el-option label="Postest" value="postest" />
              </el-select>
            </el-form-item>

            <el-form-item label="Pertanyaan" prop="pertanyaan" required>
              <el-input v-model="form.pertanyaan" placeholder="Masukkan pertanyaan" type="textarea" />
            </el-form-item>

            <el-form-item label="Pilihan Jawaban" prop="pilihan" required>
              <el-input v-for="(opsi, index) in form.pilihan" :key="index" v-model="form.pilihan[index]" :placeholder="'Opsi ' + String.fromCharCode(65 + index)" class="mb-2" />
            </el-form-item>

            <el-form-item label="Jawaban Benar" prop="jawaban_benar" required>
              <el-select v-model="form.jawaban_benar" placeholder="Pilih jawaban benar" class="w-100">
                <el-option
                  v-for="(opsi, index) in form.pilihan"
                  :key="index"
                  :label="opsi"
                  :value="opsi"
                />
              </el-select>
            </el-form-item>

            <el-form-item class="d-flex justify-content-end gap-3 mt-4">
              <el-button @click="$emit('close')" class="btn-cancel">Batal</el-button>
              <el-button type="primary" @click="submitForm" class="btn-submit">Simpan</el-button>
            </el-form-item>
          </el-form>
        </div>
      </div>
    </transition>
  </div>
</template>
