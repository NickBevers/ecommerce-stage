<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Dropdown,InputLabel } from '@/Components/Admin';
import moment from 'moment';
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'
import { Head, Link } from '@inertiajs/vue3';
import { reactive, ref, onMounted, onBeforeMount } from 'vue';

const props = defineProps({
    order: Object,
});



const orderStatuses = [
 "Pending", "Processing", "Shipped", "Delivered", "Cancelled"
];

const selectedStatus = ref(orderStatuses[2])

onBeforeMount(() => {
  console.log(selectedStatus.value) 
    props.order.order_status = props.order.order_status.charAt(0).toUpperCase() + props.order.order_status.slice(1)
    selectedStatus.value = props.order.order_status
    console.log(selectedStatus.value) 
})

</script>
<template>
    <Head title="Products" />
    <AuthenticatedLayout>
        <div class="mt-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold leading-6 text-gray-900">Order Details</h1>
                    </div>
                </div>
                <div class=" bg-white shadow sm:rounded-lg mt-8">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex justify-between w-full">
                            <div>  <span class="text-sm">Order ID:&nbsp;</span><span class="text-sm font-bold">#{{ props.order.id }}</span></div>
                          <div>  <span class="text-sm">Order placed on:&nbsp;</span><span class="text-sm font-bold">{{ props.order.order_date }}</span></div>
                        </div>
                        <div class="mt-8 flex items-center gap-2">
                                <div class="mt-2">
                                    <InputLabel for="status" value="Order status:" />
                                </div>
                                <div class="rounded-md">
                                    <Dropdown :items="orderStatuses" :selected="selectedStatus" class="w-64"/>
                                </div>
                        </div>
                        <div>
                            <div>
                                    <div class="my-6 flow-root">
                                    <ul role="list" class="-my-5 divide-y pr-4 divide-gray-200 h-[24rem] overflow-y-auto scrollbar-thin   scrollbar-thumb-gray-100 scrollbar-track-gray-50">
                                        <li v-for="product in props.order.skus" :key="product.id" class="py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                            <!-- <img class="h-8 w-8 rounded-full" :src="person.imageUrl" alt="" /> -->
                                            </div>
                                            <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-medium text-gray-900">{{ product.pivot.product_name }}</p>
                                            <p class="truncate text-sm text-gray-500">{{ '€' + product.price_incl_vat }}</p>
                                            </div>
                                            <div>
                                                <div class="mt-4 sm:mt-0 sm:pr-9">
                                                    <label :for="`quantity-${productIdx}`" class="sr-only">Quantity, {{ product.sku.title }}</label>
                                                    <input :id="`quantity-${productIdx}`" :name="`quantity-${productIdx}`" type="number" min="1"
                                                    :max="product.amount"
                                                    class="max-w-full rounded-md border border-gray-300 py-1.5 text-left text-base font-medium leading-5 text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                                                    :value="product.pivot.amount" @change="changeAmount(product, $event)" />
                                                    <div class="">
                                                    <button type="button" class="-m-2 inline-flex p-2 text-gray-400 bg-red-300 hover:text-gray-500"
                                                        @click="removeFromOrder(product.id, product)">
                                                        <span class="sr-only">Remove</span>
                                                        <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                                                    </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                            <a href="#" class="inline-flex items-center rounded-full bg-white px-2.5 py-1 text-xs font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">View</a>
                                            </div>
                                        </div>
                                        </li>
                                    </ul>
                                    </div>
                                </div>
                        </div>
                    </div>
                    
                </div>
             
            </div>
        </div>
     
    </AuthenticatedLayout>
</template>
