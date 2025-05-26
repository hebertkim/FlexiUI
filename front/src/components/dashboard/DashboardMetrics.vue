<template>
  <div class="p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div
      v-for="metric in metrics"
      :key="metric.title"
      class="bg-white shadow-md rounded-2xl p-4 flex items-center space-x-4"
    >
      <div :class="`p-3 rounded-full ${metric.bg}`">
        <component :is="metric.icon" class="h-6 w-6 text-white" />
      </div>
      <div>
        <p class="text-sm text-gray-500">{{ metric.title }}</p>
        <p class="text-xl font-bold text-gray-800">{{ metric.value }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import {
  UserGroupIcon,
  ChartBarIcon,
  CurrencyDollarIcon,
  ShoppingBagIcon,
} from '@heroicons/vue/24/outline'

const metrics = [
  {
    title: 'Usuários',
    value: '1.248',
    icon: UserGroupIcon,
    bg: 'bg-blue-500',
  },
  {
    title: 'Vendas',
    value: 'R$ 75.000',
    icon: CurrencyDollarIcon,
    bg: 'bg-green-500',
  },
  {
    title: 'Pedidos',
    value: '389',
    icon: ShoppingBagIcon,
    bg: 'bg-purple-500',
  },
  {
    title: 'Performance',
    value: '92%',
    icon: ChartBarIcon,
    bg: 'bg-yellow-500',
  },
]
</script>
