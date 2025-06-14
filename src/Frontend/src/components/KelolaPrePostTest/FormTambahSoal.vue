<template>
  <div class="form-overlay">
    <div class="form-popup">
      <div class="form-body">
        <el-form :model="form" label-width="120px" @submit.prevent="submitSoal">
          <el-form-item label="Pertanyaan">
            <el-input v-model="form.pertanyaan" type="textarea" />
          </el-form-item>

          <el-form-item label="Pilihan A">
            <el-input v-model="form.pilihan_a" />
          </el-form-item>

          <el-form-item label="Pilihan B">
            <el-input v-model="form.pilihan_b" />
          </el-form-item>

          <el-form-item label="Pilihan C">
            <el-input v-model="form.pilihan_c" />
          </el-form-item>

          <el-form-item label="Pilihan D">
            <el-input v-model="form.pilihan_d" />
          </el-form-item>

          <el-form-item label="Jawaban Benar">
            <el-select v-model="form.jawaban_benar" placeholder="Pilih jawaban benar">
              <el-option label="A" value="A" />
              <el-option label="B" value="B" />
              <el-option label="C" value="C" />
              <el-option label="D" value="D" />
            </el-select>
          </el-form-item>

          <el-form-item>
            <el-button type="primary" @click="submitSoal">Simpan</el-button>
            <el-button @click="closeDialog">Batal</el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const emit = defineEmits(['saved', 'close'])

const form = ref({
  pertanyaan: '',
  pilihan_a: '',
  pilihan_b: '',
  pilihan_c: '',
  pilihan_d: '',
  jawaban_benar: ''
})

const submitSoal = async () => {
  try {
    // const res = await axios.post('/api/soal', form.value) // uncomment this line when the api is ready
    // emit('saved', res.data) // uncomment this line when the api is ready
    console.log("Soal submitted", form.value) // replace the 2 lines above with this line for testing
    emit('saved')
    closeDialog()
  } catch (error) {
    console.error('Gagal menambahkan soal:', error)
  }
}

const closeDialog = () => {
  emit('close')
}
</script>

<style scoped>
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