<script setup> 

defineProps({
    label:String,
    content:String,
    target:String,
    class:String
})



</script> 

<template lang="">
     <button :data-tooltip-target="target" 
        data-tooltip-placement="top" 
        type="button" 
        v-bind="$attrs"
        :class="class"
        class="text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 border">
        {{ label }}
    </button>

    <div :id="target" 
        role="tooltip" 
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
        {{ content }}
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
</template>
