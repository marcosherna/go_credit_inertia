<script setup>
 
defineProps({
    label:String, 
    placeholder:String,
    value:String,
    row:{ 
        type:Number,
        default: 3
    }
})

defineEmits({'update:value':null})

</script> 
<template lang="">
    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ label }}</label>
    <textarea id="description" 
        :rows="row" 
        :value="value"
        @input="$emit('update:value', $event.target.value)"
        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
        :placeholder="placeholder">
    </textarea>
</template>
