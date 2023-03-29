<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { ProductsFilter, ProductsList } from '@/Components/Customer'

const props = defineProps({
  skus: Object,
  minPrice: Number,
  maxPrice: Number,
  subCategory: Object,
});
</script>
<template>
  <GuestLayout>
    <ProductsFilter :title="props.subCategory.name" />
    <ProductsList :skus="skus.data" :links="skus.links" />
  </GuestLayout>
</template>