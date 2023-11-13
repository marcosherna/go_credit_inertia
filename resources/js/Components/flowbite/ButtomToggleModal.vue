<script setup>

defineProps({
    text:String, 
});

</script>

<template>
    <button 
        type="button"
        class="text-white shadow-md bg-green-700 hover:bg-green-800  font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" >
        <slot></slot>
        {{ text }}
    </button>
</template>