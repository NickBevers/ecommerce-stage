<script setup>
import { QuestionMarkCircleIcon } from '@heroicons/vue/20/solid'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  total: {
    type: Number,
    required: true,
  },
})

</script>
<template>
  <section aria-labelledby="summary-heading"
    class="mt-16 rounded-lg bg-gray-50 px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8">
    <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Order summary</h2>

    <dl class="mt-6 space-y-4">
      <div class="flex items-center justify-between">
        <dt class="text-sm text-gray-600">Subtotal</dt>
        <dd class="text-sm font-medium text-gray-900">€{{ props.total.toFixed(2) }}</dd>
      </div>
      <div class="flex items-center justify-between border-t border-gray-200 pt-4">
        <dt class="flex items-center text-sm text-gray-600">
          <span>Shipping estimate</span>
          <a href="#" class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500">
            <span class="sr-only">Learn more about how shipping is calculated</span>
            <QuestionMarkCircleIcon class="h-5 w-5" aria-hidden="true" />
          </a>
        </dt>
        <dd class="text-sm font-medium text-gray-900">€..</dd>
      </div>
      <div class="flex items-center justify-between border-t border-gray-200 pt-4">
        <dt class="flex text-sm text-gray-600">
          <span>Tax estimate</span>
          <a href="#" class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500">
            <span class="sr-only">Learn more about how tax is calculated</span>
            <QuestionMarkCircleIcon class="h-5 w-5" aria-hidden="true" />
          </a>
        </dt>
        <dd class="text-sm font-medium text-gray-900">€..</dd>
      </div>
      <div class="flex items-center justify-between border-t border-gray-200 pt-4">
        <dt class="text-base font-medium text-gray-900">Order total</dt>
        <dd class="text-base font-medium text-gray-900">€{{ props.total.toFixed(2) }}</dd>
      </div>
    </dl>

    <div class="mt-6 flex text-center">
      <Link href="/checkout"
        class="w-full rounded-md border border-transparent bg-indigo-600 py-3 px-4 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">
      Checkout</Link>
    </div>
  </section>
</template>