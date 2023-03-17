<template>
    <GuestLayout>
        <ProductsFilter :title="categoryName"/>
        <ProductsList :skus="skus.data" :links="skus.links"/>
    </GuestLayout>
  </template>
  
  <script setup>
  import { defineProps, onBeforeMount, ref} from 'vue'
  import GuestLayout from '@/Layouts/GuestLayout.vue'
  import ProductsFilter from '@/Components/Customer/Molecules/ProductsFilter.vue'
  import ProductsList from '@/Components/Customer/Molecules/ProductsList.vue'

  let categoryName = ref(null)
  const props = defineProps({
    skus: Object,
  });

    onBeforeMount(() => {
        const path = props.skus.path;
        const pathArray = path.split('/');
        categoryName = pathArray[pathArray.length - 1];
        console.log(path + ' ' + categoryName)
    });
  </script>