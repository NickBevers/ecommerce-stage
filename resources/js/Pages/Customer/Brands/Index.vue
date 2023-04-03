<script setup>
import { onMounted, computed } from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";

const props = defineProps({
    brands: Object,
});

const categories = computed(() => {
    let result = {};
    for (let i = 65; i <= 90; i++) {
        result[String.fromCharCode(i)] = [];
    }
    for (let brand of props.brands) {
        let firstLetter = brand.name.charAt(0).toUpperCase();
        if (result[firstLetter]) {
            result[firstLetter].push(brand);
        }
    }
    return result;
});

onMounted(() => {

})
</script>
<template>
    <GuestLayout>
        <div class="mx-auto max-w-7xl px-6 lg:px-8 pt-36">
            <div class="mt-15">
                <div v-for="(brands, category) in categories" :key="category" class=" grid grid-cols-3 gap-4 mt-16">
                    <h2 class="text-lg font-medium text-gray-900 col-span-3">{{ category }}</h2>
                    <div class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none"
                        v-for="brand in brands">
                        <span class="flex flex-col">
                            {{ brand.name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>