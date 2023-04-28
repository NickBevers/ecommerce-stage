<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { InputLabel, TextInput, UploadFile, InputError, Dropdown, SearchDropdown } from '@/Components/Admin';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { reactive, ref, watch } from 'vue';

const props = defineProps({
    skus: Object,
    brands: Object,
    categories: Object,
    attributeTypes: Object,
    sizes: Object,
    colors: Object,
    materials: Object,
});

const audience = reactive(["Men", "Women", "Kids", "Unisex"]);
let selectedHeadCategoryIndex = ref(0);
let selectedHeadCategory = ref(0);
let selectedSubCategory = ref(0);
let selectedBrand = ref(null);

let form = useForm({
    title: props.skus.product.title,
    audience: props.skus.product.audience,
    sub_category_id: props.skus.product.sub_category_id,
    brand_id: props.skus.product.brand_id,
    description: props.skus.product.description,
    extra_info: props.skus.product.extra_info,
});

function updateSubCategories() {
    selectedHeadCategory.value = selectedHeadCategoryIndex.value.id - 1
}


watch(() => {
    if (selectedSubCategory.value) {
        form.sub_category_id = selectedSubCategory.value.id
    }
    if (selectedBrand.value) {
        form.brand_id = selectedBrand.value.id
    }

})

console.log(props.skus);
</script>
<template>
    <Head :title="'Update ' + props.skus.product.title" />
    <AuthenticatedLayout>
        <div class="mt-10 max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-between">
            <h1 class="text-2xl font-bold">Update {{ props.skus.product.title }}</h1>
        </div>
        <div class="mt-8">
            {{ form }}
            <form class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-5">
                <div class="bg-white px-4 py-5 shadow sm:rounded-lg mb-4 sm:p-6 ">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Product
                            </h3>
                            <span
                                class="inline-flex items-center rounded-full text-center bg-red-50 px-2 py-1 text-xs font-medium my-1 text-red-700 ring-1 ring-inset ring-red-600/10">Updates
                                here
                                affect all variations.</span>
                            <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly so be careful
                                what you share.</p>
                        </div>
                        <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
                            <div class="grid grid-cols-4 gap-6">
                                <div class="col-span-2 sm:col-span-2">
                                    <InputLabel for="title" value="Title" />
                                    <div class="mt-2 flex rounded-md shadow-sm">
                                        <TextInput id="title" type="text" class="mt-1 block w-full pl-3" name="title"
                                            required autocomplete="title" placeholder="Product" v-model="form.title" />
                                        <InputError class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-span-2 sm:col-span-2">
                                    <InputLabel for="audience" value="Audience" />
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <Dropdown class="w-full" :items="audience" v-model="form.audience"
                                            :selected="form.audience">
                                        </Dropdown>
                                        <InputError class="mt-2" :message="form.errors.audience" />
                                    </div>
                                </div>
                                <div class="col-span-2 sm:col-span-2">
                                    <InputLabel for="head_categories" value="Head Category" />
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <Dropdown class="w-full" :items="props.categories"
                                            :selected="props.skus.product.sub_category.category.name"
                                            v-model="selectedHeadCategoryIndex" @click="updateSubCategories" />
                                    </div>
                                </div>

                                <div class="col-span-2 sm:col-span-2">
                                    <InputLabel for="sub_category" value="Sub Category" />
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <Dropdown class="w-full" v-model="selectedSubCategory"
                                            :selected="props.skus.product.sub_category.name"
                                            :items="selectedHeadCategory >= 0 ? props.categories[selectedHeadCategory].subCategories : []" />
                                    </div>
                                </div>
                                <div class="col-span-2 sm:col-span-2">
                                    <InputLabel for="title" value="Brand" />
                                    <div class="flex">
                                        <SearchDropdown :options="props.brands" v-on:selected="onSelectedOption"
                                            :placeholder="props.skus.product.brand.name">
                                        </SearchDropdown>
                                        <InputError class="mt-2" :message="form.errors.title" />
                                    </div>
                                </div>
                            </div>
                            <div>
                                <InputLabel for="description">Description</InputLabel>
                                <div class="mt-2">
                                    <textarea id="description" name="description" maxlength="400" rows="3"
                                        class="block h-32 w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:py-1.5 sm:text-sm sm:leading-6 resize-none"
                                        placeholder="Brief description for your product."
                                        v-model="form.description">  </textarea>
                                </div>
                            </div>
                            <div>
                                <InputLabel for="description">Extra Info</InputLabel>
                                <div class="mt-2">
                                    <textarea id="description" name="description" maxlength="400" rows="3"
                                        class="block h-32 w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:py-1.5 sm:text-sm sm:leading-6 resize-none"
                                        placeholder="Brief description for your product."
                                        v-model="form.extra_info">  </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end px-4 sm:px-0">
                        <Link href="/admin/products" to="/admin/products"
                            class="rounded-md bg-white py-2 px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        Cancel
                        </Link>
                        <button type="submit"
                            class="ml-3 inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>