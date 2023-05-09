<script setup>
import { Pagination, Alert, Toggle } from '@/Components/Admin'
import { onMounted, ref } from 'vue'
import moment from 'moment'
import { Link, router } from '@inertiajs/vue3'
import { PencilIcon, EyeIcon, TrashIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    orders: Object,
})

onMounted(() => {
    if (props.orders.data) {
        props.orders.data.forEach((order) => {
            order.order_date = moment(order.order_date).format('MMMM Do YYYY, h:mm:ss a')
        })
    }
})

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
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">ID
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Order date</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Billing Address
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Amount
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Status
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white" v-if="props.orders">
                                <tr v-for="order in props.orders.data" :key="order.id">
                                    <td class="whitespace-nowrap py-2 pr-3 text-sm sm:pl-0t">
                                        <div class="flex items-left">
                                            <div class="font-medium text-gray-900">#{{ order.id }}</div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 ">
                                        <div class="font-medium text-gray-900">{{ order.order_date }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <div class="font-medium text-gray-900" v-if="order.billing_address">{{
                                            order.firstname }}
                                            {{ order.lastname }}
                                            {{ order.billing_address.address_line1 }}
                                            {{ order.billing_address.address_line2 }}, {{
                                                order.billing_address.city }} {{
        order.billing_address.country }}, {{
        order.billing_address.postal_code }}
                                        </div>
                                        <div class="font-medium text-gray-900" v-else> {{
                                            order.firstname }}
                                            {{ order.lastname }}
                                            {{ order.shipping_address.address_line1 }} {{
                                                order.shipping_address.address_line2 }},
                                            {{ order.shipping_address.city }} {{
                                                order.shipping_address.country }}, {{
        order.shipping_address.postal_code }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        €{{
                                            order.total_price.toFixed(2) }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-left">
                                        <span
                                            class="inline-flex items-left rounded-full bg-gray-100 px-3 py-0.5 text-sm font-medium text-gray-800">{{
                                                order.order_status }}</span>
                                    </td>
                                    <td
                                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right justify-end text-sm font-medium sm:pr-0 flex gap-2">
                                        <Link :href="route('admin.orders.show', order.id)"
                                            class="rounded-full bg-indigo-600 p-2 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        <EyeIcon class="h-3 w-3" aria-hidden="true" />
                                        </Link>
                                        <button type="button" @click="open = true"
                                            class="rounded-full bg-red-600 p-2 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                            <TrashIcon class="h-3 w-3" aria-hidden="true" />
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="border-t border-gray-200  flex sm:justify-end">
                            <Pagination :links="props.orders.links" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>
