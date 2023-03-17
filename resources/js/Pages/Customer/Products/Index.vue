<template>
    <GuestLayout>
        <ProductsFilter :title="props.subCategory.name"/>
        <ProductsList :skus="skus.data" :links="skus.links"/>
    </GuestLayout>
  </template>
  
  <script setup>
  import { defineProps, onMounted, ref} from 'vue'
  import GuestLayout from '@/Layouts/GuestLayout.vue'
  import ProductsFilter from '@/Components/Customer/Molecules/ProductsFilter.vue'
  import ProductsList from '@/Components/Customer/Molecules/ProductsList.vue'
  

  const props = defineProps({
    skus: Object,
    minPrice: Number,
    maxPrice: Number,
    subCategory: Object,
  });

  onMounted(()=>{
    console.log(props.minPrice)
  })
  </script>