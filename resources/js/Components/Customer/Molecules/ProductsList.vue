<template>
  <div class="bg-white">
    <div class="mx-auto max-w-2xl py-6 px-4 sm:py-6 sm:px-6 lg:max-w-7xl lg:px-8">
      <div class="grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
        <div v-for="product in props.skus" :key="product.id" class="mt-8" :id="product.id">
          <Link :to="'/product/' + product.sku" :href="'/product/' + product.sku">
          <div class="relative imgScale">
            <div class=" relative h-72 w-full overflow-hidden rounded-lg  duration-500 ">
              <img :src="product.product_images[0].image_link" alt="placeholder"
                class="h-full w-full object-cover object-center" />
            </div>
            <div class="relative mt-4">
              <h3 class="text-sm font-medium text-gray-900">{{ product.product.title }}</h3>
              <p class="mt-1 text-sm text-gray-500">
                {{ !product.product.description ? '' : product.product.description.length <= 30 ?
                  product.product.description : product.product.description.slice(0, 30) + '...' }} </p>
            </div>
            <div class="grade absolute inset-x-0 top-0 flex h-72 items-end justify-end overflow-hidden rounded-lg p-4">
              <div aria-hidden="true" class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50" />
              <p class="relative text-lg font-semibold text-white">€{{ product.price.toFixed(2) }}</p>
            </div>
            <div>
              <div class="absolute top-0 right-0 p-2 m-2">
                <a href="#" class="group -m-2 flex items-center p-2 rounded-md bg-white" v-if="product.wishlists.length === 0"
                  @click.prevent="addToWishlist(product.id, product.wishlists)">
                  <HeartIcon class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-indigo-600" aria-hidden="true" />
                </a>
                <a href="#" class="group -m-2 flex items-center p-2 rounded-md bg-white text-indigo-600" v-else
                  @click.prevent="removeFromWishlist(product.id, product.wishlists)">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path
                      d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                  </svg>
                </a>
              </div>
            </div>
          </div>
          </Link>
        </div>
      </div>
      <div class="mt-4 flex sm:justify-center" v-if="props.links.length > 3">
        <Pagination :links="props.links" />
      </div>
    </div>
  </div>
</template>
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
  
<script setup>
import { defineProps, onMounted } from 'vue'
import { Pagination } from '@/Components/Admin'
import { Link } from '@inertiajs/vue3';
import {
  HeartIcon,
} from '@heroicons/vue/24/outline'

const props = defineProps({
  skus: Object,
  links: Object,
});

console.log(props.skus)

function addToWishlist(product, wishlists) {
  fetch('/wishlist', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      sku_id: product,
    })
  })
    .then(response => {
      if (response.status === 200) {
        wishlists.push({ id: 0 });
      }
    })
    .catch(error => {
      console.log(error);
    });
}

function removeFromWishlist(product, wishlists) {
  fetch('/wishlist/' + product, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      sku_id: product,
    })
  })
    .then(response => {
      if (response.status === 200) {
        wishlists.pop();
      }
    })
    .catch(error => {
      console.log(error);
    });
}
</script>