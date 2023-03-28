<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { EmptyState, OrderSummary, CartItem } from '@/Components/Customer'

const props = defineProps({
  cart: Object,
});

console.log(props.cart)
</script>
<template>
  <GuestLayout>
    <div class="bg-white mt-24">
      <div class="mx-auto max-w-2xl px-4 pt-16 pb-24 sm:px-6 lg:max-w-7xl lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Shopping Bag</h1>
        <form class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16" v-if="props.cart.length > 0">
          <section aria-labelledby="cart-heading" class="lg:col-span-7">
            <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>
            <CartItem :products="props.cart" />
          </section>
          <OrderSummary />
        </form>
        <div v-else>
          <EmptyState title="No products" description="Get started by adding a product to your cart"
            button="Continue Shopping" />
        </div>
      </div>
    </div>
  </GuestLayout>
</template>