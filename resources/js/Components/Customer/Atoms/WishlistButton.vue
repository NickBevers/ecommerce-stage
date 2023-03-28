<template>
    <div>
        <a href="#" class="group/item -m-2 flex items-center p-2 rounded-md" v-if="props.product.wishlists.length === 0"
            @click.prevent="addToWishlist(props.product.id, props.product.wishlists)">
            <HeartIcon class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover/item:text-indigo-600" aria-hidden="true" />
        </a>
        <a href="#" class="group -m-2 flex items-center p-2 rounded-md text-indigo-600" v-else
            @click.prevent="removeFromWishlist(props.product.id, props.product.wishlists)">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path
                    d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
            </svg>
        </a>
    </div>
</template>

<script setup>
import {
  HeartIcon,
} from '@heroicons/vue/24/outline'
import { useWishlistStore } from '@/Stores/wishlist';


const props = defineProps({
  product: Object,
});


const wishlistStore = useWishlistStore();

function addToWishlist(product, wishlists) {
  fetch('/wishlist', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      sku_id: product,
    })
  })
    .then(response => {
      if (response.status === 200) {
        wishlists.push({ id: 0 });
        wishlistStore.increment()
      }
    })
    .catch(error => {
      console.log(error);
    });
}

function removeFromWishlist(product, wishlists) {
  fetch('/wishlist/' + product, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      sku_id: product,
    })
  })
    .then(response => {
      if (response.status === 200) {
        wishlists.pop();
        wishlistStore.decrement()
      }
    })
    .catch(error => {
      console.log(error);
    });
}
</script>