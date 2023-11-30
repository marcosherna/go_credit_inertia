<script setup> 
defineProps({
    label:String, 
    placeholder:String,
    value:String,
    type:{
        type:String,
        default:'text'
    },
    disabled:{
        type:Boolean,
        default:false
    },
    min:{
        type:Number,
        default:null
    }, 
    pattern:{
        type:String,
        default:null
    }, 
    step:{
        type:Number,
        default:null
    }
})

defineEmits({'update:value':null})  
</script> 

<template >
    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ label  }}</label>
    <input  
        :type="type"
        :value="value"
        :disabled="disabled"  
        :min="min"
        :pattern="pattern"
        :step="step"
        @input="$emit('update:value', $event.target.value)"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 focus:ring-green-500 focus:border-green-500" :placeholder="placeholder">
</template>
