<script setup>
import { defineProps, onMounted } from 'vue'
import {Link} from '@inertiajs/vue3';

let props = defineProps({
    links: Array,
})

onMounted(() => {
    props.links[0].label = 'Previous'
    props.links[props.links.length - 1].label = 'Next'
})
</script>
<template>
    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-end">
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <div v-for="link in props.links"> 
                        <Link v-if="link" :href="link.url"
                            :class="{ 'bg-indigo-600': props.links.active }"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">{{ link.label }}
                        </Link>
                    </div>
                </nav>
            </div>
        </div>
</div></template>