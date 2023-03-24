<template>
      <ul role="list" class="divide-y divide-gray-200 border-t border-b border-gray-200">
              <li v-for="(product, productIdx) in products" :key="product.id" class="flex py-6 sm:py-10">
                <div class="flex-shrink-0">
                  <img :src="product.imageSrc" :alt="product.imageAlt" class="h-24 w-24 rounded-md object-cover object-center sm:h-48 sm:w-48" />
                </div>
  
                <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                  <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                    <div>
                      <div class="flex justify-between">
                        <h3 class="text-sm">
                          <a :href="product.href" class="font-medium text-gray-700 hover:text-gray-800">{{ product.name }}</a>
                        </h3>
                      </div>
                      <div class="mt-1 flex text-sm">
                        <p class="text-gray-500">{{ product.color }}</p>
                        <p v-if="product.size" class="ml-4 border-l border-gray-200 pl-4 text-gray-500">{{ product.size }}</p>
                      </div>
                      <p class="mt-1 text-sm font-medium text-gray-900">{{ product.price }}</p>
                    </div>
  
                    <div class="mt-4 sm:mt-0 sm:pr-9">
                      <label :for="`quantity-${productIdx}`" class="sr-only">Quantity, {{ product.name }}</label>
                      <select :id="`quantity-${productIdx}`" :name="`quantity-${productIdx}`" class="max-w-full rounded-md border border-gray-300 py-1.5 text-left text-base font-medium leading-5 text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                      </select>
  
                      <div class="absolute top-0 right-0">
                        <button type="button" class="-m-2 inline-flex p-2 text-gray-400 hover:text-gray-500">
                          <span class="sr-only">Remove</span>
                          <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                        </button>
                      </div>
                    </div>
                  </div>
  
                  <p class="mt-4 flex space-x-2 text-sm text-gray-700">
                    <CheckIcon v-if="product.inStock" class="h-5 w-5 flex-shrink-0 text-green-500" aria-hidden="true" />
                    <ClockIcon v-else class="h-5 w-5 flex-shrink-0 text-gray-300" aria-hidden="true" />
                    <span>{{ product.inStock ? 'In stock' : `Ships in ${product.leadTime}` }}</span>
                  </p>
                </div>
              </li>
            </ul>
</template>
<script setup>
import { CheckIcon, ClockIcon, QuestionMarkCircleIcon, XMarkIcon } from '@heroicons/vue/20/solid'

defineProps({
  products: {
    type: Array,
    required: true,
  },
})
</script>