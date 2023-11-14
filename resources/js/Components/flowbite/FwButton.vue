<script setup>

defineProps({
    type:String,
    disabled:{
        type:Boolean,
        default:false
    }
}) 
</script> 

<template lang="">
     <button :type="type" 
        :disabled="disabled"
        class="text-white inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
        <slot></slot>
    </button> 
</template>
