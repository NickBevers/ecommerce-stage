<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { CategoryPreview, Trending, Hero, PromoSection, Incentive } from '@/Components/Customer';

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
    <GuestLayout>
        <div>
            <Hero />
            <CategoryPreview />
            <Trending :recent-ordered-products="props.recentOrderedProducts" :recent-products="props.recentProducts"/>
            <Incentive />
            <PromoSection />
        </div>
    </GuestLayout>
</template>
