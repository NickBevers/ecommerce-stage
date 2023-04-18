<script setup>
import { computed, onMounted } from "vue";
import { ApplicationLogo } from "@/Components/Customer";
import { Link } from "@inertiajs/vue3";
import { ref } from 'vue'
import {
  Dialog,
  DialogPanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { Bars3CenterLeftIcon, ChartPieIcon, ShoppingBagIcon, StarIcon, UsersIcon, ClipboardIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import { ChevronRightIcon, ChevronUpDownIcon, EllipsisVerticalIcon, MagnifyingGlassIcon } from '@heroicons/vue/20/solid'

const navigation = [
  { name: 'Overview', href: '/admin/dashboard', icon: ChartPieIcon, current: false },
  { name: 'Products', href: '/admin/products', icon: ShoppingBagIcon, current: false },
  { name: 'Orders', href: '/admin/orders', icon: ClipboardIcon, current: false },
  { name: 'Reviews', href: '/admin/products', icon: StarIcon, current: false },
  { name: 'Customers', href: '/admin/customers', icon: UsersIcon, current: false },
]

let active = ref(false)

const sidebarOpen = ref(false)

const props = defineProps({
  user: {
    type: Object,
  },
});

const firstname = computed(() => {
  return capitalizeFirstLetter(props.user.firstname);
});

const lastname = computed(() => {
  return capitalizeFirstLetter(props.user.lastname);
});

const initial = computed(() => {
  return getInitials(props.user.firstname, props.user.lastname);
});

function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

function getInitials(firstName, lastName) {
  const firstInitial = firstName.charAt(0).toUpperCase();
  const lastInitial = lastName.charAt(0).toUpperCase();
  return firstInitial + lastInitial;
}

onMounted(() => {


  navigation.forEach((item) => {
    if (item.href === window.location.pathname) {
      item.current = true;
    }
  });
});


</script>
<template>
  <TransitionRoot as="template" :show="sidebarOpen">
    <Dialog as="div" class="relative z-40 lg:hidden" @close="sidebarOpen = false">
      <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0"
        enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
        leave-to="opacity-0">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75" />
      </TransitionChild>

      <div class="fixed inset-0 z-40 flex">
        <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
          enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform"
          leave-from="translate-x-0" leave-to="-translate-x-full">
          <DialogPanel class="relative flex w-full max-w-xs flex-1 flex-col bg-white pt-5 pb-4">
            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
              leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
              <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button type="button"
                  class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                  @click="sidebarOpen = false">
                  <span class="sr-only">Close sidebar</span>
                  <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                </button>
              </div>
            </TransitionChild>
            <div class="flex flex-shrink-0 items-center px-4">
              <Link to="/" href="/">
              <ApplicationLogo class="h-8 w-auto" />
              </Link>
            </div>
          </DialogPanel>
        </TransitionChild>
        <div class="w-14 flex-shrink-0" aria-hidden="true">
          <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
      </div>
    </Dialog>
  </TransitionRoot>

  <!-- Static sidebar for desktop -->
  <div
    class="hidden lg:inset-y-0 lg:flex lg:w-64 lg:flex-col lg:border-r lg:border-gray-200 lg:bg-gray-100 lg:pt-5 lg:pb-4">
    <div class="flex flex-shrink-0 items-center px-6">
      <Link to="/" href="/">
      <ApplicationLogo class="h-8 w-auto" />
      </Link>
    </div>
    <div class="mt-5 flex h-0 flex-1 flex-col overflow-y-auto pt-1">
      <Menu as="div" class="relative inline-block px-3 text-left">
        <div>
          <MenuButton
            class="group w-full rounded-md bg-gray-100 px-3.5 py-2 text-left text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-100">
            <span class="flex w-full items-center justify-between">
              <span class="flex min-w-0 items-center justify-between space-x-3">
                <div
                  class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-300 rounded-full dark:bg-gray-600">
                  <span class="font-medium text-xl text-gray-600">{{ initial }}</span>
                </div>
                <span class="flex min-w-0 flex-1 flex-col">
                  <span class="truncate text-sm font-medium text-gray-900">{{ firstname }} {{ lastname }}</span>
                  <span class="truncate text-sm text-gray-500">{{ props.user.email }}</span>
                </span>
              </span>
              <ChevronUpDownIcon class="h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                aria-hidden="true" />
            </span>
          </MenuButton>
        </div>
        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95"
          enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75"
          leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
          <MenuItems
            class="absolute right-0 left-0 z-10 mx-3 mt-1 origin-top divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
            <div class="py-1">
              <MenuItem v-slot="{ active }">
              <Link :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']"
                :href="route('profile.edit')">Profile</Link>
              </MenuItem>
            </div>
            <div class="py-1">
              <Link :href="route('logout')" method="post" as="button"
                class="hover:bg-gray-100 hover:text-gray-900 w-full text-left"
                :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
              Logout
              </Link>
            </div>
          </MenuItems>
        </transition>
      </Menu>
      <!-- Navigation -->
      <nav class="mt-6 px-3">
        <div class="space-y-1">
          <Link v-for="item in navigation" :key="item.name" :href="item.href"
            :class="[item.current ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center rounded-md px-2 py-2 text-sm font-medium']"
            :aria-current="item.current ? 'page' : undefined">
          <component :is="item.icon"
            :class="[item.current ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'mr-3 h-6 w-6 flex-shrink-0']"
            aria-hidden="true" />
          {{ item.name }}
          </Link>
        </div>
      </nav>
    </div>
  </div>
  <!-- Main column -->
  <div class="top-0 left-0 fixed lg:pl-64 w-full">
    <!-- Search header -->
    <div class="top-0 z-10 relative flex h-16 flex-shrink-0 border-b border-gray-200 bg-white lg:hidden">
      <button type="button"
        class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 lg:hidden"
        @click="sidebarOpen = true">
        <span class="sr-only">Open sidebar</span>
        <Bars3CenterLeftIcon class="h-6 w-6" aria-hidden="true" />
      </button>
      <div class="flex flex-1 justify-end px-4 sm:px-6 lg:px-8">
        <div class="flex items-center">
          <!-- Profile dropdown -->
          <Menu as="div" class="relative ml-3">
            <div>
              <MenuButton
                class="flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <span class="sr-only">Open user menu</span>
                <span class="mr-4 truncate text-sm font-medium text-gray-900">{{ firstname }} {{ lastname }}</span>
                <div
                  class="relative inline-flex items-center justify-center w-8 h-8 overflow-hidden bg-gray-300 rounded-full dark:bg-gray-600">
                  <span class="font-medium text-l text-gray-600">{{ initial }}</span>
                </div>
              </MenuButton>
            </div>
            <transition enter-active-class="transition ease-out duration-100"
              enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95">
              <MenuItems
                class="absolute right-0 z-10 mt-2 w-48 origin-top-right divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                <div class="py-1">
                  <MenuItem v-slot="{ active }">
                  <Link :href="route('profile.edit')"
                    :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">View
                  profile</Link>
                  </MenuItem>
                </div>
                <div class="py-1">
                  <MenuItem v-slot="{ active }">
                  <Link :href="route('logout')" method="POST" as="button"
                    :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Logout
                  </Link>
                  </MenuItem>
                </div>
              </MenuItems>
            </transition>
          </Menu>
        </div>
      </div>
    </div>
  </div>
</template>
