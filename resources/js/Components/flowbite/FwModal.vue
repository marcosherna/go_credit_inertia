<script setup>
import { computed, onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(['close']);

watch(() => props.show, () => {
    if (props.show) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = null;
    }
});

const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
    return {
        'sm': 'sm:max-w-sm',
        'md': 'sm:max-w-md',
        'lg': 'sm:max-w-lg',
        'xl': 'sm:max-w-xl',
        '2xl': 'sm:max-w-2xl',
        '3xl': 'sm:max-w-3xl'
    }[props.maxWidth];
});
</script>

<template>
    <teleport to="body">
        <transition leave-active-class="duration-200">
            <div v-show="show" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" scroll-region>
                <transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div v-show="show" class="fixed inset-0 transform transition-all" @click="close">
                        <div class="absolute inset-0 bg-slate-900 opacity-20" />
                    </div>
                </transition>

                <transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div v-show="show" class="overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto" :class="maxWidthClass">


                        <div v-if="show" class="overflow-y-auto overflow-x-hidden 
                            justify-center items-center w-full md:inset-0 
                            h-[calc(100%-1rem)] max-h-full"> 

                            <div class="relative w-full max-h-full"
                                :class="maxWidthClass"> 
                                <!-- Modal content --> 
                                <div class="relative 
                                    bg-white rounded-lg 
                                    shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    
                                    <div class="flex items-center 
                                        justify-between p-4 
                                        md:p-5 border-b rounded-t 
                                        dark:border-gray-600">

                                        <slot name="header"></slot>
                                         
                                        <button v-on:click="close" 
                                            type="button" 
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900
                                            rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center 
                                            dark:hover:bg-gray-600 dark:hover:text-white">
                                            
                                                <svg class="w-3 h-3" aria-hidden="true" 
                                                    xmlns="http://www.w3.org/2000/svg" 
                                                    fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" 
                                                        stroke-linecap="round" 
                                                        stroke-linejoin="round" 
                                                        stroke-width="2" 
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                            <span class="sr-only">Cerrar Modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->

                                    <slot name="body"></slot>

                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </transition>
    </teleport>
</template>
