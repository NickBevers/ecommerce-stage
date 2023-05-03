<script setup>
import { ref, reactive, watch, onMounted, capitalize } from 'vue'
import { InputLabel, TextInput, Dropdown, PrimaryButton, UploadFile, InputError, SearchDropdown } from '@/Components/Admin'
import { Link, useForm } from '@inertiajs/vue3';
import {
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
} from '@headlessui/vue'
import { ChevronDownIcon, XMarkIcon } from '@heroicons/vue/20/solid'
import { string } from "postcss-selector-parser";
function onSelectedOption(option) {
    form.brand_id = option.id
}

const props = defineProps({
    brands: Array,
    categories: Array,
    attributeTypes: Array,
    sizeVar: Boolean,
    colorVar: Boolean,
    materialVar: Boolean,
});

console.log(props.categories)

let checkedFilters = reactive([])
let submitImage = ref(false)

function addCheckedFilter(filter, value) {
    const index = checkedFilters.findIndex(item => item[filter])
    if (index === -1) {
        checkedFilters.push({ [filter]: [value] })
    } else {
        const values = checkedFilters[index][filter]
        if (!values) {
            checkedFilters[index][filter] = []
        }
        const valueIndex = values.indexOf(value)
        if (valueIndex === -1) {
            values.push(value)
        } else {
            values.splice(valueIndex, 1)
        }
    }
}

function addRadioFilter(filter, value) {
    //check if it already has a value
    const index = checkedFilters.findIndex(item => item[filter])
    //if it does replace the value
    if (index !== -1) {
        checkedFilters[index][filter] = [value]
    } else {
        //if it doesn't add it
        checkedFilters.push({ [filter]: [value] })
    }
}

//isChecked
function isChecked(filter, value) {
    const index = checkedFilters.findIndex(item => item[filter])
    if (index === -1) {
        // Attribute not present in the array
        return false
    } else {
        const values = checkedFilters[index][filter]
        if (!values) {
            // The filter key is present but its value is undefined
            return false
        }
        const valueIndex = values.indexOf(value)
        return valueIndex !== -1;
    }
}


const form = useForm({
    title: "",
    audience: "Men",
    vat_id: 72,
    sub_category_id: 1,
    product_type: "variable",
    brand_id: 1,
    description: "",
    extra_info: "",
    variations: {}
});

const variationForm = useForm({
    sku: "",
    amount: "",
    price: "",
    color: "",
    size: "",
    material: "",
    images: [],
})

const audience = reactive(["Men", "Women", "Kids", "Unisex"]);

let selectedHeadCategoryIndex = ref(0);
let selectedHeadCategory = ref(0);
let selectedSubCategory = ref(null);
let selectedBrand = ref(null);

let variations = ref([]);
let variationError = ref(false);

let formVariationError = ref(false);
let variationAttribute = reactive([]);
let generated = false;

let material = ref("");
let attributes = ref([]);
let variationsMade = ref(false);

let selectedImageIndex = ref(0);
let newIndex = ref(0);

function updateSubCategories() {
    selectedHeadCategory.value = selectedHeadCategoryIndex.value.id - 1
}

function handleVariationCreation() {
    if (generated) {
        return
    }
    variations.value = [];
    generated = true;
    generateVariations({}, 0);
    props.attributeTypes.forEach((attribute, index) => {
        if (variationAttribute.indexOf(attribute.name) === -1) {
            variations.value.forEach((variation) => {
                variation[attribute.name] = props.attributeTypes[index]['attributeValues'][0].name
            })
        }
    })

    variations.value.forEach((variation) => {
        variation.attributes = [];
        props.attributeTypes.forEach((attribute) => {
            if (variation[attribute.name]) {
                variation.attributes.push({ [attribute.name]: variation[attribute.name] })
                variation[attribute.name] = undefined
            }
        })
    })
}

function generateVariations(currentCombination, index) {
    const valueArray = checkedFilters.map((filter) => Object.values(filter)[0]);
    if (index !== valueArray.length) {
        for (let i = 0; i < valueArray[index].length; i++) {
            const newCombination = { ...currentCombination };
            newCombination[Object.keys(checkedFilters[index])[0]] = valueArray[index][i];
            generateVariations(newCombination, index + 1);
        }
    }

    variations.value.push(currentCombination);
    variations.value = variations.value.filter((variation) => Object.keys(variation).length === checkedFilters.length);
    generated = false;
    variationsMade.value = true;
}

function removeVariation(index) {
    variations.value.splice(index, 1)
}

watch(() => {
    if (selectedSubCategory.value) {
        form.sub_category_id = selectedSubCategory.value.id
    }
    if (selectedBrand.value) {
        form.brand_id = selectedBrand.value.id
    }
    form.variations = variations.value
})


watch(selectedImageIndex, (index) => {
    const images = [...form.variations[0].images];
    const selectedImage = images[index];
    images.splice(index, 1); // remove the selected image from its current position
    images.splice(newIndex, 0, selectedImage); // insert the selected image at the new position
    form.variations[0].images = images;
    selectedImageIndex.value = newIndex.value;
});


function updateImages(images, index) {
    // console.log(images)
    variations.value[index].images = images;
}

function removeImage(index, imageIndex) {
    fetch('/admin/products/removeVariationImage', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            public_id: variations.value[index].images[imageIndex].public_id
        })
    })
    variations.value[index].images.splice(imageIndex, 1)
}

function updateVariationAttribute(attribute) {
    const index = variationAttribute.findIndex(item => item === attribute)
    if (index !== -1) {
        variationAttribute.splice(index, 1);
        const filterIndex = checkedFilters.findIndex(item => item[attribute])
        if (filterIndex !== -1) {
            checkedFilters.splice(filterIndex, 1)
        }
    } else {
        variationAttribute.push(attribute)
    }
}

function applyAttribute(type, value) {
    variations.value.forEach((variation) => {
        const index = variation.attributes.findIndex(item => Object.keys(item)[0] === type)
        if (index !== -1) {
            variation.attributes[index][type] = value
        } else {
            // if it doesn't exist add it
            variation.attributes.push({ [type]: value })
        }
    })
}

function getAttribute(variation, attributeType) {
    const index = variation.attributes.findIndex(item => Object.keys(item)[0] === Object.keys(attributeType)[0])
    if (index !== -1) {
        return Object.values(variation.attributes[index])[0]
    }
    return null
}

function handlePrice(e) {
    if (e.target.value === "" || e.target.value === null || e.target.value === undefined || e.target.value === " ") {
        e.target.value = 0.00
    }

    isNaN(e.target.value)
        ? e.target.value = 0.00
        : e.target.value = parseFloat(e.target.value).toFixed(2)
}

function submit() {
    if (variations.value.length === 0) {
        formVariationError.value = true
        return
    }

    props.attributeTypes.forEach((attribute, index) => {
        if (variationAttribute.indexOf(attribute.name) === -1) {
            variations.value.forEach((variation) => {
                variation[attribute.name] = props.attributeTypes[index]['attributeValues'][0].name
            })
        }
    })
    form.variations = variations.value
    formVariationError.value = false

    form.post(route('admin.products.store'))
}
</script>
<template>
    <div class="mt-8">
        <form class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-5" @submit.prevent="submit">
            <div class="bg-white px-4 py-5 shadow sm:rounded-lg mb-4 sm:p-6">
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
                                <div class="flex">
                                    <SearchDropdown :options="props.brands" v-on:selected="onSelectedOption"
                                        placeholder="Search for a brand...">
                                    </SearchDropdown>
                                    <InputError class="mt-2" :message="form.errors.title" />
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-row justify-between mt-0">
                            <div>
                                <InputLabel for="variation">Make variations based on</InputLabel>
                                <div class="flex flex-row">
                                    <div v-for="attribute in props.attributeTypes" class="mr-6">
                                        <input type="checkbox" class="mr-1" :value="attribute.name"
                                            @click="updateVariationAttribute(attribute.name)">
                                        <label>{{ attribute.name }}</label>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex mt-auto mb-auto rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                <p @click="() => { variations.value = []; handleVariationCreation() }"
                                    class="cursor-pointer">Make my variations</p>
                                <!--                                <p @click="generateVariations({}, 0)">Make my variations</p>-->
                            </div>
                        </div>
                        <div class="flex flex-row gap-3 no-spacing">
                            <div class="flow-root" v-for="attribute in props.attributeTypes"
                                :class="variationAttribute.indexOf(attribute.name) >= 0 ? 'block' : 'hidden'">
                                <div v-if="variationAttribute.indexOf(attribute.name) >= 0">
                                    <PopoverGroup class="-mx-4 flex items-center divide-x divide-gray-200">
                                        <Popover class="relative inline-block px-4">
                                            <PopoverButton
                                                class="flex rounded-md bg-white px-3 py-1 mt-4  shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                <span>{{ attribute.name }}</span>
                                                <span v-if="attribute.attributeValues.length > 0"
                                                    class="ml-1.5 mt-0.5 rounded bg-gray-200 py-0.5 px-1.5 text-xs font-semibold tabular-nums text-gray-700">
                                                    {{ attribute.attributeValues.length }}
                                                </span>
                                                <ChevronDownIcon
                                                    class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                                                    aria-hidden="true" />
                                            </PopoverButton>

                                            <transition enter-active-class="transition ease-out duration-100"
                                                enter-from-class="transform opacity-0 scale-95"
                                                enter-to-class="transform opacity-100 scale-100"
                                                leave-active-class="transition ease-in duration-75"
                                                leave-from-class="transform opacity-100 scale-100"
                                                leave-to-class="transform opacity-0 scale-95">
                                                <PopoverPanel
                                                    class="absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white p-4 shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none max-h-60 overflow-y-auto">
                                                    <div class="space-y-4">
                                                        <div v-for="item in attribute.attributeValues" :key="item.id"
                                                            class="flex items-center">
                                                            <input :id="`filter-${item.id}`" :name="`${item.id}`"
                                                                :value="item.name" type="checkbox"
                                                                @click.self="addCheckedFilter(attribute.name, item.name)"
                                                                required :checked="isChecked(attribute.name, item.name)"
                                                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                            <label
                                                                class="ml-3 whitespace-nowrap pr-6 text-sm font-medium text-gray-900">{{
                                                                    item.name }}</label>
                                                        </div>
                                                    </div>
                                                </PopoverPanel>
                                            </transition>
                                        </Popover>
                                    </PopoverGroup>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <div class="sm:mt-0">
                                <div class="-m-1 flex flex-wrap items-center">
                                    <span v-for="(select, key) in checkedFilters" :key="key"
                                        class="m-1 inline-flex items-center rounded-lg border border-gray-200 bg-gray-50 py-1.5 pl-3 pr-2 text-sm font-medium text-gray-900">
                                        <span v-if="select.size !== undefined">Size: {{ select.size.join(', ')
                                        }}</span>
                                        <span v-if="select.color !== undefined">Color: {{
                                            select.color.join(',') }}</span>
                                        <span v-if="select.material !== undefined">Material: {{
                                            select.material.join(',') }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6" v-if="variationsMade">
                            <div v-for="(type, index) in attributeTypes" class="flex flex-row"
                                :class="variationAttribute.includes(type.name) ? 'hidden' : 'block'">
                                <div v-if="variationAttribute.includes(type.name) === false"
                                    class="max-w-[23.5rem] w-[23.5rem]">
                                    <div>
                                        <p class="text-sm font-medium mb-2">{{ capitalize(type.name) }}</p>
                                        <div class="flex rounded-md shadow-sm">
                                            <Dropdown class="w-full" :type="type.name" :items="type.attributeValues"
                                                @change-value="applyAttribute"></Dropdown>
                                        </div>
                                    </div>
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
            <div class="max-w-7xl mx-auto sm:py-6" v-if="variations.length">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold leading-6 text-gray-900">Variations</h1>
                    </div>
                    <div class="sm:mt-0 sm:ml-16 sm:flex-none">

                    </div>
                </div>
            </div>
            <InputError class="mt-2" v-if="formVariationError" message="Please create at least one variation" />
            <div class="pointer-events-none mb-4" v-for="(variation, index) in variations" :key="variation">
                <transition enter-active-class="transform ease-out duration-300 transition"
                    enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                    enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                    leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
                    leave-to-class="opacity-0">
                    <div
                        class="pointer-events-auto relative flex flex-row flex-wrap justify-between rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 p-4 items-center">
                        <div>
                            <div class="flex flex-row space-x-4 mb-2">
                                <p class="text-base font-large text-gray-900 mr-3 items-end">Variation {{ index + 1 }}:</p>
                                <div class="bg-gray-100 flex flex-row shadow">
                                    <p v-for="(type, index) in checkedFilters"
                                        class="text-base font-large text-gray-900 mx-2 items-end">{{ getAttribute(variation,
                                            type) }}</p>
                                </div>
                            </div>
                            <div class="flex flex-row gap-6 flex-wrap overflow-hidden items-end">
                                <div>
                                    <InputLabel for="skuInput" value="sku" />
                                    <TextInput id="skuInput" type="text"
                                        class="mt-2 flex rounded-md shadow-sm mt-1 block w-full pl-3" name="title"
                                        v-model="variations[index]['sku']" required placeholder="SKU" />
                                </div>
                                <div>
                                    <InputLabel for="stockInput" value="stock" />
                                    <TextInput id="stockInput" type="number"
                                        class="mt-2 flex rounded-md shadow-sm mt-1 block w-full pl-3" name="title"
                                        v-model="variations[index]['amount']" required placeholder="50" />
                                </div>
                                <div>
                                    <InputLabel for="priceInput" value="price" />
                                    <TextInput id="priceInput" pattern="^\d*(\.\d{0,2})?$" @blur="handlePrice" type="float"
                                        class="mt-2 flex rounded-md shadow-sm mt-1 block w-full pl-3" name="title"
                                        v-model="variations[index]['price']" required placeholder="19.99" />
                                </div>
                            </div>

                            <div class="flex flex-row gap-6 overflow-hidden pt-4">
                                <UploadFile @image-previews="updateImages" :images="variation.images" :index="index"
                                    :req="true" />
                                <div class="mt-6 flex gap-6 flex-wrap text-center">
                                    <div v-for="(preview, imageIndex) in variation.images" :key="imageIndex"
                                        class="relative cursor-pointer" @click="selectedImageIndex = imageIndex">
                                        <div class="bg-indigo-600 p-0.5 cursor-pointer absolute right-0 top-0 rounded-bl-md rounded-tr-md"
                                            @click="removeImage(index, imageIndex)">
                                            <XMarkIcon class="h-6 w-6 text-white" />
                                        </div>
                                        <img :src="preview.url" alt="Uploaded Image"
                                            :class="{ 'ring-2 rounded-md ring-indigo-600': imageIndex === selectedImageIndex }"
                                            class="mx-auto h-24 rounded-md w-24 object-cover" />
                                        <p :class="{ 'invisible': imageIndex != selectedImageIndex }">thumbnail</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </transition>
            </div>
            <div class="flex justify-end px-4 sm:px-0">
                <Link href="/admin/products" to="/admin/products"
                    class="rounded-md bg-white py-2 px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                Cancel
                </Link>
                <button type="submit"
                    class="ml-3 inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                    Save
                </button>
            </div>
        </form>
    </div>
</template>