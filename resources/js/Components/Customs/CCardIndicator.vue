<script setup>

defineProps({
    color: {
        type: String,
        default: 'from-blue-600 to-blue-400 text-white shadow-blue-500/40'
    },
    label: {
        type: String,
        default: 'sub title'
    },
    indicator: {
        type: String,
        default: '00'
    }
})

</script>
<template>
    <div class="relative flex flex-col bg-clip-border rounded-lg bg-white text-gray-700 shadow-md">
        <div
            class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr  shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center"
            :class="color">
            <slot name="icon"></slot>
        </div>
        <div class="p-4 text-right">
            
            <h4 class="block antialiased tracking-normal font-sans text-3xl font-semibold leading-snug text-gray-900">
                {{indicator}}</h4>
                <p class="block antialiased font-sans text-sm  leading-normal font-normal text-gray-600">{{ label }}</p>
        </div>
    </div>
</template>
