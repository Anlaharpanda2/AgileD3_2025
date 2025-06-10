<template>
  <div class="element-error-page">
    <div class="div">
      <div class="left-panel">
        <div class="element">404ERRORS</div>
        <div class="group">
          <div class="text-wrapper">404</div>
          <div class="group-2">
            <p class="p">Maaf halaman yang anda cari tidak tersedia di sistem DP3AP2KB Provinsi Sumatera Barat</p>
            <div class="overlap-group-wrapper" @click="goToBeranda">
              <div class="overlap-group">
                <div class="text-wrapper-2">Kembali Ke Beranda</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <img class="img" src="/group-15-1.png" />
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
const router = useRouter()
function goToBeranda() {
  router.push('/')
}
</script>

<style scoped>
@import url("https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css");
@import url("https://fonts.googleapis.com/css2?family=Clash+Grotesk:wght@500&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Concert+One&display=swap");
@import url("https://fonts.googleapis.com/css2?family=ABeeZee&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Aclonica&display=swap");
* {
  -webkit-font-smoothing: antialiased;
  box-sizing: border-box;
}
button:focus-visible {
  outline: 2px solid #4a90e2 !important;
  outline: -webkit-focus-ring-color auto 5px !important;
}
a {
  text-decoration: none;
}
@keyframes goyangAtasBawah {
  0% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
  100% {
    transform: translateY(0);
  }
}
.element-error-page {
  background-color: rgba(255, 255, 255, 1.0);
  display: flex;
  flex-direction: row;
  justify-content: center;
  width: 100%;
  min-height: 100vh; 
}
.div {
  background: linear-gradient(
    72deg,
    rgb(250, 160, 183) 0%,
    rgb(255, 98, 147) 100%
  );
  width: 100%;
  min-height: 100vh; 
  display: flex; 
  flex-direction: row; 
  flex-wrap: wrap; 
  justify-content: center; 
  align-items: center; 
  gap: 40px; 
  padding: 20px; 
}
.left-panel {
  display: flex;
  flex-direction: column; 
  align-items: center; 
  justify-content: center;
  flex-basis: 500px; 
  max-width: 90%; 
  text-align: center; 
  min-width: 280px;
}
.element-error-page .element {
  font-family: "Clash Grotesk-Medium", Helvetica;
  font-weight: 500;
  color: #ffffff;
  font-size: 22px; 
  letter-spacing: 0;
  line-height: normal;
  margin-bottom: 20px; 
  text-align: center; 
}
.element-error-page .group {
  width: 100%; 
  max-width: 463px; 
  height: auto; 
  display: flex;
  flex-direction: column; 
  align-items: center; 
  position: relative; 
  padding-top: 250px; 
  padding-bottom: 20px; 
}
.element-error-page .text-wrapper {
  position: absolute;
  top: -60px; 
  left: 50%; 
  transform: translateX(-50%); 
  background: linear-gradient(
    180deg,
    rgba(27, 48, 68, 1) 0%,
    rgba(18, 38, 56, 1) 100%
  );
  -webkit-background-clip: text !important;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  font-family: "Concert One-Regular", Helvetica;
  font-weight: 400;
  color: transparent;
  font-size: 302px; 
  text-align: center;
  letter-spacing: 0;
  line-height: normal;
  white-space: nowrap;
  z-index: 0; 
  pointer-events: none; 
}
.element-error-page .group-2 {
  width: 100%;
  max-width: 382px; 
  height: auto; 
  display: flex;
  flex-direction: column; 
  align-items: center; 
  margin-top: 20px; 
  z-index: 1; 
}
.element-error-page .p {
  width: 100%;
  max-width: 380px; 
  -webkit-text-stroke: 0.5px #ffffff;
  font-family: "ABeeZee-Regular", Helvetica;
  font-weight: 400;
  color: #ffffff;
  font-size: 21px; 
  text-align: center;
  letter-spacing: 0;
  line-height: normal;
  margin-bottom: 30px; 
}
.element-error-page .overlap-group-wrapper {
  width: 204px;
  height: 48px;
  cursor: pointer;
  margin-top: 10px; 
}
.element-error-page .overlap-group {
  position: relative; 
  width: 202px;
  height: 48px;
  background-color: #1a3f55;
  border-radius: 16px;
  display: flex; 
  justify-content: center;
  align-items: center;
}
.element-error-page .text-wrapper-2 {
  font-family: "Aclonica-Regular", Helvetica;
  font-weight: 400;
  color: #ffffff;
  font-size: 14px; 
  text-align: center;
  letter-spacing: 0;
  line-height: normal;
  white-space: nowrap;
}
.element-error-page .img {
  animation: goyangAtasBawah 2s ease-in-out infinite;
  width: auto; 
  height: auto; 
  max-width: 474px; 
  flex-shrink: 0; 
  object-fit: cover;
  min-width: 250px;
}
@media(max-width:750px){
  .div {
    flex-direction: column; 
    gap: 20px; 
  }
  .left-panel {
    order: 2; 
    flex-basis: auto; 
    max-width: 95%; 
  }
  .element-error-page .img {
    order: 1; 
    width: 50%; 
    max-width: 250px; 
    min-width: 150px; 
  }
  .element {
    display: none;
  }
  .element-error-page .group {
    width: 100%;
    max-width: 400px; 
    padding-top: 150px; 
  }
  .element-error-page .text-wrapper {
    font-size: 200px; 
    top: -40px; 
  }
  .element-error-page .p {
    font-size: 18px;
  }
  .element-error-page .group-2 {
    max-width: 300px;
  }
}
</style>