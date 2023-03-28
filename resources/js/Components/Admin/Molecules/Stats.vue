<script setup>
import { ArrowDownIcon, ArrowUpIcon } from '@heroicons/vue/20/solid'
import { CurrencyEuroIcon, ShoppingBagIcon, ShoppingCartIcon } from '@heroicons/vue/24/outline'

const stats = [
  { id: 1, name: 'Orders', stat: '0', icon: ShoppingBagIcon, change: '24%', changeType: 'increase' },
  { id: 2, name: 'Sold Items', stat: '0', icon: ShoppingCartIcon, change: '24%', changeType: 'increase' },
  { id: 3, name: 'Sales', stat: '€200', icon: CurrencyEuroIcon, change: '24%', changeType: 'decrease' },
]
</script>
<template>
  <div>
    <h3 class="text-base font-semibold leading-6 text-gray-900">Last 30 days</h3>

    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
      <div v-for="item in stats" :key="item.id"
        class="relative overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:px-6 sm:pt-6">
        <dt>
          <div class="absolute rounded-md bg-indigo-500 p-3">
            <component :is="item.icon" class="h-6 w-6 text-white" aria-hidden="true" />
          </div>
          <p class="ml-16 truncate text-sm font-medium text-gray-500">{{ item.name }}</p>
        </dt>
        <dd class="ml-16 flex items-baseline">
          <p class="text-2xl font-semibold text-gray-900">{{ item.stat }}</p>
          <p
            :class="[item.changeType === 'increase' ? 'text-green-600' : 'text-red-600', 'ml-2 flex items-baseline text-sm font-semibold']">
            <ArrowUpIcon v-if="item.changeType === 'increase'" class="h-5 w-5 flex-shrink-0 self-center text-green-500"
              aria-hidden="true" />
            <ArrowDownIcon v-else class="h-5 w-5 flex-shrink-0 self-center text-red-500" aria-hidden="true" />
            <span class="sr-only"> {{ item.changeType === 'increase' ? 'Increased' : 'Decreased' }} by </span>
            {{ item.change }}
          </p>
        </dd>
      </div>
    </dl>
  </div>
</template>