<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { WishList } from '@/Components/Customer'

const props = defineProps({
    wishlist: Object,
});

</script>
<template>
    <GuestLayout>
        <WishList :products="props.wishlist" />
    </GuestLayout>
</template>