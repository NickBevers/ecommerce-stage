  
<script setup>
import { ref, reactive, onMounted } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { HomeIcon } from '@heroicons/vue/24/outline'
import { Link, useForm, router } from '@inertiajs/vue3';

const open = ref(true)
const emit = defineEmits(['closed', 'submitted'])
let addresses = reactive([])

function closed() {
    emit('closed')
}

function submit() {
    fetch('/addresses', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(form)
    })
        .then(response => response.json())
        .then(data => {
            closed()
            emit('submitted', data)
        })
        .catch(error => {
            console.error('Error:', error);
        })
}

onMounted(() => {
    console.log('mounted')
})

</script>

<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false; closed()">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                            <form @submit.prevent="submit">
                                <div>
                                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100">
                                        <HomeIcon class="h-6 w-6 text-indigo-600" aria-hidden="true" />
                                    </div>
                                    <h2 class="mt-4 text-lg font-medium text-gray-900">Add a new address</h2>
                                    <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                        <div class="sm:col-span-2">
                                            <label for="company" class="block text-sm font-medium text-gray-700">Company
                                                VAT</label>
                                            <div class="mt-1">
                                                <input type="text" name="company" id="company"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                            </div>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="address"
                                                class="block text-sm font-medium text-gray-700">Address*</label>
                                            <div class="mt-1">
                                                <input type="text" name="address" id="address" autocomplete="street-address"
                                                    required
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                            </div>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="apartment" class="block text-sm font-medium text-gray-700">Number,
                                                apartment,
                                                suite,
                                                etc.*</label>
                                            <div class="mt-1">
                                                <input type="text" name="apartment" id="apartment" required
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                            </div>
                                        </div>

                                        <div>
                                            <label for="city" class="block text-sm font-medium text-gray-700">City*</label>
                                            <div class="mt-1">
                                                <input type="text" name="city" id="city" autocomplete="address-level2"
                                                    required
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                            </div>
                                        </div>

                                        <div>
                                            <label for="country"
                                                class="block text-sm font-medium text-gray-700">Country*</label>
                                            <div class="mt-1">
                                                <select id="country" name="country" autocomplete="country-name" required
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                    <option v-for="country in countries" :value="country.code">{{
                                                        country.name }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div>
                                            <label for="region" class="block text-sm font-medium text-gray-700">State /
                                                Province</label>
                                            <div class="mt-1">
                                                <input type="text" name="region" id="region" autocomplete="address-level1"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                            </div>
                                        </div>

                                        <div>
                                            <label for="postal-code" class="block text-sm font-medium text-gray-700">Postal
                                                code*</label>
                                            <div class="mt-1">
                                                <input type="number" name="postal-code" id="postal-code"
                                                    autocomplete="postal-code" required
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 sm:mt-6">
                                    <button type="submit"
                                        class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>