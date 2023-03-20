<template>
    <div class="mt-8">
        {{ form }}
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
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <TextInput id="sku" type="text" class="mt-1 block w-full pl-3" name="SKU"
                                    
                                        v-model="form.variations[0].sku" required autocomplete="SKU" placeholder="SKU" />
                                    <InputError class="mt-2" :message="form.variations.error" />
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-2">
                                <InputLabel for="price" value="Price" />
                                <div class="mt-2 flex rounded-md shadow-sm">
                                    <TextInput id="price" type="number" class="mt-1 block w-full pl-3" name="price"
                                        pattern="^\d*(\.\d{0,2})?$" step="0.01" v-model="form.variations[0].price" required
                                        autocomplete="title" placeholder="19.99" />
                                    <InputError class="mt-2" :message="form.variations.error" />
                                </div>
                            </div>
                            <div class="col-span-2 sm:col-span-2">
                                <InputLabel for="stock" value="Stock" />
                                <div class="mt-2 flex rounded-md shadow-sm">
                                    <TextInput id="stock" type="number" class="mt-1 block w-full pl-3" name="amount"
                                        pattern="^\d*(\.\d{0,2})?$" step="0.01" v-model="form.variations[0].amount" required
                                        autocomplete="title" placeholder="100" />
                                    <InputError class="mt-2" :message="form.variations.error" />
                                </div>
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <InputLabel for="attributes" value="Attributes" />
                            <div class="flex flex-row gap-6 flex-wrap">
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <Dropdown :items="props.attributeTypes[0].attributeValues"
                                        class="min-w-[150px]"
                                         v-model="formSize"
                                         @click="updateVariation('sizes')"
                                         place="Select Size"
                                         />
                                    </div>

                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <Dropdown :items="props.attributeTypes[1].attributeValues"
                                           v-model="formColor"
                                           class="min-w-[150px]"
                               
                                           place="Select Color"/>
                                    </div>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <Dropdown :items="props.attributeTypes[2].attributeValues"
                                            v-model="formMaterial"
                                            class="min-w-[180px]"
                                            place="Select Material"/>
                                    </div>
                              
                            </div>
                            <InputError class="mt-2" v-if="variationError" message="Please select add-ons" />
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

                        <div class="mt-5 md:col-span-2 md:mt-0">
                            <InputError class="mt-2" v-if="formVariationError"
                                message="Please create at least one variation" />
                            <UploadFile class="mt-6" />

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
        </form>
    </div>
</template>
<script setup>
import { defineProps, ref, reactive, watch, onMounted, onBeforeMount } from 'vue'
import InputLabel from '@/Components/Admin/Atoms/InputLabel.vue';
import TextInput from '@/Components/Admin/Atoms/TextInput.vue';
import PrimaryButton from '@/Components/Admin/Atoms/PrimaryButton.vue';
import SecondaryButton from '@/Components/Admin/Atoms/SecondaryButton.vue';
import UploadFile from '@/Components/Admin/Molecules/UploadFile.vue';
import InputError from '@/Components/Admin/Atoms/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Dropdown from '@/Components/Admin/Atoms/Dropdown.vue';
import SearchDropdown from 'search-dropdown-vue';
import {
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
} from '@headlessui/vue'
import { ChevronDownIcon, XMarkIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    brands: Array,
    categories: Array,
    attributeTypes: Array,
});

let object = reactive({ id: null, name: null })



let checkedFilters = reactive([])

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

function updateVariation(filter) {
    if(filter === 'sizes') {
        console.log('sizes')
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
    variations: [
        { 
        sku: "",
        amount: 0,
        price: 0,
        color: "",
        sizes: [],
        material: "",
        images: [],
    }
    ]
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

let formSize = ref("");
let formColor = ref("");
let formMaterial = ref("");


let variationError = ref(false);

let formVariationError = ref(false);

function updateSubCategories() {
    selectedHeadCategory.value = selectedHeadCategoryIndex.value.id - 1
}

function onSelectedOption(option) {
    form.brand_id = option.id
}

function addVariation() {
    if (!variationForm.color || !variationForm.sizes || !variationForm.material) {
        variationError.value = true
        return
    }
    variationError.value = false
    formVariationError.value = false
    const newVariation = {
        sku: variationForm.sku,
        amount: variationForm.amount,
        price: variationForm.price,
        color: variationForm.color,
        sizes: variationForm.sizes,
        material: variationForm.material,
    };


    variationForm.reset();

    checkedFilters = reactive([])

}

function removeVariation(index) {

}

watch(() => {
    if (selectedSubCategory.value) {
        form.sub_category_id = selectedSubCategory.value.id
    }

    if (formSize.value) {
       form.variations[0].sizes = [formSize.value.name]
    }

    if (formColor.value) {
        form.variations[0].color = formColor.value.name
    }

    if (formMaterial.value) {
        form.variations[0].material = formMaterial.value.name
    }
})

function submit() {

    form.post(route('admin.products.store'))
}
</script>