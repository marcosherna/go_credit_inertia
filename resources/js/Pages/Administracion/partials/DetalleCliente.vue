<script setup>  
import NavigationLayout from '../../../Layouts/NavigationLayout.vue'; 
import controller from './ClienteController.js';


const props =  defineProps({
    cliente: Object,
    idCliente:{
        type: String,
        default: null
    }
})  

</script>

<template lang=""> 
    <navigation-layout title="Detalle Cliente">  

        <div class="intro-y flex items-center mt-6">
            <h2 class="text-lg font-medium mr-auto">Cliente</h2> 
        </div> 

        <div class="grid grid-cols-12 gap-6 lg:col-span-4 p-6"> 
            <div class="col-span-4 ">
                <div class="bg-white rounded-lg px-6 py-3 ring-1 ring-slate-200 flex flex-col">
                    <label class="text-lg font-bold">{{ 
                         cliente.CLIE_NOMBRE + ' '+ cliente.CLIE_NOMBRE2 + ' ' + cliente.CLIE_APELLIDO + ' '+cliente.CLIE_APELLIDO2}}
                    </label>
                    <span class="text-gray-700 text-sm">{{ cliente.pais_nacimiento.PAIS_NOMBRE }}</span>

                    <span class="bg-slate-200 h-px my-3"></span>

                    <div class="grid grid-rows-6 mt-2 gap-3">
                        <div class="row-span-1 flex flex-row justify-between">
                            <label class="text-gray-700 text-sm">Email</label>
                            <span class="text-gray-800 text-sm">{{ cliente.CLIE_MAIL2 ?? 'No asignado'  }}</span>
                        </div>
                        <div class="row-span-1 flex flex-row justify-between">
                            <label class="text-gray-700 text-sm">Telefono</label>
                            <span class="text-gray-800 text-sm">{{ `${cliente.CLIE_TEL}`}}</span>
                        </div>
                        <div class="row-span-1 flex flex-row justify-between">
                            <label class="text-gray-700 text-sm">Trabajo</label>
                            <span class="text-gray-700 text-sm">{{ cliente.CLIE_PROFESION??'No asignado' }}</span>
                        </div>
                        <div class="row-span-1 flex flex-row justify-between">
                            <label class="text-gray-700 text-sm">Documento</label>
                            <span class="text-gray-700 text-sm">{{ cliente.CLIE_DOCIDEN }}</span>
                        </div>
                        <div class="row-span-1 flex flex-row justify-between">
                            <label class="text-gray-700 text-sm">Genero</label>
                            <span class="text-gray-700 text-sm">{{ controller.genero[cliente.CLIE_SEXO].text }}</span>
                        </div> 
                    </div>

                    <button class="ring-1 ring-slate-200 rounded-lg py-2 text-sm">
                        nuevo
                    </button>
                </div>


                <div class="bg-white rounded-lg px-6 py-3 ring-1 ring-slate-200 flex flex-col mt-6">
                    <span class="text-sm">Creditos</span>
                    <span class="bg-slate-200 h-px my-3"></span>

                    <div class="text-sm flex flex-col">
                        <a href="" class="font-bold">Lorem ipsum dolor sit </a>
                        <span>Lorem ipsum dolor sit amet, consectetur adipisicing</span>
                    </div>
                </div>
            </div>  
        </div>

    </navigation-layout>
   
</template>
