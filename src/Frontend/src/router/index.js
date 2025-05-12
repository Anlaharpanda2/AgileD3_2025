import { createRouter, createWebHistory } from 'vue-router';
import LoginMasyarakat from '../views/Login/LoginMasyarakat.vue';
import LoginOperator from '../views/Login/LoginOperator.vue';
import LoginPegawai from '../views/Login/LoginPegawai.vue';
import Home from '../views/Home/HomeView.vue';
import DataPendaftarView from '../views/DataPendaftar/DataPendaftarView.vue';
import NotFound from '../views/NotFound.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/login/masyarakat',
    name: 'LoginMasyarakat',
    component: LoginMasyarakat
  },
  {
    path: '/login/pegawai',
    name: 'LoginPegawai',
    component: LoginPegawai
  },
  {
    path: '/login/operator',
    name: 'LoginOperator',
    component: LoginOperator
  },
  {
    path: '/data/pendaftar',
    name: 'DataPendaftar',
    component: DataPendaftarView,
    meta: { requiresAuth: true }
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: NotFound
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});
router.beforeEach((to, from, next) => {
  const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';

  if (to.meta.requiresAuth && !isLoggedIn) {
    next({ path: '/login/masyarakat' });
  } else {
    next();
  }
});

export default router;
