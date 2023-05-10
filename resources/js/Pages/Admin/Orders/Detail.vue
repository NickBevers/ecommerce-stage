<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Dropdown, InputLabel } from '@/Components/Admin';
import moment from 'moment';
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon, XMarkIcon } from '@heroicons/vue/20/solid'
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { reactive, ref, onMounted, computed, onBeforeMount } from 'vue';

const props = defineProps({
    order: Object,
    shipping_address: Object,
    billing_address: Object,
});

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


const orderStatuses = [
    "Pending", "Processing", "Shipped", "Delivered", "Cancelled"
];

const selectedStatus = ref(orderStatuses[2])

onBeforeMount(() => {
    props.order.order_status = props.order.order_status.charAt(0).toUpperCase() + props.order.order_status.slice(1)
    selectedStatus.value = props.order.order_status
})

function changeStatus(event) {
    selectedStatus.value = event.target.innerText.toLowerCase()
}

function changeAmount(product, event) {
    if (event.target.value > 0 && event.target.value <= product.amount) {
        fetch('/admin/orders/product/' + props.order.id, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                sku_id: product.id,
                amount: event.target.value,
            }),
        })
            .then((response) => {
                product.pivot.amount = parseInt(event.target.value);
            })
            .catch((error) => {
                console.error('There has been a problem with your fetch operation:', error);
            });
    } else {
        event.target.value = product.pivot.amount;
    }
}

function removeFromOrder(id, product) {
    fetch('/admin/orders/product/' + props.order.id, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            sku_id: product.id,
        }),
    })
        .then((response) => {
            document.getElementById(id).remove();
        })
        .catch((error) => {
            console.error('There has been a problem with your fetch operation:', error);
        });
}

function submit() {
    fetch('/addresses/' + props.billing_address.id, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(props.billing_address),
    })
        .then((response) => {
            console.log(response)
        })
    fetch('/admin/orders/' + props.order.id, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            order_status: selectedStatus.value,
        }),
    })
        .then((response) => {
            console.log(response)
            router.visit('/admin/orders')
        })


}

const totalPrice = computed(() => {
    let total = 0;
    props.order.skus.forEach((product) => {
        total += product.pivot.amount * product.price_incl_vat;
    });
    return total.toFixed(2);
});

</script>
<template>
    <Head title="Products" />
    <AuthenticatedLayout>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold leading-6 text-gray-900">Order Details</h1>
                    </div>

                </div>
                <div class="bg-white shadow sm:rounded-lg mt-8">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex justify-between w-full">
                            <div> <span class="text-sm">Order ID:&nbsp;</span><span class="text-sm font-bold">#{{
                                props.order.id }}</span></div>
                            <div v-if="props.order.shipping_address_id === null && props.order.billing_address_id === null">
                                <span class="text-sm">Delivery address:&nbsp;</span><span class="text-sm font-bold">{{
                                    props.order.delivery_address }}</span>
                            </div>
                            <div> <span class="text-sm">Order placed on:&nbsp;</span><span class="text-sm font-bold">{{
                                props.order.order_date }}</span></div>
                        </div>
                        <div class="py-8 flex items-center gap-2">
                            <div class="mt-2">
                                <InputLabel for="status" value="Order status:" />
                            </div>
                            <div class="rounded-md">
                                <Dropdown :items="orderStatuses" :selected="selectedStatus" class="w-64"
                                    @click="changeStatus($event)" />
                            </div>
                        </div>
                        <div>
                            <div>
                                <div class="my-6 flow-root">
                                    <ul role="list"
                                        class="-my-5 divide-y pr-4 divide-gray-200 max-h-[24rem] overflow-y-auto scrollbar-thin   scrollbar-thumb-gray-100 scrollbar-track-gray-50">
                                        <li v-for="product in props.order.skus" :key="product.id" class="py-4"
                                            :id="product.id">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <img class="h-14 w-14 rounded-md mr-2 object-cover object-top"
                                                        :src="product.product_images[0].image_link"
                                                        :alt="product.product_images[0].alt" />
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="truncate text-sm font-medium text-gray-900">{{
                                                        product.pivot.product_name }}</p>
                                                    <p class="truncate text-sm text-gray-500">{{ '€' +
                                                        product.price_incl_vat }}
                                                        {{ ' x ' + product.pivot.amount }}</p>
                                                    <p class="truncate text-sm text-gray-500"></p>
                                                    <p class="truncate text-sm text-gray-500">total: €{{
                                                        product.pivot.amount *
                                                        product.price_incl_vat }}</p>
                                                </div>
                                                <div>
                                                    <div class="mt-4 sm:mt-0 flex flex-row">
                                                        <label :for="`amount-${product.id}`" class="sr-only">Quantity, {{
                                                            product.sku.title }}</label>
                                                        <div class="flex gap-4">
                                                            <input :id="`amount-${product.id}`"
                                                                :name="`amount-${product.id}`" type="number" min="1"
                                                                :max="product.amount"
                                                                class="max-w-full rounded-md border border-gray-300 py-1.5 text-left text-base font-medium leading-5 text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                                                                :value="product.pivot.amount"
                                                                @change="changeAmount(product, $event)" />

                                                            <button type="button"
                                                                class=" inline-flex p-2 bg-red-500 rounded-md text-xs font-semibold text-white shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-red-600"
                                                                @click="removeFromOrder(product.id, product)">
                                                                <span class="sr-only">Remove</span>
                                                                <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div>

                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <p class="text-md font-medium text-gray-900">Subtotal</p>
                                    <p class="text-md text-gray-500">€{{ totalPrice }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 space-x-0 sm:space-x-8 sm:grid-cols-2">
                    <div class="bg-white shadow rounded-lg mt-8 " v-if="props.shipping_address">
                        <div class="px-4 sm:p-6">
                            <h2 class="text-lg font-medium text-gray-900">Shipping address</h2>
                            <div class="flex w-full">
                                <div class="mt-4 grid grid-cols-1 w-full gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                    <div class="sm:col-span-2">
                                        <label for="company" class="block text-sm font-medium text-gray-700">Company
                                            VAT</label>
                                        <div class="mt-1">
                                            <input type="text" name="company" id="company"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                v-model="props.shipping_address.btw_number" />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="address"
                                            class="block text-sm font-medium text-gray-700">Address*</label>
                                        <div class="mt-1">
                                            <input type="text" name="address" id="address" autocomplete="street-address"
                                                required v-model="props.shipping_address.address_line1"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="apartment" class="block text-sm font-medium text-gray-700">Number,
                                            apartment,
                                            suite,
                                            etc.*</label>
                                        <div class="mt-1">
                                            <input type="text" name="apartment" id="apartment" required
                                                v-model="props.shipping_address.address_line2"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700">City*</label>
                                        <div class="mt-1">
                                            <input type="text" name="city" id="city" autocomplete="address-level2" required
                                                v-model="props.shipping_address.city"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div>
                                        <label for="country"
                                            class="block text-sm font-medium text-gray-700">Country*</label>
                                        <div class="mt-1">
                                            <select id="country" name="country" autocomplete="country-name" required
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                v-model="props.shipping_address.country">
                                                <option v-for="country in countries" :value="country.code">{{
                                                    country.name
                                                }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="region" class="block text-sm font-medium text-gray-700">State /
                                            Province</label>
                                        <div class="mt-1">
                                            <input type="text" name="region" id="region" autocomplete="address-level1"
                                                v-model="props.shipping_address.state"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div>
                                        <label for="postal-code" class="block text-sm font-medium text-gray-700">Postal
                                            code*</label>
                                        <div class="mt-1">
                                            <input type="number" name="postal-code" id="postal-code"
                                                autocomplete="postal-code" required
                                                v-model="props.shipping_address.postal_code"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white shadow rounded-lg mt-8 " v-if="props.billing_address">
                        <div class="px-4 sm:p-6">
                            <h2 class="text-lg font-medium text-gray-900">Billing address</h2>
                            <div class="flex w-full">
                                <div class="mt-4 grid grid-cols-1 w-full gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                    <div class="sm:col-span-2">
                                        <label for="company" class="block text-sm font-medium text-gray-700">Company
                                            VAT</label>
                                        <div class="mt-1">
                                            <input type="text" name="company" id="company"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                v-model="props.billing_address.btw_number" />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="address"
                                            class="block text-sm font-medium text-gray-700">Address*</label>
                                        <div class="mt-1">
                                            <input type="text" name="address" id="address" autocomplete="street-address"
                                                required v-model="props.billing_address.address_line1"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="apartment" class="block text-sm font-medium text-gray-700">Number,
                                            apartment,
                                            suite,
                                            etc.*</label>
                                        <div class="mt-1">
                                            <input type="text" name="apartment" id="apartment" required
                                                v-model="props.billing_address.address_line2"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700">City*</label>
                                        <div class="mt-1">
                                            <input type="text" name="city" id="city" autocomplete="address-level2" required
                                                v-model="props.billing_address.city"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div>
                                        <label for="country"
                                            class="block text-sm font-medium text-gray-700">Country*</label>
                                        <div class="mt-1">
                                            <select id="country" name="country" autocomplete="country-name" required
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                v-model="props.billing_address.country">
                                                <option v-for="country in countries" :value="country.code">{{ country.name
                                                }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="region" class="block text-sm font-medium text-gray-700">State /
                                            Province</label>
                                        <div class="mt-1">
                                            <input type="text" name="region" id="region" autocomplete="address-level1"
                                                v-model="props.billing_address.state"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <div>
                                        <label for="postal-code" class="block text-sm font-medium text-gray-700">Postal
                                            code*</label>
                                        <div class="mt-1">
                                            <input type="number" name="postal-code" id="postal-code"
                                                autocomplete="postal-code" required
                                                v-model="props.billing_address.postal_code"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--                    <div v-else class="bg-white shadow rounded-lg mt-8 ">-->
                    <!--                        <div class="px-4 sm:p-6">-->
                    <!--                            <h2 class="text-lg font-medium text-gray-900">Shipping address</h2>-->
                    <!--                            <p>{{ props.order.delivery_address }}</p>-->
                    <!--                        </div>-->
                    <!--                    </div>-->

                </div>
                <div class="flex justify-end mt-4">
                    <button @click="submit"
                        class="rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Save
                    </button>
                </div>
            </div>





        </div>

    </AuthenticatedLayout>
</template>
