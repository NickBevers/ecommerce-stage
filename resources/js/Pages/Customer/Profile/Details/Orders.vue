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
import {EllipsisVerticalIcon, HomeIcon, MagnifyingGlassIcon, ShoppingBagIcon} from '@heroicons/vue/24/outline'
import { CheckCircleIcon } from '@heroicons/vue/20/solid'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    orders: {
        type: Array,
        required: true,
    },
})

console.log(props.orders)

function showProducts(orderId) {
    console.log(orderId)

}

</script>
<template>
    <Index>
        <main class="py-24 lg:py-0 w-full">
            <div class="mx-auto w-full">
                <div class="mx-auto px-4  lg:px-0">
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Order history</h1>
                    <p class="mt-2 text-sm text-gray-500">Check the status of recent orders and manage returns.</p>
                </div>
            </div>

            <section aria-labelledby="recent-heading" class="mt-16 w-full">
                <h2 id="recent-heading" class="sr-only">Recent orders</h2>
                <div class="mx-auto max-w-7xl">
                    <div class="mx-auto space-y-8 sm:px-4 lg:px-0 w-full" v-if="props.orders.length > 0">
                        <div v-for="order in props.orders" :key="order.id" @click="showProducts(order.id)"
                            class="border-b border-t border-gray-200 bg-white shadow-sm sm:rounded-lg sm:border cursor-pointer">
                            <h3 class="sr-only">
                                Order placed on <time :datetime="order.order_date">{{ order.order_date }}</time>
                            </h3>
                            <div class="flex items-center border-b border-gray-200 p-4  sm:p-6 flex-row ">
                                <dl class="grid flex-1 grid-cols-2 gap-x-6 text-sm sm:grid-cols-5">
                                    <div>
                                        <dt class="font-medium text-gray-900">Order number</dt>
                                        <dd class="mt-1 text-gray-500">#{{ order.id }}</dd>
                                    </div>
                                    <div class="hidden sm:block">
                                        <dt class="font-medium text-gray-900">Date placed</dt>
                                        <dd class="mt-1 text-gray-500">
                                            <p>{{ moment(order.order_date).format('LLL') }}</p>

                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-900">Total amount</dt>
                                        <dd class="mt-1 font-medium text-gray-500">€{{ order.total_price.toFixed(2) }}
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
                                <li v-for="product in order.skus" :key="product.id" class="p-4 sm:p-6">
                                    <div class="flex items-center sm:items-start">
                                        <div
                                            class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-lg bg-gray-200 sm:h-20 sm:w-20">
                                            <img :src="product.product_images[0].image_link" :alt="product.imageAlt"
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
                                        <div class="flex items-center" v-if="order.order_status === 'delivered'">
                                            <CheckCircleIcon class="h-5 w-5 text-green-500" aria-hidden="true" />
                                            <p class="ml-2 text-sm font-medium text-gray-500">
                                                Delivered<time :datetime="order.deliveredDatetime" v-if="order.delivery_date"> on {{
                                                    order.deliveredDate }}</time>
                                            </p>
                                        </div>
                                        <div class="flex items-center" v-else>
                                            <CheckCircleIcon class="h-5 w-5 text-gray-300" aria-hidden="true" />
                                            <p class="ml-2 text-sm font-medium text-gray-500">
                                                {{ order.order_status }}
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

                    <div v-else>
                        <div class="flex flex-col items-center justify-center h-64 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                            <div class="flex flex-col items-center justify-center">
                                <HomeIcon class="h-20 w-20 text-gray-500" aria-hidden="true" />
                                <h1 class="text-xl font-bold text-gray-500 mt-4">You have no orders yet. <br> Make your first one now!</h1>
                                <button  class="mt-4 px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600">Take me there!</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </Index>
</template>