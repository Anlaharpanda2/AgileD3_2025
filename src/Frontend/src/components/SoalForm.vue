<template>
  <div class="soal-form">
    <h3>Tambah Soal Baru</h3>
    <form @submit.prevent="submitForm">
      <label>
        Jenis Soal:
        <select v-model="form.jenis" required>
          <option value="" disabled>Pilih jenis soal</option>
          <option value="pretest">Pretest</option>
          <option value="postest">Postest</option>
        </select>
      </label>

      <label>
        Pertanyaan:
        <input
          type="text"
          v-model="form.pertanyaan"
          placeholder="Masukkan pertanyaan"
          required
        />
      </label>

      <fieldset>
        <legend>Pilihan Jawaban:</legend>
        <label v-for="option in options" :key="option">
          {{ option }}:
          <input
            type="text"
            v-model="form.pilihan[option]"
            :placeholder="`Masukkan pilihan ${option}`"
            required
          />
        </label>
      </fieldset>

      <label>
        Jawaban Benar:
        <select v-model="form.jawaban_benar" required>
          <option value="" disabled>Pilih jawaban benar</option>
          <option v-for="option in options" :key="option" :value="option" :disabled="!form.pilihan[option]">
            {{ option }}
          </option>
        </select>
      </label>

      <button type="submit">Simpan Soal</button>
      <button type="button" @click="$emit('close')">Batal</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const options = ['a', 'b', 'c', 'd', 'e']; // Pilihan jawaban
const form = ref({
  jenis: '',
  pertanyaan: '',
  pilihan: {
    a: '',
    b: '',
    c: '',
    d: '',
    e: '',
  },
  jawaban_benar: ''
});

// Submit the form to add a new question
const submitForm = async () => {
  // Validasi minimal satu pilihan diisi
  const filledOptions = Object.values(form.value.pilihan).filter(v => v.trim() !== '');
  if (filledOptions.length === 0) {
    alert('Harap isi minimal satu pilihan jawaban');
    return;
  }

  // Pastikan jawaban benar sudah dipilih
  if (!form.value.jawaban_benar) {
    alert('Silakan pilih jawaban benar');
    return;
  }

  // Siapkan data untuk dikirim
  const payload = {
    jenis: form.value.jenis,
    pertanyaan: form.value.pertanyaan,
    pilihan: { ...form.value.pilihan }, // Mengirim pilihan yang terisi
    jawaban_benar: form.value.jawaban_benar
  };

  try {
    await axios.post('http://your-backend-url/api/soal-prepost', payload);
    form.value = { jenis: '', pertanyaan: '', pilihan: { a: '', b: '', c: '', d: '', e: '' }, jawaban_benar: '' }; // Reset form
    $emit('close'); // Close the form
  } catch (error) {
    console.error('Error adding question:', error);
    alert('Gagal menyimpan soal: ' + (error.response?.data?.message || error.message));
  }
};
</script>

<style scoped>
.soal-form {
  background: #f9f9f9;
  border-radius: 8px;
  padding: 20px;
  margin-top: 20px;
}
.soal-form h3 {
  margin-bottom: 15px;
}
.soal-form input,
.soal-form select {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.soal-form button {
  background: #69C5C2;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
  transition: background 0.2s;
}
.soal-form button:hover {
  background: #1e8e86;
}
</style>