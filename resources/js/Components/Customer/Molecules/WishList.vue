<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue'
import { useWishlistStore } from '@/Stores/wishlist';
import { ProductCartModal } from '@/Components/Customer';
import {
  PlusIcon,
} from '@heroicons/vue/24/solid'
import { CheckIcon, ClockIcon } from "@heroicons/vue/20/solid";

const props = defineProps({
  products: Object,
});

const wishlistStore = useWishlistStore();

let openCart = ref(false);
let selectedProduct = ref(null);

function removeFromWishlist(id) {
  fetch('/wishlist/' + id, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
    },
  })
    .then((response) => {
      document.getElementById(id).remove();
      wishlistStore.decrement();
    })
    .catch((error) => {
      console.error('There has been a problem with your fetch operation:', error);
    });
}

</script>
<template>
  <div class="bg-white mt-24">
    <div class="mx-auto max-w-2xl px-4 pt-16 pb-24 sm:px-6 lg:max-w-7xl lg:px-8">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Wishlist</h1>
      <ProductCartModal :product="selectedProduct" v-if="openCart" :open="openCart" @close="openCart = false"
        @closed="openCart = false"  />
      <div class="grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8"
        v-if="props.products.length > 0">
        <div v-for="product in props.products" :key="product.id" class="mt-8" :id="product.sku.id">
          <!--          <Link :to="'/product/' + product.sku.sku" :href="'/product/' + product.sku.sku">-->
          <Link :to="'/product/' + product.sku.sku + '/' + product.sku.product.slug"
            :href="'/product/' + product.sku.sku + '/' + product.sku.product.slug">
          <div class="relative group">
            <div class=" relative h-72 w-full overflow-hidden rounded-lg">
              <img :src="product.sku.product_images[0].image_link" alt="placeholder"
                class="h-full w-full object-cover object-center group-hover:scale-125 duration-500 " />
            </div>
            <div class="relative mt-4">
              <h3 class="text-sm font-medium text-gray-900">{{ product.sku.product.title }}</h3>
            </div>
            <div class="grade absolute inset-x-0 top-0 flex h-72 items-end justify-end overflow-hidden rounded-lg p-4">
              <div aria-hidden="true"
                class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50 group-hover:h-20 group-hover:opacity-20 duration-500" />
              <p class="relative text-lg font-semibold text-white">€{{ product.sku.price_incl_vat.toFixed(2) }}</p>
            </div>
            <div>
              <div class="absolute top-0 right-0 p-2 m-2">
                <a href="#" class="group -m-2 flex items-center p-2 rounded-md bg-white"
                  @click.prevent="removeFromWishlist(product.sku.id)">
                  <PlusIcon class="h-6 w-6 rotate-45 flex-shrink-0 text-gray-400 group-hover:text-blue-600"
                    aria-hidden="true" />
                </a>
              </div>
            </div>
          </div>
          </Link>
          <div class="mt-6">
            <a href="#" @click.prevent="selectedProduct = product; openCart = true"
              class="relative flex items-center justify-center rounded-md border border-transparent bg-gray-100 py-2 px-8 text-sm font-medium text-gray-900 hover:bg-gray-200">
              Add
              to bag<span class="sr-only">, {{ product.sku.product.title }}</span></a>
          </div>
        </div>
      </div>

      <div v-else>
        <div class="flex flex-col items-center justify-center h-96">
          <div class="flex flex-col items-center justify-center">
            <img src="/assets/wishlist.svg" alt="empty" class="w-1/4" />
            <h1 class="text-2xl font-bold text-gray-500 mt-8">You have no wishlist items yet, add your favourites now!
            </h1>
            <Link href="/">
            <button class="mt-4 px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600">Take me home!</button>
            </Link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>