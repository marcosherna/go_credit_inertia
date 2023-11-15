<script setup>  
import NavigationLayout from '../../../Layouts/NavigationLayout.vue'; 
import MenuModuloContable from './MenuModuloContable.vue';

</script>  

<template>
    <NavigationLayout title="Modulo Contable"> 
        <div class="intro-y flex items-center mt-6">
            <h2 class="text-lg font-medium mr-auto">Catalogos</h2> 
        </div> 

        <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Menu --> 
        <MenuModuloContable/>
        <!-- END: Menu-->  

        <!-- BEGIN: Contenido--> 
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">  
            <div class="relative overflow-x-auto">
                <div class="flex flex-colum sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">

                    <slot name="opctions">
                        
                    </slot>  

                </div> 

                <!--TABLE BANCO--> 
                    <slot name="content"></slot>
                </div>
            </div>
        </div>   
</NavigationLayout>  
    
</template>
