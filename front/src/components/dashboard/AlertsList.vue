<template>
  <div class="p-4">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Alertas Recentes</h2>
    <ul class="space-y-4">
      <li
        v-for="alert in alerts"
        :key="alert.id"
        :class="['p-4 rounded-2xl shadow-md border-l-4', alertStyles[alert.type].border, 'bg-white']"
        class="flex items-start gap-4"
      >
        <component :is="alert.icon" :class="['w-6 h-6', alertStyles[alert.type].icon]" />
        <div class="flex-1">
          <p class="font-medium text-sm text-gray-900">{{ alert.title }}</p>
          <p class="text-sm text-gray-600">{{ alert.message }}</p>
          <span class="text-xs text-gray-400">{{ alert.timestamp }}</span>
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup>
import {
  ExclamationTriangleIcon,
  CheckCircleIcon,
  InformationCircleIcon,
} from '@heroicons/vue/24/outline'

const alertStyles = {
  warning: {
    border: 'border-yellow-400',
    icon: 'text-yellow-500',
  },
  success: {
    border: 'border-green-400',
    icon: 'text-green-500',
  },
  info: {
    border: 'border-blue-400',
    icon: 'text-blue-500',
  },
}

const alerts = [
  {
    id: 1,
    title: 'Desvio detectado',
    message: 'Centro de custo "TI" com gastos acima do limite.',
    icon: ExclamationTriangleIcon,
    type: 'warning',
    timestamp: 'Há 5 minutos',
  },
  {
    id: 2,
    title: 'Processo concluído',
    message: 'Backup financeiro realizado com sucesso.',
    icon: CheckCircleIcon,
    type: 'success',
    timestamp: 'Há 1 hora',
  },
  {
    id: 3,
    title: 'Informação adicional',
    message: 'Atualização do sistema disponível.',
    icon: InformationCircleIcon,
    type: 'info',
    timestamp: 'Ontem',
  },
]
</script>
