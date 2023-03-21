<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProductTable from '@/Components/Admin/Organisms/ProductTable.vue';
import PrimaryButton from '@/Components/Admin/Atoms/PrimaryButton.vue';
import { defineProps, onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    skus: Object,
    subCategory: Object,
    minPrice: Number,
    maxPrice: Number,
});

onMounted(() => {
    console.log(props.skus);
});

</script>
<template>
    <Head title="Products" />
   <AuthenticatedLayout>
        <div class="mt-8">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
                            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold leading-6 text-gray-900">Products</h1>
                </div>
                <div class="sm:mt-0 sm:ml-16 sm:flex-none">
                    <Link href="/admin/products/create" to="/admin/products/create" class="rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Add product
                    </Link>
                </div>
                </div>
                <ProductTable :skus="skus.data" :links="skus.links"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
