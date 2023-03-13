<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Navigation from '@/Components/Customer/Organisms/Navigation.vue';
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
  
    
    <div class="relative sm:flex sm:justify-center sm:items-center bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <Navigation :canLogin="canLogin" :canRegister="canRegister"/>
    </div>
  
    <div>
        <Hero/>
        <CategoryPreview/>
        <Trending/>
        <Incentive/>
        <PromoSection/>
    </div>

    <Footer/>
      
</template>
