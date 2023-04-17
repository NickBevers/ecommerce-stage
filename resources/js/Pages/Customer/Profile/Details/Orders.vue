<script setup>
import Index from '../Index.vue'
import moment from 'moment'
import {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
} from '@headlessui/vue'
import { EllipsisVerticalIcon, MagnifyingGlassIcon, ShoppingBagIcon } from '@heroicons/vue/24/outline'
import { CheckCircleIcon } from '@heroicons/vue/20/solid'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    orders: {
        type: Array,
        required: true,
    },
})

console.log(props.orders)

const orders = [
    {
        number: 'WU88191111',
        href: '#',
        invoiceHref: '#',
        createdDate: 'Jul 6, 2021',
        createdDatetime: '2021-07-06',
        deliveredDate: 'July 12, 2021',
        deliveredDatetime: '2021-07-12',
        total: '$160.00',
        products: [
            {
                id: 1,
                name: 'Micro Backpack',
                description:
                    'Are you a minimalist looking for a compact carry option? The Micro Backpack is the perfect size for your essential everyday carry items. Wear it like a backpack or carry it like a satchel for all-day use.',
                href: '#',
                price: '$70.00',
                imageSrc: 'https://tailwindui.com/img/ecommerce-images/order-history-page-03-product-01.jpg',
                imageAlt:
                    'Moss green canvas compact backpack with double top zipper, zipper front pouch, and matching carry handle and backpack straps.',
            },
            {
                id: 1,
                name: 'Micro Backpack',
                description:
                    'Are you a minimalist looking for a compact carry option? The Micro Backpack is the perfect size for your essential everyday carry items. Wear it like a backpack or carry it like a satchel for all-day use.',
                href: '#',
                price: '$70.00',
                imageSrc: 'https://tailwindui.com/img/ecommerce-images/order-history-page-03-product-01.jpg',
                imageAlt:
                    'Moss green canvas compact backpack with double top zipper, zipper front pouch, and matching carry handle and backpack straps.',
            },
            // More products...
        ],
    },
    {
        number: 'WU88191111',
        href: '#',
        invoiceHref: '#',
        createdDate: 'Jul 6, 2021',
        createdDatetime: '2021-07-06',
        deliveredDate: 'July 12, 2021',
        deliveredDatetime: '2021-07-12',
        total: '$160.00',
        products: [
            {
                id: 1,
                name: 'Micro Backpack',
                description:
                    'Are you a minimalist looking for a compact carry option? The Micro Backpack is the perfect size for your essential everyday carry items. Wear it like a backpack or carry it like a satchel for all-day use.',
                href: '#',
                price: '$70.00',
                imageSrc: 'https://tailwindui.com/img/ecommerce-images/order-history-page-03-product-01.jpg',
                imageAlt:
                    'Moss green canvas compact backpack with double top zipper, zipper front pouch, and matching carry handle and backpack straps.',
            },
            {
                id: 1,
                name: 'Micro Backpack',
                description:
                    'Are you a minimalist looking for a compact carry option? The Micro Backpack is the perfect size for your essential everyday carry items. Wear it like a backpack or carry it like a satchel for all-day use.',
                href: '#',
                price: '$70.00',
                imageSrc: 'https://tailwindui.com/img/ecommerce-images/order-history-page-03-product-01.jpg',
                imageAlt:
                    'Moss green canvas compact backpack with double top zipper, zipper front pouch, and matching carry handle and backpack straps.',
            },
            // More products...
        ],
    },
]
</script>
<template>
    <Index>
        <main class="py-24 py-6 lg:py-0 w-full">
            <div class="mx-auto w-full">
                <div class="mx-auto px-4  lg:px-0">
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Order history</h1>
                    <p class="mt-2 text-sm text-gray-500">Check the status of recent orders and manage returns.</p>
                </div>
            </div>

            <section aria-labelledby="recent-heading" class="mt-16 w-full">
                <h2 id="recent-heading" class="sr-only">Recent orders</h2>
                <div class="mx-auto max-w-7xl">
                    <div class="mx-auto space-y-8 sm:px-4 lg:px-0 w-full">
                        <div v-for="order in props.orders" :key="order.order.id"
                            class="border-b border-t border-gray-200 bg-white shadow-sm sm:rounded-lg sm:border">
                            <h3 class="sr-only">
                                Order placed on <time :datetime="order.order.order_date">{{ order.order.order_date }}</time>
                            </h3>
                            <div class="flex items-center border-b border-gray-200 p-4  sm:p-6 flex-row ">
                                <dl class="grid flex-1 grid-cols-2 gap-x-6 text-sm sm:grid-cols-5">
                                    <div>
                                        <dt class="font-medium text-gray-900">Order number</dt>
                                        <dd class="mt-1 text-gray-500">#{{ order.order.id }}</dd>
                                    </div>
                                    <div class="hidden sm:block">
                                        <dt class="font-medium text-gray-900">Date placed</dt>
                                        <dd class="mt-1 text-gray-500">
                                            <p>{{ moment(order.order.order_date).format('LLL') }}</p>

                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-900">Total amount</dt>
                                        <dd class="mt-1 font-medium text-gray-500">€{{ order.order.total_price.toFixed(2) }}
                                        </dd>
                                    </div>
                                    <div v-if="order.shipping_address">
                                        <dt class="font-medium text-gray-900">Shipping Address</dt>
                                        <dd class="mt-1 font-medium text-gray-500">{{ order.shipping_address.address_line1
                                        }}
                                            {{ order.shipping_address.address_line2 }}, {{ order.shipping_address.city }} {{
                                                order.shipping_address.postal_code }} {{ order.shipping_address.country }}
                                        </dd>
                                    </div>
                                    <div v-if="order.billing_address">
                                        <dt class="font-medium text-gray-900">Billing Address</dt>
                                        <dd class="mt-1 font-medium text-gray-500">{{ order.billing_address.address_line1
                                        }}
                                            {{ order.billing_address.address_line2 }}, {{ order.billing_address.city }} {{
                                                order.billing_address.postal_code }} {{ order.billing_address.country }}
                                        </dd>
                                    </div>
                                </dl>


                            </div>

                            <!-- Products -->
                            <h4 class="sr-only">Items</h4>
                            <ul role="list" class="divide-y divide-gray-200">
                                <li v-for="product in order.order.skus" :key="product.id" class="p-4 sm:p-6">
                                    <div class="flex items-center sm:items-start">
                                        <div
                                            class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-lg bg-gray-200 sm:h-20 sm:w-20">
                                            <img :src="product.imageSrc" :alt="product.imageAlt"
                                                class="h-full w-full object-cover object-center" />
                                        </div>
                                        <div class="ml-6 flex-1 text-sm">
                                            <div class="font-medium text-gray-900 sm:flex sm:justify-between">
                                                <h5>{{ product.pivot.product_name }}</h5>
                                                <p class="mt-2 sm:mt-0">€{{ product.price_incl_vat.toFixed(2) }}</p>
                                            </div>
                                            <p class="hidden text-gray-500 sm:mt-2 sm:block">
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-6 sm:flex sm:justify-between">
                                        <div class="flex items-center">
                                            <CheckCircleIcon class="h-5 w-5 text-green-500" aria-hidden="true" />
                                            <p class="ml-2 text-sm font-medium text-gray-500">
                                                Delivered on <time :datetime="order.deliveredDatetime">{{
                                                    order.deliveredDate }}</time>
                                            </p>
                                        </div>

                                        <div
                                            class="mt-6 flex items-center space-x-4 divide-x divide-gray-200 border-t border-gray-200 pt-4 text-sm font-medium sm:ml-4 sm:mt-0 sm:border-none sm:pt-0">
                                            <div class="flex flex-1 justify-center">
                                                <Link :href="`/product/${product.sku}`"
                                                    class="whitespace-nowrap text-indigo-600 hover:text-indigo-500">View
                                                product</Link>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </main>

    </Index>
</template>