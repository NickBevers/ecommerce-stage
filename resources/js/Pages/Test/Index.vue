<script setup>
import Pagination from '@/Components/Pagination.vue'
import SkuTable from "@/Components/Admin/Organisms/SkuTable.vue";
import { defineProps } from 'vue'

const props = defineProps({
    skus: Object,
});


</script>
<template>
    <div title="Users">
        <div class="container mt-5">
            <SkuTable :skus="skus.data" />
            <Pagination class="mt-6" :links="skus.links" />
        </div>
    </div>
</template>