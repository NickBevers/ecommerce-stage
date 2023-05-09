<script setup>
import { onMounted } from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { ProductsFilter, ProductsList } from '@/Components/Customer'

const props = defineProps({
    brand: Object,
    skus: Object,
})

</script>
<template>
    <GuestLayout>
        <ProductsFilter :title="props.brand.name" />
        <ProductsList :skus="skus.data" :links="skus.links" />
    </GuestLayout>
</template>