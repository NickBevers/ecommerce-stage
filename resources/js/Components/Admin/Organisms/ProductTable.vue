<script setup>
import CreateProductModal from '@/Components/Admin/Molecules/CreateProductModal.vue';
import { defineProps, onMounted } from 'vue';
import moment from 'moment';

const props = defineProps({
    skus: Array,
});

onMounted(() => {
    props.skus.forEach((sku) => {
        sku.updated_at = moment(sku.updated_at).fromNow();
    });
});
</script>
<template>
    <section>
        <div class="flex justify-between items-center">
            <div class="flex flex-row gap-5">
                <h5>
                    <span class="text-gray-500">All Products: </span>
                    <span class="dark:text-white">{{ skus.length }}</span>
                </h5>
                <h5>
                    <span class="text-gray-500">Total sales:</span>
                    <span class="dark:text-white">$88.4k</span>
                </h5>
            </div>

            <CreateProductModal />
        </div>
        <div class="mx-auto max-w-screen-2xl">
            <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Product</th>
                                <th scope="col" class="px-4 py-3">Category</th>
                                <th scope="col" class="px-4 py-3">Stock</th>
                                <th scope="col" class="px-4 py-3">Price</th>
                                <th scope="col" class="px-4 py-3">Last Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700"
                                v-for="product in skus" :key="product">
                                <th scope="row"
                                    class="flex items-center px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <img src="https://flowbite.s3.amazonaws.com/blocks/application-ui/products/imac-front-image.png"
                                        alt="iMac Front Image" class="w-auto h-8 mr-3">
                                    {{ product.product.title }}
                                </th>
                                <td class="px-4 py-2">
                                    <span
                                        class="bg-primary-100 text-primary-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-primary-900 dark:text-primary-300">
                                        {{ product.product.sub_category_id }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="flex items-center">
                                        <div class="inline-block w-4 h-4 mr-2 bg-red-700 rounded-full"></div>
                                        {{ product.amount }}
                                    </div>
                                </td>
                                <td class="px-4 py-2">$23</td>
                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ product.updated_at }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</template>