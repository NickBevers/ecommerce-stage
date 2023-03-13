<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Navigation from '@/Components/Customer/Organisms/Navigation.vue';
import CategoryPreview from '@/Components/Customer/Molecules/CategoryPreview.vue';
import Trending from '@/Components/Customer/Molecules/Trending.vue';
import Hero from '@/Components/Customer/Molecules/Hero.vue';
import PromoSection from '@/Components/Customer/Molecules/PromoSection.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div class="relative sm:flex sm:justify-center sm:items-center bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <Navigation :canLogin="canLogin" :canRegister="canRegister"/>
    </div>
  
    <div>
        <Hero/>
        <CategoryPreview/>
        <Trending/>
        <PromoSection/>
    </div>
      
</template>
