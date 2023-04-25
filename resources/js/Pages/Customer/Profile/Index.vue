<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import UpdateProfileInformationForm from '../../Profile/Partials/UpdateProfileInformationForm.vue'
import { Link } from '@inertiajs/vue3'
import {
    BellIcon,
    CreditCardIcon,
    KeyIcon,
    ShoppingBagIcon,
    UserCircleIcon,
    CogIcon,
} from '@heroicons/vue/24/outline'
import {XMarkIcon} from "@heroicons/vue/20/solid";
import { ref } from "vue";
import {AddAddressModal} from "@/Components/Customer";

const subNavigation = [
    { name: 'User', href: '/profile', icon: UserCircleIcon, current: false },
    { name: 'Orders', href: '/profile/orders', icon: ShoppingBagIcon, current: false },
    { name: 'Password', href: '/profile/password', icon: KeyIcon, current: false },
    { name: 'Advanced', href: '/profile/advanced', icon: CogIcon, current: false },
]

const props = defineProps({
    addresses: {
        type: Object,
        required: true
    },
});

const currentPath = window.location.pathname;
const showAddressModal = ref(false)

subNavigation.forEach((item) => {
    console.log(item.href, currentPath)
    if (item.href === currentPath) {
        item.current = true
    }
})

function removeAddress(address) {
    console.log(address.id)
    fetch('/addresses/' + address.id, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                props.addresses.splice(props.addresses.indexOf(address), 1)
            }
        })
}

function handleNewAddress(address) {
    console.log(address)
    props.addresses.push(address.address)
}
</script>
<template>
    <GuestLayout class="bg-gray-50">
        <main class="mx-auto max-w-7xl pb-10 lg:px-8 lg:py-12 mt-16 ">
            <div class="flex gap-x-24 flex-col sm:flex-row">
                <aside class="px-2 py-6 sm:px-6 lg:col-span-3 lg:px-0 lg:py-0 w-40">
                    <nav class="space-y-1">
                        <Link v-for="item in subNavigation" :key="item.name" :href="item.href"
                            :class="[item.current ? 'bg-gray-50 text-indigo-600' : 'text-gray-900 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center rounded-md px-3 py-2 text-sm font-medium']"
                            :aria-current="item.current ? 'page' : undefined">
                        <component :is="item.icon"
                            :class="[item.current ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500', '-ml-1 mr-3 h-6 w-6 flex-shrink-0']"
                            aria-hidden="true" />
                        <span class="truncate">{{ item.name }}</span>
                        </Link>
                    </nav>
                </aside>
                <div v-if="currentPath === '/profile'" class="px-2 py-6 sm:px-6 lg:col-span-6 lg:px-0 lg:py-0">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg w-full">
                        <UpdateProfileInformationForm user_type="customer" />
                    </div>

                    <AddAddressModal class="z-20" v-if="showAddressModal" @closed="showAddressModal = false" @submitted="handleNewAddress" />
                    <div class="mt-8 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="mx-auto max-w-2xl px-4 lg:max-w-4xl lg:px-0">
                            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Your addresses</h1>
                            <p class="mt-2 text-sm text-gray-500"> add or remove addresses.</p>
                        </div>
                        <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                            <div v-for="(address, index) in props.addresses">
                                <div class="relative flex rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                                    <span class="flex flex-1">
                                        <XMarkIcon @click.prevent="removeAddress(address)" class="h-5 w-5 text-indigo-500 absolute top-4 right-4 cursor-pointer" aria-hidden="true" />
                                        <span class="flex flex-col">
                                            <span class="block text-sm font-medium text-gray-900">{{ address.address_line1 }}, {{ address.address_line2 }}</span>
                                            <span class="mt-1 flex items-center text-sm text-gray-500">
                                            </span>
                                            <span class="mt-1 flex items-center text-sm text-gray-500">{{ address.city }}, {{ address.postal_code }}
                                            </span>
                                            <span  class="mt-1 flex items-center text-sm text-gray-500">{{  address.country }}</span>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div @click="showAddressModal = true"
                             class="relative flex cursor-pointer rounded-lg border border-indigo-200 bg-indigo-50 p-4 focus:outline-none text-indigo-700 mt-8">
                                <span class="flex flex-1 self-center">
                                    <span class="flex flex-col w-full">
                                        <span class="block text-sm font-medium self-center ">
                                            Add address</span>
                                    </span>
                                </span>
                        </div>
                    </div>
                </div>
                <div v-else>

                </div>
            </div>
        </main>
    </GuestLayout>
</template>