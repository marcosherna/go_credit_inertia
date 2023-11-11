<script setup>

import { Head } from '@inertiajs/vue3'
import DropdownNav from '../Components/flowbite/DropdownNav.vue';
import DropdownNavItem from '../Components/flowbite/DropdownNavItem.vue';

defineProps({
    title:String,
    DropdownNav,
    DropdownNavItem
})

</script>
<template >
    <div>
        <Head :title="title" />
        <div class="antialiased bg-gray-50 dark:bg-gray-900">
            <nav class="bg-white border-b border-gray-200 px-4 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50">
                <slot name="header" />
            </nav> 
            <!-- Sidebar --> 
            
            <main class="p-4 md:ml-64 h-auto pt-20">
                <slot />
            </main>
        </div>
    </div>
</template>

 