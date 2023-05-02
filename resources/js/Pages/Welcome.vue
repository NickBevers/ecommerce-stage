<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { CategoryPreview, Trending, Hero, PromoSection, Incentive } from '@/Components/Customer';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    recentOrderedProducts: Array,
    recentProducts: Array,
});
</script>

<template>
    <Head title="Home" />
    <GuestLayout>
        <div>
            <Hero />
            <CategoryPreview />
            <Trending :recent-ordered-products="props.recentOrderedProducts" :recent-products="props.recentProducts" />
            <Incentive />
            <PromoSection />
        </div>
    </GuestLayout>
</template>
