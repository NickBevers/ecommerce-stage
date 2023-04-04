<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3';
import { ProductReviews, WishlistButton, DetailCart, ProductVariationList, ProductStars, ImageGallery, ProductDetails, Policies } from '@/Components/Customer';

const props = defineProps({
  sku: Object,
  variations: Object,
  sizes: Object,
  colors: Object,
  material: String,
});

console.log(props.sku)

let checked = ref(false)

function checkout() {
  checked.value = true
}

</script>
<template>
  <GuestLayout>
    <main class="mx-auto mt-36 max-w-2xl px-4 pb-16 sm:px-6 sm:pb-24 lg:max-w-7xl lg:px-8">
      <div class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-8">
        <div class="lg:col-span-5 lg:col-start-8">
          <div class="flex justify-between">
            <h1 class="text-xl font-medium text-gray-900">{{ props.sku.product.title }}</h1>
            <p class="text-xl font-medium text-gray-900">€{{ props.sku.price_incl_vat }}</p>
          </div>
          <ProductStars />
        </div>

        <ImageGallery :sku="props.sku" />

        <div class="mt-8 lg:col-span-5">
          <form>
            <div class="mb-6">
              <ProductVariationList :variations="props.variations" />
            </div>
            <div class="mt-10 flex">
              <DetailCart :product="props.sku" @checkout="checkout" class="w-full" />
              <div
                class="ml-4 flex self-end h-fit items-center justify-center rounded-md py-3 px-3 text-gray-400 hover:bg-gray-100 hover:text-gray-500"
                :class="checked ? 'mb-16' : ''">
                <WishlistButton :product="props.sku" />
              </div>
            </div>

          </form>
          <!-- Product details -->
          <ProductDetails :sku="props.sku" />
          <Policies />
        </div>
      </div>
      <ProductReviews />
    </main>

  </GuestLayout>
</template>