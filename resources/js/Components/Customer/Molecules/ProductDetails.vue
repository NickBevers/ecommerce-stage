<script setup>
const props = defineProps({
  sku: {
    type: Object,
    required: true
  }
})
</script>
<template>
  <div class="mt-10" v-if="props.sku.product.description">
    <h2 class="text-sm font-medium text-gray-900">Description</h2>

    <div class="prose prose-sm mt-4 text-gray-500">
      <p>{{ props.sku.product.description }}</p>
    </div>
  </div>

  <div class="mt-8 border-t border-gray-200 pt-8" v-if="props.sku.product.extra_info">
    <h2 class="text-sm font-medium text-gray-900">Extra Info</h2>

    <div class="prose prose-sm mt-4 text-gray-500">
      <p>{{ props.sku.product.extra_info }}</p>
    </div>
  </div>
</template>
