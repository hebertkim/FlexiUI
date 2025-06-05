<template>
  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 min-h-[28rem]">
    <h2 class="text-xl font-semibold mb-6 text-white dark:text-white">Tendências de Performance</h2>

    <div class="mb-6 flex flex-wrap gap-2">
      <button
        v-for="type in chartTypes"
        :key="type"
        @click="currentChart = type"
        :class="buttonClass(type)"
        class="px-4 py-1 rounded transition whitespace-nowrap"
      >
        {{ typeLabels[type] }}
      </button>
    </div>

    <div class="relative h-auto min-h-[24rem] p-4">
      <Line v-if="currentChart === 'line'" :data="lineData" :options="chartOptions" />
      <Bar v-if="currentChart === 'bar'" :data="barData" :options="chartOptions" />
      <Pie v-if="currentChart === 'pie'" :data="pieData" :options="chartOptions" />
      <Doughnut v-if="currentChart === 'doughnut'" :data="doughnutData" :options="chartOptions" />
      <Radar v-if="currentChart === 'radar'" :data="radarData" :options="radarOptions" />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  BarElement,
  PointElement,
  ArcElement,
  RadialLinearScale,
  CategoryScale,
  LinearScale
} from 'chart.js'
import { Line, Bar, Pie, Doughnut, Radar } from 'vue-chartjs'

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  BarElement,
  PointElement,
  ArcElement,
  RadialLinearScale,
  CategoryScale,
  LinearScale
)

const currentChart = ref('line')
const chartTypes = ['line', 'bar', 'pie', 'doughnut', 'radar']
const typeLabels = {
  line: 'Linha',
  bar: 'Barras',
  pie: 'Pizza',
  doughnut: 'Rosca',
  radar: 'Radar',
}

const buttonClass = (type) =>
  currentChart.value === type
    ? 'bg-blue-500 text-white shadow-md'
    : 'bg-gray-200 dark:bg-gray-700 text-white dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600'

const lineData = {
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
  datasets: [
    {
      label: 'Acessos Mensais',
      data: [150, 200, 300, 280, 500, 620],
      fill: false,
      borderColor: '#3b82f6',
      tension: 0.3,
      pointBackgroundColor: '#1d4ed8',
    },
  ],
}

const barData = {
  labels: ['Produto A', 'Produto B', 'Produto C', 'Produto D'],
  datasets: [
    {
      label: 'Vendas',
      data: [500, 700, 300, 450],
      backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
    },
  ],
}

const pieData = {
  labels: ['Vermelho', 'Azul', 'Amarelo'],
  datasets: [
    {
      label: 'Participação',
      data: [300, 50, 100],
      backgroundColor: ['#ef4444', '#3b82f6', '#fbbf24'],
      hoverOffset: 30,
    },
  ],
}

const doughnutData = {
  labels: ['Marketing', 'Vendas', 'Suporte'],
  datasets: [
    {
      label: 'Distribuição de equipe',
      data: [120, 90, 40],
      backgroundColor: ['#8b5cf6', '#10b981', '#f43f5e'],
      hoverOffset: 20,
    },
  ],
}

const radarData = {
  labels: ['Velocidade', 'Força', 'Agilidade', 'Resistência', 'Inteligência', 'Carisma'],
  datasets: [
    {
      label: 'Meu desempenho',
      data: [65, 59, 90, 81, 56, 55],
      fill: true,
      backgroundColor: 'rgba(59, 130, 246, 0.2)',
      borderColor: '#3b82f6',
      pointBackgroundColor: '#1e40af',
      pointBorderColor: '#fff',
      pointHoverBackgroundColor: '#fff',
      pointHoverBorderColor: '#1e40af',
    },
  ],
}

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  layout: {
    padding: {
      top: 24,
      bottom: 24,
      left: 24,
      right: 24,
    },
  },
  plugins: {
    legend: {
      position: 'top',
      labels: {
        color: '#ffffff',
        font: {
          size: 14,
        },
      },
    },
    title: {
      display: false,
    },
    tooltip: {
      titleColor: '#ffffff',
      bodyColor: '#ffffff',
      backgroundColor: '#111827',
    },
  },
  scales: {
    x: {
      ticks: {
        color: '#ffffff',
        padding: 8,
      },
      grid: {
        display: false,
      },
    },
    y: {
      beginAtZero: true,
      ticks: {
        color: '#ffffff',
        padding: 8,
      },
      grid: {
        display: false,
      },
    },
  },
}

const radarOptions = {
  responsive: true,
  maintainAspectRatio: false,
  layout: {
    padding: {
      top: 24,
      bottom: 24,
      left: 24,
      right: 24,
    },
  },
  plugins: {
    legend: {
      position: 'top',
      labels: {
        color: '#ffffff',
        font: {
          size: 14,
        },
      },
    },
    title: {
      display: false,
    },
  },
  scales: {
    r: {
      angleLines: {
        color: '#6b7280',
      },
      grid: {
        color: '#6b7280',
      },
      pointLabels: {
        color: '#ffffff',
        font: {
          size: 12,
        },
      },
      ticks: {
        color: '#ffffff',
        backdropColor: 'transparent',
      },
    },
  },
}
</script>
