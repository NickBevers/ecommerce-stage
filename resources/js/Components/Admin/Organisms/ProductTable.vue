<script setup>
import { Pagination, Alert, Toggle } from '@/Components/Admin'
import { onMounted, ref } from 'vue';
import moment from 'moment';
import { Link, router } from '@inertiajs/vue3';
import { PencilIcon, EyeIcon, TrashIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
  skus: Array,
  links: Array,
});

onMounted(() => {
  props.skus.forEach((sku) => {
    sku.updated_at = moment(sku.updated_at).fromNow();
  });
});


function getBgClass(amount) {
  if (amount >= 50) {
    return 'bg-green-500';
  } else if (amount >= 25) {
    return 'bg-yellow-500';
  } else {
    return 'bg-red-500';
  }
}

const open = ref(false)
const selectedProduct = ref(null)

function deleteProduct() {
  if (!selectedProduct.value) {
    return
  }
  router.delete('/admin/products/' + selectedProduct.value);
}

function toggleActive() {
  console.log(selectedProduct.value);
  fetch('/admin/products/toggle/' + selectedProduct.value, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
    },
  })
    .then((response) => response.json())
    .then((response) => {
      if (response.status === 'success') {
        // TODO: SHOW SUCCESS MESSAGE
      }
    });
}
</script>
<template>
  <Alert title="Delete product"
    description="Are you sure you want to delete the product? All of product data will be permanently removed from our servers forever. This action cannot be undone."
    :open="open" @close="open = false" @confirm="open = false; deleteProduct()" />
  <section class="my-8">
    <div class="overflow-hidden px-4 py-5 rounded-lg bg-white shadow">
      <div class="flow-root">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="min-w-full divide-y divide-gray-300">
              <thead>
                <tr>
                  <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Category</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Stock</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Price</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Active</th>
                  <th scope="col" class="px-3 py-3.5 text-end text-sm font-semibold text-gray-900">Action</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="product in skus" :key="product.id">
                  <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm sm:pl-0  w-2/6">
                    <div class="flex items-center">
                      <div class="h-10 w-10 flex-shrink-0">
                        <img :src="product.product_images[0].image_link" alt="iMac Front Image"
                          class="h-10 w-10 rounded-m object-cover object-center">
                      </div>
                      <div class="ml-4">
                        <div class="font-medium text-gray-900">{{ product.product.title }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500  w-1/6">
                    <div class="inline-flex rounded-full bg-blue-100 px-2 text-xs font-semibold leading-5 text-blue-800 ">
                      {{ product.product.sub_category.name }}</div>

                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 w-1/6">
                    <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 text-white"
                      :class="getBgClass(product.amount)">{{ product.amount }}</span>
                  </td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 w-1/6">€{{
                    product.price_incl_vat.toFixed(2) }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 w-1/6">
                    <Toggle :on="product.is_active" @click="selectedProduct = product.id; toggleActive();" />
                  </td>
                  <td
                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right justify-end text-sm font-medium sm:pr-0 flex gap-2 w-fill">
                    <button type="button"
                      class="rounded-full bg-indigo-600 p-2 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                      <PencilIcon class="h-3 w-3" aria-hidden="true" />
                    </button>
                    <Link :to="`/product/${product.id}`" :href="`/product/${product.id}`"
                      class="rounded-full bg-indigo-600 p-2 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <EyeIcon class="h-3 w-3" aria-hidden="true" />
                    </Link>
                    <button type="button" @click="open = true; selectedProduct = product.id;"
                      class="rounded-full bg-red-600 p-2 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                      <TrashIcon class="h-3 w-3" aria-hidden="true" />
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="border-t border-gray-200  flex sm:justify-end" v-if="props.links && props.links.length > 0">
              <Pagination :links="props.links" />
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</template>