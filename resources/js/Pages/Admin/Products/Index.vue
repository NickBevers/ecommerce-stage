<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProductTable from '@/Components/Admin/Organisms/ProductTable.vue';
import PrimaryButton from '@/Components/Admin/Atoms/PrimaryButton.vue';
import { defineProps, onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    skus: Object,
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
                    <PrimaryButton
                    >
                    <Link href="/products/create" to="/products/create">
                        Add product
                    </Link>
              </PrimaryButton>
                </div>
                </div>
                <ProductTable :skus="skus.data" :links="skus.links"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
