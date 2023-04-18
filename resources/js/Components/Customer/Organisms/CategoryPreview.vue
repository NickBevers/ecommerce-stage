<script setup>
import { Link } from '@inertiajs/vue3'
</script>
<template>
  <div class="bg-gray-50">
    <div class="mx-auto max-w-7xl py-16 px-4 sm:py-12 sm:px-6 lg:px-8">
      <div class="sm:flex sm:items-baseline sm:justify-between">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Shop by Category</h2>
      </div>
      <div class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:grid-rows-2 sm:gap-x-6 lg:gap-8">
        <div class="group aspect-w-2 aspect-h-1 overflow-hidden rounded-lg sm:aspect-h-1 sm:aspect-w-1 sm:row-span-2">
          <img
            src="https://images.unsplash.com/photo-1416339698674-4f118dd3388b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Nnx8dHNoaXJ0c3xlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60"
            alt="Two models wearing women's black cotton crewneck tee and off-white cotton crewneck tee."
            class="object-cover object-center group-hover:opacity-75" />
          <div aria-hidden="true" class="bg-gradient-to-b from-transparent to-black opacity-50" />
          <div class="flex items-end p-6">
            <div>
              <h3 class="font-semibold text-white">
                <Link href="/products/tshirts">
                <span class="absolute inset-0" />
                T-Shirts
                </Link>
              </h3>
              <p aria-hidden="true" class="mt-1 text-sm text-white">Shop now</p>
            </div>
          </div>
        </div>
        <div class="group aspect-w-2 aspect-h-1 overflow-hidden rounded-lg sm:aspect-none sm:relative sm:h-full">
          <img src="https://images.pexels.com/photos/6650001/pexels-photo-6650001.jpeg?auto=compress&cs=tinysrgb&w=1600"
            alt="Wooden shelf with gray and olive drab green baseball caps, next to wooden clothes hanger with sweaters."
            class="object-cover object-center group-hover:opacity-75 sm:absolute sm:inset-0 sm:h-full sm:w-full" />
          <div aria-hidden="true" class="bg-gradient-to-b from-transparent to-black opacity-50 sm:absolute sm:inset-0" />
          <div class="flex items-end p-6 sm:absolute sm:inset-0">
            <div>
              <h3 class="font-semibold text-white">
                <Link href="/products/bags">
                <span class="absolute inset-0" />
                Bags
                </Link>
              </h3>
              <p aria-hidden="true" class="mt-1 text-sm text-white">Shop now</p>
            </div>
          </div>
        </div>
        <div class="group aspect-w-2 aspect-h-1 overflow-hidden rounded-lg sm:aspect-none sm:relative sm:h-full">
          <img
            src="https://images.unsplash.com/photo-1600815207540-a9e265616357?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=627&q=80"
            alt="Walnut desk organizer set with white modular trays, next to porcelain mug on wooden desk."
            class="object-cover object-top group-hover:opacity-75 sm:absolute sm:inset-0 sm:h-full sm:w-full" />
          <div aria-hidden="true" class="bg-gradient-to-b from-transparent to-black opacity-50 sm:absolute sm:inset-0" />
          <div class="flex items-end p-6 sm:absolute sm:inset-0">
            <div>
              <h3 class="font-semibold text-white">
                <Link href="/products/sandals">
                <span class="absolute inset-0" />
                Sandals
                </Link>
              </h3>
              <p aria-hidden="true" class="mt-1 text-sm text-white">Shop now</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>  