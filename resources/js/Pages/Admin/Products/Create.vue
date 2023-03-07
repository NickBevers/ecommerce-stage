<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps } from 'vue'
import InputLabel from '@/Components/Admin/Atoms/InputLabel.vue';
import TextInput from '@/Components/Admin/Atoms/TextInput.vue';
import InputError from '@/Components/Admin/Atoms/InputError.vue';
import { Head, Link, useForm} from '@inertiajs/vue3';
import Dropdown from '@/Components/Admin/Atoms/Dropdown.vue';

const form = useForm({
    title: "",
    description: "",
    price: "",
    stock: "",
    sku: "",
    audience: "",
    variations: {
        
    }
});

//create an item array object with 3 names in
const items = [
  { name: 'item1',},
    { name: 'item2',},
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
          <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly so be careful what you share.</p>
        </div>
        <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
          <div class="grid grid-cols-4 gap-6">
            <div class="col-span-2 sm:col-span-2">
            <InputLabel for="title" value="Title" />
              <div class="mt-2 flex rounded-md shadow-sm">
                <TextInput
                id="title"
                type="title"
                class="mt-1 block w-full pl-3"
                name="title"
                v-model="form.title"
                required
                autocomplete="title"
                placeholder="Product "
              />
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
              <textarea id="description" name="description" maxlength="400" rows="3" class="block h-32 w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:py-1.5 sm:text-sm sm:leading-6 resize-none" placeholder="Brief description for your product." />
            </div>
          </div>  
          </div>
        </div>
      </div>

    <div class="bg-white px-4 py-5 shadow  mb-4 sm:rounded-lg sm:p-6">
      <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
          <h3 class="text-base font-semibold leading-6 text-gray-900">Personal Information</h3>
          <p class="mt-1 text-sm text-gray-500">Use a permanent address where you can receive mail.</p>
        </div>
        <div class="mt-5 md:col-span-2 md:mt-0">
          <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">
              <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">First name</label>
              <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>

            <div class="col-span-6 sm:col-span-3">
              <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">Last name</label>
              <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>

            <div class="col-span-6 sm:col-span-4">
              <label for="email-address" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
              <input type="text" name="email-address" id="email-address" autocomplete="email" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>

            <div class="col-span-6 sm:col-span-3">
              <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Country</label>
              <select id="country" name="country" autocomplete="country-name" class="mt-2 block w-full rounded-md border-0 bg-white py-1.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option>United States</option>
                <option>Canada</option>
                <option>Mexico</option>
              </select>
            </div>

            <div class="col-span-6">
              <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">Street address</label>
              <input type="text" name="street-address" id="street-address" autocomplete="street-address" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>

            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
              <label for="city" class="block text-sm font-medium leading-6 text-gray-900">City</label>
              <input type="text" name="city" id="city" autocomplete="address-level2" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>

            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
              <label for="region" class="block text-sm font-medium leading-6 text-gray-900">State / Province</label>
              <input type="text" name="region" id="region" autocomplete="address-level1" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>

            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
              <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">ZIP / Postal code</label>
              <input type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="bg-white px-4 py-5 shadow sm:rounded-lg  mb-4 sm:p-6">
      <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
          <h3 class="text-base font-semibold leading-6 text-gray-900">Notifications</h3>
          <p class="mt-1 text-sm text-gray-500">Decide which communications you'd like to receive and how.</p>
        </div>
        <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
          <fieldset>
            <legend class="sr-only">By Email</legend>
            <div class="text-sm font-semibold leading-6 text-gray-900" aria-hidden="true">By Email</div>
            <div class="mt-4 space-y-4">
              <div class="flex items-start">
                <div class="flex h-6 items-center">
                  <input id="comments" name="comments" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                </div>
                <div class="ml-3">
                  <label for="comments" class="text-sm font-medium leading-6 text-gray-900">Comments</label>
                  <p class="text-sm text-gray-500">Get notified when someones posts a comment on a posting.</p>
                </div>
              </div>
              <div class="flex items-start">
                <div class="flex h-6 items-center">
                  <input id="candidates" name="candidates" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                </div>
                <div class="ml-3">
                  <label for="candidates" class="text-sm font-medium leading-6 text-gray-900">Candidates</label>
                  <p class="text-sm text-gray-500">Get notified when a candidate applies for a job.</p>
                </div>
              </div>
              <div class="flex items-start">
                <div class="flex h-6 items-center">
                  <input id="offers" name="offers" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                </div>
                <div class="ml-3">
                  <label for="offers" class="text-sm font-medium leading-6 text-gray-900">Offers</label>
                  <p class="text-sm text-gray-500">Get notified when a candidate accepts or rejects an offer.</p>
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend class="contents text-sm font-semibold leading-6 text-gray-900">Push Notifications</legend>
            <p class="text-sm leading-6 text-gray-500">These are delivered via SMS to your mobile phone.</p>
            <div class="mt-4 space-y-4">
              <div class="flex items-center">
                <input id="push-everything" name="push-notifications" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                <label for="push-everything" class="ml-3 block text-sm font-medium leading-6 text-gray-900">Everything</label>
              </div>
              <div class="flex items-center">
                <input id="push-email" name="push-notifications" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                <label for="push-email" class="ml-3 block text-sm font-medium leading-6 text-gray-900">Same as email</label>
              </div>
              <div class="flex items-center">
                <input id="push-nothing" name="push-notifications" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                <label for="push-nothing" class="ml-3 block text-sm font-medium leading-6 text-gray-900">No push notifications</label>
              </div>
            </div>
          </fieldset>
          
          <div>
            <label class="block text-sm font-medium leading-6 text-gray-900">Cover photo</label>
            <div class="mt-2 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
              <div class="space-y-1 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                  <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="flex text-sm text-gray-600">
                  <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
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
    </div>

    <div class="flex justify-end px-4 sm:px-0">
      <button type="button" class="rounded-md bg-white py-2 px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancel</button>
      <button type="submit" class="ml-3 inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
    </div>
    
  </form>
        </div>
        
    </AuthenticatedLayout>
</template>