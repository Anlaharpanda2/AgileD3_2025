<template>
  <div class="element-error-page">
      <div class="div">
          <div class="element">404ERRORS</div>
          <div class="group">
              <div class="text-wrapper">404</div>
              <div class="group-2">
                  <p class="p">Maaf halaman yang anda cari tidak tersedia di sistem DP3AP2KB Provinsi Sumatera Barat</p>
                  <div class="overlap-group-wrapper" @click="goToPendaftaran">
                      <div class="overlap-group">
                        <div class="text-wrapper-2">Kembali Ke Beranda</div>
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

function goToPendaftaran() {
  router.push('/data/pendaftaran')
}
</script>
<style>
@import url("https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css");
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
    transform: translateY(-10px); /* naik */
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
    height: 100%;
}

.element-error-page .div {
    background-color: rgba(255, 255, 255, 1.0);
    background: linear-gradient(
        72deg,
        rgb(250, 160, 183) 0%,
        rgb(255, 98, 147) 100%
    );
    width: 100%;
    height: 100vh;
    position: relative;
}

.element-error-page .element {
    position: absolute;
    top: 30px;
    left: 93px;
    font-family: "Clash Grotesk-Medium", Helvetica;
    font-weight: 500;
    color: #ffffff;
    font-size: 22px;
    letter-spacing: 0;
    line-height: normal;
}

.element-error-page .group {
    position: absolute;
    width: 463px;
    height: 414px;
    top: 208px;
    left: 93px;
}

.element-error-page .text-wrapper {
    position: absolute;
    top: -60px;
    left: 0;
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
}

.element-error-page .group-2 {
    position: absolute;
    width: 382px;
    height: 133px;
    top: 281px;
    left: 41px;
}

.element-error-page .p {
    position: absolute;
    width: 380px;
    top: -30px;
    left: 0;
    -webkit-text-stroke: 0.5px #ffffff;
    font-family: "ABeeZee-Regular", Helvetica;
    font-weight: 400;
    color: #ffffff;
    font-size: 21px;
    text-align: center;
    letter-spacing: 0;
    line-height: normal;
}

.element-error-page .overlap-group-wrapper {
    position: absolute;
    width: 204px;
    height: 48px;
    top: 85px;
    left: 89px;
}

.element-error-page .overlap-group {
    position: relative;
    width: 202px;
    height: 48px;
    background-color: #1a3f55;
    border-radius: 16px;
}

.element-error-page .text-wrapper-2 {
    position: absolute;
    top: 16px;
    left: 24px;
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
    position: absolute;
    width: 474px;
    height: 488px;
    top: 125px;
    left: 683px;
    object-fit: cover;
}

</style>
