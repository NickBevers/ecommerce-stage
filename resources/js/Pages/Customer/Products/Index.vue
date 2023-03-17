<template>
    <GuestLayout>
        <ProductsFilter :title="test"/>
        <ProductsList :skus="skus.data" :links="skus.links"/>
    </GuestLayout>
  </template>
  
  <script setup>
  import { defineProps, onMounted} from 'vue'
  import GuestLayout from '@/Layouts/GuestLayout.vue'
  import ProductsFilter from '@/Components/Customer/Organisms/ProductsFilter.vue'
  import ProductsList from '@/Components/Customer/Molecules/ProductsList.vue'

  let test = 'test category'

  const props = defineProps({
    skus: Object,
    });

  </script>