<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue'
import { Alert } from '@/Components/Customer'
import { useCartStore } from '@/Stores/cart';
import {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
} from '@headlessui/vue'

const emits = defineEmits(['closed', 'checked'])

const props = defineProps({
    product: {
        type: Object,
        required: true,
        default: null,
    },
})

const cartStore = useCartStore();

let showError = ref(false)
const error = {
    title: "There were errors with your submission",
    errors: [{
        message: "Select attributes"
    }]
}
const selectedColor = ref("")
const selectedSize = ref("")
const amount = ref(1)

function submit() {
    if (props.product.sku.attribute_values.length === 0) {
        fetch('/cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                sku_id: props.product.sku.id,
                amount: amount.value,
            })
        })
            .then(response => {
                if (response.status == 200) {
                    cartStore.increment();
                    emits('checked')
                    emits('closed')
                }
            })
            .catch(error => {
                console.log(error);
            });
    }
    else if (selectedColor.value === "" || selectedSize.value === "") {
        showError.value = true
        console.log("error")
    }
    else {
        fetch('/cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                sku_id: props.product.sku.id,
                amount: amount.value,
            })
        })
            .then(response => {
                if (response.status == 200) {
                    console.log("success")
                    emits('checked')
                    emits('closed')
                }
            })
            .catch(error => {
                console.log(error);
            });
    }
}

</script>
<template>
    <section class="mt-8">
        <h3 class="sr-only">Product options</h3>

        <form>
            <!-- Color picker -->
            <div v-if="props.product.sku.attribute_values.length > 0">
                <h4 class="text-sm font-medium text-gray-900">Color</h4>

                <RadioGroup v-model="selectedColor" class="mt-2">
                    <RadioGroupLabel class="sr-only"> Choose a color </RadioGroupLabel>
                    <div class="flex items-center space-x-3">
                        <RadioGroupOption as="template" v-for="color in props.product.sku.attribute_values"
                            :key="color.name" :value="color" v-slot="{ active, checked }">
                            <div class="-ml-4"
                                :class="[active && checked ? 'ring ring-offset-1' : '', !active && checked ? 'ring-2' : '', 'relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 focus:outline-none']">
                                <RadioGroupLabel as="span" class="sr-only"> {{ color.name }} </RadioGroupLabel>
                                <span aria-hidden="true"
                                    :class="['h-8 w-8 rounded-full border border-black border-opacity-10', color.attribute_type_id !== 2 ? 'hidden' : '']"
                                    :style="{ backgroundColor: color.color_value }" />
                            </div>
                        </RadioGroupOption>
                    </div>
                </RadioGroup>
            </div>

            <!-- Size picker -->
            <div class="mt-8" v-if="props.product.sku.attribute_values.length > 1">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-medium text-gray-900">Size</h4>
                </div>

                <RadioGroup v-model="selectedSize" class="mt-2">
                    <RadioGroupLabel class="sr-only"> Choose a size </RadioGroupLabel>
                    <div class="grid grid-cols-7 gap-2">
                        <RadioGroupOption as="template" v-for="size in props.product.sku.attribute_values" :key="size.name"
                            :value="size" v-slot="{ active, checked }">
                            <div
                                :class="[active ? 'ring-2 ring-indigo-500 ring-offset-2' : '', checked ? 'border-transparent bg-indigo-600 text-white hover:bg-indigo-700' : 'border-gray-200 bg-white text-gray-900 hover:bg-gray-50', 'flex items-center justify-center rounded-md border py-3 px-3 text-sm font-medium uppercase sm:flex-1', size.attribute_type_id !== 1 ? 'hidden' : '']">
                                <RadioGroupLabel as="span">
                                    {{ size.name }}
                                </RadioGroupLabel>
                            </div>
                        </RadioGroupOption>
                    </div>
                </RadioGroup>
            </div>
            <Alert class="mt-4" :error="error" v-if="showError" />
            <div class="flex flex-row gap-4 mt-8">
                <button @click.prevent="submit"
                    class="w-[90%] flex items-center justify-center rounded-md border border-transparent bg-indigo-600 py-3 px-8 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Add
                    to bag</button>
                <input :id="`quantity-${props.product.sku.id}`" :name="`quantity-${props.product.sku.id}`" type="number"
                    min="1" :max="product.sku.amount"
                    class="rounded-md border border-gray-300 text-left text-base font-medium text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                    v-model="amount" />
            </div>
            <p class="absolute top-4 left-4 text-center sm:static sm:mt-8">
                <Link :to="'/product/' + props.product.sku.sku" :href="'/product/' + props.product.sku.sku">
                <a class="font-medium text-indigo-600 hover:text-indigo-500">View full details</a>
                </Link>
            </p>
        </form>
    </section>
</template>