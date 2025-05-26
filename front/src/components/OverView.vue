<template>
  <div class="p-6 space-y-6">
    <!-- Resumo de Métricas -->
    <DashboardMetrics :metrics="metrics" />

    <!-- Ações Rápidas -->
    <QuickActions @createFlow="handleCreateFlow" @importFile="handleImportFile" />

    <!-- Últimas Análises -->
    <RecentAnalyses :analyses="recentAnalyses" />

    <!-- Alertas Recentes -->
    <AlertsList :alerts="recentAlerts" />

    <!-- Gráfico de Tendências -->
    <TrendsChart :data="trendData" />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import DashboardMetrics from '@/components/dashboard/DashboardMetrics.vue'
import QuickActions from '@/components/dashboard/QuickActions.vue'
import RecentAnalyses from '@/components/dashboard/RecentAnalyses.vue'
import AlertsList from '@/components/dashboard/AlertsList.vue'
import TrendsChart from '@/components/dashboard/TrendsChart.vue'

const metrics = ref([
  { label: 'Fluxos Criados', value: 24, icon: 'workflow' },
  { label: 'Análises com Sucesso', value: 19, icon: 'check-circle' },
  { label: 'Anomalias Detectadas', value: 5, icon: 'alert-triangle' },
  { label: 'Pendentes', value: 3, icon: 'clock' },
])

const recentAnalyses = ref([
  { name: 'Fluxo Fiscal A', status: 'success', anomalies: 0, date: '25/05/2025' },
  { name: 'Fluxo Entrada Julho', status: 'warning', anomalies: 2, date: '24/05/2025' },
])

const recentAlerts = ref([
  { message: 'Diferença de saldo no centro de custo X', date: '24/05/2025' },
  { message: 'Lançamento sem contrapartida detectado', date: '23/05/2025' },
])

const trendData = ref({
  labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex'],
  values: [2, 4, 1, 5, 3],
})

const handleCreateFlow = () => {
  console.log('Criar novo fluxo')
}

const handleImportFile = () => {
  console.log('Importar novo arquivo')
}
</script>

<style scoped>
</style>
