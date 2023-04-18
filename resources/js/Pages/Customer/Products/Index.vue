<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { ProductsFilter, ProductsList } from '@/Components/Customer'
import { onMounted, ref } from "vue";

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

const filters = ref([]);

onMounted(() => {
  // Add colors to filters
  const colors = props.colors;
  if (colors) {
    const colorOptions = Object.keys(colors).map(key => ({ value: key, label: colors[key] }));
    filters.value.push({ id: 'color', name: 'Color', options: colorOptions });
  }

  // Add sizes to filters
  const sizes = props.sizes;
  if (sizes) {
    const sizeOptions = Object.keys(sizes).map(key => ({ value: key, label: sizes[key] }));
    filters.value.push({ id: 'size', name: 'Size', options: sizeOptions });
  }

  // Add materials to filters
  const materials = props.materials;
  if (materials) {
    const materialOptions = Object.keys(materials).map(key => ({ value: key, label: materials[key] }));
    filters.value.push({ id: 'material', name: 'Material', options: materialOptions });
  }

  // Add brands to filters
  const brands = props.brands;
  if (brands) {
    const brandOptions = Object.keys(brands).map(key => ({ value: key, label: brands[key] }));
    filters.value.push({ id: 'brand', name: 'Brand', options: brandOptions });
  }
});


</script>
<template>
  <GuestLayout>
    <ProductsFilter :title="props.subCategory.name" :filters="filters" />
    <ProductsList :skus="skus.data" :links="skus.links" />
  </GuestLayout>
</template>