<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/atoms/ApplicationLogo.vue';
import Dropdown from '@/Components/molecules/Dropdown.vue';
import DropdownLink from '@/Components/atoms/DropdownLink.vue';
import NavLink from '@/Components/atoms/NavLink.vue';
import ResponsiveNavLink from '@/Components/atoms/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import AdminSidePanel from '@/Components/organisms/AdminSidePanel.vue';

const showingNavigationDropdown = ref(false);
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
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
