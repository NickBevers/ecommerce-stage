<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {CurrencyEuroIcon, ShoppingBagIcon, ShoppingCartIcon} from "@heroicons/vue/24/outline";
import {Pagination, ProductTable, Stats, Toggle} from '@/Components/Admin';
import {Head, Link} from '@inertiajs/vue3';
import { ref } from "vue";
import {CartItem, EmptyState, OrderSummary} from "@/Components/Customer";
import {EyeIcon, PencilIcon, TrashIcon} from "@heroicons/vue/20/solid";

const stats = ref({
    orderAmount: { id: 1, name: 'Orders Today', stat: '0', icon: ShoppingBagIcon, change: '24%', changeType: 'increase' },
    skusSold: { id: 2, name: 'Product Sold', stat: '0', icon: ShoppingCartIcon, change: '24%', changeType: 'increase' },
    amount: { id: 3, name: 'Sales', stat: '200', prefix: '€', icon: CurrencyEuroIcon, change: '24%', changeType: 'decrease' },
})

const skus = ref([])

fetch('/admin/sales-today')
    .then((response) => response.json())
    .then((data) => {
        console.log(data.skus)
        skus.value = data.skus
        Object.keys(data).forEach((key) => {
            if (! stats.value[key]) return
            stats.value[key].stat = data[key]
        })
    })

</script>
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 px-4 lg:px-8">
                <Stats class="py-12" :stats="stats"/>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 pb-0 text-gray-900">Products sold today!</div>
                    <div class="overflow-hidden px-4 py-5 rounded-lg bg-white shadow">
                        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Product</th>
                                        <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 min-w-full">
                                    <tr v-for="sku in skus" :key="sku.id">
                                        <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm sm:pl-0  w-2/6">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <img :src="sku.sku.product_images[0].image_link" alt="iMac Front Image"
                                                         class="h-10 w-10 rounded-m object-cover object-center">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="font-medium text-gray-900">{{ sku.sku.product.title }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4text-sm text-gray-500 w-1/6 text-right">
                                            <span class="inline-flex rounded-full px-2 text-xs font-medium leading-5 text-gray-900">{{ sku.amount }}</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
