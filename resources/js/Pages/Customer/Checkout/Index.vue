//TODO : wait for backend to be ready 
<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { ref, onMounted } from 'vue'
import {
    RadioGroup,
    RadioGroupDescription,
    RadioGroupLabel,
    RadioGroupOption,
} from '@headlessui/vue'
import { CheckCircleIcon, ChevronDownIcon, PlusIcon } from '@heroicons/vue/20/solid'
import { useCartStore } from '@/Stores/cart'
import { AddAddressModal } from '@/Components/Customer'

const props = defineProps({
    cart: {
        type: Object,
        required: true,
    },
    addresses: {
        type: Object,
        required: true,
    },
    paymentTypes: {
        type: Object,
        required: true,
    },
})

console.log(props.addresses)

const cartStore = useCartStore()

let subTotal = ref(0)
let taxes = ref(0)
let total = ref(0)

const selected = ref()
const showAddressModal = ref(false)

const selectedDeliveryMethod = ref(props.addresses[0])

function getTotal() {
    subTotal.value = 0
    taxes.value = 0
    total.value = 0
    props.cart.forEach((product) => {
        subTotal.value += product.sku.price_excl_vat * product.amount
        total.value += product.sku.price_incl_vat * product.amount
    })
    taxes.value = total.value - subTotal.value
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
            props.cart.splice(props.cart.indexOf(product), 1)
            getTotal()
        })
        .catch((error) => {
            console.error('There has been a problem with your fetch operation:', error);
        });
}

onMounted(() => {
    getTotal()
})
</script>
<template>
    <GuestLayout>
        <AddAddressModal class="z-20" v-if="showAddressModal" @closed="showAddressModal = false" />
        <div class=" bg-gray-50 pt-24">
            <main class="mx-auto max-w-7xl px-4 pb-24 pt-16 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:max-w-none">
                    <h1 class="sr-only">Checkout</h1>

                    <form class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
                        <div>
                            <div>
                                <h2 class="text-lg font-medium text-gray-900">Contact information</h2>

                                <div class="mt-4">
                                    <label for="email-address" class="block text-sm font-medium text-gray-700">Email
                                        address</label>
                                    <div class="mt-1">
                                        <input type="email" id="email-address" name="email-address" autocomplete="email"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                </div>
                                <div class="sm:col-span-2 mt-8">
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                    <div class="mt-1">
                                        <input type="text" name="phone" id="phone" autocomplete="tel"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="mt-10 border-t border-gray-200 pt-10">
                                    <RadioGroup v-model="selectedDeliveryMethod">
                                        <RadioGroupLabel class="text-lg font-medium text-gray-900">Shipping information
                                        </RadioGroupLabel>

                                        <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                            <RadioGroupOption as="template" v-for="deliveryMethod in props.addresses"
                                                :key="deliveryMethod.id" :value="deliveryMethod"
                                                v-slot="{ checked, active }">
                                                <div
                                                    :class="[checked ? 'border-transparent' : 'border-gray-300', active ? 'ring-2 ring-indigo-500' : '', 'relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none']">
                                                    <span class="flex flex-1">
                                                        <span class="flex flex-col">
                                                            <RadioGroupLabel as="span"
                                                                class="block text-sm font-medium text-gray-900">{{
                                                                    deliveryMethod.address_type }}</RadioGroupLabel>
                                                            <RadioGroupDescription as="span"
                                                                class="mt-1 flex items-center text-sm text-gray-500">{{
                                                                    deliveryMethod.address_line1 }}
                                                            </RadioGroupDescription>
                                                            <RadioGroupDescription as="span"
                                                                class="mt-1 flex items-center text-sm text-gray-500">{{
                                                                    deliveryMethod.city }}, {{ deliveryMethod.postal_code }}
                                                            </RadioGroupDescription>
                                                            <RadioGroupDescription as="span"
                                                                class="mt-1 flex items-center text-sm text-gray-500">{{
                                                                    deliveryMethod.country }}</RadioGroupDescription>
                                                        </span>
                                                    </span>
                                                    <CheckCircleIcon v-if="checked" class="h-5 w-5 text-indigo-600"
                                                        aria-hidden="true" />
                                                    <span
                                                        :class="[active ? 'border' : 'border-2', checked ? 'border-indigo-500' : 'border-transparent', 'pointer-events-none absolute -inset-px rounded-lg']"
                                                        aria-hidden="true" />
                                                </div>
                                            </RadioGroupOption>
                                            <div @click="showAddressModal = true"
                                                class="relative flex cursor-pointer rounded-lg border border-indigo-200 bg-indigo-50 p-4 focus:outline-none text-indigo-700">
                                                <span class="flex flex-1 self-center">
                                                    <span class="flex flex-col w-full">
                                                        <RadioGroupLabel as="span"
                                                            class="block text-sm font-medium  self-center ">
                                                            Add
                                                            address</RadioGroupLabel>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </RadioGroup>
                                </div>

                            </div>



                            <!-- Payment -->
                            <div class="mt-10 border-t border-gray-200 pt-10">
                                <h2 class="text-lg font-medium text-gray-900">Payment</h2>

                                <fieldset class="mt-4">
                                    <legend class="sr-only">Payment type</legend>

                                    <RadioGroup v-model="selected">
                                        <RadioGroupLabel class="sr-only"> Payment </RadioGroupLabel>
                                        <div class="relative -space-y-px rounded-md bg-white">
                                            <RadioGroupOption as="template" v-for="(plan, planIdx) in props.paymentTypes"
                                                :key="plan.id" :value="plan" v-slot="{ checked, active }">
                                                <div
                                                    :class="[planIdx === 0 ? 'rounded-tl-md rounded-tr-md text-right' : '', planIdx === props.paymentTypes.length - 1 ? 'rounded-bl-md rounded-br-md' : '', checked ? 'z-10 border-indigo-200 bg-indigo-50' : 'border-gray-200', 'relative flex cursor-pointer flex-col border p-4 focus:outline-none md:grid md:grid-cols-2 md:pl-4 md:pr-6']">
                                                    <span class="flex items-center text-sm">
                                                        <span
                                                            :class="[checked ? 'bg-indigo-600 border-transparent' : 'bg-white border-gray-300', active ? 'ring-2 ring-offset-2 ring-indigo-600' : '', 'h-4 w-4 rounded-full border flex items-center justify-center']"
                                                            aria-hidden="true">
                                                            <span class="rounded-full bg-white w-1.5 h-1.5" />
                                                        </span>
                                                        <RadioGroupLabel as="span"
                                                            :class="[checked ? 'text-indigo-900' : 'text-gray-900', 'ml-3 font-medium']">
                                                            {{ plan.name }}</RadioGroupLabel>
                                                    </span>
                                                    <RadioGroupDescription as="span"
                                                        :class="[checked ? 'text-indigo-700' : 'text-gray-500', 'ml-6 pl-1 text-sm md:ml-0 md:pl-0 md:text-right']">
                                                        {{ plan.description }}
                                                    </RadioGroupDescription>
                                                </div>
                                            </RadioGroupOption>
                                        </div>
                                    </RadioGroup>
                                </fieldset>
                            </div>
                        </div>

                        <!-- Order summary -->
                        <div class="mt-10 lg:mt-0 ">
                            <div class="sticky top-36 left-0">
                                <h2 class="text-lg font-medium text-gray-900">Order summary</h2>

                                <div class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm">
                                    <h3 class="sr-only">Items in your cart</h3>
                                    <ul role="list"
                                        class="divide-y divide-gray-200 max-h-96 overflow-y-auto  scrollbar-thin scrollbar-rounded-lg scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                                        <li v-for="product in props.cart" :key="product.id" class="flex px-4 py-6 sm:px-6"
                                            :id="product.sku.id">

                                            <div class="flex-shrink-0">
                                                <img :src="product.sku.product_images[0].image_link"
                                                    alt="shopping cart item"
                                                    class="h-24 w-24 rounded-md object-cover object-center sm:h-32 sm:w-22" />
                                            </div>

                                            <div class="ml-6 flex flex-1 flex-col">
                                                <div class="flex">
                                                    <div class="min-w-0 flex-1">
                                                        <h4 class="text-sm">
                                                            <a :href="`/product/${product.sku.sku}`"
                                                                class="font-medium text-gray-700 hover:text-gray-800">{{
                                                                    product.sku.product.title }}</a>
                                                        </h4>
                                                        <p class="mt-1 text-sm text-gray-500"
                                                            v-if="product.sku.attribute_values.length > 0">
                                                            <span
                                                                v-for="(attribute, index) in product.sku.attribute_values">
                                                                {{ attribute.name }}<span
                                                                    v-if="index !== product.sku.attribute_values.length - 1">,
                                                                </span>
                                                            </span>
                                                        </p>
                                                        <p v-else>
                                                            <span class="text-sm text-gray-500">{{
                                                                product.sku.product.description.length > 30
                                                                ? product.sku.product.description.slice(0, 30) + "..."
                                                                : product.sku.product.description
                                                            }}</span>
                                                        </p>
                                                    </div>

                                                    <div class="ml-4 flow-root flex-shrink-0">
                                                        <button type="button"
                                                            @click="removeFromCart(product.sku.id, product)"
                                                            class="-m-2.5 flex items-center justify-center bg-white p-2.5 text-gray-400 hover:text-gray-500">
                                                            <span class="sr-only">Remove</span>
                                                            <PlusIcon class="h-6 w-6 rotate-45" aria-hidden="true" />
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="flex flex-1 items-end justify-between pt-2">
                                                    <p class="mt-1 text-sm font-medium text-gray-900">€{{
                                                        product.sku.price_incl_vat.toFixed(2) }}
                                                    </p>

                                                    <div class="ml-4">
                                                        <label for="quantity" class="sr-only">Quantity</label>
                                                        <p class="text-sm font-medium text-gray-900">x {{ product.amount
                                                        }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <dl class="space-y-6 border-t border-gray-200 px-4 py-6 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <dt class="text-sm">Subtotal</dt>
                                            <dd class="text-sm font-medium text-gray-900">€{{ subTotal.toFixed(2) }}</dd>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <dt class="text-sm">Shipping</dt>
                                            <dd class="text-sm font-medium text-gray-900">€...</dd>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <dt class="text-sm">Taxes</dt>
                                            <dd class="text-sm font-medium text-gray-900">€{{ taxes.toFixed(2) }}</dd>
                                        </div>
                                        <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                                            <dt class="text-base font-medium">Total</dt>
                                            <dd class="text-base font-medium text-gray-900">€{{ total.toFixed(2) }}</dd>
                                        </div>
                                    </dl>

                                    <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                                        <button type="submit"
                                            class="w-full rounded-md border border-transparent bg-indigo-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Confirm
                                            order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </GuestLayout>
</template>
