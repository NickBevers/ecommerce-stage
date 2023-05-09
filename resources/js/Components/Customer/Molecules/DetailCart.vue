<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue'
import { Alert } from '@/Components/Customer'
import { useCartStore } from '@/Stores/cart';
import { useProductStore } from '@/Stores/product.js';
import {
  RadioGroup,
  RadioGroupLabel,
  RadioGroupOption,
} from '@headlessui/vue'

const checkout = ref(false)
const emit = defineEmits(['checkout'])
const props = defineProps({
  product: {
    type: Object,
    required: true,
    default: null,
  },
  sizeVariations: {
    type: Object,
    required: true,
    default: null,
  },
})

const user = computed(() => {
  return usePage().props.auth.user
})

const cartStore = useCartStore()
const productStore = useProductStore()

let selectedProduct = ref('')

let showError = ref(false)
const error = {
  title: "There were errors with your submission",
  errors: [{
    message: "Select a size"
  }]
}
const selectedSize = ref("")
const amount = ref(1)

function submit() {
  if (props.product.attribute_values.length === 0 || props.sizeVariations[0].size === null) {
    cartStore.setOpen(true)
    productStore.fetchProducts()
    fetch('/cart', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        sku_id: props.product.id,
        amount: amount.value,
      })
    })
      .then(response => {
        if (response.status === 200) {
          checkout.value = true
          emit('checkout')
          let cart = cartStore.getCount
          cart = parseInt(cart)
          cartStore.setCount(cart + amount.value)

        }
      })
      .catch(error => {
        console.log(error);
      });
  }
  else if (props.product.attribute_values && selectedSize.value === "") {
    showError.value = true
  }
  else {
    showError.value = false
    // productStore.fetchProducts()
    // cartStore.setOpen(true)

    // fetch the products in the user's cart (with the newly added one) and set the cart count



    fetch('/cart', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        sku_id: selectedProduct.value,
        amount: amount.value,
      })
    })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          checkout.value = true
          emit('checkout')
          let cart = cartStore.getCount
          cart = parseInt(cart)
          cartStore.setCount(cart + amount.value)
          cartStore.setOpen(true)
          productStore.setProducts(data.products)
        }
      })
      .catch(error => {
        console.log(error);
      });
  }
}

function changeProduct(sku) {
  selectedProduct.value = sku.id
}
</script>
<template>
  <section>
    <h3 class="sr-only">Product options</h3>
    <div v-if="props.product.attribute_values.length > 0">
      <template v-for="attributeValue in props.product.attribute_values">
        <h4 v-if="attributeValue.attribute_type_id === 2" class="text-md font-medium text-gray-900">Color: {{
          attributeValue.name }}</h4>
        <h4 v-if="attributeValue.attribute_type_id === 3" class="text-md font-medium text-gray-900">Material: {{
          attributeValue.name }}</h4>
      </template>
    </div>
    <form>
      <div class="mt-8" v-if="Object.keys(props.sizeVariations).length >= 1">
        <div class="flex items-center justify-between" v-if="props.sizeVariations[0].size != null">
          <h4 class="text-sm font-medium text-gray-900">Size</h4>
        </div>
        <RadioGroup v-model="selectedSize" class="mt-2" v-if="props.sizeVariations[0].size != null">
          <RadioGroupLabel class="sr-only"> Choose a size </RadioGroupLabel>
          <div class="grid grid-cols-7 gap-2">
            <RadioGroupOption as="template" v-for="size in props.sizeVariations" :key="size" :value="size"
              v-slot="{ active, checked }" class="cursor-pointer" @click="changeProduct(size)">
              <div
                :class="[active ? 'ring-2 ring-indigo-500 ring-offset-2' : '', checked ? 'border-transparent bg-indigo-600 text-white hover:bg-indigo-700' : 'border-gray-200 bg-white text-gray-900 hover:bg-gray-50', 'flex items-center justify-center rounded-md border py-3 px-3 text-sm font-medium uppercase sm:flex-1']">
                <RadioGroupLabel as="span">
                  {{ size.size }}
                </RadioGroupLabel>
              </div>
            </RadioGroupOption>
          </div>
        </RadioGroup>
      </div>
      <Alert class="mt-4" :error="error" v-if="showError" />
      <div class="flex flex-row gap-4 mt-8" v-if="!checkout">
        <button @click.prevent="submit" v-if="user"
          class="w-[90%] flex items-center justify-center rounded-md border border-transparent bg-indigo-600 py-3 px-0 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Add
          to bag</button>
        <Link href="/login" v-else
          class="w-[90%] flex items-center justify-center rounded-md border border-transparent bg-indigo-600 py-3 px-0 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        Add to bag</Link>
        <input :id="`quantity-${props.product.id}`" :name="`quantity-${props.product.id}`" type="number" min="1"
          :max="product.amount"
          class="rounded-md border border-gray-300 w-[20%] text-left text-base font-medium text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
          v-model="amount" />
      </div>
      <div class="mt-8" v-else="checkout">
        <Link href="/cart"
          class="w-full flex items-center justify-center rounded-md border border-transparent bg-indigo-600 py-3 px-8 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        Go to shopping bag</Link>
        <!-- continue shopping link -->
        <Link href="/"
          class="w-full mt-3 flex items-center justify-center rounded-md border border-transparent bg-white py-3 px-8 text-base font-medium text-indigo-600 cursor-pointer hover:underline hover:text-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        Continue
        shopping</Link>

      </div>
    </form>
  </section>
</template>