
<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    recentOrderedProducts: Array,
    recentProducts: Array,
});
</script>
<template>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Trending products</h2>
            </div>
            <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">
                <div v-for="product in (recentOrderedProducts.length > 0 ? recentOrderedProducts : recentProducts)"
                    :key="product.id" class="group relative">
                    <div class="h-56 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75 lg:h-72 xl:h-80">
                        <img :src="product.product_images[0].image_link" :alt="product.product_images[0].alt"
                            class="h-full w-full object-cover object-center" />
                    </div>
                    <h3 class="mt-4 text-sm text-gray-700">
                        <Link :to="'/product/' + product.sku" :href="'/product/' + product.sku">
                        <span class="absolute inset-0" />
                        {{ product.product.title }}
                        </Link>
                    </h3>
                    <p class="mt-1 text-sm font-medium text-gray-900">€{{ product.price_incl_vat }}</p>
                </div>
            </div>
        </div>
    </div>
</template>