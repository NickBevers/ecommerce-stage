<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps, ref, reactive} from 'vue'
import InputLabel from '@/Components/Admin/Atoms/InputLabel.vue';
import TextInput from '@/Components/Admin/Atoms/TextInput.vue';
import PrimaryButton from '@/Components/Admin/Atoms/PrimaryButton.vue';
import InputError from '@/Components/Admin/Atoms/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Dropdown from '@/Components/Admin/Atoms/Dropdown.vue';
import {
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
} from '@headlessui/vue'
import { ChevronDownIcon } from '@heroicons/vue/20/solid'

const filters = [
    {
        id: 'sizes',
        name: 'Sizes',
        options: [
            { value: 'M', label: 'M', checked: false },
            { value: 'L', label: 'L', checked: false },
            { value: 'XL', label: 'XL', checked: false },
            { value: '2XL', label: '2XL', checked: false },
        ],
    },
]

let checkedFilters = reactive([])


function addCheckedFilter(filter, value) {
  //create an object to store the filter and value
    const filterObject = {
        filter: filter,
        value: value,
    };
    //check if filter already exist in checkedFilters
    const filterExist = checkedFilters.find(
        (checkedFilter) => checkedFilter.filter === filter
    );


}

const form = useForm({
    title: "",
    description: "",

    amount: "",
    sku: "",
    audience: "",
    variations: {

    }
});

const items = [
    { name: 'item1', },
    { name: 'item2', },
    { name: 'item3', }
];


</script>
<template>
    <Head title="Products" />
    <AuthenticatedLayout>
        <div class="mt-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold leading-6 text-gray-900">Add product</h1>
                    </div>
                    <div class="sm:mt-0 sm:ml-16 sm:flex-none">

                    </div>
                </div>
            </div>
            <form class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-5" action="#" method="POST">
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
                                        <TextInput id="title" type="title" class="mt-1 block w-full pl-3" name="title"
                                            v-model="form.title" required autocomplete="title" placeholder="Product " />
                                        <InputError class="mt-2" :message="form.errors.title" />
                                    </div>
                                </div>
                                <div class="col-span-2 sm:col-span-2">
                                    <InputLabel for="title" value="Title" />
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <Dropdown class="w-full" :items="items">
                                        </Dropdown>
                                        <InputError class="mt-2" :message="form.errors.title" />
                                    </div>

                                </div>
                                <div class="col-span-2 sm:col-span-2">
                                    <InputLabel for="title" value="Title" />
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <Dropdown class="w-full" :items="items">
                                        </Dropdown>
                                        <InputError class="mt-2" :message="form.errors.title" />
                                    </div>

                                </div>
                                <div class="col-span-2 sm:col-span-2">
                                    <InputLabel for="title" value="Title" />
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <Dropdown class="w-full" :items="items">
                                        </Dropdown>
                                        <InputError class="mt-2" :message="form.errors.title" />
                                    </div>

                                </div>
                            </div>
                            <div>
                                <InputLabel for="description">Description</InputLabel>
                                <div class="mt-2">
                                    <textarea id="description" name="description" maxlength="400" rows="3"
                                        class="block h-32 w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:py-1.5 sm:text-sm sm:leading-6 resize-none"
                                        placeholder="Brief description for your product." />
                                </div>
                            </div>
                            <div>
                                <InputLabel for="description">Extra Info</InputLabel>
                                <div class="mt-2">
                                    <textarea id="description" name="description" maxlength="400" rows="3"
                                        class="block h-32 w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:py-1.5 sm:text-sm sm:leading-6 resize-none"
                                        placeholder="Brief description for your product." />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white px-4 py-5 shadow  mb-4 sm:rounded-lg sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Variations</h3>
                            <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly so be careful
                                what you share.</p>
                        </div>
                        <div class="mt-5 md:col-span-2 md:mt-0">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <InputLabel for="title" value="Title" />
                                    <div class="mt-2 flex rounded-md shadow-sm">
                                        <TextInput id="title" type="title" class="mt-1 block w-full pl-3" name="title"
                                            v-model="form.title" required autocomplete="title" placeholder="SKU " />
                                        <InputError class="mt-2" :message="form.errors.title" />
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <InputLabel for="title" value="Title" />
                                    <div class="mt-2 flex rounded-md shadow-sm">
                                        <TextInput id="title" type="title" class="mt-1 block w-full pl-3" name="title"
                                            v-model="form.title" required autocomplete="title" placeholder="Stock" />
                                        <InputError class="mt-2" :message="form.errors.title" />
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <InputLabel for="variation" value="Add-ons" />
                                    <div class="flex flex-row gap-6">
                                        <div class="flow-root">
                                            <PopoverGroup class="-mx-4 flex items-center divide-x divide-gray-200">
                                                <Popover v-for="(section, sectionIdx) in filters" :key="section.name"
                                                    class="relative inline-block px-4">
                                                    <PopoverButton
                                                        class="flex rounded-md bg-white px-3 py-1 mt-4  shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                        <span>{{ section.name }}</span>
                                                        <span v-if="sectionIdx === 0"
                                                            class="ml-1.5 mt-0.5 rounded bg-gray-200 py-0.5 px-1.5 text-xs font-semibold tabular-nums text-gray-700">
                                                            {{  section.options.length }}
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
                                                            class="absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white p-4 shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                            <form class="space-y-4">
                                                                <div v-for="(option, optionIdx) in section.options"
                                                                    :key="option.value" class="flex items-center">
                                                                    <input :id="`filter-${section.id}-${optionIdx}`"
                                                                        :name="`${section.id}[]`" :value="option.value"
                                                                        type="checkbox" :checked="option.checked"
                                                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" 
                                                                        @click="addCheckedFilter(section.id, option.value)"
                                                                        />
                                                                    <label :for="`filter-${section.id}-${optionIdx}`"
                                                                        class="ml-3 whitespace-nowrap pr-6 text-sm font-medium text-gray-900">{{
                                                                            option.label }}</label>
                                                                </div>
                                                            </form>
                                                        </PopoverPanel>
                                                    </transition>
                                                </Popover>
                                            </PopoverGroup>
                                        </div>
                                        <div class="flow-root">
                                            <PopoverGroup class="-mx-4 flex items-center divide-x divide-gray-200">
                                                <Popover v-for="(section, sectionIdx) in filters" :key="section.name"
                                                    class="relative inline-block px-4">
                                                    <PopoverButton
                                                        class="flex rounded-md bg-white px-3 py-1 mt-4  shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                        <span>{{ section.name }}</span>
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
                                                            class="absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white p-4 shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                            <form class="space-y-4">
                                                                <div v-for="(option, optionIdx) in section.options"
                                                                    :key="option.value" class="flex items-center">
                                                                    <input :id="`filter-${section.id}-${optionIdx}`"
                                                                        :name="`${section.id}[]`" :value="option.value"
                                                                        type="radio" :checked="option.checked"
                                                                        class="h-4 w-4 rounded-ld border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                                    <label :for="`filter-${section.id}-${optionIdx}`"
                                                                        class="ml-3 whitespace-nowrap pr-6 text-sm font-medium text-gray-900">{{
                                                                            option.label }}</label>
                                                                </div>
                                                            </form>
                                                        </PopoverPanel>
                                                    </transition>
                                                </Popover>
                                            </PopoverGroup>
                                        </div>
                                        <div class="flow-root">
                                            <PopoverGroup class="-mx-4 flex items-center divide-x divide-gray-200">
                                                <Popover v-for="(section, sectionIdx) in filters" :key="section.name"
                                                    class="relative inline-block px-4">
                                                    <PopoverButton
                                                        class="flex rounded-md bg-white px-3 py-1 mt-4  shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                        <span>{{ section.name }}</span>
                                                        <span v-if="sectionIdx === 0"
                                                            class="ml-1.5 mt-0.5 rounded bg-gray-200 py-0.5 px-1.5 text-xs font-semibold tabular-nums text-gray-700">1</span>
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
                                                            class="absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white p-4 shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                            <form class="space-y-4">
                                                                <div v-for="(option, optionIdx) in section.options"
                                                                    :key="option.value" class="flex items-center">
                                                                    <input :id="`filter-${section.id}-${optionIdx}`"
                                                                        :name="`${section.id}[]`" :value="option.value"
                                                                        type="checkbox" :checked="option.checked"
                                                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                                    <label :for="`filter-${section.id}-${optionIdx}`"
                                                                        class="ml-3 whitespace-nowrap pr-6 text-sm font-medium text-gray-900">{{
                                                                            option.label }}</label>
                                                                </div>
                                                            </form>
                                                        </PopoverPanel>
                                                    </transition>
                                                </Popover>
                                            </PopoverGroup>
                                        </div>
                                   
                                        <p>Checked Filters: {{ checkedFilters }}</p>

                                    </div>
                                </div>


                            </div>
                            <div class="mt-6">
                                <label class="block text-sm font-medium leading-6 text-gray-900">Cover photo</label>
                                <div
                                    class="mt-2 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file-upload"
                                            class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="file-upload" name="file-upload" type="file" class="sr-only" />
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <PrimaryButton class="mt-4" type="submit">Add variation</PrimaryButton>
                </div>

            </div>

            <div class="flex justify-end px-4 sm:px-0">
                <button type="button"
                    class="rounded-md bg-white py-2 px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancel</button>
                <button type="submit"
                    class="ml-3 inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
            </div>

        </form>
    </div>

</AuthenticatedLayout></template>