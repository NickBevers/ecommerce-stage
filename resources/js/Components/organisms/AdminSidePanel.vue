<script setup>
import { computed, onMounted } from "vue";
import SecondaryButton from "@/Components/atoms/SecondaryButton.vue";
import PrimaryButton from "@/Components/atoms/PrimaryButton.vue";
import NavLink from "@/Components/atoms/NavLink.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  user: {
    type: Object,
  },
});

const firstname = computed(() => {
  return capitalizeFirstLetter(props.user.firstname);
});

const lastname = computed(() => {
  return capitalizeFirstLetter(props.user.lastname);
});

const initial = computed(() => {
  return getInitials(props.user.firstname, props.user.lastname);
});

function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

function getInitials(firstName, lastName) {
  const firstInitial = firstName.charAt(0).toUpperCase();
  const lastInitial = lastName.charAt(0).toUpperCase();
  return firstInitial + lastInitial;
}

</script>
<template>
  <aside class="w-64 h-full" aria-label="Sidenav">
    <div
      class="overflow-y-auto py-5 px-3 h-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
    >
      <ul
        class="pb-5 space-y-2 border-b text-center border-gray-200 dark:border-gray-700"
      >
        <li>
          <div
            class="relative inline-flex items-center justify-center w-20 h-20 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600"
          >
            <span
              class="font-medium text-2xl text-gray-600 dark:text-gray-300"
              >{{ initial }}</span
            >
          </div>
        </li>
        <li>
          <h2 class="font-medium text-m text-gray-600 dark:text-gray-300">
            {{ firstname }}&nbsp;{{ lastname }}
          </h2>
        </li>
        <li>
          <h3 class="font-medium text-sm text-gray-600 dark:text-gray-300">
            {{ user.email }}
          </h3>
        </li>
        <li class="flex gap-1 justify-center">
          <Link
            :href="route('profile.edit')"
            class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
          >
            Profile
          </Link>

          <Link
            :href="route('logout')"
            method="post"
            as="button"
            class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
          >
            Logout
          </Link>
        </li>
      </ul>
      <ul>
        <li>
            <NavLink
            :href="route('overview')"
            :active="route().current('overview')"
          >
            <svg
              aria-hidden="true"
              class="w-6 h-6 text-gray-400 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
              <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
            </svg>
            <span class="ml-3">Overview</span>
          </NavLink>
        </li>
        <li>
            <NavLink
            :href="route('products.index')"
            :active="route().current('products.index')"
          >
            <svg
              aria-hidden="true"
              class="w-6 h-6 text-gray-400 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
            <path d="M5.223 2.25c-.497 0-.974.198-1.325.55l-1.3 1.298A3.75 3.75 0 007.5 9.75c.627.47 1.406.75 2.25.75.844 0 1.624-.28 2.25-.75.626.47 1.406.75 2.25.75.844 0 1.623-.28 2.25-.75a3.75 3.75 0 004.902-5.652l-1.3-1.299a1.875 1.875 0 00-1.325-.549H5.223z"></path>
            <path clip-rule="evenodd" fill-rule="evenodd" d="M3 20.25v-8.755c1.42.674 3.08.673 4.5 0A5.234 5.234 0 009.75 12c.804 0 1.568-.182 2.25-.506a5.234 5.234 0 002.25.506c.804 0 1.567-.182 2.25-.506 1.42.674 3.08.675 4.5.001v8.755h.75a.75.75 0 010 1.5H2.25a.75.75 0 010-1.5H3zm3-6a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v3a.75.75 0 01-.75.75h-3a.75.75 0 01-.75-.75v-3zm8.25-.75a.75.75 0 00-.75.75v5.25c0 .414.336.75.75.75h3a.75.75 0 00.75-.75v-5.25a.75.75 0 00-.75-.75h-3z"></path>
            </svg>
            <span class="ml-3">Products</span>
          </NavLink>
        </li>
      </ul>
    </div>
  </aside>
</template>
