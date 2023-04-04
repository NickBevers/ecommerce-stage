<script setup>
import { onMounted } from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { ProductsFilter, ProductsList } from '@/Components/Customer'

const props = defineProps({
    brand: Object,
    skus: Object,
    sku: Object,
})

onMounted(() => {
    console.log(props.brand)
    console.log(props.skus)
    console.log(props.sku)
})
</script>
<template>
    <GuestLayout>
        <ProductsFilter :title="props.brand.name" />
        {{ skus.data }}
        <!-- <ProductsList :skus="skus.data" :links="skus.links" /> -->
    </GuestLayout>
</template>