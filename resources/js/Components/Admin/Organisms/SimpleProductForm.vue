<script setup>
import { ref, reactive, watch, capitalize } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3';
import { InputLabel, TextInput, UploadFile, InputError, Dropdown, SearchDropdown } from '@/Components/Admin';
import { XMarkIcon } from "@heroicons/vue/20/solid";

const props = defineProps({
    brands: Array,
    categories: Array,
    attributeTypes: Array,
});

const form = useForm({
    title: "",
    audience: "Men",
    sub_category_id: 1,
    brand_id: 1,
    product_type: "simple",
    vat_id: 1,
    description: "",
    extra_info: "",
    variations: [
        {
            sku: "",
            amount: "",
            price: "",
            attributes: [],
            images: [],
        }
    ]
});

const audience = reactive(
    ["Men", "Women", "Kids", "Unisex"]
);

let selectedHeadCategoryIndex = ref(0);
let selectedHeadCategory = ref(0);
let selectedSubCategory = ref(null);
let attributeError = ref("");
let imageError = ref("");
let skuError = ref("");
let selectedImageIndex = ref(0);
let newIndex = ref(0);

function updateImages(images) {
    form.variations[0].images = images
}

function removeImage(imageIndex) {
    fetch('/admin/products/removeVariationImage', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            public_id: form.variations[0].images[imageIndex].public_id
        })
    })
    form.variations[0].images.splice(imageIndex, 1)
}

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

watch(attributeError, (value) => {
    if (value !== "") {
        setTimeout(() => {
            attributeError.value = "";
        }, 5000);
    }
})

watch(imageError, (value) => {
    if (value !== "") {
        setTimeout(() => {
            imageError.value = "";
        }, 5000);
    }
})

watch(selectedImageIndex, (index) => {
    const images = [...form.variations[0].images];
    const selectedImage = images[index];
    images.splice(index, 1); // remove the selected image from its current position
    images.splice(newIndex, 0, selectedImage); // insert the selected image at the new position
    form.variations[0].images = images;
    selectedImageIndex.value = newIndex.value;
});

function updateVariation(event, attribute) {
    const obj = {}
    obj[attribute] = event.target.textContent
    form.variations[0].attributes.push(obj);
}
function submit() {
    if (form.variations[0].attributes.length === 0) {
        // show error message
        attributeError.value = "Please select at least one attribute";
        return;
    }

    if (form.variations[0].images.length === 0) {
        // show error message
        imageError.value = "Please upload at least one image";
        return;
    }

    form.post(route('admin.products.store'), {
        onSuccess: () => {
            // show success message
            console.log("success");
        },
        onError: (errors) => {
            // show error message
            console.log(errors);
            console.log(errors[Object.keys(errors)[0]]);
            skuError.value = errors[Object.keys(errors)[0]];
            setTimeout(() => {
                skuError.value = "";
            }, 3000);
        }
    });
}
</script>
<template>
    <div class="mt-8">
        <form class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-5" @submit.prevent="submit">
            <div class="bg-white px-4 py-5 shadow sm:rounded-lg mb-4 sm:p-6 ">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">Product</h3>
                        <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly so be careful
                            what you share.</p>
                    </div>
                    <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
                        <div class="grid grid-cols-4 gap-6">
                            <div class="col-span-2 sm:col-span-2">
                                <InputLabel for="title" value="Title" />
                                <div class="mt-2 flex rounded-md shadow-sm">
                                    <TextInput id="title" type="text" class="mt-1 block w-full pl-3" name="title"
                                        v-model="form.title" required autocomplete="title" placeholder="Product" />
                                    <InputError class="mt-2" :message="form.errors.title" />
                                </div>
                            </div>
                            <div class="col-span-2 sm:col-span-2">
                                <InputLabel for="audience" value="Audience" />
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <Dropdown class="w-full" :items="audience" v-model="form.audience">
                                    </Dropdown>
                                    <InputError class="mt-2" :message="form.errors.audience" />
                                </div>

                            </div>
                            <div class="col-span-2 sm:col-span-2">
                                <InputLabel for="head_categories" value="Head Category" />
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <Dropdown class="w-full" :items="props.categories" v-model="selectedHeadCategoryIndex"
                                        @click="updateSubCategories" />
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-2">
                                <InputLabel for="sub_category" value="Sub Category" />
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <Dropdown class="w-full" v-model="selectedSubCategory"
                                        :items="selectedHeadCategory >= 0 ? props.categories[selectedHeadCategory].subCategories : []" />
                                </div>
                            </div>
                            <div class="col-span-2 sm:col-span-2">
                                <InputLabel for="title" value="Brand" />
                                <div>
                                    <SearchDropdown :options="props.brands" v-on:selected="onSelectedOption"
                                        v-on:filter="getDropdownValues" placeholder="Search for a brand...">
                                    </SearchDropdown>
                                    <InputError class="mt-2" :message="form.errors.title" />
                                </div>

                            </div>
                            <div class="col-span-2 sm:col-span-2">
                                <InputLabel for="sku" value="SKU" />
                                <div class="mt-1 flex flex-col rounded-md shadow-sm">
                                    <TextInput id="sku" type="text" class="mt-1 block w-full pl-3" name="SKU"
                                        v-model="form.variations[0].sku" required autocomplete="SKU" placeholder="SKU" />
                                    <InputError class="mt-2" :message="skuError" />
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-2">
                                <InputLabel for="price" value="Price" />
                                <div class="mt-2 flex rounded-md shadow-sm">
                                    <TextInput id="price" type="number" class="mt-1 block w-full pl-3" name="price"
                                        pattern="^\d*(\.\d{0,2})?$" step="0.01" v-model="form.variations[0].price" required
                                        placeholder="19.99" @blur="handlePrice" />
                                    <InputError class="mt-2" :message="form.variations.error" />
                                </div>
                            </div>
                            <div class="col-span-2 sm:col-span-2">
                                <InputLabel for="stock" value="Stock" />
                                <div class="mt-2 flex rounded-md shadow-sm">
                                    <TextInput id="stock" type="number" class="mt-1 block w-full pl-3" name="amount"
                                        pattern="^\d*(\.\d{0,2})?$" step="1" v-model="form.variations[0].amount" required
                                        autocomplete="title" placeholder="100" />
                                    <span v-if="skuError.length > 0" class="text-red-500 -mt-4"> {{ attributeError }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <InputLabel for="attributes" value="Attributes" />
                            <div class="flex flex-row gap-6 flex-wrap">
                                <div class="mt-1 flex rounded-md shadow-sm" v-for="attribute in props.attributeTypes">
                                    <Dropdown :items="attribute.attributeValues" class="min-w-[150px]"
                                        v-model="form.variations[0].attributes[attribute]"
                                        @click="e => updateVariation(e, attribute.name)"
                                        :place="capitalize(attribute.name)" />
                                </div>
                                <span v-if="attributeError.length > 0" class="text-red-500 -mt-4"> {{ attributeError }}
                                </span>
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
                        <div class="flex flex-row">
                            <UploadFile @image-previews="updateImages" :images="form.variations[0].images" :index="0"
                                :req="true" />
                            <div class="flex gap-x-6 flex-wrap items-end ml-4 text-center">
                                <div v-for="(preview, imageIndex) in form.variations[0].images" :key="imageIndex"
                                    class="relative cursor-pointer" @click="selectedImageIndex = imageIndex">
                                    <div class="bg-indigo-600 p-0.5 cursor-pointer absolute right-0 top-0 rounded-bl-md rounded-tr-md"
                                        @click="removeImage(imageIndex)">
                                        <XMarkIcon class="h-6 w-6 text-white" />
                                    </div>
                                    <img :src="preview.url" alt="Uploaded Image"
                                        :class="{ 'ring-2 rounded-md ring-indigo-600': imageIndex === selectedImageIndex }"
                                        class="mx-auto h-24 rounded-md w-24 object-cover" />
                                    <p :class="{ 'invisible': imageIndex != selectedImageIndex }">thumbnail</p>
                                </div>
                            </div>
                        </div>
                        <span v-if="imageError.length > 0" class="text-red-500 -mt-4"> {{ imageError }} </span>
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
        </form>
    </div>
</template>