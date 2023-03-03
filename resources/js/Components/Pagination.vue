<script setup>
    import { defineProps } from 'vue'

    defineProps({
        links: Array,
    })
</script>
<template>
    <div class="flex justify-center">
        <div class="flex">
            <template v-for="link in links">
                <a
                    v-if="link.active"
                    :href="link.url"
                    class="px-4 py-2 bg-gray-200 border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-300"
                >
                    {{ link.label }}
                </a>
                <a
                    v-else
                    :href="link.url"
                    class="px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    {{ link.label }}
                </a>
            </template>
        </div>
    </div>
</template>