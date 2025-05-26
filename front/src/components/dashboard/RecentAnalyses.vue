<template>
  <div class="p-4">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Análises Recentes</h2>
    <ul class="bg-white shadow-md rounded-2xl divide-y divide-gray-100">
      <li
        v-for="item in recentAnalyses"
        :key="item.id"
        class="flex items-start gap-4 p-4 hover:bg-gray-50 transition"
      >
        <div class="flex-shrink-0">
          <component :is="item.icon" class="w-6 h-6 text-blue-500" />
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-medium text-gray-900">{{ item.title }}</p>
          <p class="text-sm text-gray-500">{{ item.description }}</p>
        </div>
        <div class="text-sm text-gray-400 whitespace-nowrap">
          {{ item.date }}
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup>
import {
  ExclamationTriangleIcon,
  CheckCircleIcon,
  MagnifyingGlassCircleIcon,
  CurrencyDollarIcon,
} from '@heroicons/vue/24/outline'

const recentAnalyses = [
  {
    id: 1,
    title: 'Desvio no centro de custo',
    description: 'Identificado lançamento fora do padrão no centro de custo "Marketing".',
    icon: ExclamationTriangleIcon,
    date: 'Hoje',
  },
  {
    id: 2,
    title: 'Análise de Lucro Bruto',
    description: 'Relatório mensal gerado com sucesso para todas as filiais.',
    icon: CheckCircleIcon,
    date: 'Ontem',
  },
  {
    id: 3,
    title: 'Conferência de notas fiscais',
    description: 'Notas fiscais divergentes encontradas no período 01/05 - 15/05.',
    icon: MagnifyingGlassCircleIcon,
    date: '22 Mai',
  },
  {
    id: 4,
    title: 'Revisão de impostos',
    description: 'Análise de ICMS e IPI para produtos cadastrados incorretamente.',
    icon: CurrencyDollarIcon,
    date: '20 Mai',
  },
]
</script>
