<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { VariationForm, SimpleProductForm, Toggle } from '@/Components/Admin';

const props = defineProps({
    brands: Array,
    categories: Array,
    attributeTypes: Array,
});

let variation = ref(false);
let sizeVariation = ref(false);
let colorVariation = ref(false);
let materialVariation = ref(false);

</script>
<template>
    <Head title="Products" />
    <AuthenticatedLayout>
        <div class="mt-10 max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-between">
            <h1 class="text-2xl font-bold">Create Product</h1>
            <div class="flex flex-row gap-6">
                <p>Simple</p>
                <Toggle v-model="variation" />
                <p>Variable</p>
            </div>
        </div>
        <SimpleProductForm v-if="!variation" :brands="props.brands" :categories="props.categories"
            :attributeTypes="props.attributeTypes" />
        <VariationForm v-else :brands="props.brands" :categories="props.categories"
            :attributeTypes="props.attributeTypes" :sizeVar="sizeVariation" :colorVar="colorVariation" :materialVar="materialVariation" />
    </AuthenticatedLayout>
</template>