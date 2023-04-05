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

const props = defineProps({
    cart: {
        type: Array,
        required: true,
    },
})

console.log(props.cart)

const cartStore = useCartStore()

let subTotal = ref(0)
let taxes = ref(0)
let total = ref(0)

const deliveryMethods = [
    { id: 1, title: 'Home', turnaround: 'home adress', number: '12', city: 'city' },
    { id: 2, title: 'Point', turnaround: 'another adress', number: '12', city: 'city' },
]
const paymentMethods = [
    { id: 'credit-card', title: 'Credit card' },
    { id: 'paypal', title: 'PayPal' },
    { id: 'invoice', title: 'Invoice' },
]

const countries = [
    { name: 'Belgium', code: 'BE' },
    { name: 'United States', code: 'US' },
    { name: 'Canada', code: 'CA' },
    { name: 'France', code: 'FR' },
    { name: 'Germany', code: 'DE' },
    { name: 'Ireland', code: 'IE' },
    { name: 'Italy', code: 'IT' },
    { name: 'Mexico', code: 'MX' },
    { name: 'Netherlands', code: 'NL' },
    { name: 'Portugal', code: 'PT' },
    { name: 'Spain', code: 'ES' },
    { name: 'Switzerland', code: 'CH' },
    { name: 'United Kingdom', code: 'GB' },
]

const selectedDeliveryMethod = ref(deliveryMethods[0])

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
        <div class="bg-gray-50 pt-24">

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
                                            <RadioGroupOption as="template" v-for="deliveryMethod in deliveryMethods"
                                                :key="deliveryMethod.id" :value="deliveryMethod"
                                                v-slot="{ checked, active }">
                                                <div
                                                    :class="[checked ? 'border-transparent' : 'border-gray-300', active ? 'ring-2 ring-indigo-500' : '', 'relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none']">
                                                    <span class="flex flex-1">
                                                        <span class="flex flex-col">
                                                            <RadioGroupLabel as="span"
                                                                class="block text-sm font-medium text-gray-900">{{
                                                                    deliveryMethod.title }}</RadioGroupLabel>
                                                            <RadioGroupDescription as="span"
                                                                class="mt-1 flex items-center text-sm text-gray-500">{{
                                                                    deliveryMethod.turnaround }}, {{ deliveryMethod.number }}
                                                            </RadioGroupDescription>
                                                            <RadioGroupDescription as="span"
                                                                class="mt-1 flex items-center text-sm text-gray-500">{{
                                                                    deliveryMethod.city }}</RadioGroupDescription>
                                                        </span>
                                                    </span>
                                                    <CheckCircleIcon v-if="checked" class="h-5 w-5 text-indigo-600"
                                                        aria-hidden="true" />
                                                    <span
                                                        :class="[active ? 'border' : 'border-2', checked ? 'border-indigo-500' : 'border-transparent', 'pointer-events-none absolute -inset-px rounded-lg']"
                                                        aria-hidden="true" />
                                                </div>
                                            </RadioGroupOption>
                                        </div>
                                    </RadioGroup>
                                </div>
                                <div class="mt-12 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                    <div>
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">First
                                            name</label>
                                        <div class="mt-1">
                                            <input type="text" id="first-name" name="first-name" autocomplete="given-name"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div>
                                        <label for="last-name" class="block text-sm font-medium text-gray-700">Last
                                            name</label>
                                        <div class="mt-1">
                                            <input type="text" id="last-name" name="last-name" autocomplete="family-name"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                                        <div class="mt-1">
                                            <input type="text" name="company" id="company"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                        <div class="mt-1">
                                            <input type="text" name="address" id="address" autocomplete="street-address"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="apartment" class="block text-sm font-medium text-gray-700">Apartment,
                                            suite,
                                            etc.</label>
                                        <div class="mt-1">
                                            <input type="text" name="apartment" id="apartment"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                        <div class="mt-1">
                                            <input type="text" name="city" id="city" autocomplete="address-level2"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div>
                                        <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                        <div class="mt-1">
                                            <select id="country" name="country" autocomplete="country-name"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option v-for="country in countries">{{ country.name }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="region" class="block text-sm font-medium text-gray-700">State /
                                            Province</label>
                                        <div class="mt-1">
                                            <input type="text" name="region" id="region" autocomplete="address-level1"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div>
                                        <label for="postal-code" class="block text-sm font-medium text-gray-700">Postal
                                            code</label>
                                        <div class="mt-1">
                                            <input type="text" name="postal-code" id="postal-code"
                                                autocomplete="postal-code"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <!-- remember checkbox -->
                                    <div>
                                        <div class="relative flex items-start">
                                            <div class="flex h-6 items-center">
                                                <input id="candidates" aria-describedby="candidates-description"
                                                    name="candidates" type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                                            </div>
                                            <div class="ml-3 text-sm leading-6">
                                                <label for="candidates"
                                                    class="font-medium text-gray-900 cursor-pointer">Remember
                                                    address</label>

                                                <span id="candidates-description" class="text-gray-500"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- Payment -->
                            <div class="mt-10 border-t border-gray-200 pt-10">
                                <h2 class="text-lg font-medium text-gray-900">Payment</h2>

                                <fieldset class="mt-4">
                                    <legend class="sr-only">Payment type</legend>
                                    <div class="space-y-4 sm:flex sm:items-center sm:space-x-10 sm:space-y-0">
                                        <div v-for="(paymentMethod, paymentMethodIdx) in paymentMethods"
                                            :key="paymentMethod.id" class="flex items-center">
                                            <input v-if="paymentMethodIdx === 0" :id="paymentMethod.id" name="payment-type"
                                                type="radio" checked=""
                                                class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                            <input v-else :id="paymentMethod.id" name="payment-type" type="radio"
                                                class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                            <label :for="paymentMethod.id"
                                                class="ml-3 block text-sm font-medium text-gray-700">{{ paymentMethod.title
                                                }}</label>
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="mt-6 grid grid-cols-4 gap-x-4 gap-y-6">
                                    <div class="col-span-4">
                                        <label for="card-number" class="block text-sm font-medium text-gray-700">Card
                                            number</label>
                                        <div class="mt-1">
                                            <input type="text" id="card-number" name="card-number" autocomplete="cc-number"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div class="col-span-4">
                                        <label for="name-on-card" class="block text-sm font-medium text-gray-700">Name on
                                            card</label>
                                        <div class="mt-1">
                                            <input type="text" id="name-on-card" name="name-on-card" autocomplete="cc-name"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div class="col-span-3">
                                        <label for="expiration-date"
                                            class="block text-sm font-medium text-gray-700">Expiration
                                            date (MM/YY)</label>
                                        <div class="mt-1">
                                            <input type="text" name="expiration-date" id="expiration-date"
                                                autocomplete="cc-exp"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div>
                                        <label for="cvc" class="block text-sm font-medium text-gray-700">CVC</label>
                                        <div class="mt-1">
                                            <input type="text" name="cvc" id="cvc" autocomplete="csc"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>
                                </div>
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
