<script setup>
import { onMounted, onBeforeMount } from 'vue'
import { Link } from '@inertiajs/vue3';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid'

let props = defineProps({
    links: Array,
})

onBeforeMount(() => {
    for (let i = 0; i < props.links.length; i++) {
        if (props.links[i].url === null) {
            props.links[i].url = ''
        }
    }
})
onMounted(() => {
    props.links[0].label = ''
    props.links[props.links.length - 1].label = ''
})
</script>
<template>
    <div class="flex items-center bg-white pt-4">
        <div class="sm:flex sm:flex-1 sm:items-center">
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm">
                    <div v-for="(link, index) in props.links">
                        <Link v-if="link" :href="link.url" :to="link.url"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 focus:z-20 focus:outline-offset-0"
                            :class="{
                                'rounded-l-md': index === 0,
                                'rounded-r-md': index === props.links.length - 1,
                                'hover:bg-indigo-50': !link.active,
                                'bg-indigo-600 hover:bg-indigo-700 ring-indigo-600 text-white': link.active,
                            }">
                        <template v-if="index === 0">
                            <ChevronLeftIcon class="h-5 w-5 text-gray-500" />
                        </template>
                        <template v-else-if="index === props.links.length - 1">
                            <ChevronRightIcon class="h-5 w-5 text-gray-500" />
                        </template>
                        <div v-if="index !== 0 && index !== props.links.length - 1">
                            {{ link.label }}
                        </div>
                        </Link>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</template>