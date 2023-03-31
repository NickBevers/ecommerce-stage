<script setup>
import { ref, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3';
import { Alert } from '@/Components/Customer'
import {
  Dialog,
  DialogPanel,
  RadioGroup,
  RadioGroupLabel,
  RadioGroupOption,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { StarIcon } from '@heroicons/vue/20/solid'

const open = ref(true)
const selectedColor = ref("")
const selectedSize = ref("")
const amount = ref(1)

const emits = defineEmits(['closed', 'checked'])

const props = defineProps({
  product: {
    type: Object,
    required: true,
    default: null,
  },
})



const error = {
  title: "There were errors with your submission",
  errors: [{
    message: "Select attributes"
  }]
}
console.log(props.product)
let showError = ref(false)

function toggleOpen() {
  open.value = !open.value
  emits('closed')
}

function submit() {
  if(props.product.sku.attribute_values.length===0){
    fetch('/cart', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        sku_id: props.product.sku.id,
        amount: amount,
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
  else if(selectedColor.value==="" || selectedSize.value===""){
    showError.value = true
    console.log("error")
  }
  else{
    fetch('/cart', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        sku_id: props.product.sku.id,
        amount: amount,
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
  <TransitionRoot as="template" :show="open" v-if="props.product">
    <Dialog as="div" class="relative z-20" @close="toggleOpen">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
        leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 hidden bg-gray-500 bg-opacity-75 transition-opacity md:block" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-stretch justify-center text-center md:items-center md:px-2 lg:px-4">
          <!-- This element is to trick the browser into centering the modal contents. -->
          <span class="hidden md:inline-block md:h-screen md:align-middle" aria-hidden="true">&#8203;</span>
          <TransitionChild as="template" enter="ease-out duration-300"
            enter-from="opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
            enter-to="opacity-100 translate-y-0 md:scale-100" leave="ease-in duration-200"
            leave-from="opacity-100 translate-y-0 md:scale-100"
            leave-to="opacity-0 translate-y-4 md:translate-y-0 md:scale-95">

            <DialogPanel
              class="flex w-full transform text-left text-base transition md:my-8 md:max-w-2xl md:px-4 lg:max-w-4xl">
              <div
                class="relative flex w-full items-center overflow-hidden bg-white px-4 pt-14 pb-8 shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                <button type="button"
                  class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 sm:top-8 sm:right-6 md:top-6 md:right-6 lg:top-8 lg:right-8"
                  @click="toggleOpen">
                  <span class="sr-only">Close</span>
                  <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                </button>
                <div
                  class="grid w-full grid-cols-1 items-start gap-y-8 gap-x-6 sm:grid-cols-12 lg:items-center lg:gap-x-8">
                  <div class="aspect-w-2 aspect-h-3 overflow-hidden rounded-lg bg-gray-100 sm:col-span-4 lg:col-span-5">
                    <img :src="props.product.sku.product_images[0].image_link" alt="Product image"
                      class="object-cover object-center" />
                  </div>
                  <div class="sm:col-span-8 lg:col-span-7">

                    <h2 class="text-xl font-medium text-gray-900 sm:pr-12">{{ props.product.sku.product.title }}</h2>

                    <section aria-labelledby="information-heading" class="mt-1">
                      <h3 id="information-heading" class="sr-only">Product information</h3>

                      <p class="font-medium text-gray-900">€{{ props.product.sku.price.toFixed(2) }}</p>
                    </section>

                    <section aria-labelledby="options-heading" class="mt-8">
                      <h3 id="options-heading" class="sr-only">Product options</h3>

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
                              <RadioGroupOption as="template" v-for="size in props.product.sku.attribute_values"
                                :key="size.name" :value="size" v-slot="{ active, checked }">
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
                          <input :id="`quantity-${props.product.sku.id}`" :name="`quantity-${props.product.sku.id}`"
                            type="number" min="1"
                            :max="product.sku.amount"
                            class="rounded-md border border-gray-300 text-left text-base font-medium text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                            v-model="amount"/>
                       </div>
                        <p class="absolute top-4 left-4 text-center sm:static sm:mt-8">
                          <Link :to="'/product/' + props.product.sku.sku" :href="'/product/' + props.product.sku.sku">
                          <a class="font-medium text-indigo-600 hover:text-indigo-500">View full details</a>
                          </Link>
                        </p>
                      </form>
                    </section>
                  </div>
                </div>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>