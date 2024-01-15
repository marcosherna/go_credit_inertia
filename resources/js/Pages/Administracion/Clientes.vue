<script setup>
import NavigationLayout from '@/Layouts/NavigationLayout.vue';
import {
    FwTable, FwBadge, FwButton, FwModal,
    FwInput, FwTextArea, FwSelect, FwRadioCheckbox,
    FwSearchBar, FwButtonDropdown
} from '../../Components/flowbite/index';
import controller from './partials/ClienteController.js';
import { useForm, router, Link, usePage } from '@inertiajs/vue3';
import { defineProps, ref, onMounted } from 'vue';

import { CPagination } from '@Components/Customs';

import { jsPDF } from 'jspdf';
import html2pdf from 'html2pdf.js';

const props = defineProps({
    clientes: Object,

});
const page = usePage();
const form = useForm({
    ...controller.model,
    antecentes: false,
    tipoCliente: false,
    ingresosAdicionales: false,
})

console.log(props.clientes);

const modalAdd = ref(false);
const paises = ref([]);
const departamentos = ref([]);
const municipios = ref([]);
const estadosCiviles = ref([]);
const lstClientes = ref(props.clientes.data);
const selectionItemDrop = ref([]);

const openModalAdd = async () => {
    modalAdd.value = true;
    paises.value = paises.value.length == 0 ? await controller.getPaises() : paises.value;
    estadosCiviles.value = estadosCiviles.value.length == 0 ? await controller.getEstadosCivil() : estadosCiviles.value;
}

const filtrarDepartamentos = async (id_pais) => {
    departamentos.value = await controller.getDepartamentos(id_pais);
}

const filtrarMunicipios = async (id_departamento) => {
    municipios.value = await controller.getMunicipios(id_departamento);

}

const onSearch = (text) => {
    lstClientes.value = props.clientes.data.filter((item) => {
        return item.CLIE_NOMBRE.toUpperCase().includes(text.toUpperCase()) ||
            item.CLIE_APELLIDO.toUpperCase().includes(text.toUpperCase()) ||
            item.departamento_nacimiento.DEPA_NOMBRE.toUpperCase().includes(text.toUpperCase()) ||
            item.pais_nacimiento.PAIS_NOMBRE.toUpperCase().includes(text.toUpperCase());
    });

    if (text == '') {
        lstClientes.value = props.clientes.data;
    }
}


const onShowClient = (CLIE_ID) => {
    router.visit(route('cliente.detalle-layout', CLIE_ID));
}

const editClient = (CLIE_ID) => {
    router.visit(route('cliente.editar-layout', CLIE_ID));
}

const newCliente = () => {
    router.visit(route('cliente.store'));
}

const checkboxes = [
    { label: "Excel", value: true },
    { label: "Pdf", value: false },
    { label: "Word", value: false },
]


</script> 

<template lang=""> 
    <div>
        <navigation-layout title="Clientes">
            
            <div class="px-6  mx-auto">
                <div>
                    <div class="flex items-center gap-x-3">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Modulo de Caja</h2>

                        <span
                            class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">Caja</span>
                    </div>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300"></p>
                </div> 

                <div class="flex items-center mt-12 justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4  dark:bg-gray-900">
                    <div>
                        <!-- BOTON --> 
                        <fw-button v-on:click="newCliente">
                            Nuevo Cliente
                        </fw-button>  

                        <button v-on:click="exportDdf">Exportar</button>  
                    </div> 

                    <div class="relative">  
                        <fw-search-bar   
                            @search="onSearch"
                            placeholder="Buscar..."/>
                    </div>
                    
                </div>

                <div class="flex flex-col mt-6">
                    
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <button class="flex items-center gap-x-3 focus:outline-none">
                                        <span>ID</span>
                                        <svg class="h-3" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z"
                                                fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                            <path
                                                d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z"
                                                fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                            <path
                                                d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z"
                                                fill="currentColor" stroke="currentColor" stroke-width="0.3" />
                                        </svg>
                                    </button>
                                </th>
                                <th scope="col"
                                    class="pl-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    DESCRIPCION
                                </th>

                                <th scope="col"
                                    class="pl-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    EMAIL</th>
                                <th scope="col"
                                    class="pl-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    ESTADO</th>

                                <th scope="col" class="pl-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Acciones
                                </th>
                            </tr>

                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                            <tr v-for="(c, index) in lstClientes" > 
                                <td class="pl-4 py-4 text-sm font-medium ">
                                    <div>
                                        <h2 class="font-medium text-gray-800 dark:text-white ">
                                            {{ c.CLIE_ID }}
                                        </h2>
                                        <p class="text-sm font-normal text-gray-600 dark:text-gray-400"></p>
                                    </div>
                                </td>
                                <td class="pl-4 py-4 text-sm whitespace-nowrap">
                                    <div>
                                        <h4 class="text-gray-700 dark:text-gray-200">
                                            {{ c.CLIE_NOMBRE + ' ' + c.CLIE_NOMBRE2 + ' ' + c.CLIE_APELLIDO + ' ' + c.CLIE_APELLIDO2}}
                                                <span class="text-blue-700"> {{ `No. Tel ${c.CLIE_TEL == null || c.CLIE_TEL == ' ' ? c.CLIE_TEL2: c.CLIE_TEL}` }}</span> 
                                        </h4> 
                                    </div>
                                </td>
                                <td class="pl-4 py-4 text-sm whitespace-nowrap">
                                    <div class="flex ">
                                        <div
                                            class="object-cover w-6 h-6 -mx-1 border-2 border-white rounded-full dark:border-gray-700 shrink-0">
                                            {{ `${c.CLIE_MAIL == null || c.CLIE_MAIL == '' ? 'no asignado': c.CLIE_MAIL }` }}
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 text-sm whitespace-nowrap"> 
                                    <fw-badge 
                                            :color="`${ controller.estadoCliente.find(estado => estado.value == c.CLIE_ESTADO).color }`">
                                            {{ controller.estadoCliente.find(estado => estado.value == c.CLIE_ESTADO).text }}
                                        </fw-badge>
                                </td>
                                <td class="py-4 text-sm whitespace-nowrap"> 
                                    <button href="#" v-on:click="onShowClient(c.CLIE_ID)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Detalle</button>
                                        <button href="#" v-on:click="editClient(c.CLIE_ID)" class="pl-3 font-medium text-blue-600  dark:text-blue-500 hover:underline">Editar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table> 
                </div>

                <c-pagination :items="clientes" />
            </div> 


            

        </navigation-layout>  


        
             
    </div> 
</template>
