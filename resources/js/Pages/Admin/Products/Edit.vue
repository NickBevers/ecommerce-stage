<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { InputLabel, TextInput, UploadFile, InputError, Dropdown, SearchDropdown } from '@/Components/Admin';
import { XMarkIcon } from "@heroicons/vue/24/outline";
import { Head, Link, useForm } from '@inertiajs/vue3';
import { reactive, ref, watch, onBeforeMount, capitalize } from 'vue';
import moment from 'moment';

const props = defineProps({
    skus: Object,
    brands: Object,
    categories: Object,
    attributeTypes: Object,
    attributeValues: Object,
    sizes: Object,
    colors: Object,
    materials: Object,
});

const audience = reactive(["Men", "Women", "Kids", "Unisex"]);
let selectedHeadCategoryIndex = ref(0);
let selectedHeadCategory = ref(0);
let selectedSubCategory = ref(0);

let selectedImageIndex = ref(0);
let newIndex = ref(0);


let form = useForm({
    title: props.skus.product.title,
    audience: props.skus.product.audience,
    sub_category_id: props.skus.product.sub_category_id,
    brand_id: props.skus.product.brand.id,
    description: props.skus.product.description,
    extra_info: props.skus.product.extra_info,
    variations: {
        sku: props.skus.sku,
        amount: props.skus.amount,
        price: props.skus.price_excl_vat,
        attributes: [

        ],
        images: props.skus.product_images,
    }
});

function updateSubCategories() {
    selectedHeadCategory.value = selectedHeadCategoryIndex.value.id - 1
}

function onSelectedOption(option) {
    form.brand_id = option.id
}

function handlePrice(e) {
    if (e.target.value === "" || e.target.value === null || e.target.value === undefined || e.target.value === " ") {
        e.target.value = 0.00
    }

    isNaN(e.target.value)
        ? e.target.value = 0.00
        : e.target.value = parseFloat(e.target.value).toFixed(2)
}

watch(() => {
    if (selectedSubCategory.value) {
        form.sub_category_id = selectedSubCategory.value.id
    }
})

function updateSize(event) {
    form.variations.attributes[0] = event.target.innerText
}

function updateColors(event) {
    form.variations.attributes[1] = event.target.innerText
}

function updateMaterial(event) {
    form.variations.attributes[2] = event.target.innerText
}


onBeforeMount(() => {

    if (props.skus.attribute_values) {
        if (props.skus.attribute_values[0]) {
            form.variations.attributes.push(props.skus.attribute_values[0].name)
        }
        if (props.skus.attribute_values[1]) {
            form.variations.attributes.push(props.skus.attribute_values[1].name)
        }
        if (props.skus.attribute_values[2]) {
            form.variations.attributes.push(props.skus.attribute_values[2].name)
        }
    }
})

function removeImage(image) {
    let publicVar;
    if (image.public_id){
        publicVar = image.public_id
    } else if (image.image_public_id) {
        publicVar = image.image_public_id
    }

    fetch('/admin/products/removeVariationImage', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            public_id: publicVar
        })
    })

    // remove the image from the array
    const imageIndex = form.variations.images.findIndex((img) => img.id === image.id)
    form.variations.images.splice(imageIndex, 1)
    selectedImageIndex.value = 0
}


function updateImages(images) {
    for (let i = 0; i < images.length; i++) {
        form.variations.images.push(images[i]);
    }
}

function update() {
    form.patch('/admin/products/' + props.skus.id, {
        preserveScroll: true,
        onSuccess: () => {
            console.log('success')
        },
        onError: () => {
            console.log('error')
        }
    })
}

function updateThumbnail(image, index) {
    selectedImageIndex.value = index;

    const images = [...form.variations.images];
    const selectedImage = images[index];
    images.splice(index, 1); // remove the selected image from its current position
    images.splice(newIndex, 0, selectedImage); // insert the selected image at the new position
    form.variations.images = images;
    selectedImageIndex.value = newIndex.value;
}

function removePromo(id) {
    fetch('/promos/' + id, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    props.skus.promos = props.skus.promos.filter(promo => promo.id !== id)
}

</script>
<template>
    <Head :title="'Update ' + props.skus.product.title" />
    <AuthenticatedLayout>
        <div class="mt-10 max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-between">
            <h1 class="text-2xl font-bold">Update {{ props.skus.product.title }}</h1>
        </div>
        <div class="mt-8">
            <form class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-5" @submit.prevent="update">
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
                                    <InputLabel for="brands" value="Brand" />
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

                </div>
                <div class="bg-white px-4 py-5 shadow sm:rounded-lg mb-4 sm:p-6 ">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">SKU
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly so be careful
                                what you share.</p>
                        </div>
                        <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
                            <div class="grid grid-cols-4 gap-6">
                                <div class="col-span-2 sm:col-span-2">
                                    <InputLabel for="stockInput" value="SKU" />
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <TextInput id="skuInput" type="text"
                                            class="mt-2 flex rounded-md shadow-sm mt-1 block w-full pl-3" name="title"
                                            v-model="form.variations.sku" required placeholder="SKU" />
                                    </div>
                                </div>

                                <div class="col-span-2 sm:col-span-2">
                                    <InputLabel for="stockInput" value="Stock" />
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <TextInput id="stockInput" type="number"
                                            class="mt-2 flex rounded-md shadow-sm mt-1 block w-full pl-3" name="title"
                                            v-model="form.variations.amount" required placeholder="50" />
                                    </div>
                                </div>

                                <div class="col-span-2 sm:col-span-2">
                                    <InputLabel for="audience" value="Price" />
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <TextInput id="priceInput" pattern="^\d*(\.\d{0,2})?$" @blur="handlePrice"
                                            type="float" class="mt-2 flex rounded-md shadow-sm mt-1 block w-full pl-3"
                                            name="title" v-model="form.variations.price" required placeholder="19.99" />

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white px-4 py-5 shadow sm:rounded-lg mb-4 sm:p-6 "
                    v-if="props.skus.attribute_values.length > 0">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Attributes
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly so be careful
                                what you share.</p>
                        </div>
                        <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
                            <div class="col-span-6 sm:col-span-6">
                                <div class="flex flex-row gap-6 flex-wrap">
                                    <div class="mt-1 flex rounded-md shadow-sm flex-col"
                                        v-if="props.skus.attribute_values[0]">
                                        <InputLabel for="attributes" value="Size" />
                                        <Dropdown :items="props.sizes" class="min-w-[150px]" @click="updateSize($event)"
                                            :place="capitalize(props.skus.attribute_values[0].name)"
                                            :selected="props.skus.attribute_values[0].name" />
                                    </div>
                                    <div class="mt-1 flex rounded-md shadow-sm flex-col"
                                        v-if="props.skus.attribute_values[1]">
                                        <InputLabel for="attributes" value="Color" />
                                        <Dropdown :items="props.colors" class="min-w-[150px]" @click="updateColors($event)"
                                            :place="capitalize(props.skus.attribute_values[1].name)"
                                            :selected="props.skus.attribute_values[1].name" />
                                    </div>
                                    <div class="mt-1 flex rounded-md shadow-sm flex-col"
                                        v-if="props.skus.attribute_values[2]">
                                        <InputLabel for="attributes" value="Material" />
                                        <Dropdown :items="props.materials" class="min-w-[150px]"
                                            @click="updateMaterial($event)"
                                            :place="capitalize(props.skus.attribute_values[2].name)"
                                            :selected="props.skus.attribute_values[2].name" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white px-4 py-5 shadow sm:rounded-lg mb-4 sm:p-6 ">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Images
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly so be careful
                                what you share.</p>
                        </div>
                        <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
                            <div class="col-span-6 sm:col-span-6">
                                <div class="flex flex-row gap-6 flex-wrap">
                                    <UploadFile :images="form.variations.images" @image-previews="updateImages"
                                        class="col-span-6 sm:col-span-6" :index="0" />
                                    <div class="flex gap-6 flex-wrap items-center text-center">
                                        <div v-for="(preview, imageIndex) in form.variations.images" :key="imageIndex"
                                            class="relative cursor-pointer text-white hover:text-gray-400"
                                            @click="updateThumbnail(preview, imageIndex)">
                                            <div class="bg-indigo-600 p-0.5 cursor-pointer absolute right-0 top-0 rounded-bl-md rounded-tr-md"
                                                v-if="(form.variations.images.length) > 1">
                                                <XMarkIcon class="h-6 w-6 text-white"  @click="removeImage(preview)"/>
                                            </div>
                                            <img :src="preview.image_link || preview.url" alt="Uploaded Image"
                                                :class="{ 'rounded-md ring-2 ring-indigo-600 ': imageIndex === selectedImageIndex }"
                                                class="mx-auto h-24 rounded-md w-24 object-cover" />
                                            <p :class="{ 'text-black': imageIndex === selectedImageIndex }"
                                                v-if="imageIndex === selectedImageIndex" class="select-none">
                                                thumbnail
                                            </p>

                                            <p :class="{ 'text-black': imageIndex === selectedImageIndex }" v-else
                                                class="select-none">
                                                &lt;
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white px-4 py-5 shadow sm:rounded-lg mb-4 sm:p-6 " v-if="props.skus.promos.length > 0">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Promotions
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly so be careful
                                what you share.</p>
                        </div>
                        <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
                            <div class="col-span-6 sm:col-span-6">
                                <div v-for="promo in props.skus.promos" :key="promo.id"
                                    class="relative flex items-center justify-between space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-indigo-400 mb-4">
                                    <span> #{{ promo.id }}</span>
                                    <span>new price: €{{ promo.new_price_incl_vat.toFixed(2) }}</span>
                                    <span v-if="promo.extra_info != null">{{ promo.extra_info }}</span>
                                    <span>ends: {{new Date(promo.end_date).toLocaleDateString('en-US', {month:'long', day: '2-digit', year: 'numeric'})}}</span>
<!--                                    <span>ends: {{ moment(promo.end_date).format("MMM Do YY") }}</span>-->
                                    <button type="button" @click="removePromo(promo.id)"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-transparent bg-white text-red-400 hover:text-red-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        <span class="sr-only">Open options</span>
                                        <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class=" flex justify-end px-4 mt-4 sm:px-0">
                    <Link href="/admin/products" to="/admin/products"
                        class="rounded-md bg-white py-2 px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    Cancel
                    </Link>
                    <button type="submit"
                        class="ml-3 inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
                </div>
            </form>

        </div>
    </AuthenticatedLayout>
</template>