  
<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { ChevronDownIcon } from '@heroicons/vue/20/solid'
import { Link } from '@inertiajs/vue3'
import { UserIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
})

console.log('user', props.user)
</script>
<template>
    <Menu as="div" class="relative inline-block text-left">
        <div>
            <MenuButton class="inline-flex w-full justify-center text-sm font-semiboldshadow-sm p-2">
                <UserIcon class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
            </MenuButton>
        </div>

        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <MenuItems
                class="absolute -right-24 top-10 z-10 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                <div class="px-4 py-3" v-if="props.user">
                    <p class="text-sm">Signed in as</p>
                    <p class="truncate text-sm font-medium text-gray-900">{{ props.user.email }}</p>
                </div>
                <div class="px-4 py-3" v-else>
                    <p class="text-sm">Hi, Guest</p>
                    <p class="truncate text-sm font-medium text-gray-900"></p>
                </div>
                <div class="py-1" v-if="props.user">
                    <MenuItem v-slot="{ active }" v-if="props.user.user_type === 'admin'">
                    <Link :href="route('dashboard')"
                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                    Dashboard</Link>
                    </MenuItem>
                    <MenuItem v-slot="{ active }" v-if="props.user.user_type === 'admin'">
                    <Link href="/admin/profile"
                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Account
                    settings</Link>
                    </MenuItem>
                    <MenuItem v-slot="{ active }" v-else>
                    <Link href="/profile"
                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Account
                    settings</Link>
                    </MenuItem>
                </div>
                <div class="py-1" v-else>
                    <MenuItem v-slot="{ active }">
                    <Link href="/login"
                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Sign
                    in</Link>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                    <Link href="/register"
                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                    Create account
                    </Link>
                    </MenuItem>
                </div>
                <div class="py-1" v-if="props.user">

                    <MenuItem v-slot="{ active }">
                    <Link :href="route('logout')" method="post" as="button"
                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block w-full px-4 py-2 text-left text-sm']">
                    Sign out
                    </Link>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>
