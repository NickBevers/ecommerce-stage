<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import CategoryPreview from '@/Components/Customer/Organisms/CategoryPreview.vue';
import Trending from '@/Components/Customer/Organisms/Trending.vue';
import Hero from '@/Components/Customer/Organisms/Hero.vue';
import PromoSection from '@/Components/Customer/Organisms/PromoSection.vue';
import Incentive from '@/Components/Customer/Organisms/Incentive.vue';
import Footer from '@/Components/Customer/Organisms/Footer.vue';

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
        <Hero/>
        <CategoryPreview/>
        <Trending/>
        <Incentive/>
        <PromoSection/>
    </div>
</GuestLayout>
      
</template>
