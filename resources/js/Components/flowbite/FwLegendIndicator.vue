<script setup>
import { defineProps, ref } from 'vue';

defineProps({
    label: {
        type: String,
        default: 'Visitors',
    },
    color: {
        type: String,
        default: 'blue',
    }, 
})
</script>

<template>
    <span :class="`flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span class="flex w-2.5 h-2.5 bg-${color}-600 rounded-full me-1.5 flex-shrink-0`"  ></span>{{ label }}</span>

</template>
