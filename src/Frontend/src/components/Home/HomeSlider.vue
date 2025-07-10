<template>
  <v-carousel
    height="400"
    show-arrows="hover"
    cycle
    hide-delimiter-background
  >
    <v-carousel-item
      v-for="(slide, i) in slides"
      :key="i"
    >
      <v-img
        :src="slide"
        height="100%"
        cover
      />
    </v-carousel-item>
  </v-carousel>
</template>

<script setup>
const slides = [
  '/Home/1.jpeg',
  '/Home/1.jpeg',
  '/Home/1.jpeg'
]
</script>
