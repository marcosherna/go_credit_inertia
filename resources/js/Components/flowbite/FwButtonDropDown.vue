<script setup>
import { defineProps, watchEffect, defineEmits } from 'vue';

const emit = defineEmits(['update:value']);

const props = defineProps({
    dropdownId: {
    type: String,
    required: true,
  },
  buttonText: {
    type: String,
    required: true,
  },
  checkboxes: {
    type: Array,
    required: true,
  },
  checkboxClasses: {
    type: String,
    default: "w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500",
  },
  value: {
    type: Array,
    default: () => [],
  },
  classes: {
    type: String,
    default: ""
  },
});

const syncCheckboxes = (newValue) => {
  props.checkboxes.forEach((checkbox, index) => {
    props.checkboxes[index] = {
      ...checkbox,
      checked: newValue.includes(checkbox.value),
    };
  });
};

watchEffect(() => {
  syncCheckboxes(props.value);
});

const emitChange = () => {
  const selectedValues = props.checkboxes
    .filter((checkbox) => checkbox.checked)
    .map((checkbox) => checkbox.value);

  emit('update:value', selectedValues);
};
</script>

<template> 
 
    <button
      :id="dropdownId"
      :data-dropdown-toggle="`default${dropdownId}`"
      class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
      :class="classes"
      type="button"
    >
      {{ buttonText }}
      <svg
        class="w-2.5 h-2.5 ms-3"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 10 6"
      >
        <path
          stroke="currentColor"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="m1 1 4 4 4-4"
        />
      </svg>
    </button>

    <!-- Dropdown menu -->
    <div
      :id="`default${dropdownId}`"
      class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
    >
      <ul
        class="p-3 space-y-3 text-sm text-gray-700 dark:text-gray-200"
        :aria-labelledby="dropdownId" 
      >
        <li v-for="(checkbox, index) in checkboxes" :key="index">
          <div class="flex items-center">
            <input
              :id="`checkbox-item-${index+1}`"
              type="checkbox"
              :class="checkboxClasses"
              :checked="checkbox.value"
            />  
            <label
              :for="`checkbox-item-${index+1}`"
              class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
            >
              {{ checkbox.label }}
            </label>
          </div>
        </li>
      </ul>
    </div> 
</template>
