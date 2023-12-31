<script setup>
import { Pagination } from '@/Components/Admin'
import { WishlistButton } from '@/Components/Customer'
import { Link } from '@inertiajs/vue3';
import { CheckCircleIcon, XMarkIcon } from '@heroicons/vue/20/solid'

import { ref } from "vue";
import { ConfirmationMessage } from "@/Components/Customer";

const props = defineProps({
  skus: Object,
  links: Object,
})

const wishlistMsg = ref('');

function handleAdd(sku) {
  wishlistMsg.value = sku.product.title + ' has been added to your wishlist';
  setTimeout(() => {
    wishlistMsg.value = '';
  }, 3000);
}

function handleRemove(sku) {
  wishlistMsg.value = sku.product.title + ' has been removed from your wishlist';
  setTimeout(() => {
    wishlistMsg.value = '';
  }, 3000);
}

</script>
<template>
  <div v-if="wishlistMsg.length > 0">
    <ConfirmationMessage :Msg="wishlistMsg" />
  </div>
  <div class="bg-white">
    <div class="mx-auto max-w-2xl py-6 px-4 sm:py-6 sm:px-6 lg:max-w-7xl lg:px-8" v-if="props.skus.length > 0">
      <div class="grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
        <div v-for="product in props.skus" :key="product.id" class="mt-8" :id="product.id">
          <Link :to="'/product/' + product.sku  + '/' + product.product.slug" :href="'/product/' + product.sku + '/' + product.product.slug">
          <div class="relative group">
            <div class="relative h-72 w-full overflow-hidden rounded-lg">
              <img :src="product.product_images[0].image_link" alt="placeholder"
                class="h-full w-full object-cover object-center duration-500 group-hover:scale-125" />
            </div>
            <div class="relative mt-4">
              <h3 class="text-sm font-medium text-gray-900">{{ product.product.title }}</h3>
              <p class="mt-1 text-sm text-gray-500">
                {{ !product.product.description ? '' : product.product.description.length <= 30 ?
                  product.product.description : product.product.description.slice(0, 30) + '...' }} </p>
            </div>
            <div class="grade absolute inset-x-0 top-0 flex h-72 items-end justify-end overflow-hidden rounded-lg p-4">
              <div aria-hidden="true" class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50 group-hover:h-20 group-hover:opacity-20 duration-500" />
              <p class="relative text-lg font-semibold text-red-500" v-if="product.promos.length > 0
                  && new Date(product.promos[0].start_date.split(' ')[0]) < new Date()
                  && new Date(product.promos[0].end_date.split(' ')[0]) > new Date()">
                <span class="text-white no-underline mr-3">
                  €{{ product.promos[0].new_price_incl_vat.toFixed(2) }}
                </span>
                <span class="line-through">€{{ product.price_incl_vat.toFixed(2) }}</span>
              </p>

                <p class="relative text-lg font-semibold text-white" v-else>
                    €{{ product.price_incl_vat.toFixed(2) }}
                </p>
            </div>
            <div>
              <WishlistButton :product="product" class="absolute top-0 right-0 p-2 m-2 bg-white rounded-md group-odd" @added-to-wishlist="handleAdd" @removed-from-wishlist="handleRemove"/>
            </div>
          </div>
          </Link>
        </div>
      </div>
      <div class="mt-4 flex sm:justify-center" v-if="props.links.length > 3">
        <Pagination :links="props.links" />
      </div>
    </div>
    <div v-else>
        <div class="flex flex-col items-center justify-center h-96">
            <div class="flex flex-col items-center justify-center">
              <img src="/assets/search.svg" alt="empty" class="w-1/3" />
              <h1 class="text-2xl font-bold text-gray-500">Sorry, no products were found</h1>
                <Link href="/">
                  <button class="mt-4 px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600">Take me home!</button>
                </Link>
            </div>
        </div>
    </div>
  </div>
</template>