<script setup> 

import { defineEmits} from 'vue'; 

defineProps({
    defaultItem:String,
    label:String,
    selected:null, 
})

defineEmits({'update:selected':null});
</script> 

<template lang="">
    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ label }}</label>
    <select :value="selected" 
        @input="$emit('update:selected', $event.target.value)"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
            
        <option value="0" >{{ defaultItem }}</option>

        <slot></slot>
        
    </select>
</template>
