<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CurrencyEuroIcon, HomeIcon, ShoppingBagIcon, ShoppingCartIcon } from "@heroicons/vue/24/outline";
import { Pagination, ProductTable, Stats, Toggle } from '@/Components/Admin';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from "vue";
import { CartItem, EmptyState, OrderSummary } from "@/Components/Customer";
import { EyeIcon, PencilIcon, TrashIcon } from "@heroicons/vue/20/solid";

const stats = ref({
    orderAmount: { id: 1, name: 'Orders Today', stat: '0', icon: ShoppingBagIcon, change: '24%', changeType: 'increase' },
    skusSold: { id: 2, name: 'Product Sold', stat: '0', icon: ShoppingCartIcon, change: '24%', changeType: 'increase' },
    amount: { id: 3, name: 'Sales', stat: '200', prefix: '€', icon: CurrencyEuroIcon, change: '24%', changeType: 'decrease' },
})

const skus = ref([])

fetch('/admin/sales-today')
    .then((response) => response.json())
    .then((data) => {
        skus.value = data.skus
        Object.keys(data).forEach((key) => {
            if (!stats.value[key]) return
            stats.value[key].stat = data[key]
        })

        data.amount = data.amount.toFixed(2)

        // calculate difference in orderAmount in %
        stats.value.orderAmount.change = ((data.orderAmount - data.orderAmountYesterday) / data.orderAmountYesterday * 100).toFixed(1) + '%' || '';
        stats.value.orderAmount.changeType = stats.value.orderAmount.change > 0 ? 'increase' : 'decrease';
        if (stats.value.orderAmount.change === 'NaN%') stats.value.orderAmount.change = '0%'
        if (stats.value.orderAmount.change === 'Infinity%') stats.value.orderAmount.change = `${data.orderAmount * 100}%`; stats.value.orderAmount.changeType = 'increase'

        // calculate difference in skusSold in %
        stats.value.skusSold.change = ((data.skusSold - data.skusSoldYesterday) / data.skusSoldYesterday * 100).toFixed(1) + '%' || '';
        if (stats.value.skusSold.change === 'NaN%') stats.value.skusSold.change = '0%'; stats.value.skusSold.changeType = 'neutral'
        stats.value.skusSold.changeType = stats.value.skusSold.change > 0 ? 'increase' : 'decrease';

        // calculate difference in amount in %
        stats.value.amount.change = ((data.amount - data.amountYesterday) / data.amountYesterday * 100).toFixed(1) + '%' || '';
        stats.value.amount.changeType = stats.value.amount.change > 0 ? 'increase' : 'decrease';
        if (stats.value.amount.change === 'NaN%') stats.value.amount.change = '0%'
        if (stats.value.amount.change === 'Infinity%') stats.value.amount.change = `${(data.amount * 100).toFixed(0)}%`; stats.value.amount.changeType = 'increase'
    })

</script>
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 px-4 lg:px-8">
                <Stats class="py-12" :stats="stats" />
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" v-if="skus.length > 0">
                    <div class="p-6 pb-0 text-gray-900">Products sold today!</div>
                    <div class="overflow-hidden px-4 py-5 rounded-lg bg-white shadow">
                        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                                Product</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Amount
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 min-w-full">
                                        <tr v-for="sku in skus" :key="sku.id">
                                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm sm:pl-0  w-2/6">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <img :src="sku.sku.product_images[0].image_link"
                                                            alt="iMac Front Image"
                                                            class="h-10 w-10 rounded-m object-cover object-center">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900">{{ sku.sku.product.title }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4text-sm text-gray-500 w-1/6 text-right">
                                                <span
                                                    class="inline-flex rounded-full px-2 text-xs font-medium leading-5 text-gray-900">{{
                                                        sku.amount }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else>
                    <div class="flex flex-col items-center justify-center h-64 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="flex flex-col items-center justify-center">
                            <ShoppingBagIcon class="h-20 w-20 text-gray-500" aria-hidden="true" />
                            <h1 class="text-xl font-bold text-gray-500 mt-4">There haven't been any orders today (yet)</h1>
                        </div>
                </div>
            </div>
        </div>
    </div>
</AuthenticatedLayout></template>
