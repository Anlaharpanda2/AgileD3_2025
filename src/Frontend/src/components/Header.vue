<template>
  <header class="header">
    <div class="header__container">
      <!-- KIRI -->
      <div class="header__left">
        <SideBar/>
        <div class="header__brand">
          <Vue3Lottie
            :animationLink="'/lottie/logo.json'"
            :height="36"
            :width="300"
            :loop="false"
            :autoplay="true"
          />
        </div>
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
        <img src="/layout/image-6.png" alt="Gambar 1" class="header__icon-right" />
        <Avatar class="header__icon-right" />
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import Avatar from '@/components/Avatar.vue'
import SideBar from '@/components/SideBar.vue'
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
  justify-content: center;
  padding: 10px;
}

.header__container {
  max-width: 1280px;
  width: 100%;
  padding: 0 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 24px;
}

/* KIRI */
.header__left {
  display: flex;
  align-items: center;
  gap: 16px;
}

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

/* RESPONSIF */
@media (max-width: 768px) {
  .header__container {
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
  }

  .header__center {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }

  .header__right {
    align-self: flex-end;
  }

  .header__search-wrapper {
    width: 100% !important;
  }
}
</style>
