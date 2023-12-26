<script setup>
defineProps({
    title: String,
    indicator: String,  
    color: {
        type: String,
        default: 'blue'
    },
    background: {
        type: String,
        default: 'white'
    }
})
</script>
<template >
    <section :class="`w-full px-6 rounded-lg max-w-2xl shadow-sm  bg-${background}`">
        <section class="py-4">
            <div class="flex items-center py-3">
                <slot name="icon" />
                <div class="space-y-3 flex-1">
                    <div class="flex items-center">
                        <h4 class="font-medium text-sm mr-auto text-gray-700 flex items-center">
                            {{ title }}
                            <!--<svg xmlns="http://www.w3.org/2000/svg" class="ml-2 shrink-0 w-5 h-5 text-gray-500" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                <path d="M12 9h.01"></path>
                                <path d="M11 12h1v4h1"></path>
                            </svg>-->
                        </h4>
                        <span :class="`px-2 py-1 rounded-lg bg-${color}-50 text-${color}-500 text-xs`">
                            {{ indicator }}
                        </span>
                    </div>
                </div>
            </div>
        </section>
    </section>
</template>
