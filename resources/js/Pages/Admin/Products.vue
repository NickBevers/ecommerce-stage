<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProductTable from '@/Components/Admin/Organisms/ProductTable.vue';
import { defineProps, onMounted } from 'vue'
import Pagination from '@/Components/Pagination.vue'
import { Head } from '@inertiajs/vue3';
const props = defineProps({
    skus: Object,
});

</script>
<template>
    <Head title="Products" />
   <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
                <ProductTable :skus="skus.data"/>
                <Pagination class="mt-6" :links="skus.links" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
