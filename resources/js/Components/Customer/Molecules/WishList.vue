<template>
  <div class="bg-white mt-24">
    <div class="mx-auto max-w-2xl px-4 pt-16 pb-24 sm:px-6 lg:max-w-7xl lg:px-8">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Wishlist</h1>
      <div class="grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
        <div v-for="product in props.products" :key="product.id" class="mt-8" :id="product.sku.id">
          <Link :to="'/product/' + product.sku.sku" :href="'/product/' + product.sku.sku">
          <div class="relative imgScale">
            <div class=" relative h-72 w-full overflow-hidden rounded-lg  duration-500 ">
              <img :src="product.sku.product_images[0].image_link" alt="placeholder"
                class="h-full w-full object-cover object-center" />
            </div>
            <div class="relative mt-4">
              <h3 class="text-sm font-medium text-gray-900">{{ product.sku.product.title }}</h3>
            </div>
            <div class="grade absolute inset-x-0 top-0 flex h-72 items-end justify-end overflow-hidden rounded-lg p-4">
              <div aria-hidden="true" class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50" />
              <p class="relative text-lg font-semibold text-white">€{{ product.sku.price.toFixed(2) }}</p>
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
            <a :href="'/product/' + product.href"
              class="relative flex items-center justify-center rounded-md border border-transparent bg-gray-100 py-2 px-8 text-sm font-medium text-gray-900 hover:bg-gray-200">Add
              to bag<span class="sr-only">, {{ product.name }}</span></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script setup>
import { Link } from '@inertiajs/vue3';
import { useWishlistStore } from '@/Stores/wishlist';
import {
  PlusIcon,
} from '@heroicons/vue/24/solid'

const props = defineProps({
  products: Object,
});

const wishlistStore = useWishlistStore();

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

<style scoped>
.imgScale img {
  transition: all 0.5s ease;
}

.imgScale:hover img {
  transform: scale(1.1);
}

.imgScale .grade div {
  transition: all 0.5s ease;
}

.imgScale:hover .grade div {
  height: 6rem;
}
</style>