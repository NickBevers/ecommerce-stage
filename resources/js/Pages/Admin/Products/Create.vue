<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps } from 'vue'
import { Head, Link } from '@inertiajs/vue3';

</script>
<template>
    <Head title="Products" />
   <AuthenticatedLayout>
        <div class="mt-8">
               <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
                            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold leading-6 text-gray-900">Add product</h1>
                </div>
                <div class="sm:mt-0 sm:ml-16 sm:flex-none">
               
                </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>