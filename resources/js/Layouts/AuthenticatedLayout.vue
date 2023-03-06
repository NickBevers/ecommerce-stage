<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/Customer/Atoms/ApplicationLogo.vue';
import Dropdown from '@/Components/Admin/Molecules/Dropdown.vue';
import DropdownLink from '@/Components/Admin/Atoms/DropdownLink.vue';
import NavLink from '@/Components/Admin/Atoms/NavLink.vue';
import ResponsiveNavLink from '@/Components/Admin/Atoms/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import AdminSidePanel from '@/Components/Admin/Organisms/AdminSidePanel.vue';

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
