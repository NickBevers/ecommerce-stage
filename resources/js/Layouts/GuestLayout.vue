<script setup>
import { Navigation, Footer } from "@/Components/Customer";

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
});
</script>

<template>
  <div class="selection:bg-blue-700 selection:text-white">
    <div
      class="relative sm:flex sm:justify-center sm:items-center bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900">
      <Navigation />
    </div>
    <div>
      <slot />
    </div>

    <div>
      <Footer />
    </div>
  </div>
</template>
