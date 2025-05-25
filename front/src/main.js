import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import './assets/main.css';
import api from './services/api';
import VueTheMask from 'vue-the-mask';

const app = createApp(App);

// Axios global
app.config.globalProperties.$axios = api;

app.use(store).use(router);

// Verifica localStorage antes de montar
const authToken = localStorage.getItem('authToken');
const userName = localStorage.getItem('userName');

if (authToken && userName) {
  //localStorage.clear();
  // Redireciona para /login manualmente
  router.push('/login').then(() => {
    app.mount('#app');
  });
} else {
  app.mount('#app');
}

app.use(VueTheMask);
