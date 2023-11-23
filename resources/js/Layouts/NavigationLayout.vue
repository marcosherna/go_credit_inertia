<script setup> 
import { Head } from '@inertiajs/vue3' 
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import Navbar from '../Components/flowbite/Navbar.vue';
import SideBard from '../Components/flowbite/SideBard.vue';

defineProps({ 
    Navbar, 
    SideBard, 
    title: { type:String, default: 'Go Credit' }
}) 

onMounted(() => {
    initFlowbite();
})


</script> 

<template>
    <div>
        <Head :title="title" />
        <div class="antialiased bg-gray-50 dark:bg-gray-900"> 
            <Navbar /> 
            <SideBard />
            
            <main class="p-4 md:ml-64 h-auto pt-20">
                <slot></slot>
            </main> 
        </div>
    </div>
</template>
