<script setup>
import { ref } from 'vue'

const props = defineProps({
  sku: {
    type: Object,
    required: true
  }
})

let imagePreview = ref(props.sku.product_images[0].image_link);
</script>

<template>
  <div class="mt-8 lg:col-span-7 lg:col-start-1 lg:row-span-3 lg:row-start-1 lg:mt-0">
    <h2 class="sr-only">Images</h2>
    <div class="flex flex-row gap-4 sticky top-0">
      <div class="flex flex-col w-1/3 gap-4 h-[42rem] overflow-y-scroll no-scrollbar relative">
        <div v-for="image in props.sku.product_images">
          <div class="rounded-lg overflow-hidden h-60 w-full" @mouseenter="imagePreview = image.image_link">
            <img :src="image.image_link" alt="Back of women's Basic Tee in black."
              class="h-full w-full object-cover object-center">
          </div>
        </div>

      </div>
      <div class="flex flex-col w-2/2 w-full h-[42rem] rounded-md overflow-hidden ">
        <img :src="imagePreview" class="h-full w-full object-cover object-center">
      </div>
    </div>
  </div>
</template>
