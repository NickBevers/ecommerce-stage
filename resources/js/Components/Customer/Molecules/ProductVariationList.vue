<script setup>
import { ref, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  variations: {
    type: Object,
    required: true
  },
  sku: {
    type: Object,
    required: true
  }
})

let showAll = ref(false);
let color = ref('');
let material = ref('');

onMounted(() => {
  if (props.sku.attribute_values.length > 0) {
    props.sku.attribute_values.forEach((attributeValue) => {
      if (attributeValue.attribute_type_id === 2) {
        color.value = attributeValue.name
      }
      if (attributeValue.attribute_type_id === 3) {
        material.value = attributeValue.name
      }
    })
  }
})

function changeAttributes(sku) {
  if (sku.attribute_values.length > 0) {
    sku.attribute_values.forEach((attributeValue) => {
      if (attributeValue.attribute_type_id === 2) {
        color.value = attributeValue.name
      }
      if (attributeValue.attribute_type_id === 3) {
        material.value = attributeValue.name
      }
    })
  }
}

function resetAttributes() {
  if (props.sku.attribute_values.length > 0) {
    props.sku.attribute_values.forEach((attributeValue) => {
      if (attributeValue.attribute_type_id === 2) {
        color.value = attributeValue.name
      }
      if (attributeValue.attribute_type_id === 3) {
        material.value = attributeValue.name
      }
    })
  }
}

</script>
<template v-if="props.variations.length > 0" >
  <h3 class="text-sm" v-if="props.variations.length > 0">
    Variation: {{ color }} / {{ material }}</h3>
  <div class="flex flex-wrap justify-start" @mouseout="resetAttributes">
    <div v-for="(variation, index) in props.variations" :key="variation.id" class="m-1 overflow-hidden rounded-md"
      :class="{ 'hidden': !showAll && index > 3 }" @mouseover="changeAttributes(variation)">
      <div v-if="!showAll" class="overflow-hidden">
        <div class="h-32 w-20 inline hover:scale-125 duration-500 col-span-4 transition-all rounded-md object-cover">
          <Link :to="'/product/' + variation.sku + '/' + variation.product.slug"
            :href="'/product/' + variation.sku + '/' + variation.product.slug">
          <img class="h-32 w-20  inline hover:scale-125 duration-500 transition-all rounded-md object-cover"
            :src="variation.product_images[0].image_link" alt="variation.name" />
          </Link>
        </div>
      </div>
      <div v-else>
        <div class="h-32 w-20 inline hover:scale-125 duration-500 transition-all rounded-md object-cover">
          <Link :to="'/product/' + variation.sku + '/' + variation.product.slug"
            :href="'/product/' + variation.sku + '/' + variation.product.slug">
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