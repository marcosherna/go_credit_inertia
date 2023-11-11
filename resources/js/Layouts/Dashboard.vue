<script setup>
import Navbar from '../Components/flowbite/Navbar.vue';
import SideBard from '../Components/flowbite/SideBard.vue';

defineProps({
    title:String, 
    Navbar,
    SideBard
})

</script>

<template lang="">
    <Head :title="title" />
        <div class="antialiased bg-gray-50 dark:bg-gray-900"> 
            <Navbar />
            <SideBard />
            
            <main class="p-4 md:ml-64 h-auto pt-20">
                <slot />
            </main>
        </div>
</template> 