<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { ProductsFilter, ProductsList } from '@/Components/Customer'
import { onMounted } from "vue";

const props = defineProps({
  skus: Object,
  minPrice: Number,
  maxPrice: Number,
  subCategory: Object,
  colors: Object,
  sizes: Object,
  materials: Object,
  brands: Object,
});

onMounted(() => {

});
</script>
<template>
  <GuestLayout>
    <ProductsFilter :title="props.subCategory.name" />
    <ProductsList :skus="skus.data" :links="skus.links" />
  </GuestLayout>
</template>