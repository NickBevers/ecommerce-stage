<script setup>
import { Link } from '@inertiajs/vue3' 
</script>
<template>
  <div class="relative overflow-hidden bg-white">
    <div class="pt-32 pb-80 sm:pt-24 sm:pb-40 lg:pt-60 lg:pb-48">
      <div class="relative mx-auto max-w-7xl px-4 sm:static sm:px-6 lg:px-8">
        <div class="sm:max-w-lg">
          <h1 class="font text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">New Hot Drops</h1>
          <p class="mt-4 text-xl text-gray-500">Elevate your footwear with these amazing new shoes! Stylish, versatile,
            and durable, they're perfect for any occasion. With a comfortable fit and high-quality construction, you'll
            never want to take them off!</p>
        </div>
        <div>
          <div class="mt-10">
            <!-- Decorative image grid -->
            <div aria-hidden="true"
              class="pointer-events-none lg:absolute lg:inset-y-0 lg:mx-auto lg:w-full lg:max-w-7xl">
              <div
                class="absolute transform sm:left-1/2 sm:top-0 sm:translate-x-8 lg:left-1/2 lg:top-1/2 lg:-translate-y-1/2 lg:translate-x-8">
                <div class="flex items-center space-x-6 lg:space-x-8">
                  <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                    <div class="h-64 w-44 overflow-hidden rounded-lg sm:opacity-0 lg:opacity-100">
                      <img
                        src="https://images.unsplash.com/photo-1560769629-975ec94e6a86?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=764&q=80"
                        alt="" class="h-full w-full object-cover object-center" />
                    </div>
                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                      <img
                        src="https://images.unsplash.com/photo-1543508282-6319a3e2621f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1yZWxhdGVkfDd8fHxlbnwwfHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60"
                        alt="" class="h-full w-full object-cover object-center" />
                    </div>
                  </div>
                  <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                      <img
                        src="https://images.unsplash.com/photo-1620138546344-7b2c38516edf?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1yZWxhdGVkfDIwfHx8ZW58MHx8fHw%3D&auto=format&fit=crop&w=500&q=60"
                        alt="" class="h-full w-full object-cover object-center" />
                    </div>
                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                      <img
                        src="https://images.unsplash.com/photo-1513188732907-5f732b831ca8?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1yZWxhdGVkfDR8fHxlbnwwfHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60"
                        alt="" class="h-full w-full object-cover object-center" />
                    </div>
                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                      <img
                        src="https://images.unsplash.com/photo-1636718281370-b5e3f51a5af2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1yZWxhdGVkfDE5fHx8ZW58MHx8fHw%3D&auto=format&fit=crop&w=500&q=60"
                        alt="" class="h-full w-full object-cover object-center" />
                    </div>
                  </div>
                  <div class="grid flex-shrink-0 grid-cols-1 gap-y-6 lg:gap-y-8">
                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                      <img
                        src="https://images.unsplash.com/photo-1600500989762-7944a0b802b1?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1yZWxhdGVkfDh8fHxlbnwwfHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60"
                        alt="" class="h-full w-full object-cover object-center" />
                    </div>
                    <div class="h-64 w-44 overflow-hidden rounded-lg">
                      <img
                        src="https://images.unsplash.com/photo-1609535766154-e47e5aa87789?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1yZWxhdGVkfDE1fHx8ZW58MHx8fHw%3D&auto=format&fit=crop&w=500&q=60"
                        alt="" class="h-full w-full object-cover object-center" />
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <Link href="/products/sneakers"
              class="inline-block rounded-md border border-transparent bg-indigo-600 py-3 px-8 text-center font-medium text-white hover:bg-indigo-700">
            Shop
            Sneakers</Link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>  