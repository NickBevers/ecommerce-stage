<template>
    <div class="bg-white mt-24">
      <div class="mx-auto max-w-2xl px-4 pt-16 pb-24 sm:px-6 lg:max-w-7xl lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Wishlist</h1>
      <div class="grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
        <div v-for="product in products" :key="product.id" class="mt-8">
          <Link :to="'/product/' + product.href" :href="'/product/' + product.href">
          <div class="relative imgScale">
            <div class=" relative h-72 w-full overflow-hidden rounded-lg  duration-500 ">
              <img :src="product.imageSrc"
                alt="placeholder" class="h-full w-full object-cover object-center" />
            </div>
            <div class="relative mt-4">
              <h3 class="text-sm font-medium text-gray-900">{{ product.name }}</h3>
              <p class="mt-1 text-sm text-gray-500">
              {{ product.color }}
            </p>
            </div>
            <div class="grade absolute inset-x-0 top-0 flex h-72 items-end justify-end overflow-hidden rounded-lg p-4">
              <div aria-hidden="true" class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50" />
              <p class="relative text-lg font-semibold text-white">€{{ product.price }}</p>
            </div>
            <div>
              <div class="absolute top-0 right-0 p-2 m-2">
                <a href="#" class="group -m-2 flex items-center p-2">
                  <HeartIcon class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-blue-600" aria-hidden="true" />
                </a>
              </div>
            </div>
            
          </div>     
        </Link>
        <div class="mt-6">
            <a :href="'/product/' + product.href" class="relative flex items-center justify-center rounded-md border border-transparent bg-gray-100 py-2 px-8 text-sm font-medium text-gray-900 hover:bg-gray-200"
              >Add to bag<span class="sr-only">, {{ product.name }}</span></a
            >
          </div>
        </div>
      </div>
    </div>
  </div>
  </template>
  
  <script setup>
import { Link } from '@inertiajs/vue3';
import {
  HeartIcon,
} from '@heroicons/vue/24/outline'

  const products = [
    {
      id: 1,
      name: 'Zip Tote Basket',
      color: 'White and black',
      href: '51145052',
      imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-page-03-related-product-01.jpg',
      imageAlt: 'Front of zip tote bag with white canvas, black canvas straps and handle, and black zipper pulls.',
      price: '140',
    },

  ]
  </script>