<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { OrderTable } from '@/Components/Admin';
import { Head, Link } from '@inertiajs/vue3';
import {ShoppingBagIcon} from "@heroicons/vue/24/outline";

const props = defineProps({
    orders: Object,
});

console.log(props.orders.data);
</script>
<template>
    <Head title="Products" />
    <AuthenticatedLayout>
        <div class="mt-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold leading-6 text-gray-900">Orders</h1>
                    </div>
                </div>
                <OrderTable :orders="props.orders" v-if="props.orders.data.length > 0"/>
                <div v-else>
                    <div class="flex flex-col items-center justify-center h-64 mt-16 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="flex flex-col items-center justify-center">
                            <ShoppingBagIcon class="h-20 w-20 text-gray-500" aria-hidden="true" />
                            <h1 class="text-xl font-bold text-gray-500 mt-4">There are no orders yet!</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
