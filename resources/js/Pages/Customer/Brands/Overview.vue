<script setup>
import { onMounted } from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";

const props = defineProps({
    brand: Object,
    skus: Object,
    sku: Object,
})

onMounted(() => {
    console.log(props.brand)
    console.log(props.skus)
    console.log(props.sku)
})
</script>
<template>
    <GuestLayout>

    </GuestLayout>
</template>