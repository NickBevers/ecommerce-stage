<script setup>
import { onMounted, computed } from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { ChevronRightIcon } from '@heroicons/vue/20/solid'
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    brands: Object,
});

const categories = computed(() => {
    let result = {};
    for (let i = 65; i <= 90; i++) {
        result[String.fromCharCode(i)] = [];
    }
    result["0-9"] = [];
    result["+"] = [];
    for (let i = 0; i < props.brands.length; i++) {
        let brand = props.brands[i];
        let firstChar = brand.name.charAt(0).toUpperCase();
        if (/[0-9]/.test(firstChar)) {
            result["0-9"].push(brand);
        } else if (/[^A-Za-z0-9]/.test(firstChar)) {
            result["+"].push(brand);
        } else if (/[A-Za-z]/.test(firstChar)) {
            if (!result[firstChar]) {
                result[firstChar] = undefined;
            }
            result[firstChar].push(brand);
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
            <div class="flex justify-between">
                <a class="text-indigo-600" :href="`#${category}`" v-for="(brands, category) in categories" :class="brands.length > 0 ? 'block' :'hidden' "
                    :key="category">{{ category }}</a>
            </div>
            <div v-for="(brands, category) in categories" :key="category" class="grid grid-cols-3 gap-4">
                <h2 class="text-4xl font-bold text-gray-900 col-span-3 pt-32" :id="category" v-if="brands.length > 0">{{ category }}</h2>
                <Link :href="`/brands/${brand.slug}`" v-for="brand in brands"
                    class="relative flex cursor-pointer rounded-lg border justify-between bg-white p-4 shadow-sm focus:outline-none">
                <span class="flex flex-col">
                    {{ brand.name }}
                </span>
                <ChevronRightIcon class="text-gray-500 w-6 h-6" />

                </Link>
            </div>
        </div>
    </GuestLayout>
</template>