<script setup> 

const emit = defineEmits(['onClose', 'onAction']);

defineProps({
    message: {
        type: String,
        default: 'This is a warning alert'
    },
    title: {
        type: String,
        default: 'Warning'
    },
    show: {
        type: Boolean,
        default: false
    },
    titleAction: {
        type: Array,
        default: () => ['Action', 'Close']
    },
    class: {
        type: String,
        default: ''
    }
})

const onClose = () => {
    emit('onClose');
}

const onAction = () => {
    emit('onAction');
}

</script> 
<template>
    <div  
        v-show="show"  
        class="p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-300 dark:border-green-800" 
        role="alert"
        :class="class">
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Info</span>
                        <h3 class="text-lg font-medium">{{ title }}</h3>
                    </div>
                    <div class="mt-2 mb-4 text-sm">
                        {{  message  }}
                    </div>
                    <div class="flex">
                        <button v-on:click="onAction" type="button" class="text-white bg-green-800 hover:bg-green-900 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center dark:bg-green-300 dark:text-gray-800 dark:hover:bg-green-400 dark:focus:ring-green-800">
                            <svg class="me-2 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                                <path d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/>
                            </svg>
                        {{ titleAction[0] }}
                        </button>
                        <button v-on:click="onClose" type="button" class="text-green-800 bg-transparent border border-green-800 hover:bg-green-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-green-300 dark:border-green-300 dark:text-green-300 dark:hover:text-gray-800 dark:focus:ring-green-800" >
                            {{ titleAction[1] }}
                        </button>
                    </div>
                </div>
</template>
