<script setup>
import { StarIcon, ChevronUpIcon } from '@heroicons/vue/20/solid'
import { HeartIcon } from '@heroicons/vue/24/outline'
import { router } from '@inertiajs/vue3'
import { AddReviewModal } from '@/Components/Customer';
import { ref } from 'vue'

const props = defineProps({
  reviews: Object,
  sku: String,
  userHasBought: Boolean,
})
let openReview = ref(false)

function updateReviews(data) {
  props.reviews.push(data.review)
}


function upvote(review) {
  router.get('/upvote/' + review.id)
}

</script>
<template>
  <AddReviewModal v-if="openReview" :open="openReview" @close="openReview = false" @closed="openReview = false"
    :sku="props.sku" class="absolute top-0 left-0 z-20" @submitted="updateReviews" />
  <div class="bg-white">
    <div
      class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:grid lg:max-w-7xl lg:grid-cols-12 lg:gap-x-8 lg:px-8 lg:py-32">
      <div class="lg:col-span-4">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Customer Reviews</h2>
        <div class="mt-6">
          <h3 class="sr-only">Review data</h3>
        </div>
        <div class="mt-10" v-if="props.userHasBought">
          <h3 class="text-lg font-medium text-gray-900">Share your thoughts</h3>
          <p class="mt-1 text-sm text-gray-600">If you’ve used this product, share your thoughts with other customers</p>

          <button @click="openReview = true" type="button"
            class="mt-6 inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-8 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 sm:w-auto lg:w-full">Write
            a review</button>
        </div>
      </div>

      <div class="mt-16 lg:col-span-7 lg:col-start-6 lg:mt-0">
        <h3 class="sr-only">Recent reviews</h3>

        <div class="flow-root">
          <div class="-my-12 divide-y divide-gray-200">
            <div v-for="review in props.reviews" :key="review.id" class="py-12 flex flex-row justify-between">
              <div>
                <div class="flex items-center">
                  <div class="flex gap-2">
                    <h4 class="text-sm font-bold text-gray-900">{{ review.title }}</h4>
                    <div class="flex items-center">
                      <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating"
                        :class="[review.score > rating ? 'text-yellow-400' : 'text-gray-300', 'h-5 w-5 flex-shrink-0']"
                        aria-hidden="true" />
                    </div>
                    <p class="sr-only">{{ review.score }} out of 5 stars</p>
                  </div>
                </div>
                <div class="mt-4 space-y-6 text-base italic text-gray-600" v-html="review.body" />
              </div>
              <div class="flex items-center gap-4">
                <button type="button" @click="upvote(review)"
                  class="rounded-full bg-indigo-400 p-1 px-4 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                  {{ review.useful_count }}
                  <HeartIcon class="h-5 w-5" aria-hidden="true" />
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>