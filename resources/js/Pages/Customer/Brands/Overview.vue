<script setup>
import { onMounted } from "vue";

const props = defineProps({
    brand: Object,
    skus: Object,
})

onMounted(() => {
    console.log(props.brand)
    console.log(props.skus)
})
</script>
<template></template>