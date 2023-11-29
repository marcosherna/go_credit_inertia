<script setup>  
import NavigationLayout from '../../../Layouts/NavigationLayout.vue'; 
import {  FwBadge, FwModal, FwSkeleton } from '../../../Components/flowbite/index'; 
import controller from './ClienteController.js';
import { defineProps, ref, onMounted } from 'vue';
import cuotaService from './services/cuotasServices.js';




const props =  defineProps({
    cliente: Object,
    idCliente:{
        type: String,
        default: null
    }, 
    solicitudes: Array,
})  

const showAllSolicitud= ref(false); 
const allSolicitudes = ref([]);
const showDetalleCredito = ref(false);
const solicitud = ref({});
const cuotas = ref([]);

const valorPorCuota = ref(0);
const cuota = ref(0);
const cuotasPendientes = ref(0);
const creditos = ref([]);

onMounted(async () => {
    if(props.cliente.CLIE_ID){
        creditos.value = await controller.takeCreditos(props.cliente.CLIE_ID, 3); 
    } 
});
 

const openAllSolicitud =  async (idCliente) => {
    try {
        showAllSolicitud.value = true;   
        allSolicitudes.value = await controller.getAllSolicitudes(idCliente); 
    } catch (error) {
        console.log(error);
    }
}

const detalleCredito = async (idSolicitud) => {
    cuotas.value = null;
    showDetalleCredito.value = true; 
    solicitud.value = await controller.getSolicitudById(idSolicitud);
    cuotas.value = await controller.getCuotasById(idSolicitud);

    valorPorCuota.value = controller.cantidaCuotas(solicitud.value.plazo.PLAZ_VALOR, solicitud.value.forma_pago.FORM_VALOR);

    cuota.value = controller.calcularCuota(solicitud.value.SOLI_MONTO, solicitud.value.tasa_interes.TASA_VALOR ,  valorPorCuota.value);

    cuotasPendientes.value = cuotas.value.filter(cuota => cuota.CUOT_ESTADO != 1).length; 
    
}

</script>

<template lang=""> 
    <navigation-layout title="Detalle Cliente">  

        <div class="intro-y flex items-center mt-6">
            <h2 class="text-lg font-medium mr-auto"></h2> 
        </div>  
            <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Menu --> 
            <div class="col-span-12 max-h-md lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse ">
                <div class="intro-y box mt-5 rounded-md bg-white shadow-lg">
                    <div class="relative flex items-center p-5">
                        <div class="ml-4 mr-auto">
                            <div class="font-medium text-base">{{ 
                            cliente.CLIE_NOMBRE + ' '+ cliente.CLIE_NOMBRE2 + ' ' + cliente.CLIE_APELLIDO + ' '+cliente.CLIE_APELLIDO2}}</div>
                                <div class="text-slate-500">{{ cliente.pais_nacimiento.PAIS_NOMBRE }}</div>
                            </div>
                        </div>
                        <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                            <div class="grid grid-rows-6 mt-2 gap-3 pb-5">
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
                                <div class="row-span-1 flex flex-row justify-between">
                                    <label class="text-gray-700 text-sm">Estado</label>
                                    <fw-badge :color="`${ controller.estadoCliente.find(estado => estado.value == cliente.CLIE_ESTADO).color }`">
                                        {{ controller.estadoCliente.find(estado => estado.value == cliente.CLIE_ESTADO).text }}
                                    </fw-badge> 
                                </div> 
                            </div>
                            <button class="ring-1 w-full ring-slate-200 rounded-lg mt-6 py-2 text-sm">
                                nuevo Credito
                            </button>
                    </div> 
                </div>
                
                <div class="intro-y box mt-5 bg-white shadow-lg"> 
                    <div class="w-full max-w-md p-4 ">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Creditos Activos</h5>
                            <a href="#" v-on:click="openAllSolicitud(cliente.CLIE_ID)" class="text-sm font-medium text-green-400 hover:underline dark:text-green-400">
                                todos
                            </a>
                    </div>
                    <div class="flow-root">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                <li   v-for="(s,index) in solicitudes" class="py-3 sm:py-4">
                                    <div class="flex items-center">     
                                        <div class="flex-1 min-w-0 ms-4">
                                            <a href="#" v-on:click="detalleCredito(s.SOLI_ID)" class="text-sm pb-2 font-medium text-gray-900 truncate dark:text-white">
                                                Categoria: {{ s.SOLI_CATEGORIA  }} Estado: 
                                                <fw-badge :color="controller.estadoSolicitud[s.SOLI_ESTADO].color">
                                                    {{ controller.estadoSolicitud[s.SOLI_ESTADO].text }}
                                                </fw-badge> 
                                            </a>
                                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                Apro: {{ s.SOLI_FECHAAPROB }} Venc: {{  s.SOLI_FECHAVENCIMIENTO }}
                                            </p>
                                        </div>
                                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                            ${{ s.SOLI_MONTO }}
                                        </div>
                                    </div>
                                </li> 
                            </ul>
                        </div>
                    </div> 
                </div> 
            </div>
        <!-- END: Menu-->  

        <!-- BEGIN: Contenido--> 
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">  
            <div class="relative overflow-x-auto">
                <div class="flex flex-colum sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
                    <!-- BOTON -->
                </div> 

                <!--TABLE BANCO-->
                
                <div class="grid my-4 grid-cols-12 gap-4 ">
                    <div class="col-span-12 sm:col-span-4">
                        <div class="p-4 relative transition hover:scale-105 duration-300 ease-in-out  bg-white border shadow-sm  rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14  absolute bottom-4 right-3 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                            </svg> 
                            <div class="text-2xl text-gray-900 font-medium leading-8 mt-5">20</div>
                            <div class="text-sm text-gray-500">Creditos</div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-4">
                        <div class="p-4 relative transition hover:scale-105 duration-300 ease-in-out  bg-white border shadow-sm  rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14  absolute bottom-4 right-3 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                            </svg>
                            <div class="flex justify-between items-center ">
                                <i class="fab fa-behance text-xl text-gray-400"></i>
                            </div>
                            <div class="text-2xl text-gray-900 font-medium leading-8 mt-5">99</div>
                            <div class="text-sm text-gray-500">Abirtos</div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-4">
                        <div class="p-4 relative transition hover:scale-105 duration-300 ease-in-out  bg-white border shadow-sm  rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14  absolute bottom-4 right-3 text-yellow-300" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex justify-between items-center ">
                                <i class="fab fa-codepen text-xl text-gray-400"></i>
                            </div>
                            <div class="text-2xl text-gray-900 font-medium leading-8 mt-5">50</div>
                            <div class="text-sm text-gray-500">Pagados</div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sticky top-0 z-10">
                    <div class="bg-white border shadow-sm  rounded-2xl p-4">
                        <div class="flex-none sm:flex"> 
                            <div class="flex-auto sm:ml-5 justify-evenly">
                            <div class="flex items-center justify-between sm:mt-2">
                                <div class="flex items-center">
                                <div class="flex flex-col"> 
                                </div>
                                </div>
                            </div>
                            <div class="flex flex-row items-center">
                                <div class="flex">
                                    <div class="flex flex-col  mr-2">
                                        <div class="text-gray-400 text-xs uppercase font-semibold tracking-wide">Solicitudes</div>
                                        <div class="text-lg font-bold">1.2k</div>
                                    </div> 
                                </div>
                                <div class="flex-1 inline-flex   items-center ml-2 space-x-2">
                                <a hre="https://www.behance.net/ajeeshmon" target="_blank"><svg class=" cursor-pointer w-5 h-5 p-1  rounded-2xl hover:bg-blue-500 hover:text-white transition ease-in duration-300" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="48" height="48" viewBox="0 0 172 172" style=" fill:#4a90e2;">
                                    <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                        <path d="M0,172v-172h172v172z" fill="none"></path>
                                        <g fill="#ffffff">
                                        <path d="M71.66667,82.41667c3.58333,0 14.33333,-5.79783 14.33333,-20.13117c0,-22.28475 -19.72983,-26.45217 -41.95367,-26.45217c-4.19967,0 -17.00292,0.00717 -26.12967,0.00358c-5.93758,-0.00358 -10.75,4.81242 -10.75,10.75v78.82975c0,5.93758 4.81242,10.75 10.75,10.75h42.28333c15.83475,0 29.25792,-12.52733 29.38333,-28.36208c0.16842,-21.77233 -17.91667,-25.38792 -17.91667,-25.38792zM28.66667,53.75h25.08333c5.93758,0 10.75,4.81242 10.75,10.75c0,5.93758 -4.81242,10.75 -10.75,10.75h-25.08333zM55.54167,118.25h-26.875v-25.08333h26.875c6.92658,0 12.54167,5.61508 12.54167,12.54167c0,6.92658 -5.61508,12.54167 -12.54167,12.54167zM163.0775,103.91667c2.97058,0 5.375,-2.40442 5.37858,-5.375v0c0,-20.77975 -14.37275,-37.625 -35.83333,-37.625c-19.79075,0 -35.83333,16.84525 -35.83333,37.625c0,20.77975 16.04258,37.625 35.83333,37.625c17.51175,0 27.2405,-8.1915 31.992,-20.22075c0.91733,-2.31842 -0.8815,-4.83033 -3.3755,-4.83033h-8.60358c-1.30792,0 -2.46533,0.74175 -3.14258,1.86333c-3.27517,5.41083 -8.27392,8.85442 -15.00342,8.85442c-10.07633,0 -17.415,-7.65042 -19.2855,-17.91667h38.4205zM132.62275,75.25c7.44258,0 14.65583,5.934 16.69117,14.33333h-33.22825c2.69825,-8.41725 9.08375,-14.33333 16.53708,-14.33333zM148.70833,53.75h-28.66667c-2.967,0 -5.375,-2.408 -5.375,-5.375v0c0,-2.967 2.408,-5.375 5.375,-5.375h28.66667c2.967,0 5.375,2.408 5.375,5.375v0c0,2.967 -2.408,5.375 -5.375,5.375z"></path>
                                        </g>
                                    </g>
                                    </svg></a>

                                <a hre="https://www.linkedin.com/in/ajeeshmon" target="_blank"><svg class="cursor-pointer w-5 h-5 p-1  rounded-2xl hover:bg-blue-500 hover:text-white transition ease-in duration-300" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 172 172" style=" fill:#ffffff;">
                                    <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                        <path d="M0,172v-172h172v172z" fill="none"></path>
                                        <g fill="#ffffff">
                                        <path d="M51.6,143.33333h-28.66667v-86h28.66667zM37.2724,45.86667c-7.9292,0 -14.33907,-6.42707 -14.33907,-14.33907c0,-7.912 6.42133,-14.3276 14.33907,-14.3276c7.90053,0 14.3276,6.42707 14.3276,14.3276c0,7.912 -6.42707,14.33907 -14.3276,14.33907zM154.8,143.33333h-27.56013v-41.85333c0,-9.98173 -0.1892,-22.81867 -14.3276,-22.81867c-14.35053,0 -16.55787,10.8704 -16.55787,22.09627v42.57573h-27.5544v-86.06307h26.4536v11.75907h0.37267c3.6808,-6.76533 12.6764,-13.8976 26.0924,-13.8976c27.92133,0 33.08133,17.82493 33.08133,40.99907z"></path>
                                        </g>
                                    </g>
                                    </svg></a>
                                <a hre="https://twitter.com/ajeemon?lang=en" target="_blank"><svg class="cursor-pointer w-5 h-5 p-1  rounded-2xl hover:bg-blue-400 hover:text-white transition ease-in duration-300" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 172 172" style=" fill:#ffffff;">
                                    <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                        <path d="M0,172v-172h172v172z" fill="none"></path>
                                        <g fill="#ffffff">
                                        <path d="M155.04367,28.88883c-5.84083,2.75917 -15.781,7.9335 -20.77617,8.9225c-0.1935,0.05017 -0.35117,0.11467 -0.5375,0.16483c-5.8265,-5.74767 -13.81017,-9.3095 -22.64667,-9.3095c-17.80917,0 -32.25,14.44083 -32.25,32.25c0,0.93883 -0.07883,2.666 0,3.58333c-23.06233,0 -39.904,-12.03283 -52.51017,-27.4985c-1.68417,-2.07833 -3.47583,-0.99617 -3.8485,0.48017c-0.8385,3.33967 -1.12517,8.9225 -1.12517,12.90717c0,10.0405 7.8475,19.90183 20.06667,26.015c-2.25033,0.5805 -4.73,0.99617 -7.31,0.99617c-3.03867,0 -6.536,-0.7955 -9.59617,-2.40083c-1.13233,-0.59483 -3.57617,-0.43 -2.85233,2.46533c2.9025,11.60283 16.1465,19.75133 27.97867,22.1235c-2.6875,1.58383 -8.42083,1.26133 -11.05817,1.26133c-0.97467,0 -4.3645,-0.22933 -6.5575,-0.50167c-1.9995,-0.24367 -5.074,0.27233 -2.50117,4.171c5.5255,8.3635 18.02417,13.61667 28.78133,13.81733c-9.90433,7.76867 -26.101,10.60667 -41.61683,10.60667c-3.139,-0.07167 -2.98133,3.5045 -0.4515,4.83033c11.44517,6.00567 30.19317,9.56033 43.58767,9.56033c53.24833,0 83.51317,-40.58483 83.51317,-78.8405c0,-0.61633 -0.01433,-1.90633 -0.03583,-3.2035c0,-0.129 0.03583,-0.25083 0.03583,-0.37983c0,-0.1935 -0.05733,-0.37983 -0.05733,-0.57333c-0.0215,-0.97467 -0.043,-1.88483 -0.0645,-2.35783c4.22117,-3.04583 10.6855,-8.33483 13.9535,-12.384c1.11083,-1.376 0.215,-3.04583 -1.29717,-2.52267c-3.8915,1.3545 -10.621,3.9775 -14.835,4.47917c8.43517,-5.58283 12.60617,-10.44183 16.1895,-15.83833c1.2255,-1.84183 -0.30817,-3.71233 -2.17867,-2.82367z"></path>
                                        </g>
                                    </g>
                                    </svg></a>
                                </div>
                            </div>
                            <div class="flex pt-2  text-sm text-gray-400">
                                <div class="flex-1 inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z">
                                    </path>
                                </svg>
                                <p class="">Es mala paga</p>
                                </div>
                                <div class="flex-1 inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
                                </svg>
                                <p class=""></p>
                                </div>
                                <a href="#" class="flex-no-shrink bg-green-400 hover:bg-green-500 px-5 ml-4 py-2 text-xs  hover:shadow-lg font-medium  border-2 border-green-300 hover:border-green-500 text-white rounded-full transition ease-in duration-300">Detalle</a>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                     

                
                <div class="grid grid-cols-1 lg:grid-cols-2 p-4 gap-4">
                    <div class="relative flex flex-col min-w-0 mb-4 lg:mb-0 break-words bg-gray-50 dark:bg-gray-800 w-full shadow-lg rounded">
                    <div class="rounded-t mb-0 px-0 border-0">
                        <div class="flex flex-wrap items-center px-4 py-2">
                            <div class="relative w-full max-w-full flex-grow flex-1">
                                <h3 class="font-semibold text-base text-gray-900 dark:text-gray-50">Ultimos Creditos</h3>
                            </div>
                            <div class="relative w-full max-w-full flex-grow flex-1 text-right">
                                <button v-on:click="openAllSolicitud(cliente.CLIE_ID)" class="bg-blue-500 dark:bg-gray-100 text-white active:bg-blue-600 dark:text-gray-800 dark:active:text-gray-700 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">Ver todos
                                </button>
                            </div>
                        </div>
                        <div class="w-full overflow-x-auto">
                            <table class="items-center w-full bg-transparent border-collapse">
                                <thead>
                                    <tr>
                                        <th class="pl-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">Aprobado / Vence</th>
                                        <th class="pl-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"><span>Estado</span></th>
                                        <th class="pl-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left min-w-140-px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(c, index) in creditos" :key="index" v-on:click="detalleCredito(c.SOLI_ID)" class="text-gray-700 hover:bg-green-200 dark:text-gray-100">
                                        <th class="border-t-0  pl-4 align-middle border-l-0 border-r-0 text-xs  p-4 text-left">
                                            
                                            {{  c.SOLI_FECHAAPROB }} <br> {{  c.SOLI_FECHAVENCIMIENTO }}
                                        </th>
                                        <td class="border-t-0 pl-4 align-middle border-l-0 border-r-0 text-xs   p-4"> <fw-badge :color="controller.estadoSolicitud[c.SOLI_ESTADO].color ">
                                                {{ controller.estadoSolicitud[c.SOLI_ESTADO].text }}
                                            </fw-badge> 
                                        </td>
                                        <td class="border-t-0 pl-4 align-middle border-l-0 border-r-0 text-xs  p-4">
                                            <div class="flex items-center">
                                            <span class="mr-2">${{ c.SOLI_MONTO}}</span>
                                                <div class="relative w-full">
                                                    <div class="overflow-hidden h-2 text-xs flex rounded bg-blue-200">
                                                        <div style="width: 30%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-600"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td> 
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- ./Social Traffic -->

                <!-- Recent Activities -->
                <div class="relative flex flex-col min-w-0 break-words bg-gray-50 dark:bg-gray-800 w-full shadow-lg rounded">
                    <div class="rounded-t mb-0 px-0 border-0">
                        <div class="flex flex-wrap items-center px-4 py-2">
                            <div class="relative w-full max-w-full flex-grow flex-1">
                                <h3 class="font-semibold text-base text-gray-900 dark:text-gray-50">Pagos recientes</h3>
                            </div>
                            <div class="relative w-full max-w-full flex-grow flex-1 text-right">
                                <button class="bg-blue-500 dark:bg-gray-100 text-white active:bg-blue-600 dark:text-gray-800 dark:active:text-gray-700 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">Ver todos</button>
                            </div>
                        </div>
                    <div class="block w-full">
                        <div class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                        Fecha
                        </div>
                        <ul class="my-1">
                            <li class="flex px-4">
                                <div class="w-9 h-9 rounded-full flex-shrink-0 bg-indigo-500 my-2 mr-3">
                                <svg class="w-9 h-9 fill-current text-indigo-50" viewBox="0 0 36 36"><path d="M18 10c-4.4 0-8 3.1-8 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7zm4 10.8v2.3L18.9 22H18c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8z"></path></svg>
                                </div>
                                <div class="flex-grow flex items-center border-b border-gray-100 dark:border-gray-400 text-sm text-gray-600 dark:text-gray-100 py-2">
                                <div class="flex-grow flex justify-between items-center">
                                    <div class="self-center">
                                    <a class="font-medium text-gray-800 hover:text-gray-900 dark:text-gray-50 dark:hover:text-gray-100" href="#0" style="outline: none;">{{ cliente.CLIE_NOMBRE }}</a> pago a <a class="font-medium text-gray-800 dark:text-gray-50 dark:hover:text-gray-100" href="#0" style="outline: none;">sucursal de sonsonate</a> Monto: ${{ cliente.CLIE_MONTO }}
                                    </div>
                                    <div class="flex-shrink-0 ml-2">
                                    <a class="flex items-center font-medium text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-500" href="#0" style="outline: none;">
                                        ver<span><svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" class="transform transition-transform duration-500 ease-in-out"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></span>
                                    </a>
                                    </div>
                                </div>
                                </div>
                            </li> 
                        </ul>
                        <div class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                        refenrencias
                        </div>
                        <ul class="my-1">
                        <li class="flex px-4">
                            <div class="w-9 h-9 rounded-full flex-shrink-0 bg-green-500 my-2 mr-3">
                            <svg class="w-9 h-9 fill-current text-light-blue-50" viewBox="0 0 36 36"><path d="M23 11v2.085c-2.841.401-4.41 2.462-5.8 4.315-1.449 1.932-2.7 3.6-5.2 3.6h-1v2h1c3.5 0 5.253-2.338 6.8-4.4 1.449-1.932 2.7-3.6 5.2-3.6h3l-4-4zM15.406 16.455c.066-.087.125-.162.194-.254.314-.419.656-.872 1.033-1.33C15.475 13.802 14.038 13 12 13h-1v2h1c1.471 0 2.505.586 3.406 1.455zM24 21c-1.471 0-2.505-.586-3.406-1.455-.066.087-.125.162-.194.254-.316.422-.656.873-1.028 1.328.959.878 2.108 1.573 3.628 1.788V25l4-4h-3z"></path></svg>
                            </div>
                            <div class="flex-grow flex items-center border-gray-100 text-sm text-gray-600 dark:text-gray-50 py-2">
                            <div class="flex-grow flex justify-between items-center">
                                <div class="self-center">
                                <a class="font-medium text-gray-800 hover:text-gray-900 dark:text-gray-50 dark:hover:text-gray-100" href="#0" style="outline: none;">2+</a> Las referencias del cliente <a class="font-medium text-gray-800 dark:text-gray-50 dark:hover:text-gray-100" href="#0" style="outline: none;">{{ cliente.CLIE_NOMBRE }} </a>
                                </div>
                                <div class="flex-shrink-0 ml-2">
                                <a class="flex items-center font-medium text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-500" href="#0" style="outline: none;">
                                    Ver <span><svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" class="transform transition-transform duration-500 ease-in-out"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></span>
                                </a>
                                </div>
                            </div>
                            </div>
                        </li>
                        </ul>
                    </div>
                    </div>
                </div>
                <!-- ./Recent Activities -->
            </div>





                 
                </div>
            </div>
        </div>    
    </navigation-layout>

    <fw-modal :show="showDetalleCredito"
        v-on:close="showDetalleCredito = false">
        <template #header>
            <header class="flex items-center">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="mr-2 shrink-0 w-6 h-6 text-gray-500"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          stroke-width="2"
          stroke="currentColor"
          fill="none"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
          <path d="M4 19l16 0"></path>
          <path d="M4 15l4 -6l4 2l4 -5l4 4"></path>
        </svg>
        <h3 class="font-medium text-lg mr-3">Detelle Creditos</h3> 
        <fw-badge :color="controller.estadoSolicitud[solicitud.SOLI_ESTADO ?? 0].color">
            {{ controller.estadoSolicitud[solicitud.SOLI_ESTADO ?? 0].text}}
        </fw-badge>
      </header>
        </template>
        <template #body>
            <!-- component --> 
            
            <div class="flex items-center justify-center  bg-gray-100">
                <section class="w-full p-6 max-w-2xl shadow-gray-300 bg-white">
                    <section class="grid grid-cols-2 gap-x-6">
                        <div class="flex items-center py-3">
                            <span class="w-8 h-8 shrink-0 mr-4 rounded-full bg-green-50 flex items-center justify-center">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-green-500"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M13 4m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    <path d="M7 21l3 -4"></path>
                                    <path d="M16 21l-2 -4l-3 -3l1 -6"></path>
                                    <path d="M6 12l2 -3l4 -1l3 3l3 1"></path>
                                </svg>
                            </span>
                            <div class="space-y-3 flex-1">
                                <div class="flex items-center">
                                    <h4 class="font-medium text-sm mr-auto text-gray-700 flex items-center">
                                        Aprobado 
                                    </h4>
                                    <span class="px-2 py-1 rounded-lg bg-red-50 text-red-500 text-xs">
                                        {{ solicitud.SOLI_FECHAAPROB }}
                                    </span>
                                </div> 
                            </div>
                        </div>
                        <div class="flex items-center py-3">
                            <span class="w-8 h-8 shrink-0 mr-4 rounded-full bg-green-50 flex items-center justify-center">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-green-500"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    >
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M13 4m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                <path d="M7 21l3 -4"></path>
                                <path d="M16 21l-2 -4l-3 -3l1 -6"></path>
                                <path d="M6 12l2 -3l4 -1l3 3l3 1"></path>
                                </svg>
                            </span>
                            <div class="space-y-3 flex-1">
                                <div class="flex items-center">
                                <h4
                                    class="font-medium text-sm mr-auto text-gray-700 flex items-center"
                                >
                                    Fecha Vencimiento
                                </h4>
                                <span class="px-2 py-1 rounded-lg bg-red-50 text-red-500 text-xs">
                                    {{ solicitud.SOLI_FECHAVENCIMIENTO }}
                                </span>
                                </div> 
                            </div>
                        </div>
                        <div class="flex items-center py-3 border-t border-gray-100">
                            <span
                                class="w-8 h-8 shrink-0 mr-4 rounded-full bg-green-50 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-green-500"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3 21h18"></path>
                                    <path d="M19 21v-4"></path>
                                    <path
                                        d="M19 17a2 2 0 0 0 2 -2v-2a2 2 0 1 0 -4 0v2a2 2 0 0 0 2 2z"
                                    ></path>
                                    <path d="M14 21v-14a3 3 0 0 0 -3 -3h-4a3 3 0 0 0 -3 3v14"></path>
                                    <path d="M9 17v4"></path>
                                    <path d="M8 13h2"></path>
                                    <path d="M8 9h2"></path>
                                </svg>
                            </span>
                            <div class="space-y-3 flex-1">
                                <div class="flex items-center">
                                    <h4 class="font-medium text-sm mr-auto text-gray-700 flex items-center">
                                        Monto Aprobado 
                                    </h4>
                                    <span class="px-2 py-1 rounded-lg bg-green-50 text-green-700 text-xs">
                                        ${{ solicitud.SOLI_MONTO }}
                                    </span>
                                </div> 
                            </div>
                        </div>
                        <div class="flex items-center py-3 border-t border-gray-100">
                            <span
                                class="w-8 h-8 shrink-0 mr-4 rounded-full bg-green-50 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-green-500"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M6.331 8h11.339a2 2 0 0 1 1.977 2.304l-1.255 8.152a3 3 0 0 1 -2.966 2.544h-6.852a3 3 0 0 1 -2.965 -2.544l-1.255 -8.152a2 2 0 0 1 1.977 -2.304z"
                                    ></path>
                                    <path d="M9 11v-5a3 3 0 0 1 6 0v5"></path>
                                </svg>
                            </span>
                            <div class="space-y-3 flex-1">
                                <div class="flex items-center">
                                    <h4 class="font-medium text-sm mr-auto text-gray-700 flex items-center">
                                        Valor por Cuotas 
                                    </h4>
                                    <span class="px-2 py-1 rounded-lg bg-red-50 text-red-500 text-xs">
                                        ${{ cuota }}
                                    </span>
                                </div> 
                            </div>
                        </div>
                        <div class="flex items-center py-3 border-t border-gray-100">
                            <span class="w-8 h-8 shrink-0 mr-4 rounded-full bg-green-50 flex items-center justify-center">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h5- w-5 text-green-500"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 13l-2 -2"></path>
                                    <path d="M12 12l2 -2"></path>
                                    <path d="M12 21v-13"></path>
                                    <path
                                        d="M9.824 16a3 3 0 0 1 -2.743 -3.69a3 3 0 0 1 .304 -4.833a3 3 0 0 1 4.615 -3.707a3 3 0 0 1 4.614 3.707a3 3 0 0 1 .305 4.833a3 3 0 0 1 -2.919 3.695h-4z"
                                    ></path>
                                </svg>
                            </span>
                            <div class="space-y-3 flex-1">
                                <div class="flex items-center">
                                    <h4 class="font-medium text-sm mr-auto text-gray-700 flex items-center">
                                        Plazo
                                    </h4>
                                    <span class="px-2 py-1 rounded-lg bg-green-50 text-green-700 text-xs">
                                        {{ solicitud.plazo ? solicitud.plazo.PLAZ_NOMBRE : 0 }}
                                    </span>
                                </div>
                                <div class="overflow-hidden bg-green-50 h-1.5 rounded-full w-full">
                                    <span
                                        class="h-full bg-green-500 w-full block rounded-full"
                                        style="width: 80%"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center py-3 border-t border-gray-100">
                            <span class="w-8 h-8 shrink-0 mr-4 rounded-full bg-green-50 flex items-center justify-center">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-green-500"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M6 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                    <path d="M18 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                    <path
                                        d="M4 17h-2v-11a1 1 0 0 1 1 -1h14a5 7 0 0 1 5 7v5h-2m-4 0h-8"
                                    ></path>
                                    <path d="M16 5l1.5 7l4.5 0"></path>
                                    <path d="M2 10l15 0"></path>
                                    <path d="M7 5l0 5"></path>
                                    <path d="M12 5l0 5"></path>
                                </svg>
                            </span>
                            <div class="space-y-3 flex-1">
                                <div class="flex items-center">
                                <h4 class="font-medium text-sm mr-auto text-gray-700 flex items-center">
                                    Cuotas Pendientes 
                                </h4>
                                <span class="px-2 py-1 rounded-lg bg-green-50 text-green-700 text-xs">
                                    {{ cuotasPendientes }}
                                </span>
                                </div>
                                <div class="overflow-hidden bg-green-50 h-1.5 rounded-full w-full">
                                    <span
                                        class="h-full bg-green-500 w-full block rounded-full"
                                        style="width: 80%"
                                    ></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center py-3 border-t border-gray-100">
                            <span
                                class="w-8 h-8 shrink-0 mr-4 rounded-full bg-green-50 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-green-500"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M6.331 8h11.339a2 2 0 0 1 1.977 2.304l-1.255 8.152a3 3 0 0 1 -2.966 2.544h-6.852a3 3 0 0 1 -2.965 -2.544l-1.255 -8.152a2 2 0 0 1 1.977 -2.304z"
                                    ></path>
                                    <path d="M9 11v-5a3 3 0 0 1 6 0v5"></path>
                                </svg>
                            </span>
                            <div class="space-y-3 flex-1">
                                <div class="flex items-center">
                                <h4 class="font-medium text-sm mr-auto text-gray-700 flex items-center">
                                    Taza de Interes 
                                </h4>
                                <span class="px-2 py-1 rounded-lg bg-green-50 text-green-700 text-xs">
                                    {{ solicitud.tasa_interes ? solicitud.tasa_interes.TASA_VALOR : 0 }}%
                                </span>
                                </div> 
                            </div>
                        </div>
                        <div class="flex items-center py-3 border-t border-gray-100">
                            <span
                                class="w-8 h-8 shrink-0 mr-4 rounded-full bg-green-50 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-green-500"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3 21h18"></path>
                                    <path d="M19 21v-4"></path>
                                    <path
                                        d="M19 17a2 2 0 0 0 2 -2v-2a2 2 0 1 0 -4 0v2a2 2 0 0 0 2 2z"
                                    ></path>
                                    <path d="M14 21v-14a3 3 0 0 0 -3 -3h-4a3 3 0 0 0 -3 3v14"></path>
                                    <path d="M9 17v4"></path>
                                    <path d="M8 13h2"></path>
                                    <path d="M8 9h2"></path>
                                </svg>
                            </span>
                            <div class="space-y-3 flex-1">
                                <div class="flex items-center">
                                <h4 class="font-medium text-sm mr-auto text-gray-700 flex items-center">
                                    Monto Total 
                                </h4>
                                <span class="px-2 py-1 rounded-lg bg-green-50 text-green-700 text-xs">
                                    $ {{ solicitud.SOLI_MONTO+ (solicitud.SOLI_MONTO * ( parseInt(solicitud.tasa_interes ? solicitud.tasa_interes.TASA_VALOR : 0) / 100 )) }}
                                </span>
                                </div> 
                            </div>
                        </div>
                    </section>
                </section>
            </div>

            <fw-skeleton :show="cuotas == null"></fw-skeleton>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">  
                <table v-if="cuotas != null" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Fecha a Pagar
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Mora - Dias
                            </th>
                            <th scope="col" class="px-6 py-3">
                                No. Cuota
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Monto
                            </th> 
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(c, index) in cuotas" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ c.CUOT_FECHAPAGO }}
                            </th>
                            <td class="px-6 py-4">
                                {{ c.DIAS_MORA == 0 ? '---' : c.DIAS_MORA + ' dias' }}  
                            </td>
                            <td class="px-6 py-4">
                                {{ c.CUOT_NUMERO }}  
                            </td> 
                            <td class="px-6 py-4">
                                <fw-badge :color="cuotaService.estadoCuota[c.CUOT_ESTADO].color">
                                    {{ cuotaService.estadoCuota[c.CUOT_ESTADO].text }}
                                </fw-badge>
                            </td>
                            <td class="px-6 py-4">
                                ${{ c.CUOT_MONTO }}
                            </td>  
                        </tr>    
                    </tbody>
                </table>
            </div> 
        </template>
    </fw-modal>

    <fw-modal :show="showAllSolicitud" 
        v-on:close="showAllSolicitud  = false"
        maxWidth="lg">

        <template #header>
            <div class="flex items-center justify-between mb-4">
                <h5 class="font-bold leading-none text-gray-900 dark:text-white">Historial de Creditos</h5> 
            </div>
        </template>

        <template #body>  
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Aprobado
                            </th>
                            <th scope="col" class="py-3">
                                <div class="flex items-center">
                                    Estado 
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    Vencimiento 
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    Monto 
                                </div>
                            </th> 
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(s,index) in allSolicitudes" class="bg-white hover:bg-green-200 border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ s.SOLI_FECHAAPROB }}
                            </th>
                            <td class="py-4">
                                <fw-badge :color="controller.estadoSolicitud[s.SOLI_ESTADO].color">
                                    {{ controller.estadoSolicitud[s.SOLI_ESTADO].text }}
                                </fw-badge>
                            </td>
                            <td class="px-6 py-4">
                                {{  s.SOLI_FECHAVENCIMIENTO }}
                            </td>
                            <td class="px-6 py-4">
                                ${{ s.SOLI_MONTO }}
                            </td> 
                        </tr> 
                    </tbody>
                </table>
            </div> 
        </template>  
    </fw-modal>
   
</template>
