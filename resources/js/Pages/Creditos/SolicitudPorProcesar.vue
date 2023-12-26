<script setup> 
import NavigationLayout from '@/Layouts/NavigationLayout.vue'; 
import CTablePorProcesar from './partials/CTablePorProcesar.vue';
import CSearchBar from './partials/CSearchBar.vue';  
    
import {ref } from 'vue'; 

import { ElLoading, ElMessage } from 'element-plus' 

import { solicitudService } from './../../Services/index.js';

const props = defineProps({ 
    response: { 
        type: Object,  
    }, 
    count: { 
        type: Number,  
    },
})

const txtSearch = ref('');
const data = ref(props.response);

//console.log(props.response)

const onSearch = async () => { 

    try {
        ElLoading.service({ fullscreen: true , text: 'Buscando...' , background: 'rgba(0, 0, 0, 0.8)'});
        const _data = await solicitudService.searchSolicitud(txtSearch.value);
        //data.value = _data; 
        console.log(_data)
        ElLoading.service().close();

    } catch (error) {
        ElMessage({
            showClose: true,
            message: error.message,
            type: 'error'
        });   
        ElLoading.service().close();
    }
}
 
</script> 

<template>
    <Navigation-layout title="Solicitudes"> 
        <!-- component -->
        <section class="container px-4 mx-auto">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div>
                    <div class="flex items-center gap-x-3">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Solicitudes Por Procesar</h2>

                        <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{ count  }} Creditos</span>
                    </div>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">These companies have purchased in the last 12 months.</p>
                </div>

                <div class="flex items-center mt-4 gap-x-3">
                    
                    <!-- Button exportar  <c-button-export
                        :data="solicitudes.data"
                    /> --> 
                </div>
            </div> 
            <div class="mt-6 md:flex md:items-center md:justify-between">
                <div class="inline-flex overflow-hidden bg-white border divide-x rounded-lg dark:bg-gray-900 rtl:flex-row-reverse dark:border-gray-700 dark:divide-gray-700">

                    <!-- <button v-on:click="findAll" class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 bg-gray-100 sm:text-sm dark:bg-gray-800 dark:text-gray-300">
                        Todos
                    </button>  -->

                    

                    <!--<button  class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                        Monitored

                        <c-drop-down-status
                        :options="solicitudServices.SolicitudEstado"
                        @responce="solicitudes = $event"
                        label="filtrar"/> 

                    </button> -->
                    
                </div>

                <!-- Search bar  
                -->
                <c-search-bar 
                    v-model:value="txtSearch"
                    v-on:keyup.enter="onSearch()"
                    placeholder="Buscar" />
            </div>

            <c-table-por-procesar
                :items="data"/>     
            
        </section>  
    </Navigation-layout> 
</template>
