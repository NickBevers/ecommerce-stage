<script setup>
import { ref, onMounted } from 'vue'
import { AddProductCart } from '@/Components/Customer'
import {
  Dialog,
  DialogPanel,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'

const open = ref(true)

const emits = defineEmits(['closed'])

const props = defineProps({
  product: {
    type: Object,
    required: true,
    default: null,
  },
})

function toggleOpen() {
  open.value = !open.value
  emits('closed')
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

                      <p class="font-medium text-gray-900">€{{ props.product.sku.price_incl_vat.toFixed(2) }}</p>
                    </section>

                    <AddProductCart :product="props.product" @closed="toggleOpen" />
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