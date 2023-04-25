  
<script setup>
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import Vue3StarRatings from 'vue3-star-ratings';
import { HomeIcon, TruckIcon } from '@heroicons/vue/24/outline'
import { Link, useForm, router } from '@inertiajs/vue3';
import { propsToAttrMap } from '@vue/shared';


const open = ref(true)
const emit = defineEmits(['closed', 'submitted'])

const props = defineProps({
    sku: String,
    order: Object
})


const form = useForm({
    order_id: props.order.id,
    sku_id: props.sku.id,
    amount: 1,
    reason: '',
})

function closed() {
    emit('closed')
}

function submit() {
    fetch('/returns', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(form)
    })
        .then(response => console.log(response))
        .then(data => {
            closed()
            emit('submitted', data)
        })
        .catch(error => {
            console.error('Error:', error);
        })
}

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
                                        <TruckIcon class="h-6 w-6 text-indigo-600" aria-hidden="true" />
                                    </div>
                                    <h2 class="mt-4 text-lg font-medium text-gray-900">Return Item: {{
                                        props.sku.product.title }}</h2>
                                    <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                        <div class="sm:col-span-1" v-if="props.sku.pivot.amount > 1">
                                            <label for="review"
                                                class="block text-sm font-medium text-gray-700">Amount</label>
                                            <div class="mt-1">
                                                <input :id="`quantity-${props.sku.product.id}`"
                                                    :name="`quantity-${props.sku.product.id}`" type="number" min="1"
                                                    :max="props.sku.pivot.amount" placeholder="0" required
                                                    class="rounded-md border border-gray-300 w-[40%] text-left text-base font-medium text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                                                    v-model="form.amount" />
                                            </div>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label for="review"
                                                class="block text-sm font-medium text-gray-700">Reason</label>
                                            <div class="mt-1">
                                                <textarea type="text" name="review" id="review" v-model="form.reason"
                                                    maxlength="350" required
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm resize-none"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 sm:mt-6">
                                    <button type="submit"
                                        class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Send
                                    </button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>