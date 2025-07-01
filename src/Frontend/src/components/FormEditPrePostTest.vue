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
            <el-row :gutter="20">
              <el-col :span="24" v-for="field in fields" :key="field.key" class="mb-3">
                <el-form-item :label="field.label" :prop="field.key" required>
                  <component
                    :is="field.component"
                    v-model="form[field.key]"
                    :placeholder="field.label"
                    clearable
                    class="w-100"
                  />
                </el-form-item>
              </el-col>
            </el-row>

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

<script setup>
import { reactive, ref, watch } from 'vue'
import api from '../api.js'
import { ElNotification } from 'element-plus'

const props = defineProps({
  initialData: Object
})

const emit = defineEmits(['close'])

const formRef = ref(null)

const fields = [
  { key: 'soal', label: 'Soal', component: 'el-input' },
  { key: 'opsi_a', label: 'Opsi A', component: 'el-input' },
  { key: 'opsi_b', label: 'Opsi B', component: 'el-input' },
  { key: 'opsi_c', label: 'Opsi C', component: 'el-input' },
  { key: 'opsi_d', label: 'Opsi D', component: 'el-input' },
  { key: 'jawaban', label: 'Jawaban Benar', component: 'el-input' },
]

const form = reactive({
  soal: '',
  opsi_a: '',
  opsi_b: '',
  opsi_c: '',
  opsi_d: '',
  jawaban: '',
  ...props.initialData
})

watch(() => props.initialData, (newVal) => {
  Object.assign(form, newVal)
})

const rules = {
  soal: [{ required: true, message: 'Soal wajib diisi', trigger: 'blur' }],
  opsi_a: [{ required: true, message: 'Opsi A wajib diisi', trigger: 'blur' }],
  opsi_b: [{ required: true, message: 'Opsi B wajib diisi', trigger: 'blur' }],
  opsi_c: [{ required: true, message: 'Opsi C wajib diisi', trigger: 'blur' }],
  opsi_d: [{ required: true, message: 'Opsi D wajib diisi', trigger: 'blur' }],
  jawaban: [{ required: true, message: 'Jawaban wajib diisi', trigger: 'blur' }],
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
      const response = await api.put(`/kelola/prepost/${form.id}`, form)

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

<style scoped>
.background {
  background: #69C5C2;
}
.form-overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(2px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1050;
  padding: 1rem;
}
.form-popup {
  width: 100%;
  max-width: 850px;
  max-height: 95vh;
  background-color: #ffffff;
  border-radius: 1rem;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
  display: flex;
  flex-direction: column;
  animation: popupIn 0.3s ease;
  overflow: hidden;
}
.form-body {
  overflow-y: auto;
  padding: 1rem;
}
.btn-submit {
  background-color: #69C5C2;
  border: none;
  color: white;
  padding: 0.5rem 1.5rem;
  border-radius: 6px;
  transition: background-color 0.2s ease;
}
.btn-submit:hover {
  background-color: #1e8e86;
}
.btn-cancel {
  background-color: #eeeeee;
  color: #333;
  padding: 0.5rem 1.2rem;
  border-radius: 6px;
  transition: background-color 0.2s ease;
}
.btn-cancel:hover {
  background-color: #dddddd;
}
@keyframes popupIn {
  from {
    opacity: 0;
    transform: scale(0.92);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
</style>
