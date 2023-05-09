<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { EmptyState, OrderSummary, CartItem } from '@/Components/Customer'
import { ref, onMounted } from 'vue'

const props = defineProps({
  cart: Object,
});

let subtotal = ref(0);

function totalPrice(total) {
  subtotal.value = total;
}

function getTotal() {
  subtotal.value = 0;
  props.cart.forEach((product) => {
    subtotal.value += product.sku.price_excl_vat * product.amount;
  });
}

onMounted(() => {
  getTotal()
})

</script>
<template>
  <GuestLayout>
    <div class="bg-white mt-24">
      <div class="mx-auto max-w-2xl px-4 pt-16 pb-24 sm:px-6 lg:max-w-7xl lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Shopping Bag</h1>
        <form class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16" v-if="props.cart.length !== 0">
          <section aria-labelledby="cart-heading" class="lg:col-span-7">
            <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>
            <CartItem :products="props.cart" @total="totalPrice" />
          </section>
          <OrderSummary class="sticky top-40 right-0" :total="subtotal" />
        </form>
        <div v-else>
          <EmptyState title="No products" description="Get started by adding a product to your cart"
            button="Continue Shopping" />
        </div>
      </div>
    </div>
  </GuestLayout>
</template>