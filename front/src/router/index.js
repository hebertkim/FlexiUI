import AlertsList from '@/components/dashboard/AlertsList.vue'
import DashboardMetrics from '@/components/dashboard/DashboardMetrics.vue'
import QuickActions from '@/components/dashboard/QuickActions.vue'
import RecentAnalyses from '@/components/dashboard/RecentAnalyses.vue'
import TrendsChart from '@/components/dashboard/TrendsChart.vue'
import LoginScreen from '@/components/LoginScreen.vue'
import OverView from '@/components/OverView.vue'
import RegisterScreen from '@/components/RegisterScreen.vue'
import ConectaBanco from '@/components/settings/ConectaBanco.vue'
import RegisterDataBase from '@/components/settings/RegisterDataBase.vue'
import WelcomeScreen from '@/components/WelcomeScreen.vue'
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'welcome',
    component: WelcomeScreen,
    children: [
      {
        path: 'overview',
        name: 'overview',
        component: OverView,
        children: [
          {
            path: 'metrics',
            name: 'dashboard-metrics',
            component: DashboardMetrics
          },
          {
            path: 'quick-actions',
            name: 'quick-actions',
            component: QuickActions
          },
          {
            path: 'recent-analyses',
            name: 'recent-analyses',
            component: RecentAnalyses
          },
          {
            path: 'alerts',
            name: 'alerts-list',
            component: AlertsList
          },
          {
            path: 'trends',
            name: 'trends-chart',
            component: TrendsChart
          }
        ]
      },
      {
        path: '/settings/database',
        name: 'database',
        component: RegisterDataBase
      },
      {
        path: '/settings/erp-connect',
        name: 'connectdatabase',
        component: ConectaBanco
      },
      {
        path: '/register',
        name: 'register',
        component: RegisterScreen
      }
    ]
  },
  {
    path: '/login',
    name: 'login',
    component: LoginScreen
  },

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

// Guard para proteger rotas privadas
router.beforeEach((to, from, next) => {
  const publicPages = ['/login', '/register']
  const authRequired = !publicPages.includes(to.path)
  const token = localStorage.getItem('authToken')

  console.log('Navegando para:', to.path)
  console.log('Token:', token)

  if (authRequired && !token) {
    console.log('Redirecionando para login...')
    next({ path: '/login', query: { redirect: to.fullPath } })
  } else {
    next()
  }
})

export default router
