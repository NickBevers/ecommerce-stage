<script>
export default {
  name: 'SearchDropdown',
  props: {
    name: {
      type: String,
      required: false,
      default: 'input',
    },
    options: {
      type: Array,
      required: true,
      default: [],
    },
    placeholder: {
      type: String,
      required: false,
      default: 'Search for option...',
    },
    disabled: {
      type: Boolean,
      required: false,
      default: false,
    },
    maxItem: {
      type: Number,
      required: false,
      default: 10,
    },
  },
  data() {
    return {
      selected: {},
      optionsShown: false,
      searchFilter: '',
    };
  },
  created() {
    this.$emit('selected', this.selected);
  },
  computed: {
    filteredOptions() {
      const filtered = [];
      const regex = new RegExp(this.searchFilter, 'ig');
      for (const option of this.options) {
        if (this.searchFilter.length < 1 || option.name.match(regex)) {
          if (filtered.length < this.maxItem) filtered.push(option);
        } else {
          if (filtered.length > this.maxItem) filtered.push('option');
        }
      }
      return filtered;
    },
  },
  methods: {
    selectOption(option) {
      this.selected = option;
      this.optionsShown = false;
      this.searchFilter = this.selected.name;
      this.$emit('selected', this.selected);
    },
    showOptions() {
      if (!this.disabled) {
        this.searchFilter = '';
        this.optionsShown = true;
      }
    },
    exit() {
      if (!this.selected.id) {
        this.selected = {};
        this.searchFilter = '';
      } else {
        this.searchFilter = this.selected.name;
      }
      this.optionsShown = false;
    },
    // Selecting when pressing Enter
    keyMonitor: function (event) {
      if (event.key === 'Enter' && this.filteredOptions[0])
        this.selectOption(this.filteredOptions[0]);
    },
  },
  watch: {
    searchFilter() {
      if (this.filteredOptions.length === 0) {
        this.selected = {};
      } else {
        this.selected = this.filteredOptions[0];
      }
      this.$emit('filter', this.searchFilter);
    },
  },
};
</script>
<template>
  <div class="dropdown" v-if="options">
    <div class="dropdown-toggle">
      <input
        :name="name"
        @focus="showOptions()"
        @blur="exit()"
        @keyup="keyMonitor"
        v-model="searchFilter"
        :disabled="disabled"
        :placeholder="placeholder"
        required
      />
    </div>
    <transition name="fade">
      <ul class="dropdown-menu" v-show="optionsShown">
        <li
          @mousedown="selectOption(option)"
          v-for="(option, index) in filteredOptions"
          :key="index"
        >
          <a href="javascript:void(0)">
            {{ option.name || option.id || '-' }}
          </a>
        </li>
      </ul>
    </transition>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 250ms cubic-bezier(0.25, 0.46, 0.45, 0.94) 0s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.dropdown {
  min-width: 160px;
  height: 36px;
  position: relative;
  margin: 10px 1px;
  display: inline-block;
  vertical-align: middle;
  width: 100%;
}
.dropdown a:hover {
  text-decoration: none;
}

.dropdown-toggle {
  position: relative;
  display: inline-block;
  transition: 0.75s ease-in;
  border-radius: 1px 1px 0 0;
  width: 100%;
}
.dropdown-toggle input {
  box-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) #333333;
  -webkit-box-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) #333333;
  -moz-box-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) #333333;
  cursor: pointer;
  padding: 0.375rem 0.75rem;
  background: rgb(255, 255, 255);
  outline: none;
  width: 100%;
  transition: 0.75s ease-in;
  color: #111827;
  border-radius: 0.25rem;
  box-shadow: 0 0 0 0.5px rgba(0, 0, 0, 0.192);
  font-size: 0.875rem;
}

.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1000;
  float: left;
  min-width: 160px;
  width: 100%;
  margin: 0 0 0;
  border: 1px solid rgba(0, 0, 0, 0.753);
  margin-top: 4;
  list-style: none;
  font-size: 14px;
  text-align: left;
  background-color: #fff;
  border: 1px solid #ccc;
  border-top: none;
  border-radius: 4px;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
  background-clip: padding-box;
}

.dropdown-menu > li > a {
  display: block;
  clear: both;
  font-weight: normal;
  line-height: 1.6;
  color: #333333;
  white-space: nowrap;
  text-decoration: none;
  max-width: 100%;
  font-size: 14px;
  padding: 8px 16px 8px 32px;
}
.dropdown-menu > li > a:hover {
  background-color: rgb(79 70 229);
  color: #ffffff;
}

.dropdown-menu > li {
  overflow: hidden;
  position: relative;
  margin: 0;
}

li {
  list-style: none;
}
</style>
