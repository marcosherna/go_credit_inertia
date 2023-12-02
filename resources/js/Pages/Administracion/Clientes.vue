<script setup> 
import NavigationLayout from '@/Layouts/NavigationLayout.vue';
import { FwTable, FwBadge, FwButton, FwModal, 
    FwInput, FwTextArea, FwSelect, FwRadioCheckbox, 
    FwSearchBar, FwButtonDropdown} from '../../Components/flowbite/index';
import controller from './partials/ClienteController.js';
import { useForm, router, Link } from '@inertiajs/vue3';
import { defineProps, ref, onMounted } from 'vue'; 

const props = defineProps({
    clientes:Object, 
    
});
const form = useForm({ 
    ...controller.model, 
    antecentes:false,
    tipoCliente: false, 
    ingresosAdicionales: false,
})
 

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
    estadosCiviles.value = estadosCiviles.value.length == 0 ? await controller.getEstadosCivil(): estadosCiviles.value;    
}

const filtrarDepartamentos = async (id_pais) => {
    departamentos.value = await controller.getDepartamentos(id_pais);
}

const filtrarMunicipios = async (id_departamento) => {
    municipios.value =  await controller.getMunicipios(id_departamento);
    
}

const onSearch = (text) => {   
    lstClientes.value = props.clientes.data.filter((item) => { 
        return  item.CLIE_NOMBRE.toUpperCase().includes(text.toUpperCase()) ||  
                item.CLIE_APELLIDO.toUpperCase().includes(text.toUpperCase()) ||   
                item.departamento_nacimiento.DEPA_NOMBRE.toUpperCase().includes(text.toUpperCase()) ||
                item.pais_nacimiento.PAIS_NOMBRE.toUpperCase().includes(text.toUpperCase()); 
    });
    
    if(text == ''){
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
        <navigation-layout titulo="Clientes"> 
            <div class="flex px-5 py-3 max-w-fit text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        Home
                    </a>
                    </li>
                    <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-green-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Administracion</a>
                    </div>
                    </li>
                    <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180  w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Clientes</span>
                    </div>
                    </li>
                </ol>
            </div>  
            <div class="relative overflow-x-auto  mt-6">
                <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4  dark:bg-gray-900">
                    <div>
                        <!-- BOTON --> 
                        <fw-button v-on:click="newCliente">
                            Nuevo Cliente
                        </fw-button>  

                        <fw-button-dropdown 
                            dropdownId="dropdown-export"
                            buttonText="Exportar"
                            :checkboxes="checkboxes"
                            v-model:value="selectionItemDrop"
                            classes="ms-3"
                        /> 
                    </div>

                    {{ selectionItemDrop }}

                    <div class="relative">  
                        <fw-search-bar   
                            @search="onSearch"
                            placeholder="Buscar..."/>
                    </div>
                    
                </div>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr> 
                            <th scope="col" class="px-6 py-3">
                                ID
                            </th>
                            <th scope="col" class="px-2 py-3">
                                Descripcion
                            </th>
                            <th scope="col" class="px-2 py-3">
                                EMAIL
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(c, index) in lstClientes" class="bg-white border-b dark:bg-green-800 dark:border-green-700 hover:bg-green-50 dark:hover:bg-green-600">
                            <td class="px-6 py-4">
                                {{ c.CLIE_ID }}
                            </td>
                            <th scope="row" class="flex items-center py-4 text-gray-900 whitespace-nowrap dark:text-white"> 
                                <div class="ps-3">
                                    <div class="text-sm"> 
                                        {{ c.CLIE_NOMBRE + ' ' + c.CLIE_NOMBRE2 + ' ' + c.CLIE_APELLIDO + ' ' + c.CLIE_APELLIDO2}}
                                        <span class="text-blue-700"> {{ `No. Tel ${c.CLIE_TEL == null || c.CLIE_TEL == ' ' ? c.CLIE_TEL2: c.CLIE_TEL}` }}</span>
                                    </div>
                                    <div class="font-normal text-gray-500 text-sm">
                                        {{ c.pais_nacimiento ? c.pais_nacimiento.PAIS_NOMBRE: '' + ', ' + c.departamento_nacimiento? c.departamento_nacimiento : '' + ' ' + c.CLIE_DIRECCION }}
                                    </div>
                                </div>  
                            </th>
                            <td class="px-2 py-4">
                                {{ `${c.CLIE_MAIL == null || c.CLIE_MAIL == '' ? 'no asignado': c.CLIE_MAIL }` }}
                            </td>
                            <td class="px-6 py-4">
                                <fw-badge 
                                    :color="`${ controller.estadoCliente.find(estado => estado.value == c.CLIE_ESTADO).color }`">
                                    {{ controller.estadoCliente.find(estado => estado.value == c.CLIE_ESTADO).text }}
                                </fw-badge>
                            </td>
                            <td class="px-6 py-4">
                                <button href="#" v-on:click="onShowClient(c.CLIE_ID)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Detalle</button>
                                <button href="#" v-on:click="editClient(c.CLIE_ID)" class="pl-3 font-medium text-blue-600  dark:text-blue-500 hover:underline">Editar</button>
                            </td>
                        </tr>
                         
                    </tbody>
                </table> 
            </div>  

             <!-- PAGINACION -->
             <ul class="flex items-center -space-x-px h-10 text-base py-8">
                    <li v-for="(link, index) in clientes.links" :key="index"> 
                        <Link  :href="link.url || '#'" :disabled="!(clientes.current_page ===  clientes.first_page_url || clientes.current_page  === clientes.last_page_url)"  
                            class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                            :class="{ 'rounded-s-lg': index === 0, 'rounded-e-lg': index === clientes.links.length - 1 }">

                            <span v-if="link.label === '&laquo; Previous' || link.label === 'Next &raquo;'" class="sr-only">{{ link.label }}</span>
                            <span v-else v-html="link.label"></span>
                        </Link>
                    </li>
                </ul> 
        </navigation-layout> 

    </div>


</template>
