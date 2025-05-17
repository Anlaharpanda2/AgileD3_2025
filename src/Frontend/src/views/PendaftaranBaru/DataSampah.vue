<template>
  <div class="page">
    <h2>Data Terhapus</h2>
    <router-link to="/hapusedit">
      <button class="btn-back">Kembali Ke Daftar</button>
    </router-link>
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
            <tr v-for="item in trash" :key="item.nik">
                <td>{{ item.nik }}</td>
                <td>{{ item.peserta }}</td>
                <td>{{ item.tempat_tanggal_lahir }}</td>
                <td>{{ item.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ item.alamat }}</td>
                <td>{{ item.pendidikan }}</td>
                <td>{{ item.pekerjaan }}</td>
                <td>{{ item.email }}</td>
                <td>{{ item.pelatihan }}</td>
                <td>{{ item.tanggal_pelatihan }}</td>
                <td>{{ item.tempat_pelatihan }}</td>
                
                <td>
                  <div class="btn-group">
                    <button class="btn-restore" @click="restore(item.nik)">Pulihkan</button>
                    <button class="btn-delete" @click="hapusPermanen(item.nik)">Hapus Permanen</button>
                  </div>
                </td>

            </tr>
            <tr v-if="trash.length === 0">
                <td colspan="12" style="text-align: center;">Tidak ada data terhapus.</td>
            </tr>
        </tbody>

      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '@/api';

const trash = ref([]);

const getTrashedData = async () => {
  try {
    const res = await api.get('/pendaftaranbaru/trash');
    trash.value = res.data ?? [];
  } catch (error) {
    console.error('Gagal mengambil data sampah:', error);
  }
};

const restore = async (nik) => {
  if (confirm('Pulihkan data ini?')) {
    try {
      await api.put(`/pendaftaranbaru/restore/${nik}`);
      getTrashedData();
    } catch (error) {
      console.error('Gagal memulihkan data:', error);
    }
  }
};

const hapusPermanen = async (nik) => {
  if (confirm('Yakin ingin menghapus secara permanen?')) {
    try {
      await api.delete(`/pendaftaranbaru/permanent/${nik}`);
      getTrashedData(); // refresh tampilan
    } catch (error) {
      console.error('Gagal menghapus permanen:', error);
    }
  }
};


onMounted(getTrashedData);
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
  background-color: #fff;
  text-align: left;
}

.data-table tbody tr:hover {
  background-color: #ffe5d9;
}

.btn-restore {
  background-color: #38b000;
  color: white;
  padding: 6px 12px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.btn-group {
  display: flex;
  justify-content: center;
  gap: 6px;
}

.btn-delete {
  background-color: #d9534f;
  color: white;
  padding: 6px 12px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.btn-back {
  background-color: #6c757d;
  color: white;
  padding: 8px 16px;
  margin-bottom: 20px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
  transition: background-color 0.3s ease;
}

.btn-back:hover {
  background-color: #495057;
}


</style>
