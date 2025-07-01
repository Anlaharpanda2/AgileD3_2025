<template>
  <div class="form-overlay">
    <transition name="popup">
      <div class="form-popup">
        <div class="form-header background text-center text-white py-3 rounded-top">
          <h3 class="mb-0">Form Pre/Post Test</h3>
        </div>

        <div class="form-body">
          <el-form
            :model="form"
            :rules="rules"
            ref="formRef"
            label-width="140px"
            label-position="top"
            class="p-4"
          >
            <el-row :gutter="20">
              <el-col
                v-for="field in fields"
                :key="field.key"
                :span="24"
                :md="12"
                class="mb-3"
              >
                <el-form-item
                  :label="field.label"
                  :prop="field.key"
                  required
                >
                  <component
                    :is="field.component"
                    v-model="form[field.key]"
                    :placeholder="field.label"
                    :type="field.type"
                    :id="field.key"
                    :name="field.key"
                    clearable
                    class="form-control"
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
  max-width: 750px;
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

<script setup>
import { reactive, ref } from 'vue'
import api from '../api'
import { ElNotification } from 'element-plus'

const props = defineProps({
  initialData: Object,
  pelatihanId: Number,
  type: {
    type: String,
    default: 'pretest', // atau 'posttest'
  },
})

const emit = defineEmits(['close'])

const formRef = ref(null)

const form = reactive({
  nama: '',
  nilai: '',
  keterangan: '',
  ...props.initialData,
})

const fields = [
  { key: 'nama', label: 'Nama Peserta', component: 'el-input', type: 'text' },
  { key: 'nilai', label: 'Nilai', component: 'el-input', type: 'number' },
  { key: 'keterangan', label: 'Keterangan', component: 'el-input', type: 'text' },
]

const rules = {
  nama: [{ required: true, message: 'Nama wajib diisi', trigger: 'blur' }],
  nilai: [{ required: true, message: 'Nilai wajib diisi', trigger: 'blur' }],
  keterangan: [{ required: true, message: 'Keterangan wajib diisi', trigger: 'blur' }],
}

const submitForm = () => {
  formRef.value.validate(async (valid) => {
    if (!valid) {
      ElNotification({
        title: 'Validasi gagal',
        message: 'Periksa input form anda.',
        type: 'warning',
        duration: 3000,
      })
      return
    }

    try {
      const payload = {
        ...form,
        pelatihan_id: props.pelatihanId,
        type: props.type,
        nilai: Number(form.nilai),
      }

      const response = await api.post(`/kelola/preposttest`, payload)

      ElNotification({
        title: 'Berhasil',
        message: response.data.message || 'Data berhasil ditambahkan',
        type: 'success',
        duration: 3000,
      })

      window.location.reload()
      emit('close')
    } catch (error) {
      ElNotification({
        title: 'Gagal',
        message: error.response?.data?.message || 'Gagal menambahkan data',
        type: 'error',
        duration: 0,
      })
    }
  })
}
</script>
