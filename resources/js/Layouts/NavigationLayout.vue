<script setup> 
import { Head, Link } from '@inertiajs/vue3' 
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import Navbar from '../Components/flowbite/Navbar.vue';
import SideBard from '../Components/flowbite/SideBard.vue';
 
import { CSideBar } from '@Components/Customs';
import Logo from '@assets/icons/logo.svg'; 

defineProps({   
    title: { type:String, default: 'Go Credit' }
}) 
 
onMounted(() => {
    initFlowbite();
})

</script> 

<template>
    <!--<div>
        <Head :title="title" />
        <div class="antialiased bg-gray-50 dark:bg-gray-900"> 
            <Navbar /> 
            <SideBard />
            
            <main class="p-4 md:ml-64 h-auto pt-20">
                <slot></slot>
            </main> 
        </div>
    </div> -->

    <Head :title="title" />
    <div class="antialiased  dark:bg-gray-900"> 
        <c-side-bar/> 
    <main class="md:ml-64 h-auto bg-white  md:rounded-tl-[50px]">
        <nav
            class="bg-primary  md:hidden px-4 py-2.5 w-full md:rounded-tl-[50px] fixed sm:left-0 sm:right-0 sm:top-0 
            border-b-[1px] border-green-800">
            <div class="flex flex-wrap justify-between items-center">
                <div class="flex justify-start items-center">

                    <div class="flex py-3 pl-4 md:hidden">
                        <div class="relative ">
                            <img class="h-5" :src="Logo" alt="">  
                        </div> 
                    </div> 

                    
                </div>
                <div class="flex items-center lg:order-2"> 

                    <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                        aria-controls="drawer-navigation"
                        class=" text-white rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <svg aria-hidden="true" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Toggle sidebar</span>
                    </button>

                </div>
            </div>
        </nav>


        <div class="pt-24 pb-4 md:pb-0 md:pt-0 bg-primary px-3  md:px-0">

            <div class="bg-secondary "> 

                <nav class="border-b-[1px] border-gray-200 pl-10 py-4">
                    Aplication > Dashboard
                </nav> 
                <main class="p-4 pt-11">
                    <slot></slot>
                </main> 
                
            </div>
            
        </div>

    </main>
</div>  

</template>
