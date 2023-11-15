<script setup>

defineProps({ 
    label:{
        type:String,
        default:null
    }, 
    checked:{
        type:[Array, Boolean],
        default:false
    },
})

</script> 
<template lang="">
    <div class="flex items-center ps-3">
            <input   
            v-bind="$attrs"
            :checked="checked"   
            @input="$emit('update:checked', $event.target.checked)"
            id="vue-checkbox-list"
                 
                type="checkbox" value="" 
                class="w-4 h-4 text-green-600 
                bg-gray-100 border-gray-300 
                rounded focus:ring-green-500 
                dark:focus:ring-green-600 
                dark:ring-offset-gray-700 
                dark:focus:ring-offset-gray-700 
                focus:ring-2 dark:bg-gray-600 dark:border-gray-500">

            <label v-if="label != null" for="vue-checkbox-list" 
            class="w-full py-3 ms-2 text-sm font-medium 
            text-gray-900 dark:text-gray-300">{{ label }}</label>
        </div>
</template>
