<script setup> 
import NavigationLayout from '@/Layouts/NavigationLayout.vue';
import MenuModuloBanco from '@/Pages/Banco/Partials/MenuModuloBanco.vue';
defineProps({
    title: {
        type: String,
        required: true,
    },
})
</script>
<template>

    <navigation-layout :title="title"> 
        <div class="intro-y flex items-center mt-6 md:px-12">
            <h2 class="text-lg font-medium mr-auto">Catalogos </h2> 
        </div> 

        <div class="grid grid-cols-12 gap-6 md:px-12">
        <!-- BEGIN: Menu --> 
        <menu-modulo-banco/>
        <!-- END: Menu--> 
        <!-- BEGIN: Contenido--> 
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9 container px-4 mx-auto ">  
            
            <div class="relative overflow-x-auto"> 
                <slot></slot>
                </div>
            </div>
        </div>  
    </navigation-layout>
</template>
