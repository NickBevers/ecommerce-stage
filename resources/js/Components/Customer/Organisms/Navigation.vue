<script setup>
import {ApplicationLogo} from '@/Components/Customer';
import { onBeforeMount, ref, onMounted, computed } from "vue";
import { Link } from '@inertiajs/vue3';
import { useWishlistStore } from '@/Stores/wishlist';
import { Popover, PopoverButton, PopoverGroup, PopoverPanel } from '@headlessui/vue'
import { MagnifyingGlassIcon, ShoppingBagIcon } from '@heroicons/vue/24/outline'
import {
    Dialog,
    DialogPanel,
    Tab,
    TabGroup,
    TabList,
    TabPanel,
    TabPanels,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import {
    Bars3Icon,
    QuestionMarkCircleIcon,
    XMarkIcon,
    HeartIcon,
} from '@heroicons/vue/24/outline'

const navigation = {
    categories: [
        {
            name: 'Women',
            featured: [
                {
                    name: 'New Arrivals',
                    href: '#',
                    imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-category-01.jpg',
                    imageAlt: 'Models sitting back to back, wearing Basic Tee in black and bone.',
                },
                {
                    name: 'Basic Tees',
                    href: '#',
                    imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-category-02.jpg',
                    imageAlt: 'Close up of Basic Tee fall bundle with off-white, ochre, olive, and black tees.',
                },
                {
                    name: 'Accessories',
                    href: '#',
                    imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-category-03.jpg',
                    imageAlt: 'Model wearing minimalist watch with black wristband and white watch face.',
                },
                {
                    name: 'Carry',
                    href: '#',
                    imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-category-04.jpg',
                    imageAlt: 'Model opening tan leather long wallet with credit card pockets and cash pouch.',
                },
            ],
        },
        {
            name: 'Men',
            featured: [
                {
                    name: 'New Arrivals',
                    href: '#',
                    imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-01-men-category-01.jpg',
                    imageAlt: 'Hats and sweaters on wood shelves next to various colors of t-shirts on hangers.',
                },
                {
                    name: 'Basic Tees',
                    href: '#',
                    imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-01-men-category-02.jpg',
                    imageAlt: 'Model wearing light heather gray t-shirt.',
                },
                {
                    name: 'Accessories',
                    href: '#',
                    imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-01-men-category-03.jpg',
                    imageAlt:
                        'Grey 6-panel baseball hat with black brim, black mountain graphic on front, and light heather gray body.',
                },
                {
                    name: 'Carry',
                    href: '#',
                    imageSrc: 'https://tailwindui.com/img/ecommerce-images/mega-menu-01-men-category-04.jpg',
                    imageAlt: 'Model putting folded cash into slim card holder olive leather wallet with hand stitching.',
                },
            ],
        },
    ],
    pages: [
        { name: 'Company', href: '#' },
        { name: 'Stores', href: '#' },
    ],
}


const open = ref(false)


const categories = ref([]);
let selectedCategory = ref(null);

onBeforeMount(async () => {
    const response = await fetch('/admin/subcategories');
    const categoriesData = await response.json();
    categoriesData.forEach(category => {
        category.subCategories?.slice(0, 3).forEach(subcategory => {
            subcategory.preview = true;
        });
    });
    categories.value = categoriesData;
});

const wishlistStore = useWishlistStore();


onMounted(() => {
    wishlistStore.fetchCount()
});

function selectCategory(category_id) {
    selectedCategory.value = category_id;
}


</script>
<template>
    <div class="bg-white fixed top-0 left-0 z-20 w-full">
        <!-- Mobile menu -->
        <TransitionRoot as="template" :show="open">
            <Dialog as="div" class="relative z-40 lg:hidden" @close="open = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0"
                    enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
                    leave-to="opacity-0">
                    <div class="fixed inset-0 bg-black bg-opacity-25" />
                </TransitionChild>

                <div class="fixed inset-0 z-40 flex">
                    <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                        enter-from="-translate-x-full" enter-to="translate-x-0"
                        leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                        leave-to="-translate-x-full">
                        <DialogPanel
                            class="relative flex w-full max-w-xs flex-col overflow-y-auto bg-white pb-12 shadow-xl">
                            <div class="flex px-4 pt-5 pb-2">
                                <button type="button"
                                    class="-m-2 inline-flex items-center justify-center rounded-md p-2 text-gray-400"
                                    @click="open = false">
                                    <span class="sr-only">Close menu</span>
                                    <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                                </button>
                            </div>

                            <!-- Links -->
                            <TabGroup as="div" class="mt-2">
                                <div class="border-b border-gray-200">
                                    <TabList class="-mb-px flex space-x-8 px-4">
                                        <Tab as="template" v-for="category in navigation.categories" :key="category.name"
                                            v-slot="{ selected }">
                                            <button
                                                :class="[selected ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-900', 'flex-1 whitespace-nowrap border-b-2 py-4 px-1 text-base font-medium']">{{
                                                    category.name }}</button>
                                        </Tab>
                                    </TabList>
                                </div>
                                <TabPanels as="template">
                                    <TabPanel v-for="category in navigation.categories" :key="category.name"
                                        class="space-y-12 px-4 py-6">
                                        <div class="grid grid-cols-1 gap-x-4 gap-y-10">
                                            <div v-for="item in category.featured" :key="item.name" class="group relative">
                                                <div
                                                    class="aspect-w-1 aspect-h-1 overflow-hidden rounded-md bg-gray-100 group-hover:opacity-75">
                                                    <img :src="item.imageSrc" :alt="item.imageAlt"
                                                        class="object-cover object-center" />
                                                </div>
                                                <a :href="item.href" class="mt-6 block text-sm font-medium text-gray-900">
                                                    <span class="absolute inset-0 z-10" aria-hidden="true" />
                                                    {{ item.name }}
                                                </a>
                                                <p aria-hidden="true" class="mt-1 text-sm text-gray-500">Shop now</p>
                                            </div>
                                        </div>
                                    </TabPanel>
                                </TabPanels>
                            </TabGroup>

                            <div class="space-y-6 border-t border-gray-200 py-6 px-4">
                                <div v-for="page in navigation.pages" :key="page.name" class="flow-root">
                                    <a :href="page.href" class="-m-2 block p-2 font-medium text-gray-900">{{ page.name
                                    }}</a>
                                </div>
                            </div>

                            <div class="space-y-6 border-t border-gray-200 py-6 px-4">
                                <div class="flow-root">
                                    <a href="#" class="-m-2 block p-2 font-medium text-gray-900">Create an account</a>
                                </div>
                                <div class="flow-root">
                                    <a href="#" class="-m-2 block p-2 font-medium text-gray-900">Sign in</a>
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <header class="relative">
            <nav aria-label="Top">
                <!-- Top navigation -->
                <div class="bg-gray-900">
                    <div class="mx-auto flex h-10 max-w-7xl items-center justify-end px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center space-x-6">
                            <div>
                                <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                                    class="text-sm font-medium text-white hover:text-gray-100">
                                Dashboard</Link>
                                <template v-else>
                                    <Link :href="route('register')"
                                        class="text-sm font-medium mr-4 text-white hover:text-gray-100">
                                    Create an account</Link>
                                    <Link :href="route('login')"
                                        class="text-sm  font-medium text-white hover:text-gray-100">
                                    Sign in</Link>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Secondary navigation -->
                <div class="bg-white">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="flex h-16 items-center justify-between">
                            <!-- Logo (lg+) -->
                        
                            <div class="hidden lg:flex lg:flex-1 lg:items-center">
                                <Link href="/">
                                <ApplicationLogo class="block h-8 w-auto" />
                                </Link>
                            </div>
                         
                            <div class="hidden h-full lg:flex">
                                <!-- Flyout menus -->
                                <PopoverGroup class="inset-x-0 bottom-0 px-4">
                                    <div class="flex h-full justify-center space-x-8">
                                        <Popover v-for="category in categories" :key="category.name" class="flex"
                                            v-slot="{ open }">
                                            <div class="relative flex">
                                                <PopoverButton @click="selectCategory(category.id)"
                                                    :class="[open ? 'text-indigo-600' : 'text-gray-700 hover:text-gray-800', 'relative flex items-center justify-center text-sm font-medium transition-colors duration-200 ease-out']">
                                                    {{ category.name }}
                                                    <span
                                                        :class="[open ? 'bg-indigo-600' : '', 'absolute inset-x-0 -bottom-px z-20 h-0.5 transition duration-200 ease-out']"
                                                        aria-hidden="true" />
                                                </PopoverButton>
                                            </div>

                                            <transition enter-active-class="transition ease-out duration-200"
                                                enter-from-class="opacity-0" enter-to-class="opacity-100"
                                                leave-active-class="transition ease-in duration-150"
                                                leave-from-class="opacity-100" leave-to-class="opacity-0">
                                                <PopoverPanel
                                                    v-if="selectedCategory === 1 || selectedCategory === 2 || selectedCategory === 3"
                                                    class="absolute inset-x-0 top-full z-10 bg-white text-sm text-gray-500">
                                                    <!-- Presentational element used to render the bottom shadow, if we put the shadow on the actual panel it pokes out the top, so we use this shorter element to hide the top of the shadow -->
                                                    <div class="absolute inset-0 top-1/2 bg-white shadow"
                                                        aria-hidden="true" />
                                                    <!-- Fake border when menu is open -->
                                                    <div class="absolute inset-0 top-0 mx-auto h-px max-w-7xl px-8"
                                                        aria-hidden="true">
                                                        <div
                                                            :class="[open ? 'bg-gray-200' : 'bg-transparent', 'h-px w-full transition-colors duration-200 ease-out']" />
                                                    </div>

                                                    <div class="relative">
                                                        <div
                                                            class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid grid-cols-4 gap-y-4 gap-x-8 py-16">
                                                            <div  v-for="(item, index) in category.subCategories.slice(0, 3)" :key="index"
                                                                class="group relative">
                                                                <div v-if="item.preview"
                                                                    class="aspect-w-1 aspect-h-1 overflow-hidden rounded-md bg-gray-100 group-hover:opacity-75">
                                                                    <img src="https://tailwindui.com/img/ecommerce-images/mega-menu-category-02.jpg"
                                                                        alt="placeholder"
                                                                        class="object-cover object-center" />
                                                                </div>
                                                                <div v-if="item.preview" class="flex flex-row">
                                                                    <Link :to="'/products/' + item.slug" :href="'/products/' + item.slug"
                                                                        class="mt-4 block font-medium text-gray-900">
                                                                        <span class="absolute inset-0 z-10"
                                                                            aria-hidden="true" />
                                                                        {{ item.name }}
                                                                </Link>
                                                                </div>
                                                                <div>
                                                                    <p v-if="item.preview" aria-hidden="true" class="mt-1">
                                                                        Shop now</p>
                                                                </div>
                                                            </div>
                                                      


                                                            <div class="col-span-1 flex flex-wrap ">
                                                                <div  v-for="(item, index) in category.subCategories.slice(3, 10)" :key="index"
                                                                class="group relative w-full">
                                                                <div v-if="!item.preview" class="flex flex-row flex-wrap justify-start pl-8 gap-6">
                                                                    <Link :to="'/products/' + item.slug" :href="'/products/' + item.slug"
                                                                        class="mt-4 block font-medium text-gray-900">
                                                                        <span class="absolute inset-0 z-10"
                                                                            aria-hidden="true" />
                                                                        {{ item.name }}
                                                                </Link>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </PopoverPanel>
                                            </transition>
                                        </Popover>
                                    </div>
                                </PopoverGroup>
                            </div>

                            <!-- Mobile menu and search (lg-) -->
                            <div class="flex flex-1 items-center lg:hidden">
                                <button type="button" class="-ml-2 rounded-md bg-white p-2 text-gray-400"
                                    @click="open = true">
                                    <span class="sr-only">Open menu</span>
                                    <Bars3Icon class="h-6 w-6" aria-hidden="true" />
                                </button>

                                <!-- Search -->
                                <a href="#" class="ml-2 p-2 text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Search</span>
                                    <MagnifyingGlassIcon class="h-6 w-6" aria-hidden="true" />
                                </a>
                            </div>

                            <!-- Logo (lg-) -->
                            <a href="#" class="lg:hidden">
                                <span class="sr-only">Your Company</span>
                                <img src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt=""
                                    class="h-8 w-auto" />
                            </a>

                            <div class="flex flex-1 items-center justify-end">
                                <a href="#"
                                    class="hidden text-sm font-medium text-gray-700 hover:text-gray-800 lg:block">Search</a>

                                <div class="flex items-center lg:ml-8">
                                    <!-- Help -->
                                    <a href="#" class="p-2 text-gray-400 hover:text-gray-500 lg:hidden">
                                        <span class="sr-only">Help</span>
                                        <QuestionMarkCircleIcon class="h-6 w-6" aria-hidden="true" />
                                    </a>
                                    <a href="#"
                                        class="hidden text-sm font-medium text-gray-700 hover:text-gray-800 lg:block">Help</a>
                                    <!-- Wish -->
                                    <div class="flow-root lg:ml-8">
                                        <Link href="/wishlist" class="group -m-2 flex items-center p-2">
                                            <HeartIcon class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                                                aria-hidden="true" />
                                            <span
                                                class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">{{ wishlistStore.count }}</span>
                                            <span class="sr-only">items in wishlist, view wishlist</span>
                                        </Link>
                                    </div>
                                    <!-- Cart -->
                                    <div class="ml-4 flow-root">
                                        <Link href="/cart" class="group -m-2 flex items-center p-2">
                                            <ShoppingBagIcon
                                                class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                                                aria-hidden="true" />
                                            <span
                                                class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800">0</span>
                                            <span class="sr-only">items in cart, view bag</span>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</div></template>