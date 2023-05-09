<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3';
import {
  ProductReviews,
  WishlistButton,
  DetailCart,
  ProductVariationList,
  ProductStars,
  ImageGallery,
  ProductDetails,
  Policies,
  ConfirmationMessage
} from '@/Components/Customer';

const props = defineProps({
  sku: Object,
  variations: Object,
  sizeVariations: Object,
  userHasBought: Boolean,
});

let checked = ref(false)
const wishlistMsg = ref('');

function checkout() {
  checked.value = true
}


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
  <GuestLayout>
    <div v-if="wishlistMsg.length > 0">
      <ConfirmationMessage :Msg="wishlistMsg" />
    </div>
    <main class="mx-auto mt-36 max-w-2xl px-4 pb-16 sm:px-6 sm:pb-24 lg:max-w-7xl lg:px-8">
      <div class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-8">
        <div class="lg:col-span-5 lg:col-start-8">
          <div class="flex justify-between">
            <h1 class="text-xl font-medium text-gray-900">{{ props.sku.product.title }}</h1>
            <p class="text-xl font-medium text-red-500" v-if="props.sku.promos.length > 0
              && new Date(props.sku.promos[0].start_date.split(' ')[0]) < new Date()
              && new Date(props.sku.promos[0].end_date.split(' ')[0]) > new Date()">
              <span class="text-gray-900 no-underline mr-3">€{{ props.sku.promos[0].new_price_incl_vat.toFixed(2)
              }}</span>
              <span class="line-through">€{{ props.sku.price_incl_vat.toFixed(2) }}</span>
            </p>
            <p class="relative text-xl font-medium text-gray-900" v-else>
              €{{ props.sku.price_incl_vat.toFixed(2) }}
            </p>
          </div>
          <div class="flex m-0 p-0">
            <ProductStars v-if="props.sku.reviews.length > 0" :reviews="props.sku.reviews" />
          </div>
        </div>

        <ImageGallery :sku="props.sku" />
        <div class="mt-8 lg:col-span-5" v-if="props.sku.is_active !== false">
          <form>
            <div class="mb-2">
              <ProductVariationList :variations="props.variations" :sku="props.sku" />
            </div>
            <div class="mt-2 flex">
              <DetailCart :product="props.sku" :size-variations="props.sizeVariations" @checkout="checkout"
                class="w-full" />
              <div
                class="ml-2 flex self-end h-fit items-center justify-center rounded-md py-3 px-3 text-gray-400 hover:bg-gray-100 hover:text-gray-500"
                :class="checked ? 'mb-16' : ''">
                <WishlistButton :product="props.sku" @added-to-wishlist="handleAdd" @removed-from-wishlist="handleRemove"/>
              </div>
            </div>
          </form>
          <!-- Product details -->
          <ProductDetails :sku="props.sku" />
          <Policies />
        </div>

        <div class="mt-8 lg:col-span-5" v-else>
          <p class="text-lg font-medium text-gray-900">This product is currently unavailable.</p>
        </div>
      </div>
      <ProductReviews :reviews="props.sku.reviews" :sku="props.sku.id.toString()" :userHasBought="props.userHasBought" />
    </main>
  </GuestLayout>
</template>