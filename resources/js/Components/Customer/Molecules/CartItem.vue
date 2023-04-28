<script setup>
import { ref } from 'vue'
import { CheckIcon, ClockIcon, XMarkIcon } from '@heroicons/vue/20/solid'
import { useCartStore } from '@/Stores/cart';

const props = defineProps({
  products: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['total'])

const total = ref(0)
const totalStock = ref(0)
const cartStore = useCartStore();

function getTotal() {
  total.value = 0;
  totalStock.value = 0;
  props.products.forEach((product) => {
    total.value += product.sku.price_incl_vat * product.amount;
    totalStock.value += product.amount;
  });
  emit('total', total.value)
  cartStore.setCount(totalStock.value)
}

function removeFromCart(id, product) {
  fetch('/cart/' + id, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
    },
  })
    .then((response) => {
      document.getElementById(id).remove();
      props.products.splice(props.products.indexOf(product), 1)
      getTotal()
      cartStore.setCount(cartStore.count - product.amount)
      if (cartStore.getCount < 0){
        cartStore.setCount(0)
      }
    })
    .catch((error) => {
      console.error('There has been a problem with your fetch operation:', error);
    });
}

function changeAmount(product, event) {
  if (event.target.value > 0 && event.target.value <= product.sku.amount) {
    fetch('/cart/' + product.sku.id, {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        amount: event.target.value,
      }),
    })
      .then((response) => {
        product.amount = parseInt(event.target.value);
        getTotal()
      })
      .catch((error) => {
        console.error('There has been a problem with your fetch operation:', error);
      });
  } else {
    event.target.value = product.amount;
  }
}

</script>
<template>
  <ul role="list" class="divide-y divide-gray-200 border-t border-b border-gray-200">
    <li v-for="(product, productIdx) in props.products" :key="product.id" class="flex py-6 sm:py-10" :id="product.sku.id">
      <div class="flex-shrink-0">
        <img :src="product.sku.product_images[0].image_link" alt="shopping cart item"
          class="h-24 w-24 rounded-md object-cover object-center sm:h-48 sm:w-48" />
      </div>
      <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
        <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
          <div>
            <div class="flex justify-between">
              <h3 class="text-sm">
                <a :href="`/product/${product.sku.sku}`" class="font-medium text-gray-700 hover:text-gray-800">{{
                  product.sku.product.title
                }}</a>
              </h3>
            </div>
            <div class="mt-1 flex text-sm">
              <p v-if="product.sku.attribute_values.length !== 0" class="text-gray-500">
                <span v-for="(attribute, index) in product.sku.attribute_values">
                  {{ attribute.name }}
                  <span v-if="index !== product.sku.attribute_values.length - 1">, </span>
                </span>
              </p>
            </div>
            <p class="mt-1 text-sm font-medium text-gray-900">€{{ product.sku.price_incl_vat.toFixed(2) }}</p>
          </div>

          <div class="mt-4 sm:mt-0 sm:pr-9">
            <label :for="`quantity-${productIdx}`" class="sr-only">Quantity, {{ product.sku.title }}</label>
            <input :id="`quantity-${productIdx}`" :name="`quantity-${productIdx}`" type="number" min="1"
              :max="product.sku.amount"
              class="max-w-full rounded-md border border-gray-300 py-1.5 text-left text-base font-medium leading-5 text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
              :value="product.amount" @change="changeAmount(product, $event)" />
            <div class="absolute top-0 right-0">
              <button type="button" class="-m-2 inline-flex p-2 text-gray-400 hover:text-gray-500"
                @click="removeFromCart(product.sku.id, product)">
                <span class="sr-only">Remove</span>
                <XMarkIcon class="h-5 w-5" aria-hidden="true" />
              </button>
            </div>
          </div>
        </div>

        <div class="mt-4 flex space-x-2 text-sm text-gray-700">
          <CheckIcon v-if="product.sku.amount > 0" class="h-5 w-5 flex-shrink-0 text-green-500" aria-hidden="true" />
          <ClockIcon v-else class="h-5 w-5 flex-shrink-0 text-gray-300" aria-hidden="true" />
          <span>{{ product.inStock ? 'In stock' : `Ships in 2-4 workdays` }}</span>
        </div>
      </div>
    </li>
  </ul>
</template>