import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import './assets/main.css';
import api from './services/api';
import VueTheMask from 'vue-the-mask';

// Cria a instância do aplicativo Vue
const app = createApp(App);

// Adiciona Axios como uma propriedade global
app.config.globalProperties.$axios = api;

// Usa o Vuex e o Vue Router
app.use(store).use(router).mount('#app');

// Adiciona Maskara nos campos cpf, whatsapp e cep
app.use(VueTheMask);
