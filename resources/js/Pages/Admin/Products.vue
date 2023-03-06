<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProductTable from '@/Components/Admin/Organisms/ProductTable.vue';
import { defineProps, onMounted } from 'vue'
import { Head } from '@inertiajs/vue3';
const props = defineProps({
    skus: Object,
});

</script>
<template>
    <Head title="Products" />
   <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
                <ProductTable :skus="skus.data" :links="skus.links"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
