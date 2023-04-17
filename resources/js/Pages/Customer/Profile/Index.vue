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

const subNavigation = [
    { name: 'User', href: '/profile', icon: UserCircleIcon, current: false },
    { name: 'Orders', href: '/profile/orders', icon: ShoppingBagIcon, current: false },
    { name: 'Password', href: '/profile/password', icon: KeyIcon, current: false },
    { name: 'Advanced', href: '/profile/advanced', icon: CogIcon, current: false },
]

const currentPath = window.location.pathname;

subNavigation.forEach((item) => {
    console.log(item.href, currentPath)
    if (item.href === currentPath) {
        item.current = true
    }
})
</script>
<template>
    <GuestLayout class="bg-gray-50">
        <main class="mx-auto max-w-7xl pb-10 lg:px-8 lg:py-12 mt-16 ">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <aside class="px-2 py-6 sm:px-6 lg:col-span-3 lg:px-0 lg:py-0 ">
                    <nav class="space-y-1">
                        <Link v-for="item in subNavigation" :key="item.name" :href="item.href"
                            :class="[item.current ? 'bg-gray-50 text-indigo-600 hover:bg-white' : 'text-gray-900 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center rounded-md px-3 py-2 text-sm font-medium']"
                            :aria-current="item.current ? 'page' : undefined">
                        <component :is="item.icon"
                            :class="[item.current ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500', '-ml-1 mr-3 h-6 w-6 flex-shrink-0']"
                            aria-hidden="true" />
                        <span class="truncate">{{ item.name }}</span>
                        </Link>
                    </nav>
                </aside>
                <div v-if="currentPath === '/profile'" class="px-2 py-6 sm:px-6 lg:col-span-6 lg:px-0 lg:py-0">
                    <UpdateProfileInformationForm />
                </div>
                <slot v-else>

                </slot>
            </div>
        </main>
    </GuestLayout>
</template>