<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ProductTable } from '@/Components/Admin';
import { Head, Link } from '@inertiajs/vue3';
import { HomeIcon, ShoppingBagIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    skus: Object,
    subCategory: Object,
    minPrice: Number,
    maxPrice: Number,
});

</script>
<template>
    <Head title="Products" />
    <AuthenticatedLayout>
        <div class="mt-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-2xl font-bold">Products</h1>
                    </div>
                    <div class="sm:mt-0 sm:ml-16 sm:flex-none">
                        <Link href="/admin/products/create" to="/admin/products/create"
                            class="rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Add product
                        </Link>
                    </div>
                </div>
                <ProductTable :skus="skus.data" :links="skus.links" v-if="props.skus.data.length > 0" />
                <div v-else>
                    <div
                        class="flex flex-col items-center justify-center h-64 mt-16 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="flex flex-col items-center justify-center">
                            <ShoppingBagIcon class="h-20 w-20 text-gray-500" aria-hidden="true" />
                            <h1 class="text-xl font-bold text-gray-500 mt-4">There are no products yet!</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
