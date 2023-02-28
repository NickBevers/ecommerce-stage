<script setup>
import CreateProductModal from '@/Components/molecules/CreateProductModal.vue';
import UpdateProductModal from '@/Components/molecules/UpdateProductModal.vue';
import { onMounted, reactive, computed, ref } from 'vue';
import moment from 'moment';

const state = reactive({
    products: [],
    currentPage: 1,
    itemsPerPage: 10,
});

const displayedProducts = computed(() => {
    const startIndex = (state.currentPage - 1) * state.itemsPerPage;
    const endIndex = startIndex + state.itemsPerPage;
    return state.products.slice(startIndex, endIndex);
});

const totalPages = computed(() => {
    return Math.ceil(state.products.length / state.itemsPerPage);
});

// const pages = computed(() => {
//     const pagesArray = [];
//     for (let i = 1; i <= totalPages.value; i++) {
//         pagesArray.push(i);
//     }
//     return pagesArray;
// });

let loading = ref(true);

const pages = computed(() => {
  const pagesArray = [];
  const maxPagesToShow = 3;

  let startPage = Math.max(state.currentPage - Math.floor(maxPagesToShow / 2), 1);
  let endPage = Math.min(startPage + maxPagesToShow - 1, totalPages.value);

  if (endPage - startPage < maxPagesToShow - 1) {
    startPage = Math.max(endPage - maxPagesToShow + 1, 1);
  }

  for (let i = startPage; i <= endPage; i++) {
    pagesArray.push(i);
  }

  if (pagesArray[0] !== 1) {
    pagesArray.unshift(1);
  }

  if (pagesArray[pagesArray.length - 1] !== totalPages.value) {
    pagesArray.push(totalPages.value);
  }

  return pagesArray;
});

onMounted(() => {
    fetch('/products/all')
        .then(response => response.json())
        .then(data => {
            data.sort((a, b) => {
                return new Date(b.updated_at) - new Date(a.updated_at);
            });
            state.products = data;
            state.products.forEach((product) => {
                product.updated_at = moment(product.updated_at).fromNow();
            });
            loading.value = false;
        })
        .catch(error => console.error(error));
});

function goToPage(page) {
    if (page >= 1 && page <= totalPages.value) {
        state.currentPage = page;
    }
}

</script>
<template>
    <section>
        <div class="flex justify-between items-center">
            <div class="flex flex-row gap-5">
                <h5>
                    <span class="text-gray-500">All Products: </span>
                    <span class="dark:text-white">{{ state.products.length }}</span>
                </h5>
                <h5>
                    <span class="text-gray-500">Total sales:</span>
                    <span class="dark:text-white">$88.4k</span>
                </h5>
            </div>
            <CreateProductModal />
        </div>
        <div class="mx-auto max-w-screen-2xl">

            <div role="status" v-if="loading" class="flex w-full h-28 justify-center items-center my-4  bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                            <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
            </div>
            <div v-else class=" overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Product</th>
                                <th scope="col" class="px-4 py-3">Category</th>
                                <th scope="col" class="px-4 py-3">Stock</th>
                                <th scope="col" class="px-4 py-3">Rating</th>
                                <th scope="col" class="px-4 py-3">Sales</th>
                                <th scope="col" class="px-4 py-3">Revenue</th>
                                <th scope="col" class="px-4 py-3">Last Update</th>
                                <th scope="col" class="px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                     
                            <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700" v-for="product in displayedProducts" :key="product.id">
                             
                                <th scope="row"
                                    class="flex items-center px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <img src="https://flowbite.s3.amazonaws.com/blocks/application-ui/products/imac-front-image.png"
                                        alt="iMac Front Image" class="w-auto h-8 mr-3">
                                    {{ product.title }}
                                </th>
                                <td class="px-4 py-2">
                                    <span
                                        class="bg-primary-100 text-primary-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-primary-900 dark:text-primary-300">Desktop
                                        PC
                                    </span>
                                </td>
                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="flex items-center">
                                        <div class="inline-block w-4 h-4 mr-2 bg-red-700 rounded-full"></div>
                                        {{ product.stock }}
                                    </div>
                                </td>
                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="flex items-center">
                                        <span class="ml-1 text-gray-500 dark:text-gray-400">5.0</span>
                                    </div>
                                </td>
                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24" fill="currentColor"
                                            class="w-5 h-5 mr-2 text-gray-400" aria-hidden="true">
                                            <path
                                                d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" />
                                        </svg>
                                        1.6M
                                    </div>
                                </td>
                                <td class="px-4 py-2">$3.2M</td>
                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ product.updated_at }}
                                </td>
                                <td class="px-4 py-2">
                                  <UpdateProductModal :product="product" />
                                </td>
                            </tr>
                    
                        </tbody>
                    </table>
                </div>
                <nav class="flex flex-col items-start justify-between p-4 space-y-3 md:flex-row md:items-center md:space-y-0"
                    aria-label="Table navigation">
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        Showing
                        <span class="font-semibold text-gray-900 dark:text-white">
                            {{ state.itemsPerPage * (state.currentPage - 1) + 1 }}-{{ state.currentPage * state.itemsPerPage }}
                        </span>
                        
                        of
                        <span class="font-semibold text-gray-900 dark:text-white">{{ state.products.length }}</span>
                    </span>
                    <ul class="inline-flex items-stretch -space-x-px">
                        <li :class="{ disabled: state.currentPage === 1 }">
                            <button
                                class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                @click="goToPage(state.currentPage - 1)"> <svg class="w-5 h-5" aria-hidden="true"
                                    fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg></button>
                        </li>
                        <!-- <li v-for="page in pages" :key="page" :class="{ active: state.currentPage === page }">
                            <button
                            :class="{ 'bg-primary-50 border-primary-300 hover:bg-primary-100 hover:text-primary-700': state.currentPage === page }"
                                class="flex items-center justify-center px-3 py-2 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                @click="goToPage(page)">{{ page }}</button>
                        </li> -->
                     
                        <template v-for="page in pages" :key="page">
                            <li :class="{ active: state.currentPage === page }">
                            <button :class="{ 'bg-primary-50 border-primary-300 hover:bg-primary-100 hover:text-primary-700': state.currentPage === page }"
                                    class="flex items-center justify-center px-3 py-2 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                    @click="goToPage(page)">{{ page }}</button>
                            </li>
                        </template>
               
                        <li :class="{ disabled: state.currentPage === totalPages }">
                            <button
                                class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                @click="goToPage(state.currentPage + 1)"> <svg class="w-5 h-5" aria-hidden="true"
                                    fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg></button>
                        </li>
                    </ul>
            </nav>
        </div>
    </div>
</section></template>