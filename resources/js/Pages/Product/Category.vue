<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>
<template>
    <GuestLayout :canLogin="canLogin" :canRegister="canRegister">
    <div>
   
    </div>
</GuestLayout>
</template>