<template>
  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 h-96">
    <h2 class="text-lg font-semibold mb-4 text-white dark:text-white">Tendências de Performance</h2>

    <div class="mb-4 flex space-x-2 overflow-x-auto">
      <button
        @click="currentChart = 'line'"
        :class="currentChart === 'line' ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-white dark:text-white'"
        class="px-4 py-1 rounded whitespace-nowrap"
      >
        Linha
      </button>
      <button
        @click="currentChart = 'bar'"
        :class="currentChart === 'bar' ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-white dark:text-white'"
        class="px-4 py-1 rounded whitespace-nowrap"
      >
        Barras
      </button>
      <button
        @click="currentChart = 'pie'"
        :class="currentChart === 'pie' ? 'bg-purple-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-white dark:text-white'"
        class="px-4 py-1 rounded whitespace-nowrap"
      >
        Pizza
      </button>
      <button
        @click="currentChart = 'doughnut'"
        :class="currentChart === 'doughnut' ? 'bg-pink-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-white dark:text-white'"
        class="px-4 py-1 rounded whitespace-nowrap"
      >
        Rosca
      </button>
      <button
        @click="currentChart = 'radar'"
        :class="currentChart === 'radar' ? 'bg-yellow-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-white dark:text-white'"
        class="px-4 py-1 rounded whitespace-nowrap"
      >
        Radar
      </button>
    </div>

    <div class="h-72">
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
      display: true,
      text: 'Tendências de Performance',
      color: '#ffffff',
      font: {
        size: 16,
        weight: 'bold',
      },
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
      },
      grid: {
        display: false, // ou use: display: false para remover também as verticais
      },
    },
    y: {
      beginAtZero: true,
      ticks: {
        color: '#ffffff',
      },
      grid: {
        display: false, // REMOVE as linhas horizontais
      },
    },
  },
}



const radarOptions = {
  responsive: true,
  maintainAspectRatio: false,
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
      display: true,
      text: 'Radar de Desempenho',
      color: '#ffffff',
      font: {
        size: 16,
        weight: 'bold',
      },
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
