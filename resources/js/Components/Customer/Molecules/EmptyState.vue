<template>
  <div class="text-left mt-24">
    <ShoppingBagIcon class="mb-4 h-12 w-12 text-gray-400" aria-hidden="true" />
    <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ title }}</h3>
    <p class="mt-1 text-sm text-gray-500">{{ description }}</p>
    <div class="mt-6">
      <Link href="/"
        class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
      <PlusIcon class="-ml-0.5 mr-1.5 h-5 w-5" aria-hidden="true" v-if="buttonIcon" />
      {{ button }}
      </Link>
    </div>
  </div>
</template>
  
<script setup>
import { PlusIcon, ShoppingBagIcon } from '@heroicons/vue/20/solid'
import { Link } from '@inertiajs/vue3';

defineProps({
  title: {
    type: String,
    required: true,
  },
  description: {
    type: String,
    required: true,
  },
  button: {
    type: String,
    required: true,
  },
  buttonIcon: {
    type: Boolean,
    default: false,
  },
})
</script>