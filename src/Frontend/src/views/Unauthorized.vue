<template>
  <div class="error-container">
    <div class="content-wrapper">
      <div class="text-section">
        <div class="ooops-text">Ooops....</div>
        <div class="access-denied-title">Akses Ditolak</div>
        <div class="permission-message">Anda tidak memiliki izin untuk mengakses halaman ini.</div>
        <div class="back-home-button" @click="goToBeranda">
          <div class="button-text">Kembali Ke Beranda</div>
        </div>
      </div>
      <img class="error-image" alt="Akses Ditolak" src="/Forbiden/image.png" />
    </div>
  </div>
</template>
<script setup>
import { useRouter } from 'vue-router'
const router = useRouter()
// Fungsi untuk mengarahkan pengguna kembali ke halaman beranda
function goToBeranda() {
  router.push('/')
}
</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Clash+Grotesk:wght@500&display=swap');
body {
  margin: 0;
  line-height: normal;
}
:root {
  --color-black: #000;
  --color-gray: #767676;
  --color-darkslategray: #ff0606;
  --color-white: #fff;
  --font-poppins: 'Poppins', sans-serif;
  --font-clash-grotesk: 'Clash Grotesk', sans-serif;
}
.error-container {
  width: 100%;
  height: 100vh; 
  display: flex;
  justify-content: center; 
  align-items: center; 
  background: linear-gradient(253.9deg, var(--color-white), #ffe2e2);
  text-align: left;
  font-family: var(--font-poppins);
  font-size: 56.89px; 
  color: var(--color-black);
  overflow: hidden; 
}
.content-wrapper {
  display: flex;
  flex-wrap: wrap; 
  justify-content: center; 
  align-items: center;
  max-width: 1200px; 
  padding: 20px; 
  gap: 40px; 
}
.text-section {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
  gap: 10px;
  max-width: 500px; 
}
.ooops-text {
  font-weight: 600;
  font-size: 56.89px;
}
.access-denied-title {
  font-size: 35.56px;
  font-weight: 300;
}
.permission-message {
  font-size: 21.33px;
  font-weight: 300;
  color: var(--color-gray);
  margin-bottom: 20px; 
}
.back-home-button {
  position: relative;
  width: 202px;
  height: 48px;
  background-color: #1a3f55;
  border-radius: 16px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer; 
  transition: background-color 0.3s ease; 
}
.back-home-button:hover {
  background-color: #77215c; 
}
.button-text {
  font-family: 'Aclonica-Regular', Helvetica; 
  font-weight: 400;
  color: var(--color-white);
  font-size: 14px;
  text-align: center;
  letter-spacing: 0;
  line-height: normal;
  white-space: nowrap;
}
.error-image {
  width: 581px; 
  max-width: 100%; 
  height: auto; 
  object-fit: contain; 
}
@media screen and (max-width: 750px) {
  .content-wrapper {
    flex-direction: column-reverse; 
    text-align: center; 
    gap: 30px; 
    padding: 15px; 
  }
  .text-section {
    align-items: center; 
    max-width: 100%; 
  }
  .ooops-text {
    font-size: 40px; 
  }
  .access-denied-title {
    font-size: 28px; 
  }
  .permission-message {
    font-size: 16px; 
  }
  .error-image {
    width: 50vw; 
    margin-bottom: 20px; 
  }
  .back-home-button {
    width: 100%; 
    max-width: 250px; 
  }
}
</style>
