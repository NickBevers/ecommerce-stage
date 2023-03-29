<script setup>
import { ref, reactive, watch } from 'vue'
import { InputLabel, TextInput, Dropdown, PrimaryButton, UploadFile, InputError, SearchDropdown } from '@/Components/Admin'
import { Head, Link, useForm } from '@inertiajs/vue3';
import {
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
} from '@headlessui/vue'
import { ChevronDownIcon, XMarkIcon } from '@heroicons/vue/20/solid'
function onSelectedOption(option) {
    form.brand_id = option.id
}
const props = defineProps({
    brands: Array,
    categories: Array,
    attributeTypes: Array,
});

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
        if (valueIndex === -1) {
            // Value not present in the attribute
            return false
        } else {
            // Value already present in the attribute
            return true
        }
    }
}


const form = useForm({
    title: "",
    audience: "Men",
    sub_category_id: 1,
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
    sizes: [],
    material: "",
    images: [],
})

const audience = reactive(
    ["Men", "Women", "Kids", "Unisex"]
);

let selectedHeadCategoryIndex = ref(0);
let selectedHeadCategory = ref(0);
let selectedSubCategory = ref(null);
let selectedBrand = ref(null);

let variations = reactive([])
let variationError = ref(false);

let formVariationError = ref(false);

function updateSubCategories() {
    selectedHeadCategory.value = selectedHeadCategoryIndex.value.id - 1
}

function addVariation() {
    if (!variationForm.color || !variationForm.sizes || !variationForm.material) {
        variationError.value = true
        return
    }
    variationError.value = false
    formVariationError.value = false
    submitImage.value = true

    const newVariation = {
        sku: variationForm.sku,
        amount: variationForm.amount,
        price: variationForm.price,
        color: variationForm.color,
        sizes: variationForm.sizes,
        material: variationForm.material,
        images: variationForm.images
    };

    variations.push(newVariation);

    variationForm.images = []

    variationForm.reset();

    checkedFilters = reactive([])
}

function removeVariation(index) {
    variations.splice(index, 1)
}

watch(() => {
    if (selectedSubCategory.value) {
        form.sub_category_id = selectedSubCategory.value.id
    }
    if (selectedBrand.value) {
        form.brand_id = selectedBrand.value.id
    }
    form.variations = variations
})

function updateImages(images) {
    variationForm.images = images
}


function submit() {
    if (variations.length === 0) {
        formVariationError.value = true
        return
    }
    formVariationError.value = false
    form.post(route('admin.products.store'), {
        onSuccess: () => {

        }

    })
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
                                <div class="flex">
                                    <SearchDropdown :options="props.brands" v-on:selected="onSelectedOption"
                                        v-on:filter="getDropdownValues" placeholder="Search for a brand...">
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

            <div class="bg-white px-4 py-5 shadow  mb-4 sm:rounded-lg sm:p-6">
                <form @submit.prevent="addVariation">

                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Variations</h3>
                            <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly so be
                                careful
                                what you share.</p>
                        </div>
                        <div class="mt-5 md:col-span-2 md:mt-0">
                            <InputError class="mt-2" v-if="formVariationError"
                                message="Please create at least one variation" />
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <InputLabel for="sku" value="SKU" />
                                    <div class="mt-2 flex rounded-md shadow-sm">
                                        <TextInput id="sku" type="text" class="mt-1 block w-full pl-3" name="SKU"
                                            v-model="variationForm.sku" required autocomplete="SKU" placeholder="SKU" />
                                        <InputError class="mt-2" :message="variationForm.errors.sku" />
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <InputLabel for="stock" value="Stock" />
                                    <div class="mt-2 flex rounded-md shadow-sm">
                                        <TextInput id="stock" type="number" class="mt-1 block w-full pl-3" name="stock"
                                            v-model="variationForm.amount" required autocomplete="title" placeholder="50" />
                                        <InputError class="mt-2" :message="variationForm.errors.amount" />
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <InputLabel for="stock" value="Price" />
                                    <div class="mt-2 flex rounded-md shadow-sm">
                                        <TextInput id="stock" type="number" class="mt-1 block w-full pl-3" name="price"
                                            pattern="^\d*(\.\d{0,2})?$" step="0.01" v-model="variationForm.price" required
                                            autocomplete="title" placeholder="19.99" />
                                        <InputError class="mt-2" :message="variationForm.errors.price" />
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-6">
                                    <InputLabel for="variation" value="Add-ons" />
                                    <div class="flex flex-row gap-6">
                                        <div class="flow-root" v-for="attribute in props.attributeTypes">
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
                                                        <PopoverPanel class="absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white p-4 shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none
                                                                                    max-h-60 overflow-y-auto
                                                                                    ">
                                                            <div class="space-y-4">
                                                                <div v-for="item in attribute.attributeValues"
                                                                    :key="item.id" class="flex items-center">


                                                                    <input v-if="attribute.name === 'Size'"
                                                                        :id="`filter-${item.id}`" :name="`${item.id}`"
                                                                        :value="item.name" type="checkbox"
                                                                        @click.self="addCheckedFilter(attribute.name, item.name)"
                                                                        v-model="variationForm.sizes" required
                                                                        :checked="isChecked(attribute.name, item.name)"
                                                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                                    <input v-else-if="attribute.name === 'Color'"
                                                                        :id="`filter-${item.id}`" :name="`${item.id}`"
                                                                        :value="item.name" type="radio"
                                                                        v-model="variationForm.color" required
                                                                        @click.self="addRadioFilter(attribute.name, item.name)"
                                                                        class="h-4 w-4 rounded-ld border-gray-300 text-indigo-600" />

                                                                    <input v-else :id="`filter-${item.id}`"
                                                                        :name="`${item.id}`" :value="item.name"
                                                                        @click.self="addRadioFilter(attribute.name, item.name)"
                                                                        type="radio" v-model="variationForm.material"
                                                                        required
                                                                        :checked="isChecked(attribute.name, item.name)"
                                                                        class="h-4 w-4 rounded-ld border-gray-300 text-indigo-600 focus:ring-indigo-500" />
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
                                    <InputError class="mt-2" v-if="variationError" message="Please select add-ons" />
                                </div>
                            </div>
                            <div class="mt-6">
                                <div class="sm:mt-0">
                                    <div class="-m-1 flex flex-wrap items-center">
                                        <span v-for="(select, key) in checkedFilters" :key="key"
                                            class="m-1 inline-flex items-center rounded-lg border border-gray-200 bg-gray-50 py-1.5 pl-3 pr-2 text-sm font-medium text-gray-900">
                                            <span v-if="select.Size !== undefined">Size: {{ select.Size.join(', ')
                                            }}</span>
                                            <span v-if="select.Color !== undefined">Color: {{
                                                select.Color.join(',') }}</span>
                                            <span v-if="select.Material !== undefined">Material: {{
                                                select.Material.join(',') }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <UploadFile class="mt-6" @image-previews="updateImages" :formSubmitted="submitImage" />

                        </div>

                    </div>
                    <div class="flex justify-end">
                        <PrimaryButton type="submit" class="mt-4">Add variation</PrimaryButton>
                    </div>
                </form>
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
            <div class="pointer-events-none mb-4" v-for="variation in variations" :key="variation">
                <transition enter-active-class="transform ease-out duration-300 transition"
                    enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                    enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                    leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
                    leave-to-class="opacity-0">
                    <div
                        class="pointer-events-auto relative flex flex-row flex-wrap justify-between rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 p-4 items-center">
                        <div class="flex flex-row gap-6 flex-wrap overflow-hidden">
                            <p class="text-sm font-medium text-gray-900">#{{ variation.sku }}</p>
                            <p class="text-sm font-medium text-gray-900">stock: {{ variation.amount }}</p>
                            <p class="text-sm font-medium text-gray-900">€{{ variation.price }}</p>
                            <div class="flex flex-row">
                                <div v-for="(sizes, index) in variation.sizes.slice(0, 2)" :key="index"
                                    class="text-sm font-medium text-gray-900">{{ sizes }},
                                </div>
                                <div v-if="variation.sizes.slice(0, 2).length > 1"
                                    class="text-sm font-medium text-gray-900">...</div>
                            </div>
                            <p class="text-sm font-medium text-gray-900">{{ variation.color }}</p>
                            <p class="text-sm font-medium text-gray-900">{{ variation.material }}</p>
                        </div>
                        <div class="mt-2">
                            <button type="button" @click="removeVariation(variation)"
                                class="absolute top-0 right-0 mt-4 mr-4 rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <XMarkIcon class="h-6 w-6 text-red-500" />
                            </button>
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
                    class="ml-3 inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
            </div>
        </form>
    </div>
</template>