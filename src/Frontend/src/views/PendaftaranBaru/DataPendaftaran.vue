<template>
  <div class="page">
    <!-- TABEL DATA -->
    <div v-if="!formVisible">
      <h2>Daftar Pendaftar</h2>
      <div class="table-wrapper">
        <table class="data-table">
          <thead>
            <tr>
              <th>NIK</th>
              <th>Nama</th>
              <th>TTL</th>
              <th>Jenis Kelamin</th>
              <th>Alamat</th>
              <th>Pendidikan</th>
              <th>Pekerjaan</th>
              <th>Email</th>
              <th>Pelatihan</th>
              <th>Tanggal Pelatihan</th>
              <th>Tempat Pelatihan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in pendaftar" :key="item.nik">
              <td>{{ item.nik }}</td>
              <td>{{ item.peserta }}</td>
              <td>{{ item.tempat_tanggal_lahir }}</td>
              <td>{{ item.jenis_kelamin }}</td>
              <td>{{ item.alamat }}</td>
              <td>{{ item.pendidikan }}</td>
              <td>{{ item.pekerjaan }}</td>
              <td>{{ item.email }}</td>
              <td>{{ item.pelatihan }}</td>
              <td>{{ item.tanggal_pelatihan }}</td>
              <td>{{ item.tempat_pelatihan }}</td>
              <td>
                <div class="btn-group">
                  <button class="btn-edit" @click="edit(item)">Edit</button>
                  <button class="btn-delete" @click="hapus(item.nik)">Hapus</button>
                </div>
              </td>
            </tr>
            <tr v-if="pendaftar.length === 0">
              <td colspan="12" style="text-align: center;">Data tidak ditemukan.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- FORM EDIT -->
    <div v-else class="form-container">
      <h2 class="form-title">Form Edit Data Pendaftar</h2>
      <form @submit.prevent="submitForm">
        <div class="form-group"><label>NIK</label><input v-model="form.nik" readonly /></div>
        <div class="form-group"><label>Nama</label><input v-model="form.peserta" required /></div>
        <div class="form-group"><label>Tempat Lahir</label><input v-model="form.tempat_lahir" required /></div>
        <div class="form-group"><label>Tanggal Lahir</label><input type="date" v-model="form.tanggal_lahir" required /></div>
        <div class="form-group">
          <label>Jenis Kelamin</label>
          <select v-model="form.jenis_kelamin" required>
            <option value="">Pilih</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
        </div>
        <div class="form-group"><label>Alamat</label><textarea v-model="form.alamat" required></textarea></div>
        <div class="form-group"><label>Pendidikan</label><input v-model="form.pendidikan" required /></div>
        <div class="form-group"><label>Pekerjaan</label><input v-model="form.pekerjaan" required /></div>
        <div class="form-group"><label>Email</label><input type="email" v-model="form.email" required /></div>
        <div class="form-group"><label>Pelatihan</label><input v-model="form.pelatihan" required /></div>
        <div class="form-group"><label>Tanggal Pelatihan</label><input type="date" v-model="form.tanggal_pelatihan" required /></div>
        <div class="form-group"><label>Tempat Pelatihan</label><input v-model="form.tempat_pelatihan" required /></div>
        <div class="form-actions">
          <button type="submit" class="btn-save">Simpan</button>
          <button type="button" class="btn-cancel" @click="formVisible = false">Batal</button>
        </div>
      </form>
    </div>

    <!-- TOMBOL LIHAT DATA DIHAPUS -->
    <div v-if="!formVisible" class="btn-trash-wrapper">
      <router-link to="/pendaftaran/terhapus">
        <button class="btn-trash">🗑️ Lihat Data Dihapus</button>
      </router-link>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../../api';

const pendaftar = ref([]);
const formVisible = ref(false);

const form = ref({
  nik: '', peserta: '', tempat_lahir: '', tanggal_lahir: '', jenis_kelamin: '',
  alamat: '', pendidikan: '', pekerjaan: '', email: '',
  pelatihan: '', tanggal_pelatihan: '', tempat_pelatihan: ''
});

const getData = async () => {
  try {
    const res = await api.get('/pendaftaranbaru');
    pendaftar.value = res.data.data.map(item => {
      const [tempat, tanggal] = item.tempat_tanggal_lahir.split(', ');
      return {
        ...item,
        tempat_lahir: tempat,
        tanggal_lahir: tanggal
      };
    }) ?? [];
  } catch (err) {
    console.error('Gagal mengambil data:', err);
  }
};

const edit = (item) => {
  form.value = {
    ...item,
    tempat_lahir: item.tempat_tanggal_lahir.split(', ')[0],
    tanggal_lahir: item.tempat_tanggal_lahir.split(', ')[1]
  };
  formVisible.value = true;
};

const submitForm = async () => {
  try {
    form.value.tempat_tanggal_lahir = `${form.value.tempat_lahir}, ${form.value.tanggal_lahir}`;
    await api.put(`/pendaftaranbaru/${form.value.nik}`, form.value);
    formVisible.value = false;
    getData();
  } catch (err) {
    console.error('Gagal menyimpan data:', err);
  }
};

const hapus = async (nik) => {
  if (confirm('Yakin ingin menghapus? Data akan masuk ke tempat sampah dan dapat dipulihkan.')) {
    try {
      await api.delete(`/pendaftaranbaru/${nik}`);
      getData();
    } catch (err) {
      console.error('Gagal menghapus data:', err);
    }
  }
};

onMounted(getData);
</script>

<style scoped>
.page {
  background-color: #f8edeb;
  padding: 30px;
  font-family: 'Segoe UI', sans-serif;
  min-height: 100vh;
}
.table-wrapper {
  overflow-x: auto;
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.data-table {
  width: 100%;
  border-collapse: collapse;
  background-color: #fff;
  table-layout: auto;
}
.data-table th {
  background-color: #ffb5a7;
  color: white;
  padding: 14px;
  font-weight: 600;
  text-align: center;
}
.data-table td {
  padding: 12px;
  border-bottom: 1px solid #eee;
  text-align: left;
}
.data-table tbody tr:hover {
  background-color: #ffe5d9;
  transition: background-color 0.3s ease;
}
.btn-group {
  display: flex;
  justify-content: center;
  gap: 6px;
}
.btn-edit {
  background-color: #6c757d;
  color: #fff;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
}
.btn-delete {
  background-color: #d9534f;
  color: #fff;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
}
.form-container {
  background-color: #ffffff;
  padding: 30px;
  max-width: 700px;
  margin: 30px auto;
  border-radius: 10px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.1);
}
.form-title {
  text-align: center;
  color: #2b2d42;
  margin-bottom: 20px;
  font-size: 22px;
}
.form-group {
  margin-bottom: 16px;
}
.form-group label {
  font-weight: 600;
  margin-bottom: 6px;
  display: block;
}
input,
select,
textarea {
  width: 100%;
  padding: 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 14px;
  background-color: #f1fdfb;
}
textarea {
  resize: vertical;
}
.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  margin-top: 20px;
}
.btn-save {
  background-color: #2b8a3e;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 6px;
}
.btn-cancel {
  background-color: #fa5252;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 6px;
}

.btn-trash-wrapper {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 1000;
}

.btn-trash {
  background-color: #6f42c1;
  color: white;
  padding: 10px 18px;
  border: none;
  border-radius: 8px;
  font-weight: bold;
  font-size: 14px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-trash:hover {
  background-color: #5a34a0;
}
</style>
