<template>
  <Listbox as="div" v-model="selected" :disabled="isDisabled" v-if="!lots">
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
            <li @click="handleChange(item)"
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
  <select v-else v-model="selected" :disabled="isDisabled"
    class="relative w-full cursor-default rounded-md bg-white py-1 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-50 border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
    :class="{ 'opacity-50': isDisabled }">
    <option v-for="item in props.items" :key="item" :value="item.item ? item.item : item">
      {{ item.name ? item.name : item.item ? item.item : item }}
    </option>
  </select>
</template>
<script setup>
import { ref, computed, watch, onMounted, defineEmits } from 'vue'
import { Listbox, ListboxButton, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
  items: {
    type: Object,
  },
  lots: {
    type: Boolean,
    default: false
  },
  place: {
    type: String,
    default: null
  },
  type: {
    type: String,
    required: false,
    default: null
  },
  selected: {
    type: String,
    required: false,
    default: null
  }
})

const emit = defineEmits(['changeValue'])

onMounted(() => {
  if (props.selected != null) {
    selected.value = props.selected
  }
  else if (props.place) {
    selected.value = props.place
  }
  else {
    selected.value = props.items[0]
  }
})

function handleChange(item) {
  selected.value = item.name
  emit('changeValue', props.type, selected.value)

  // emit('selectValue', )
}

const selected = ref("test")

const isDisabled = computed(() => props.items.length === 0)


if (isDisabled.value) {
  selected.value = 'No Options'
}

watch(() => Object.keys(props.items), (newVal, oldVal) => {
  if (newVal.length > 0 && oldVal.length === 0) {
    selected.value = props.items[newVal[0]].item || props.items[newVal[0]]
  }
})
</script>