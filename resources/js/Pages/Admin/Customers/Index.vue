<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CustomerTable } from '@/Components/Admin';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    customers: Object,
});
</script>
<template>
    <Head title="Products" />
    <AuthenticatedLayout>
        <div class="mt-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold leading-6 text-gray-900">Customers</h1>
                    </div>
                </div>
                <CustomerTable :customers="props.customers" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
