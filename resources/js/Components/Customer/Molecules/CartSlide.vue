<script setup>
import { ref, onBeforeMount, onMounted } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { useCartStore } from '@/Stores/cart';
import { useProductStore } from '@/Stores/product';
import { Link } from '@inertiajs/vue3'
const cartStore = useCartStore();
const productStore = useProductStore();

onBeforeMount(() => {
    productStore.fetchProducts();
})

function removeFromCart(id, product) {
    fetch('/cart/' + id, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then((response) => {
            productStore.setTotal(productStore.getTotal - (product.amount * product.sku.price_incl_vat))
            document.getElementById(id).remove();
            cartStore.setCount(cartStore.count - product.amount)
            productStore.fetchProducts();
        })
        .catch((error) => {
            console.error('There has been a problem with your fetch operation:', error);
        });
}
</script>
<template>
    <TransitionRoot as="template" :show="cartStore.getOpen">
        <Dialog as="div" class="relative z-20" @close="cartStore.setOpen(false)">
            <TransitionChild as="template" enter="ease-in-out duration-500" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in-out duration-500" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700"
                            enter-from="translate-x-full" enter-to="translate-x-0"
                            leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0"
                            leave-to="translate-x-full">
                            <DialogPanel class="pointer-events-auto w-screen max-w-md">
                                <div class="flex h-full flex-col overflow-y-scroll  scrollbar-none bg-white shadow-xl">
                                    <div class="flex-1 overflow-y-auto no-scrollbar px-4 py-6 sm:px-6">
                                        <div class="flex items-start justify-between">
                                            <DialogTitle class="text-lg font-medium text-gray-900">Shopping cart
                                            </DialogTitle>
                                            <div class="ml-3 flex h-7 items-center">
                                                <button type="button" class="-m-2 p-2 text-gray-400 hover:text-gray-500"
                                                    @click="cartStore.setOpen(false)">
                                                    <span class="sr-only">Close panel</span>
                                                    <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                                                </button>
                                            </div>
                                        </div>

                                        <div class="mt-8">
                                            <div class="flow-root">
                                                <ul role="list" class="-my-6 divide-y divide-gray-200">
                                                    <li v-for="product in productStore.getProducts" :key="product.id"
                                                        :id="product.sku.id" class="flex py-6">
                                                        <div
                                                            class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                            <img :src="product.sku.product_images[0].image_link"
                                                                :alt="product.sku.product_images[0].alt"
                                                                class="h-full w-full object-cover object-center" />
                                                        </div>

                                                        <div class="ml-4 flex flex-1 flex-col">
                                                            <div>
                                                                <div
                                                                    class="flex justify-between text-base font-medium text-gray-900">
                                                                    <h3>
                                                                        <Link :href="`/product/${product.sku.sku}/${product.sku.product.slug}`"
                                                                            class="break-words w-32">{{
                                                                                product.sku.product.title
                                                                            }}
                                                                        </Link>
                                                                    </h3>
                                                                    <p class="ml-4">€{{ product.sku.price_incl_vat }}
                                                                    </p>
                                                                </div>

                                                            </div>
                                                            <div class="flex flex-1 items-end justify-between text-sm">
                                                                <p class="text-gray-500">Qty {{ product.amount }}</p>
                                                                <div class="flex">
                                                                    <button type="button"
                                                                        @click="removeFromCart(product.sku.id, product)"
                                                                        class="font-medium text-indigo-600 hover:text-indigo-500">Remove</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                            <p>Subtotal</p>
                                            <p>€{{ productStore.getTotal.toFixed(2) }}</p>
                                        </div>
                                        <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.
                                        </p>
                                        <div class="mt-6">
                                            <Link href="/cart" @click="cartStore.setOpen(false)"
                                                class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">
                                            Shopping Bag</Link>
                                        </div>
                                        <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                                            <p>
                                                or
                                                <button type="button"
                                                    class="font-medium text-indigo-600 hover:text-indigo-500"
                                                    @click="cartStore.setOpen(false)">
                                                    Continue Shopping
                                                    <span aria-hidden="true"> &rarr;</span>
                                                </button>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>