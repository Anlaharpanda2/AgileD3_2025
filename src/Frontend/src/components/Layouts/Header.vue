<template>
  <header class="header">
      <!-- KIRI -->
        <SideBar/>
        <div class="header__brand">
          <Vue3Lottie
            :animationLink="'/lottie/logo.json'"
            :loop="false"
            :autoplay="true"
            class="panjang"
          />
        </div>

      <!-- TENGAH -->
      <div class="header__center">
        <span class="header__tagline">Keluarga Sejahtera, Setara, Terlindungi</span>
        <div class="header__search-wrapper" :class="{ active: isFocused }">
          <input
            type="text"
            v-model="searchQuery"
            @focus="isFocused = true"
            @blur="isFocused = false"
            class="header__search-input"
            placeholder="Pencarian..."
          />
          <img src="/layout/button.png" alt="Cari" class="header__search-icon" />
        </div>
      </div>

      <!-- KANAN -->
      <div class="header__right">
        <Avatar class="header__icon-right" />
      </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import Avatar from '@/components/layouts/Avatar.vue'
import SideBar from '@/components/layouts/SideBar.vue'
const searchQuery = ref('')
const isFocused = ref(false)
</script>

<style scoped>
@import url("https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css");

* {
  box-sizing: border-box;
  -webkit-font-smoothing: antialiased;
}

body, html {
  margin: 0;
  padding: 0;
  font-family: "Roboto", sans-serif;
}

/* HEADER */
.header {
  background: linear-gradient(8deg, #fb9cb1 0%, #ff5b91 100%);
  width: 100%;
  display: flex;
  justify-content: space-between;
  padding-left: 20px;
  padding-right: 20px;
  padding-bottom: 10px;
  padding-top: 10px;
}

/* KIRI */
.header__brand {
  display: flex;
  align-items: center;
  padding-left: 30px;
  gap: 10px;
}

.header__logo {
  width: 36px;
  height: 36px;
}

.header__title {
  font-family: "Paytone One", sans-serif;
  font-size: 16.5px;
  color: #ffeff6;
}

/* TENGAH */
.header__center {
  display: flex;
  align-items: center;
  gap: 20px;
  margin-left: auto;
}

.header__tagline {
  font-size: 16px;
  font-style: italic;
  font-weight: 500;
  color: #fff;
}

.header__search-wrapper {
  display: flex;
  align-items: center;
  background-color: #ff5d92;
  border: 1px solid #fff;
  border-radius: 12px;
  padding: 6px 13px;
  gap: 8px;
  transition: all 0.3s ease;
  position: relative;
  width: 120px;
  overflow: hidden;
}

.header__search-wrapper.active {
  width: 220px;
}

.header__search-input {
  border: none;
  background: transparent;
  outline: none;
  font-size: 12px;
  color: #fff;
  width: 100%;
}

.header__search-input::placeholder {
  color: rgb(225, 225, 225);
}

.header__search-icon {
  width: 14px;
  height: 14px;
}

/* KANAN */
.header__right {
  padding-left: 20px;
  display: flex;
  align-items: center;
  gap: 10px;
  position: relative;
}

.header__icon-right {
  width: 23px;
  height: 22.5px;
  object-fit: contain;
  cursor: pointer;
}
.panjang{
  width: 300px;
}

@media (max-width: 768px) {
  .header__container {
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
  }

  .header__center {
    display: none;
  }
  .header__right {
  padding:0px;
  }
}

@media(max-width:361px){
  .panjang{
    width: 250px;
  }
}
</style>
