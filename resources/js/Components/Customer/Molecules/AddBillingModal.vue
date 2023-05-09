  
<script setup>
import { ref, reactive, onMounted, onBeforeMount } from 'vue'
import {
    Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot, RadioGroup,
    RadioGroupDescription,
    RadioGroupLabel,
    RadioGroupOption,
} from '@headlessui/vue'
import { HomeIcon } from '@heroicons/vue/24/outline'
import { CheckCircleIcon } from '@heroicons/vue/24/solid'
import { Link, useForm, router } from '@inertiajs/vue3';

const open = ref(true)

const emit = defineEmits(['closed', 'submitted'])
const props = defineProps({
    addresses: {
        type: Array,
        required: true,
    }
})

function closed() {
    emit('closed')
}

function submit(submitAdress) {
    emit('closed')
    emit('submitted', submitAdress)
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

                            <div>
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100">
                                    <HomeIcon class="h-6 w-6 text-indigo-600" aria-hidden="true" />
                                </div>
                                <RadioGroup class="mt-4">
                                    <RadioGroupLabel class="text-lg font-medium text-gray-900">Choose billing
                                        address
                                    </RadioGroupLabel>
                                    <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                        <RadioGroupOption as="template" v-for="deliveryMethod in props.addresses"
                                            @click.prevent="submit(deliveryMethod)" :key="deliveryMethod.id"
                                            :value="deliveryMethod.id.toString()" v-if="props.addresses.length > 0"
                                            v-slot="{ checked, active }">
                                            <div
                                                :class="[checked ? 'border-transparent' : 'border-gray-300', 'relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none']">
                                                <span class="flex flex-1">
                                                    <span class="flex flex-col">
                                                        <RadioGroupLabel as="span"
                                                            class="block text-sm font-medium text-gray-900">{{
                                                                deliveryMethod.address_line1 }},
                                                            {{ deliveryMethod.address_line2 }}</RadioGroupLabel>
                                                        <RadioGroupDescription as="span"
                                                            class="mt-1 flex items-center text-sm text-gray-500">
                                                        </RadioGroupDescription>
                                                        <RadioGroupDescription as="span"
                                                            class="mt-1 flex items-center text-sm text-gray-500">{{
                                                                deliveryMethod.city }}, {{ deliveryMethod.postal_code }}
                                                        </RadioGroupDescription>
                                                        <RadioGroupDescription as="span"
                                                            class="mt-1 flex items-center text-sm text-gray-500">{{
                                                                deliveryMethod.country }}</RadioGroupDescription>
                                                    </span>
                                                </span>
                                                <CheckCircleIcon v-if="checked" class="h-5 w-5 text-indigo-600"
                                                    aria-hidden="true" />
                                                <span
                                                    :class="[active ? 'border' : 'border-2', checked ? 'border-indigo-500' : 'border-transparent', 'pointer-events-none absolute -inset-px rounded-lg']"
                                                    aria-hidden="true" />
                                            </div>
                                        </RadioGroupOption>

                                    </div>
                                </RadioGroup>
                            </div>

                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>