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
  CurrencyDollarIcon,
  DocumentMagnifyingGlassIcon,
  ChartPieIcon,
} from '@heroicons/vue/24/outline'

const recentAnalyses = [
  {
    id: 1,
    title: 'Erro em classificação fiscal',
    description: 'Produto classificado com NCM incorreto impactando o cálculo de ICMS.',
    icon: ExclamationTriangleIcon,
    date: 'Hoje',
  },
  {
    id: 2,
    title: 'Lucro Bruto abaixo do esperado',
    description: 'Queda de 18% no lucro bruto em comparação com o mês anterior.',
    icon: ChartPieIcon,
    date: 'Ontem',
  },
  {
    id: 3,
    title: 'Inconsistência no plano de contas',
    description: 'Contas duplicadas encontradas no agrupamento "Despesas Operacionais".',
    icon: DocumentMagnifyingGlassIcon,
    date: '24 Mai',
  },
  {
    id: 4,
    title: 'Tributação divergente',
    description: 'CST e CFOP conflitantes em 12 notas fiscais emitidas.',
    icon: CurrencyDollarIcon,
    date: '22 Mai',
  },
  {
    id: 5,
    title: 'Conferência automatizada concluída',
    description: 'Todos os lançamentos do período 01/05 a 25/05 foram conciliados.',
    icon: CheckCircleIcon,
    date: '21 Mai',
  },
]
</script>
