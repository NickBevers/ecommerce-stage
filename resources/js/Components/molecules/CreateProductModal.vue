<script setup>
import PrimaryButton from "@/Components/atoms/PrimaryButton.vue";
import { onMounted, ref, reactive } from "vue";
import InputLabel from "@/Components/atoms/InputLabel.vue";
import TextInput from "@/Components/atoms/TextInput.vue";
import { useForm, usePage } from "@inertiajs/vue3";

const showModal = ref(false);

const form = useForm({
  title: "",
  description: "",
  price: "",
  quantity: "",
  head_category: "",
  sub_category: "",
  image: "",
});

const headCategories = reactive([]);
const subCategories = reactive([]);
let categoriesSelection = reactive([]);

//fill the head categories with dummy data

headCategories.push({ id: 1, name: "Head Category 1" });
headCategories.push({ id: 2, name: "Head Category 2" });
headCategories.push({ id: 3, name: "Head Category 3" });

const showSubCategory = ref(false);

//fill the subcategories with dummy data
subCategories.push({ id: 1, name: "Sub Category 1", head_category_id: 1 });
subCategories.push({ id: 2, name: "Sub Category 2", head_category_id: 1 });
subCategories.push({ id: 3, name: "Sub Category 3", head_category_id: 1 });
subCategories.push({ id: 4, name: "Sub Category 4", head_category_id: 2 });
subCategories.push({ id: 5, name: "Sub Category 5", head_category_id: 2 });
subCategories.push({ id: 6, name: "Sub Category 6", head_category_id: 3 });
subCategories.push({ id: 7, name: "Sub Category 7", head_category_id: 3 });

function handleCategory() {
  console.log(form);
  showSubCategory.value = false;

  if (form.head_category.value != "") {
    showSubCategory.value = true;
  }

  categoriesSelection = subCategories.filter(
    (subCategory) => subCategory.head_category_id == form.head_category
  );
}
</script>
<template>
  <!-- Modal toggle -->
  <div class="flex justify-end">
    <div class="flex justify-start py-6">
      <PrimaryButton
        id="defaultModalButton"
        type="button"
        @click="showModal = !showModal"
      >
        Add Product
      </PrimaryButton>
    </div>
  </div>

  <!-- Main modal -->
  <div
    v-if="showModal"
    id="defaultModal"
    tabindex="-1"
    aria-hidden="true"
    class="flex justify-center absolute top-0 left-0 w-full h-screen bg-opacity-60 bg-gray-700 py-20"
  >
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
      <!-- Modal content -->
      <div
        class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5"
      >
        <!-- Modal header -->
        <div
          class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600"
        >
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            Add Product
          </h3>

          <button
            @click="showModal = !showModal"
            class="text-gray-400 transition-colors duration-200 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-gray-100"
            aria-label="close"
          >
            <svg
              class="w-5 h-5"
              aria-hidden="true"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path
                fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </button>
        </div>
        <!-- Modal body -->
        <form action="#">
          <div class="grid gap-4 mb-4 sm:grid-cols-2">
            <div>
              <InputLabel for="title">Title</InputLabel>
              <TextInput
                v-model="form.title"
                type="text"
                name="title"
                id="title"
                placeholder="Product title"
                required
              >
              </TextInput>
            </div>
            <div>
              <InputLabel for="price">Price</InputLabel>
              <TextInput
                type="number"
                name="price"
                id="price"
                placeholder="$999"
                required
                min="1"
              >
              </TextInput>
            </div>
            <div>
              <InputLabel for="audience">Audience</InputLabel>
              <select
                id="audience"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              >
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="children">Children</option>
              </select>
            </div>
            <div>
              <InputLabel for="stock">Stock</InputLabel>
              <TextInput
                type="number"
                name="stock"
                id="stock"
                placeholder="99"
                required
                min="1"
              >
              </TextInput>
            </div>
            <div>
              <InputLabel for="head_category">Head Category</InputLabel>
              <select
                id="head_category"
                v-model="form.head_category"
                @change="handleCategory"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              >
                <option value="" disabled selected>Select Head Category</option>
                <option
                  v-for="headCategory in headCategories"
                  :key="headCategory.id"
                  :value="headCategory.id"
                >
                  {{ headCategory.name }}
                </option>
              </select>
            </div>
            <div v-if="showSubCategory">
              <InputLabel for="sub_category">Sub Category</InputLabel>
              <select
                id="sub_category"
                @change="resetDropdown"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              >
                <option value="" disabled selected>Select subCategory</option>
                <option
                  v-for="subCategory in categoriesSelection"
                  :key="subCategory.id"
                  :value="subCategory.id"
                >
                  {{ subCategory.name }}
                </option>
              </select>
            </div>
            <div class="sm:col-span-2">
              <InputLabel for="description">Description</InputLabel>
              <textarea
                id="description"
                rows="4"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                placeholder="Write product description here"
              ></textarea>
            </div>
          </div>
          <PrimaryButton
            type="submit"
            class="inline-flex items-center text-center w-1/3"
          >
            <svg
              class="mr-1 -ml-1 w-6 h-6"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                clip-rule="evenodd"
              ></path>
            </svg>
            Add new product
          </PrimaryButton>
        </form>
      </div>
    </div>
  </div>
</template>