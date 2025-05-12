<template>
  <div>
    <h1>Daftar Pendaftar</h1>

    <table border="1">
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
        <tr v-for="pendaftar in pendaftarList" :key="pendaftar.nik">
          <td>{{ pendaftar.nik }}</td>
          <td>{{ pendaftar.nama }}</td>
          <td>{{ pendaftar.ttl }}</td>
          <td>{{ pendaftar.jenis_kelamin }}</td>
          <td>{{ pendaftar.alamat }}</td>
          <td>{{ pendaftar.pendidikan }}</td>
          <td>{{ pendaftar.pekerjaan }}</td>
          <td>{{ pendaftar.email }}</td>
          <td>{{ pendaftar.pelatihan }}</td>
          <td>{{ pendaftar.tanggal_pelatihan }}</td>
          <td>{{ pendaftar.tempat_pelatihan }}</td>
          <td>
            <button @click="hapusPendaftar(pendaftar.nik)">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import api from '../api' // pastikan path file ini benar

export default {
  data() {
    return {
      pendaftarList: []
    }
  },
  mounted() {
    this.getPendaftar()
  },
  methods: {
    async getPendaftar() {
      try {
        const response = await api.get('/pendaftar')
        this.pendaftarList = response.data
        console.log(this.pendaftarList) // debug: pastikan datanya muncul
      } catch (error) {
        console.error('Gagal ambil data:', error)
      }
    },
    async hapusPendaftar(nik) {
      if (confirm('Yakin ingin menghapus pendaftar ini?')) {
        try {
          await api.delete(`/pendaftar/${nik}`)
          this.getPendaftar() // refresh list setelah hapus
        } catch (error) {
          console.error('Gagal hapus:', error)
        }
      }
    }
  }
}
</script>
