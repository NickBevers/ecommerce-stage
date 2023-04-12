
<script setup>
import { ref, reactive, watch } from 'vue';
import { XMarkIcon } from '@heroicons/vue/24/outline'

const emit = defineEmits(['imagePreviews'])

const props = defineProps({
  formSubmitted: {
    type: Boolean,
    required: true,
  },
    index: {
        type: Number,
        required: false,
    }
});

const imagePreviews = ref([]);

const handleFileUpload = (e) => {
  const files = e.target.files;
  for (let i = 0; i < files.length; i++) {
    const file = files[i];
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
      imagePreviews.value.push(reader.result);
      submit()
    };
  }
};

const handleDrop = (e) => {
  e.preventDefault();
  const files = e.dataTransfer.files;
  for (let i = 0; i < files.length; i++) {
    const file = files[i];
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
      imagePreviews.value.push(reader.result);
      submit()
    };
  }
};

const removeImage = (index) => {
  imagePreviews.value.splice(index, 1);
};

function submit() {
  emit('imagePreviews', imagePreviews.value, props.index)
}

watch(
  () => props.formSubmitted,
  (newValue) => {
    if (newValue) {
      imagePreviews.value = [];
    }
  }
);
</script>
<template>
  <div class="mt-6">
    <label class="block text-sm font-medium leading-6 text-gray-900">Cover photo</label>
    <div class="mt-2 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6"
      :class="{ 'border-indigo-300': dragging }" @dragover.prevent @drop="handleDrop">
      <div class="space-y-1 text-center">
        <svg v-if="imagePreview === null" class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
          viewBox="0 0 48 48" aria-hidden="true">
          <path
            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <div class="flex text-sm text-gray-600">
          <label for="file-upload"
            class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
            <span>Upload a file</span>
            <input id="file-upload" name="file-upload" type="file" class="sr-only" @change="handleFileUpload" multiple
              required />
          </label>
          <p class="pl-1">or drag and drop</p>
        </div>
        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
      </div>
    </div>
  </div>
  <div class="mt-6 flex gap-6 flex-wrap">

    <div v-for="(preview, index) in imagePreviews" :key="index" class="relative">
      <div class="bg-indigo-600 p-0.5 cursor-pointer absolute right-0 top-0 rounded-bl-md rounded-tr-md"
        @click="removeImage">
        <XMarkIcon class="h-6 w-6 text-white" />
      </div>
      <img :src="preview" alt="Uploaded Image" class="mx-auto h-24 rounded-md w-24 object-cover" />
    </div>
  </div>
</template>
  