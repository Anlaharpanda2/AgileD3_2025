<template>
  <nav class="navbar">
    <ul class="nav-items">
      <li><a href="#"><span class="icon-circle"><img src="/NavBar/Vector.svg" alt="icon" /></span><span>BERANDA</span></a></li>
      <li><a href="#"><span class="icon-circle"><img src="/NavBar/Vector.svg" alt="icon" /></span><span>PENDAFTAR</span></a></li>
      <li><a href="#"><span class="icon-circle"><img src="/NavBar/Vector.svg" alt="icon" /></span><span>PELATIHAN</span></a></li>
      <li><a href="#"><span class="icon-circle"><img src="/NavBar/Vector.svg" alt="icon" /></span><span>PELAPORAN</span></a></li>
      <li><a href="#"><span class="icon-circle"><img src="/NavBar/Vector.svg" alt="icon" /></span><span>KELOLA DATA</span></a></li>
      <li><a href="#"><span class="icon-circle"><img src="/NavBar/Vector.svg" alt="icon" /></span><span>PESAN</span></a></li>
      <li><a href="#"><span class="icon-circle"><img src="/NavBar/Vector.svg" alt="icon" /></span><span>KELOLA AKSES</span></a></li>
    </ul>
  </nav>
</template>
<style scoped>
.navbar {
  background-color: var(--color-whitesmoke);
  padding: 0 20px;
  display: flex;
  align-items: center;
  height: 50px;
}

.nav-items {
  list-style: none;
  display: flex;
  flex-wrap: wrap;
  gap: 32px;
  margin: 0;
  padding: 0;
}

.nav-items li a {
  display: flex;
  align-items: center;
  text-decoration: none;
  color: var(--color-black);
  font-family: var(--font-roboto);
  font-size: 12px;
  font-weight: bold;
  gap: 8px;
}

.icon-circle {
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: rgba(105, 197, 194, 1);
  width: 28px;
  height: 28px;
  border-radius: 50%;
  flex-shrink: 0;
}

.icon-circle img {
  width: 16px;
  height: 16px;
}

/* Responsiveness */
@media (max-width: 768px) {
  .nav-items {
    gap: 16px;
    flex-wrap: wrap;
  }
}
</style>
