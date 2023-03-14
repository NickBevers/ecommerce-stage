<script setup>
import Navigation from "@/Components/Customer/Organisms/Navigation.vue";
import Footer from "@/Components/Customer/Organisms/Footer.vue";

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
});

</script>

<template>
<div class="selection:bg-blue-700 selection:text-white">
    <div class="relative sm:flex sm:justify-center sm:items-center bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900">
        <Navigation :canLogin="canLogin" :canRegister="canRegister"/>
    </div>
    <slot />
    
    <Footer/>
</div>
</template>
