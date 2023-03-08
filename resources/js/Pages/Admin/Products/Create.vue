<script setup>
import {onMounted, ref} from 'vue'

const props = defineProps({
    brands: {
        type: Array,
        required: true
    },
    categories: {
        type: Array,
        required: true
    },
    attributeTypes: {
        type: Array,
        required: true
    }
})

</script>
<template>
    <pre>
<!--        {{props.categories}}-->
<!--        {{props.attributeTypes}}-->
<!--        {{props.brands}}-->
    </pre>
</template>


<style scoped>

</style>