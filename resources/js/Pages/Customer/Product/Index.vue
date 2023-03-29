<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { ProductReviews, WishlistButton, ProductVariationList, ProductStars, ImageGallery, ProductDetails, Policies } from '@/Components/Customer';

const props = defineProps({
  sku: Object,
  variations: Object,
  sizes: Object,
  colors: Object,
  material: String,
});

console.log(props.sku)
</script>
<template>
  <GuestLayout>
    <main class="mx-auto mt-36 max-w-2xl px-4 pb-16 sm:px-6 sm:pb-24 lg:max-w-7xl lg:px-8">
      <div class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-8">
        <div class="lg:col-span-5 lg:col-start-8">
          <div class="flex justify-between">
            <h1 class="text-xl font-medium text-gray-900">{{ props.sku.product.title }}</h1>
            <p class="text-xl font-medium text-gray-900">€{{ props.sku.price }}</p>
          </div>
          <ProductStars />
        </div>

        <ImageGallery :sku="props.sku" />

      <div class="mt-8 lg:col-span-5">
        <form>
            <div class="mb-6">
              <ProductVariationList :variations="props.variations" />
            </div>

            <!-- Color picker -->
            <div v-if="props.colors.length > 0">
              <h2 class="text-sm font-medium text-gray-900">Color</h2>
              <fieldset class="mt-2">
                <legend class="sr-only">Choose a color</legend>
                <div class="flex items-center space-x-3">
                  <!--
                          Active and Checked: "ring ring-offset-1"
                          Not Active and Checked: "ring-2"
                        -->
                  <label
                    class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 focus:outline-none ring-gray-900">
                    <input type="radio" name="color-choice" value="Black" class="sr-only"
                      aria-labelledby="color-choice-0-label">
                    <span id="color-choice-0-label" class="sr-only">{{ props.colors[0].name }}</span>
                    <span aria-hidden="true" class='h-8 w-8 rounded-full border border-black border-opacity-10'
                      :style="{ backgroundColor: props.colors[0].hex }"></span>
                  </label>
                </div>
              </fieldset>
            </div>
            <div v-else-if="props.colors.length === 1" class="flex flex-row mt-8">
              <h2 class="text-sm font-medium text-gray-900 py-0.5">Color: </h2>
              <span
                class="inline-flex ml-2 items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
              {{ props.colors[0].name }}
            </span>
          </div>

            <!-- Size picker -->
            <div class="mt-8" v-if="props.sizes.length > 0">
              <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium text-gray-900">Size</h2>
              </div>

              <fieldset class="mt-2">
                <legend class="sr-only">Choose a size</legend>
                <div class="grid grid-cols-3 gap-3 sm:grid-cols-5">
                  <!--
                          In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"
                          Active: "ring-2 ring-indigo-500 ring-offset-2"
                          Checked: "border-transparent bg-indigo-600 text-white hover:bg-indigo-700", Not Checked: "border-gray-200 bg-white text-gray-900 hover:bg-gray-50"
                        -->
                  <label v-for="size in props.sizes"
                    class="flex flex-row items-center justify-center rounded-md border py-3 px-3 text-sm font-medium sm:flex-1 cursor-pointer active:ring-2 active:ring-indigo-500 active:ring-offset-2">
                    <input type="radio" name="size-choice" :value="size" class="sr-only"
                      aria-labelledby="size-choice-0-label">
                    <span id="size-choice-0-label">{{ size }}</span>
                  </label>
                </div>
              </fieldset>
            </div>
            <div class="mt-10 flex justify-between">
              <button type="submit"
                class="flex  w-full flex-1 items-center justify-center rounded-md border border-transparent bg-indigo-600 py-3 px-8 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50 sm:w-full">Add
                to bag</button>
              <div
                class="ml-4 flex items-center justify-center rounded-md py-3 px-3 text-gray-400 hover:bg-gray-100 hover:text-gray-500">
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