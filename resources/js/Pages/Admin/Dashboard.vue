<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Stats } from '@/Components/Admin';
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 px-4 lg:px-8">
                <Stats class="py-12" />
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">This is Overview!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
