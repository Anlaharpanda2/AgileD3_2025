<template>
  <nav class="navbar">
    <ul class="nav-items">
      <li class="hover"><a href="/home"><span class="icon-circle"><img src="/NavBar/Vector.svg" alt="icon" /></span><span class="hover2">BERANDA</span></a></li>
      <li class="hover"><a href="#"><span class="icon-circle"><img src="/NavBar/Vector.svg" alt="icon" /></span><span class="hover2">DASHBOARD</span></a></li>
      <li class="hover"><a href="#"><span class="icon-circle"><img src="/NavBar/Vector.svg" alt="icon" /></span><span class="hover2">PRE/POSTTEST</span></a></li>
      <li  class="hover"><a href="/data/pendaftaran"><span class="icon-circle"><img src="/NavBar/Vector.svg" alt="icon" /></span><span class="hover2">PENDAFTAR</span></a></li>
      <li class="hover"><a href="/data/pelatihan"><span class="icon-circle"><img src="/NavBar/Vector.svg" alt="icon" /></span><span class="hover2">PELATIHAN</span></a></li>
      <li class="hover"><a href="#"><span class="icon-circle"><img src="/NavBar/Vector.svg" alt="icon" /></span><span class="hover2">PELAPORAN</span></a></li>
      <li class="hover"><a href="#"><span class="icon-circle"><img src="/NavBar/Vector.svg" alt="icon" /></span><span class="hover2">KELOLA DATA</span></a></li>
      <li class="hover"><a href="/kelola/akses"><span class="icon-circle"><img src="/NavBar/Vector.svg" alt="icon" /></span><span class="hover2">KELOLA AKSES</span></a></li>
    </ul>
  </nav>
</template>
<style scoped>
.navbar {
  background-color: var(--color-whitesmoke);
  width: 100%;
  position: relative;
  padding: 0 20px;
  display: flex;
  height: 50px;
}

@media(max-width:852px){
  .navbar{
    display: none;
  }
}

.nav-items {
  list-style: none;
  display: flex;
  flex-wrap: wrap;
  margin: 0;
  padding: 0;
  align-items: center;
}

.nav-items li a {
  display: flex;
  align-items: center;
  text-decoration: none;
  color: var(--color-black);
  font-family: var(--font-roboto);
  font-size: 12px;
  font-weight: bold;
}

.nav-items span{
  padding-left: 5px;
  padding-right: 5px;
}

.hover{
  display: flex;
  padding :11px;
  transition: background-color 0.3s ease;
}
.hover2{
  transition-property: background-color, color;
  transition-duration: 0.1s;
  transition-timing-function: ease;
}
.hover:hover{
  background-color: rgba(105, 197, 194, 1);
}
.hover:hover .hover2{
  transition-duration: 0.7s;
  background-color: rgba(105, 197, 194, 1);
  color: aliceblue;
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
