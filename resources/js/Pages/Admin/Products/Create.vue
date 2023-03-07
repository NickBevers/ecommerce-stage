<script setup>
import {onMounted, ref} from 'vue'

const props = defineProps({
    sizes: {
        type: Array,
        required: true
    },
    colors: {
        type: Array,
        required: true
    },
    materials: {
        type: Array,
        required: true
    },
    brands: {
        type: Array,
        required: true
    },
    categories: {
        type: Array,
        required: true
    },
})

</script>
<template>
    <pre>
        {{props.categories}}
        {{props.sizes}}
        {{props.colors}}
        {{props.materials}}
        {{props.brands}}
    </pre>
</template>


<style scoped>

</style>