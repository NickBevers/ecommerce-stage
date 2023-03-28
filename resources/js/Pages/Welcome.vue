<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { CategoryPreview, Trending, Hero, PromoSection, Incentive } from '@/Components/Customer';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <GuestLayout>
        <div>
            <Hero />
            <CategoryPreview />
            <Trending />
            <Incentive />
            <PromoSection />
        </div>
    </GuestLayout>
</template>
