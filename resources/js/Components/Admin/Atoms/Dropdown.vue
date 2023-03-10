<template>
  <Listbox as="div" v-model="selected" :disabled="isDisabled">
    <div class="relative mt-2">
      <ListboxButton
        class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
        :class="{ 'opacity-50': isDisabled }">
        <span v-if="!isDisabled" class="block truncate">{{ selected.name ? selected.name : selected }}</span>
        <span v-else class="block truncate">No options available</span>
        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
          <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
        </span>
      </ListboxButton>

      <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
        leave-to-class="opacity-0">
        <ListboxOptions
          class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
          <ListboxOption as="template" v-for="item in props.items" :key="item" :value="item.item ? item.item : item"
            v-slot="{ active, selected }">
            <li
              :class="[active ? 'bg-indigo-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-8 pr-4']">
              <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">
                {{ item.name ? item.name : item.item ? item.item : item }}
              </span>

              <span v-if="selected"
                :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 left-0 flex items-center pl-1.5']">
                <CheckIcon class="h-5 w-5" aria-hidden="true" />
              </span>
            </li>
          </ListboxOption>
        </ListboxOptions>
      </transition>
    </div>
  </Listbox>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { Listbox, ListboxButton, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
  items: {
    type: Object,
  },
})

const selected = ref(props.items[0])

const isDisabled = computed(() => props.items.length === 0)

// Set the selected value to "No Options" if props.items is empty
if (isDisabled.value) {
  selected.value = 'No Options'
}

watch(() => Object.keys(props.items), (newVal, oldVal) => {
  if (newVal.length > 0 && oldVal.length === 0) {
    selected.value = props.items[newVal[0]].item || props.items[newVal[0]]
  }
})
</script>