<template>
  <div class="p-4">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Ações Rápidas</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
      <button
        v-for="action in actions"
        :key="action.label"
        @click="action.onClick"
        class="flex flex-col items-center justify-center p-4 bg-white hover:bg-gray-100 shadow-md rounded-2xl transition duration-200"
      >
        <component :is="action.icon" class="h-8 w-8 text-blue-500 mb-2" />
        <span class="text-sm font-medium text-gray-700 text-center">{{ action.label }}</span>
      </button>
    </div>
  </div>
</template>

<script setup>
import {
  PlusCircleIcon,
  DocumentPlusIcon,
  UserPlusIcon,
  ShoppingBagIcon,
  ChatBubbleLeftRightIcon,
  Cog6ToothIcon,
} from '@heroicons/vue/24/outline'

// Ações rápidas (exemplo)
const actions = [
  {
    label: 'Nova Venda',
    icon: ShoppingBagIcon,
    onClick: () => alert('Nova Venda'),
  },
  {
    label: 'Novo Cliente',
    icon: UserPlusIcon,
    onClick: () => alert('Novo Cliente'),
  },
  {
    label: 'Novo Produto',
    icon: PlusCircleIcon,
    onClick: () => alert('Novo Produto'),
  },
  {
    label: 'Nova Ordem',
    icon: DocumentPlusIcon,
    onClick: () => alert('Nova Ordem'),
  },
  {
    label: 'Suporte',
    icon: ChatBubbleLeftRightIcon,
    onClick: () => alert('Suporte'),
  },
  {
    label: 'Configurações',
    icon: Cog6ToothIcon,
    onClick: () => alert('Configurações'),
  },
]
</script>
