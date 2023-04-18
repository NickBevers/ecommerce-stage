<script setup>
import { MagnifyingGlassIcon, ShoppingBagIcon } from '@heroicons/vue/24/outline'
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
import { useProductStore } from '@/Stores/product.js';
import { Link } from '@inertiajs/vue3'
import { useCartStore } from '@/Stores/cart';
import { onMounted } from 'vue'

let allowCart = true;

const cartStore = useCartStore();
const productStore = useProductStore();

onMounted(() => {
    cartStore.fetchCount();
    productStore.fetchProducts();
    const path = window.location.pathname.split('/').pop()
    if (path === 'cart' || path === 'checkout') {
        allowCart = false;
    }
    else {
        allowCart = true;
    }
})

let cartToggle = false;

function fetchCart() {
    if (!cartToggle) {
        cartToggle = true;
        try {
            productStore.getProducts
        } catch (error) {
            console.error('Error:', error);
        }
    } else {
        cartToggle = false;
    }
}

function removeFromCart(id, product) {
    fetch('/cart/' + id, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then((response) => {
            document.getElementById(id).remove();
            cartStore.setCount(cartStore.count - product.amount)
        })
        .catch((error) => {
            console.error('There has been a problem with your fetch operation:', error);
        });
}
</script>

<template>
    <header class="relative bg-white">

        <div class="flex h-16 items-center justify-between">
            <div class="flex flex-1 items-center justify-end">
                <Popover class="flow-root text-sm lg:relative ml-4">
                    <PopoverButton class="group -m-2 flex items-center p-2">
                        <ShoppingBagIcon class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                            @click="fetchCart" aria-hidden="true" />
                        <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">{{ cartStore
                            .count }}</span>
                        <span class="sr-only">items in cart, view bag</span>
                    </PopoverButton>
                    <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0"
                        enter-to-class="opacity-100" leave-active-class="transition ease-in duration-150"
                        leave-from-class="opacity-100" leave-to-class="opacity-0">
                        <PopoverPanel v-if="allowCart"
                            class="absolute inset-x-0 -left-64 top-16 mt-px bg-white pb-6 shadow-lg sm:px-2 lg:top-full lg:-mr-1.5 lg:mt-3 w-80 rounded-lg lg:ring-1 lg:ring-black lg:ring-opacity-5">
                            <h2 class="sr-only">Shopping Cart</h2>

                            <form class="mx-auto max-w-2xl px-4">
                                <ul role="list" class="divide-y divide-gray-200 max-h-96 overflow-y-auto no-scrollbar">
                                    <li v-for="product in productStore.getProducts" :key="product.id" :id="product.sku.id"
                                        class="flex items-center py-6">

                                        <img :src="product.sku.product_images[0].image_link"
                                            :alt="product.sku.product_images[0].alt"
                                            class="h-16 w-16 flex-none rounded-md border border-gray-200 object-cover" />
                                        <div class="ml-4 flex-auto">
                                            <h3 class="font-medium text-sm flex justify-between text-gray-900">
                                                <Link :href="`/product/${product.sku.sku}`" class="break-words w-32">{{
                                                    product.sku.product.title
                                                }}
                                                </Link>
                                                <span>€{{
                                                    product.sku.price_incl_vat.toFixed(2)
                                                }}
                                                </span>
                                            </h3>
                                            <p class="text-gray-500">{{ product.color }}</p>
                                            <p class="mt-1 text-xs text-gray-500 w-36"
                                                v-if="product.sku.attribute_values.length > 0">
                                                <span v-for="(attribute, index) in product.sku.attribute_values">
                                                    {{ attribute.name }}<span
                                                        v-if="index !== product.sku.attribute_values.length - 1">,
                                                    </span>
                                                </span>
                                            </p>
                                            <div class="flex justify-between">
                                                <p class="text-xs"
                                                    :class="{ 'mt-6': !product.sku.attribute_values.length > 0, 'mt-2': product.sku.attribute_values.length > 0 }">
                                                    Quantity: {{ product.amount }}
                                                </p>
                                                <button type="button" class="text-xs text-indigo-600 hover:text-gray-500"
                                                    :class="{ 'mt-6': !product.sku.attribute_values.length > 0, 'mt-2': product.sku.attribute_values.length > 0 }"
                                                    @click="removeFromCart(product.sku.id, product)">
                                                    <span>Remove</span>
                                                    <XMarkIcon class="h-5 w-5" aria-hidden="true" />

                                                </button>

                                            </div>
                                        </div>
                                    </li>
                                </ul>

                                <Link type="submit" href="/checkout"
                                    class="w-full mt-8 rounded-md border text-center border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">
                                Checkout</Link>

                                <p class="mt-6 text-center">
                                    <Link href="/cart" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                    View
                                    Shopping Bag</Link>
                                </p>
                            </form>
                        </PopoverPanel>
                    </transition>
                </Popover>
            </div>
        </div>

    </header>
</template>
  
