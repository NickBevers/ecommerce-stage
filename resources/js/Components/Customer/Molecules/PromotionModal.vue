<script setup>
import {Dialog, DialogPanel, TransitionChild, TransitionRoot} from "@headlessui/vue";
import { TagIcon } from "@heroicons/vue/24/outline";
import {onMounted, ref, watch} from "vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    skus: {
        type: Object,
        required: true
    },
    sku_id: {
        type: Number,
        required: true
    }
})


const open = ref(true)
const emit = defineEmits(['closed', 'submitted']);
const form = useForm({
    start_date: '',
    end_date: '',
    sku_id: props.sku_id,
    new_price: 0,
    extra_info: '',
    apply_to_all: false,
})

onMounted(() => {
    console.log('PromotionModal', props.skus)
})

const submit = () => {
    let routeToCall = ''
    if (!form.apply_to_all) {
        routeToCall = route('promos.store')
    } else {
        routeToCall = route('promos.storeAllVariations')
    }

    fetch(routeToCall, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(form)
    }).then(response => {
        console.log(response)
        if (response.ok) {
            open.value = false
        }
    }).catch(error => {
        console.log(error)
    });
}

const handlePriceChange = (e) => {
    if (e.target.value > props.skus.price_excl_vat) {
        e.target.value = props.skus.price_excl_vat
    } else if (e.target.value < 0) {
        e.target.value = 0.1
    }
}

function closed() {
    emit('closed')
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
                                    <div class="flex w-full">
                                        <div class="flex h-12 w-14 items-center justify-center rounded-full bg-indigo-100 mr-4">
                                            <TagIcon class="h-6 w-6 text-indigo-600" aria-hidden="true" />
                                        </div>
                                        <div class="w-full flex justify-between items-center">
                                            <strong class="mr-4">{{ props.skus.product.title }}</strong>
                                            <span>€{{ props.skus.price_excl_vat.toFixed(2) }}</span>
                                        </div>
                                    </div>
                                    <h2 class="mt-4 text-lg font-medium text-gray-900">Start a new promotion</h2>
                                    <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                        <div class="sm:col-span-2">
                                            <label for="startDate" class="block text-sm font-medium text-gray-700">Start date*</label>
                                            <div class="mt-1">
                                                <input type="date" name="startDate" id="startDate"
                                                       v-model="form.start_date"
                                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                            </div>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="end_date"
                                                   class="block text-sm font-medium text-gray-700">End date</label>
                                            <div class="mt-1">
                                                <input type="date" name="endDate" id="end_date"
                                                       v-model="form.end_date"
                                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                            </div>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="new_price" class="block text-sm font-medium text-gray-700">Promo price (excl vat)</label>
                                            <div class="mt-1">
                                                <input type="number" name="newPrice" id="new_price" step="0.01"
                                                       @change="handlePriceChange" @keyup="handlePriceChange"
                                                       @blur="(e) => e.target.value = parseFloat(e.target.value).toFixed(2)"
                                                       v-model="form.new_price" required
                                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                            </div>
                                        </div>

                                        <div class="w-full sm:col-span-2">
                                            <label for="extra_info" class="block text-sm font-medium text-gray-700">Extra info</label>
                                            <div class="mt-1">
                                                <textarea type="text" name="extraInfo" id="extra_info"
                                                       v-model="form.extra_info" required style="resize: none"
                                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm w-full h-20" />
                                            </div>
                                        </div>

                                        <div class="w-full sm:col-span-2">
                                            <input type="checkbox" name="applyToAll" id="apply_to_all" class="mr-2" v-model="form.apply_to_all">
                                            <label for="apply_to_all">Apply to all sku's</label>
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

<style scoped>
</style>