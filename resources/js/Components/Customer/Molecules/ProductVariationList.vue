<template>
  <div class="flex flex-wrap gap-2">
    <div v-for="variation, index in props.variations" :key="variation.id" class="m-1 overflow-hidden rounded-md"
      :class="{ 'hidden': !showAll && index > 3 }">
      <div v-if="!showAll" class="overflow-hidden">
        <div class="h-32 w-20 inline hover:scale-125 duration-500 col-span-4 transition-all rounded-md object-cover">
          <Link :href="`/product/${variation.sku}`">
          <img class="h-32 w-20  inline hover:scale-125 duration-500 transition-all rounded-md object-cover"
            :src="variation.product_images[0].image_link" alt="variation.name" />
          </Link>
        </div>
      </div>
      <div v-else>
        <div class="h-32 w-20 inline hover:scale-125 duration-500 transition-all rounded-md object-cover">
          <Link :href="`/product/${variation.sku}`">
          <img class="h-32 w-20 inline hover:scale-125 duration-500 transition-all rounded-md object-cover"
            :src="variation.product_images[0].image_link" alt="variation.name" />
          </Link>
        </div>
      </div>
    </div>
    <div v-if="props.variations.length > 4 && !showAll"
      class="flex text-center justify-center content-center mt-1 object-center rounded-md">
      <button
        class="h-32 w-20  border-2 border-indigo-300 rounded-md hover:border-indigo-600 text-indigo-300 hover:text-indigo-600 duration-500 transition-all"
        @click.prevent="showAll = !showAll">+{{ props.variations.length - 4 }}</button>
    </div>

  </div>
</template>
<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  variations: {
    type: Object,
    required: true
  }
})


let showAll = ref(false);

</script>