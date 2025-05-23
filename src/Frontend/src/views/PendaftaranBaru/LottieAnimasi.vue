<template>
  <div ref="lottieContainer" style="width: 300px; height: 300px;"></div>
</template>

<script>
import lottie from 'lottie-web'

export default {
  name: 'LottieAnimasi',
  mounted() {
    lottie.loadAnimation({
      container: this.$refs.lottieContainer,
      renderer: 'svg',
      loop: false,
      autoplay: true,
      path: '/lottie/animasi1.json' // karena ada di public, cukup awali dengan "/"
    });
  }
}
</script>

<style scoped>
/* styling opsional */
</style>
