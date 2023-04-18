<script setup>
import { Pagination, Alert, Toggle } from '@/Components/Admin'
import { onMounted, ref } from 'vue';
import moment from 'moment';
import { Link, router } from '@inertiajs/vue3';
import { PencilIcon, EyeIcon, TrashIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    customers: Object,
});

</script>
<template>
    <section class="my-8">
        <div class="overflow-hidden px-4 py-5 rounded-lg bg-white shadow">
            <div class="flow-root">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Name</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Phone
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email
                                    </th>
                                    <!-- <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">
                                            Action
                                        </th> -->
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="customer in props.customers" :key="customer.id">
                                    <td class="whitespace-nowrap py-4 text-sm text-gray-500 ">
                                        <div class="font-medium text-gray-900">{{ customer.firstname }} {{ customer.lastname
                                        }}</div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <div class="font-medium text-gray-900" v-if="customer.phone">{{
                                        customer.phone }}
                                    </div>
                                    <div class="font-medium text-gray-300" v-else>Not provided</div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{
                                        customer.email }}
                                    </td>
                                    <!-- <td
                                                class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right justify-end text-sm font-medium sm:pr-0 flex gap-2">
                                                <Link href="/admin/customers"
                                                    class="rounded-full bg-indigo-600 p-2 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                <EyeIcon class="h-3 w-3" aria-hidden="true" />
                                                </Link>
                                                <button type="button" @click="open = true;"
                                                    class="rounded-full bg-red-600 p-2 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    <TrashIcon class="h-3 w-3" aria-hidden="true" />
                                                </button>
                                            </td> -->
                                </tr>
                            </tbody>
                        </table>
                        <div class="border-t border-gray-200  flex sm:justify-end">
                            <!-- <Pagination :links="props.links" /> -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>