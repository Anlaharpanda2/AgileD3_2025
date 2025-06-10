<template>
<div class="modal-overlay"> 
    <div class="form-import">
        <button class="close-btn" @click="$emit('close')">×</button>
      <el-upload
        class="upload-area"
        drag
        ref="upload"
        :file-list="fileList"
        :auto-upload="false"
        :before-upload="beforeUpload"
        :on-remove="handleRemove"
        :on-change="handleChange"
      >
        <i class="el-icon-upload" />
        <div class="upload-text">
          <p v-if="!fileList.length">Drag & Drop file Excel di sini atau klik untuk memilih</p>
          <p v-else>📄 {{ fileList[0].name }}</p>
        </div>
        <div class="upload-tip">(.xls, .xlsx) Maksimal 1 file</div>
      </el-upload>
      <div class="btn-group">
        <el-button
          type="warning"
          @click="$refs.upload.submit()"
          class="btn-reupload"
          v-if="fileList.length"
        >
          Pilih File Lain
        </el-button>
        <el-button
          type="primary"
          :loading="loading"
          :disabled="!fileList.length"
          @click="submitFile"
          class="btn-import"
        >
          Impor File
        </el-button>
      </div>
    </div>
</div>
</template>
<script>
import api from '@/api.js';
import { ElNotification } from 'element-plus';
export default {
  name: 'FormImport',
  data() {
    return {
      fileList: [],
      loading: false,
    };
  },
  methods: {
    beforeUpload(file) {
      const isExcel = /\.(xls|xlsx)$/i.test(file.name);
      if (!isExcel) {
        ElMessage.error('File harus berformat .xls atau .xlsx');
      }
      if (this.fileList.length >= 1) {
        this.fileList.splice(0, this.fileList.length - 1);
      }
      return isExcel;
    },
    handleChange(file, fileList) {
      this.fileList = fileList.slice(-1);
    },
    handleRemove() {
      this.fileList = [];
    },
    async submitFile() {
      if (!this.fileList.length) return;
      this.loading = true;
      const file = this.fileList[0].raw;
      const formData = new FormData();
      formData.append('file', file);
      try {
        const res = await api.post('/kelola/pelatihan/impor', formData);
        ElNotification({
          title: 'Berhasil',
          message: 'Impor data',
          type: 'success',
          duration: 3000,
        });
        this.fileList = [];
      } catch (err) {
        ElMessage.error(err.response?.data?.error || 'Terjadi kesalahan saat mengimpor');
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>
<style scoped>
.close-btn {
  position: absolute;
  top: 160px;
  right: 350px;
  background: transparent;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #909399;
  transition: color 0.2s;
}
.close-btn:hover {
  color: #606266;
}
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.6); /* latar gelap */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  animation: fadeIn 0.3s ease;
}
.form-import {
  background: #ffffff;
  border-radius: 1rem;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  max-width: 600px;
  width: 90%;
  padding: 2rem;
  animation: popup 0.3s ease;
}
@keyframes popup {
  from {
    transform: scale(0.8);
    opacity: 0;
  }
  to {
    transform: scale(1);
    opacity: 1;
  }
}
@keyframes fadeIn {
  from {
    background: rgba(0, 0, 0, 0);
  }
  to {
    background: rgba(0, 0, 0, 0.6);
  }
}
.upload-area {
  border: 2px dashed #69C5C2;
  border-radius: 0.75rem;
  padding: 2rem;
  text-align: center;
  transition: border-color 0.3s;
}
.upload-area:hover {
  border-color: #69C5C2;
}
.upload-text {
  font-size: 1rem;
  color: #606266;
  margin-top: 0.5rem;
}
.upload-tip {
  font-size: 0.85rem;
  color: #909399;
  margin-top: 0.5rem;
}
.btn-group {
  display: flex;
  justify-content: space-between;
  margin-top: 1.5rem;
}
.btn-reupload,
.btn-import {
  flex: 1;
  margin: 0 0.5rem;
  font-weight: 500;
  border-radius: 0.75rem;
  height: 3rem;
  transition: box-shadow 0.3s;
}
.btn-import:hover {
  box-shadow: 0 4px 12px #69C5C2;
}
</style>
