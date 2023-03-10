<script setup>
import CreateProductModal from '@/Components/Admin/Molecules/CreateProductModal.vue';
import Pagination from '@/Components/Admin/Molecules/Pagination.vue'
import { defineProps, onMounted, computed } from 'vue';
import moment from 'moment';

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

</script>
<template>
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
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <tr v-for="product in skus" :key="product.id">
                <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm sm:pl-0">
                  <div class="flex items-center">
                    <div class="h-10 w-10 flex-shrink-0">
                      <img src="https://flowbite.s3.amazonaws.com/blocks/application-ui/products/imac-front-image.png" alt="iMac Front Image" class="h-10 w-10 rounded-m">
                    </div>
                    <div class="ml-4">
                      <div class="font-medium text-gray-900">{{ product.product.title }}</div>
                    </div>
                  </div>
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                  <div class="inline-flex rounded-full bg-blue-100 px-2 text-xs font-semibold leading-5 text-blue-800">{{ product.product.sub_category_id }}</div>
             
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 text-white" :class="getBgClass(product.amount)">{{product.amount}}</span>
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">$23</td>
                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-left text-sm font-medium sm:pr-0">
                  <a href="#" class="text-indigo-600 hover:text-indigo-900"
                    >Edit<span class="sr-only">, {{ product.id }}</span></a
                  >
                </td>
              </tr>
            </tbody>
          </table>
          <div>
            <Pagination :links="props.links" />
        </div>
        </div>
      </div>
 
    </div>
</div>
    </section>
</template>