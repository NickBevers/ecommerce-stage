<script setup>
import { ref } from 'vue';
import {AdminSidePanel} from '@/Components/Admin';
</script>

<template>
    <div class="flex justify-start">
        <AdminSidePanel :user="$page.props.auth.user"/>
        <div class="min-h-screen w-full bg-gray-100">
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="max-lg:mt-12">
                <slot />
            </main>
        </div>
    </div>
</template>
