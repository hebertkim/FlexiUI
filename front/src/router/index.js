import LoginScreen from '@/components/LoginScreen.vue'
import RegisterScreen from '@/components/RegisterScreen.vue'
import WelcomeScreen from '@/components/WelcomeScreen.vue'
import { createRouter, createWebHistory } from 'vue-router'


const routes = [
  {
    path: '/',
    name: 'Welcome',
    component: WelcomeScreen
  },
  {
    path: '/login',
    name: 'login',
    component: LoginScreen
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterScreen
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
