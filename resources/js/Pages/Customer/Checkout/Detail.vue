<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Link } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'

const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
    skus: {
        type: Object,
        required: true,
    },
    shipping_address: {
        type: Object,
        required: true,
    },
    billing_address: {
        type: Object,
        required: true,
    },
})

let subTotal = ref(0)

onMounted(() => {
    props.order.skus.forEach((sku) => {
        subTotal.value += (sku.pivot.amount * sku.price_excl_vat)
    })
})
</script>
<template>
    <GuestLayout>
        <main class="relative lg:min-h-full mt-12">
            <div class="h-80 overflow-hidden lg:absolute lg:h-full lg:w-1/2 lg:pr-4 xl:pr-12">
                <img src="/assets/order-confirm.webp"
                    alt="TODO" class="h-full w-full object-cover object-center" />
            </div>

            <div>
                <div
                    class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:grid lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8 lg:py-32 xl:gap-x-24">
                    <div class="lg:col-start-2">
                        <h1 class="text-sm font-medium text-indigo-600">Payment successful</h1>
                        <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">Thanks for ordering</p>
                        <p class="mt-2 text-base text-gray-500">We appreciate your order, we’re currently processing it. So
                            hang
                            tight and we’ll send you confirmation very soon!</p>

                        <dl class="mt-16 text-sm font-medium">
                            <dt class="text-gray-900">Tracking number</dt>
                            <dd class="mt-2 text-indigo-600">..</dd>
                        </dl>

                        <ul role="list"
                            class="mt-6 divide-y divide-gray-200 border-t border-gray-200 text-sm font-medium text-gray-500 max-h-[32rem] overflow-y-auto no-scrollbar">
                            <li v-for="product in props.skus" :key="product.id" class="flex space-x-6 py-6">
                                <img :src="product.product_images[0].image_link" :alt="product.product_images[0].alt"
                                    class="h-24 w-24 flex-none rounded-md bg-gray-100 object-cover object-center" />
                                <div class="flex flex-col justify-between w-full">
                                    <div class="flex flex-row ">
                                        <div class="flex-auto space-y-1">
                                            <h3 class="text-gray-900">
                                                <Link :href="'/product/' + product.sku">{{ product.product.title }}</Link>
                                            </h3>
                                            <span class="text-sm text-gray-500">{{
                                                product.product.description && product.product.description.length > 30
                                                ? product.product.description.slice(0, 30) + "..."
                                                : product.product.description
                                            }}</span>
                                        </div>
                                        <p class="flex-none font-medium text-gray-900">€{{ product.price_incl_vat.toFixed(2)
                                        }}
                                        </p>
                                    </div>
                                    <div class="w-full text-right">
                                        <span class="text-gray-900">Quantity: {{ product.pivot.amount }}</span>
                                    </div>
                                </div>


                            </li>
                        </ul>

                        <dl class="space-y-6 border-t border-gray-200 pt-6 text-sm font-medium text-gray-500">
                            <div class="flex justify-between">
                                <dt>Subtotal</dt>
                                <dd class="text-gray-900">€{{ subTotal.toFixed(2) }}</dd>
                            </div>

                            <div class="flex justify-between">
                                <dt>Shipping</dt>
                                <dd class="text-gray-900">..</dd>
                            </div>

                            <div class="flex justify-between">
                                <dt>Taxes</dt>
                                <dd class="text-gray-900">€{{ (props.order.total_price - subTotal).toFixed(2) }}</dd>
                            </div>

                            <div class="flex items-center justify-between border-t border-gray-200 pt-6 text-gray-900">
                                <dt class="text-base">Total</dt>
                                <dd class="text-base">€{{ props.order.total_price.toFixed(2) }}</dd>
                            </div>
                        </dl>

                        <dl class="mt-16 grid grid-cols-2 gap-x-4 text-sm text-gray-600">
                            <div>
                                <dt class="font-medium text-gray-900">Shipping Address</dt>
                                <dd class="mt-2">
                                    <address class="not-italic" v-if="props.shipping_address">
                                        <span class="block">{{ props.shipping_address.address_line1 }}</span>
                                        <span class="block">{{ props.shipping_address.address_line2 }}</span>
                                        <span class="block">{{ props.shipping_address.city }}, {{
                                            props.shipping_address.postal_code
                                        }}, {{ props.shipping_address.country }}</span>
                                    </address>
                                </dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-900">Billing Address</dt>
                                <dd class="mt-2">
                                    <address class="not-italic" v-if="props.billing_address">
                                        <span class="block">{{ props.billing_address.address_line1 }}</span>
                                        <span class="block">{{ props.billing_address.address_line2 }}</span>
                                        <span class="block">{{ props.billing_address.city }}, {{
                                            props.billing_address.postal_code
                                        }}, {{ props.billing_address.country }}</span>
                                    </address>
                                </dd>
                            </div>

                        </dl>

                        <div class="mt-6 border-t border-gray-200 py-6 flex justify-between">
                            <Link href="/" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            <span aria-hidden="true"> &larr; </span>
                            Continue Shopping
                            </Link>
                            <Link href="/profile/orders" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            Check your order status
                            <span aria-hidden="true"> &rarr;</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </GuestLayout>
</template>