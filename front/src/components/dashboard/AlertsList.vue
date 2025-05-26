<template>
  <div class="p-4">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Alertas Recentes</h2>
    <ul class="space-y-4">
      <li
        v-for="alert in alerts"
        :key="alert.id"
        :class="[
          'p-4 rounded-2xl shadow-md border-l-4 flex items-start gap-4 bg-white',
          alertStyles[alert.type].border,
        ]"
      >
        <component :is="alert.icon" :class="['w-6 h-6 mt-1', alertStyles[alert.type].icon]" />
        <div class="flex-1">
          <p class="font-medium text-sm text-gray-900">{{ alert.title }}</p>
          <p class="text-sm text-gray-600">{{ alert.message }}</p>
          <span class="text-xs text-gray-400 block mt-1">{{ alert.timestamp }}</span>
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
  XCircleIcon,
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
  danger: {
    border: 'border-red-400',
    icon: 'text-red-500',
  },
}

const alerts = [
  {
    id: 1,
    title: 'Desvio detectado',
    message: 'Centro de custo "TI" com gastos 42% acima do orçado neste mês.',
    icon: ExclamationTriangleIcon,
    type: 'warning',
    timestamp: 'Há 5 minutos',
  },
  {
    id: 2,
    title: 'Backup concluído',
    message: 'Backup completo dos dados financeiros realizado com sucesso.',
    icon: CheckCircleIcon,
    type: 'success',
    timestamp: 'Há 1 hora',
  },
  {
    id: 3,
    title: 'Atualização disponível',
    message: 'Nova versão com melhorias fiscais e correções de bugs está pronta para instalação.',
    icon: InformationCircleIcon,
    type: 'info',
    timestamp: 'Ontem',
  },
  {
    id: 4,
    title: 'Falha em conciliação',
    message: 'Erro ao conciliar pagamentos do banco XYZ: divergência de R$ 2.453,78.',
    icon: XCircleIcon,
    type: 'danger',
    timestamp: '22 Mai',
  },
]
</script>
