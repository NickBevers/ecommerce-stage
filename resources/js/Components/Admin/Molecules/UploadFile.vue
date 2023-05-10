<script setup>
import { ref } from 'vue';

const emit = defineEmits(['imagePreviews'])
const images = ref(null);

const props = defineProps({
  index: {
    type: Number,
    required: false,
  },
  images: {
    type: Array,
    required: false,
  },
  req: {
    type: Boolean,
    required: false,
  }
});

const handleFileUpload = (e) => {
  e.preventDefault();
  images.value = e.target.files;
  uploadImages();
};

const handleDrop = (e) => {
  e.preventDefault();
  images.value = e.dataTransfer.files;
  uploadImages();
};

const uploadImages = () => {
  const formData = new FormData();
  images.value = Array.from(images.value);
  images.value.forEach((image, index) => {
    formData.append('files[' + index + ']', image);
  });

  fetch('/admin/products/images', {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      emit('imagePreviews', data.urls, props.index)
    })
    .catch((error) => {
      console.error(error);
    });
};
</script>
<template>
  <div>
    <!-- <label class="block text-sm font-medium leading-6 text-gray-900">Product images</label> -->
    <div class="flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6"
      :class="{ 'border-indigo-300': dragging }" @dragover.prevent @drop="handleDrop">
      <div class="space-y-1 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
          fill="none" viewBox="0 0 48 48" aria-hidden="true">
          <path
            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <div class="flex text-sm text-gray-600">
          <label :for="'file-upload' + props.index"
            class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
            <span>Upload a file</span>
            <input :id="'file-upload' + props.index" name="file-upload" type="file" class="sr-only"
              @change="handleFileUpload" multiple v-if="props.req" required />
            <input :id="'file-upload' + props.index" name="file-upload" type="file" class="sr-only"
              @change="handleFileUpload" multiple v-else />
          </label>
          <p class="pl-1">or drag and drop</p>
        </div>
        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
      </div>
    </div>
  </div></template>
  