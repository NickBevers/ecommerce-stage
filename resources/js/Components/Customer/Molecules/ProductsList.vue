<template>
  <div class="bg-white">
    <div class="mx-auto max-w-2xl py-6 px-4 sm:py-6 sm:px-6 lg:max-w-7xl lg:px-8">
      <div class="grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
        <div v-for="product in props.skus" :key="product.id" class="mt-8">
          <div class="relative">
            <div class="relative h-72 w-full overflow-hidden rounded-lg">
              <img src="https://tailwindui.com/img/ecommerce-images/product-page-03-related-product-01.jpg" alt="placeholder" class="h-full w-full object-cover object-center" />
            </div>
            <div class="relative mt-4">
              <h3 class="text-sm font-medium text-gray-900">{{ product.product.title }}</h3>
              <p class="mt-1 text-sm text-gray-500">{{ product.product.description.slice(0, 30) }}...</p>
            </div>
            <div class="absolute inset-x-0 top-0 flex h-72 items-end justify-end overflow-hidden rounded-lg p-4">
              <div aria-hidden="true" class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50" />
              <p class="relative text-lg font-semibold text-white">€{{ product.price }}</p>
            </div>
            <div>
              <div class="absolute top-0 right-0 p-2 m-2">
                <a href="#" class="group -m-2 flex items-center p-2">
                  <HeartIcon class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-blue-600" aria-hidden="true" />
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script setup>
import { defineProps, onMounted } from 'vue'
import {
  HeartIcon,
} from '@heroicons/vue/24/outline'

const props = defineProps({
  skus: Object,
  links: Object,
});

console.log(props.links)
</script>