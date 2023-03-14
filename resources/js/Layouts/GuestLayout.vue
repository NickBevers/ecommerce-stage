<script setup>
import Navigation from "@/Components/Customer/Organisms/Navigation.vue";
import Footer from "@/Components/Customer/Organisms/Footer.vue";

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
});

</script>

<template>
<div class="h-screen">
    <div class="relative sm:flex sm:justify-center sm:items-center bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <Navigation :canLogin="canLogin" :canRegister="canRegister"/>
    </div>
    <slot />
    
    <Footer/>
</div>
</template>
