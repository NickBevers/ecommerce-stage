<template>
    <GuestLayout>
    <main class="mx-auto mt-36 max-w-2xl px-4 pb-16 sm:px-6 sm:pb-24 lg:max-w-7xl lg:px-8">
    <div class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-8">
      <div class="lg:col-span-5 lg:col-start-8">
        <div class="flex justify-between">
          <h1 class="text-xl font-medium text-gray-900">{{ props.sku.product.title }}</h1>
          <p class="text-xl font-medium text-gray-900">€{{ props.sku.price }}</p>
        </div>
        <!-- Reviews -->
        <div class="mt-4">
          <h2 class="sr-only">Reviews</h2>
          <div class="flex items-center">
            <p class="text-sm text-gray-700">
              3.9
              <span class="sr-only"> out of 5 stars</span>
            </p>
            <div class="ml-1 flex items-center">
              <!-- Active: "text-yellow-400", Inactive: "text-gray-200" -->
              <svg class="text-yellow-400 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
              </svg>

              <svg class="text-yellow-400 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
              </svg>

              <svg class="text-yellow-400 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
              </svg>

              <svg class="text-yellow-400 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
              </svg>

              <svg class="text-gray-200 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
              </svg>
            </div>
            <div aria-hidden="true" class="ml-4 text-sm text-gray-300">·</div>
            <div class="ml-4 flex">
              <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">See all 512 reviews</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Image gallery -->
      <div class="mt-8 lg:col-span-7 lg:col-start-1 lg:row-span-3 lg:row-start-1 lg:mt-0">
        <h2 class="sr-only">Images</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-3 lg:gap-8">
          <img src="https://tailwindui.com/img/ecommerce-images/product-page-01-featured-product-shot.jpg" alt="Back of women&#039;s Basic Tee in black." class="lg:col-span-2 lg:row-span-2 rounded-lg">

          <img src="https://tailwindui.com/img/ecommerce-images/product-page-01-product-shot-01.jpg" alt="Side profile of women&#039;s Basic Tee in black." class="hidden lg:block rounded-lg">

          <img src="https://tailwindui.com/img/ecommerce-images/product-page-01-product-shot-02.jpg" alt="Front of women&#039;s Basic Tee in black." class="hidden lg:block rounded-lg">
        </div>
      </div>

      <div class="mt-8 lg:col-span-5">
        <form>
          <!-- Color picker -->
          <div>
            <h2 class="text-sm font-medium text-gray-900">Color</h2>

            <fieldset class="mt-2">
              <legend class="sr-only">Choose a color</legend>
              <div class="flex items-center space-x-3">
                <!--
                  Active and Checked: "ring ring-offset-1"
                  Not Active and Checked: "ring-2"
                -->
                <label class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 focus:outline-none ring-gray-900">
                  <input type="radio" name="color-choice" value="Black" class="sr-only" aria-labelledby="color-choice-0-label">
                  <span id="color-choice-0-label" class="sr-only">{{ props.colors[0].name }}</span>
                  <span aria-hidden="true" 
                  class='h-8 w-8 rounded-full border border-black border-opacity-10' 
                  :style="{ backgroundColor: props.colors[0].hex}"></span>
                </label>
              </div>
            </fieldset>
          </div>

          <!-- Size picker -->
          <div class="mt-8">
            <div class="flex items-center justify-between">
              <h2 class="text-sm font-medium text-gray-900">Size</h2>
            </div>

            <fieldset class="mt-2">
              <legend class="sr-only">Choose a size</legend>
              <div class="grid grid-cols-3 gap-3 sm:grid-cols-6">
                <!--
                  In Stock: "cursor-pointer", Out of Stock: "opacity-25 cursor-not-allowed"
                  Active: "ring-2 ring-indigo-500 ring-offset-2"
                  Checked: "border-transparent bg-indigo-600 text-white hover:bg-indigo-700", Not Checked: "border-gray-200 bg-white text-gray-900 hover:bg-gray-50"
                -->
                <label class="flex items-center justify-center rounded-md border py-3 px-3 text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none">
                  <input type="radio" name="size-choice" value="XXS" class="sr-only" aria-labelledby="size-choice-0-label">
                  <span id="size-choice-0-label">XXS</span>
                </label>
              </div>
            </fieldset>
          </div>
        
         
            <div class="mt-10 flex justify-between">
              <button type="submit" class="flex  w-full flex-1 items-center justify-center rounded-md border border-transparent bg-indigo-600 py-3 px-8 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50 sm:w-full">Add to bag</button>
              <button type="button" class="ml-4 flex items-center justify-center rounded-md py-3 px-3 text-gray-400 hover:bg-gray-100 hover:text-gray-500">
                <svg class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                </svg>
                <span class="sr-only">Add to favorites</span>
              </button>
        
          </div>
        </form>

        <!-- Product details -->
        <div class="mt-10">
          <h2 class="text-sm font-medium text-gray-900">Description</h2>

          <div class="prose prose-sm mt-4 text-gray-500">
            <p>The Basic tee is an honest new take on a classic. The tee uses super soft, pre-shrunk cotton for true comfort and a dependable fit. They are hand cut and sewn locally, with a special dye technique that gives each tee it's own look.</p>
          </div>
        </div>

        <div class="mt-8 border-t border-gray-200 pt-8">
          <h2 class="text-sm font-medium text-gray-900">Extra Info</h2>

          <div class="prose prose-sm mt-4 text-gray-500">
            <p>The Basic tee is an honest new take on a classic. The tee uses super soft, pre-shrunk cotton for true comfort and a dependable fit. They are hand cut and sewn locally, with a special dye technique that gives each tee it's own look.</p>
          </div>
        </div>

        <!-- Policies -->
        <section aria-labelledby="policies-heading" class="mt-10">
          <h2 id="policies-heading" class="sr-only">Our Policies</h2>

          <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-6 text-center">
              <dt>
                <svg class="mx-auto h-6 w-6 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.115 5.19l.319 1.913A6 6 0 008.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 002.288-4.042 1.087 1.087 0 00-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 01-.98-.314l-.295-.295a1.125 1.125 0 010-1.591l.13-.132a1.125 1.125 0 011.3-.21l.603.302a.809.809 0 001.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 001.528-1.732l.146-.292M6.115 5.19A9 9 0 1017.18 4.64M6.115 5.19A8.965 8.965 0 0112 3c1.929 0 3.716.607 5.18 1.64" />
                </svg>
                <span class="mt-4 text-sm font-medium text-gray-900">International delivery</span>
              </dt>
              <dd class="mt-1 text-sm text-gray-500">Get your order in 2 years</dd>
            </div>

            <div class="rounded-lg border border-gray-200 bg-gray-50 p-6 text-center">
              <dt>
                <svg class="mx-auto h-6 w-6 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="mt-4 text-sm font-medium text-gray-900">Loyalty rewards</span>
              </dt>
              <dd class="mt-1 text-sm text-gray-500">Don&#039;t look at other tees</dd>
            </div>
          </dl>
        </section>
      </div>
    </div>
    <ProductReviews />
  </main>

</GuestLayout>
</template>
<script setup>
import { defineProps, onMounted, ref} from 'vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import ProductReviews from '@/Components/Customer/Molecules/ProductReviews.vue';

const props = defineProps({
  sku: Object,
  variations: Object,
  sizes: Object,
  colors: Object,
  material: Object,
});

console.log(props.colors)

</script>