<script setup>
import { defineProps, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import VariationForm from '@/Components/Admin/Organisms/VariationForm.vue';
import SimpleProductForm from '@/Components/Admin/Organisms/SimpleProductForm.vue';
import Toggle from '@/Components/Admin/Atoms/Toggle.vue';

const props = defineProps({
    brands: Array,
    categories: Array,
    attributeTypes: Array,
});

let variation = ref(false);

</script>
<template>
    <Head title="Products" />
    <AuthenticatedLayout>
        <div  class="mt-10 max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-between">
            <h1 class="text-2xl font-bold">Create Product</h1>
           <div class="flex flex-row gap-6"> 
            <p v-if="!variation">Simple Product</p>
            <p v-else>Variable Product</p>
            <Toggle v-model="variation"/></div>
        </div>
        <SimpleProductForm v-if="!variation" :brands="props.brands" :categories="props.categories" :attributeTypes="props.attributeTypes"/>
        <VariationForm v-else :brands="props.brands" :categories="props.categories" :attributeTypes="props.attributeTypes"/>
    </AuthenticatedLayout>
</template>