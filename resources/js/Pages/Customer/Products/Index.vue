<template>
    <GuestLayout>
        <ProductsFilter :title="test"/>
    </GuestLayout>
  </template>
  
  <script setup>
  import { defineProps, onMounted} from 'vue'
  import GuestLayout from '@/Layouts/GuestLayout.vue'
  import ProductsFilter from '@/Components/Customer/Organisms/ProductsFilter.vue'

  let test = 'test category'

  const props = defineProps({
    skus: Object,
    });

    onMounted(() => {
        console.log(props)
    })
  </script>