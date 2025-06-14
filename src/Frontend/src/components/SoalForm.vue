<template>
  <div class="soal-form">
    <h3>{{ initialData ? 'Edit Soal' : 'Tambah Soal Baru' }}</h3>
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
          <option
            v-for="option in options"
            :key="option"
            :value="option"
            :disabled="!form.pilihan[option]"
          >
            {{ option }}
          </option>
        </select>
      </label>

      <button type="submit">{{ initialData ? 'Update Soal' : 'Simpan Soal' }}</button>
      <button type="button" @click="$emit('close')">Batal</button>
    </form>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import api from '@/api';

// Props & emits
const props = defineProps({
  initialData: Object
});
const emit = defineEmits(['close', 'saved']);

// Option labels
const options = ['a', 'b', 'c', 'd', 'e'];

// Default form
const form = ref({
  jenis: '',
  pertanyaan: '',
  pilihan: { a: '', b: '', c: '', d: '', e: '' },
  jawaban_benar: ''
});

// Reset form function
const resetForm = () => {
  form.value = {
    jenis: '',
    pertanyaan: '',
    pilihan: { a: '', b: '', c: '', d: '', e: '' },
    jawaban_benar: ''
  };
};

// Watch initialData to prefill form when editing
watch(
  () => props.initialData,
  (val) => {
    if (val && val.id) {
      form.value = {
        jenis: val.jenis || '',
        pertanyaan: val.pertanyaan || '',
        pilihan: typeof val.pilihan === 'string' ? JSON.parse(val.pilihan) : { ...val.pilihan },
        jawaban_benar: val.jawaban_benar || ''
      };
    } else {
      resetForm();
    }
  },
  { immediate: true }
);

// Submit form
const submitForm = async () => {
  const { jenis, pertanyaan, pilihan, jawaban_benar } = form.value;

  const filledOptions = Object.entries(pilihan).filter(([_, v]) => v.trim() !== '');
  if (filledOptions.length === 0) {
    alert('❗ Harap isi minimal satu pilihan jawaban');
    return;
  }

  if (!jawaban_benar) {
    alert('❗ Silakan pilih jawaban benar');
    return;
  }

  if (!pilihan[jawaban_benar] || pilihan[jawaban_benar].trim() === '') {
    alert('❗ Jawaban benar harus sesuai dengan pilihan yang diisi');
    return;
  }

  const payload = {
    jenis,
    pertanyaan,
    pilihan: { ...pilihan },
    jawaban_benar
  };

  try {
    if (props.initialData && props.initialData.id) {
      await api.put(`/soal-prepost/${props.initialData.id}`, payload);
      emit('saved', '✅ Soal berhasil diperbarui');
    } else {
      await api.post('/soal-prepost', payload);
      emit('saved', '✅ Soal berhasil ditambahkan');
    }

    resetForm();
    emit('close');
  } catch (error) {
    console.error('❌ Gagal menyimpan soal:', error);
    alert('❌ Gagal menyimpan soal: ' + (error.response?.data?.message || error.message));
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
  margin-right: 10px;
}
.soal-form button:hover {
  background: #1e8e86;
}
</style>
