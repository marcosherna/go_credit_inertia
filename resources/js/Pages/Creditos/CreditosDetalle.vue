<script setup>
import NavigationLayout from '@/Layouts/NavigationLayout.vue';
import {
    FwBadge, FwModal, FwSkeleton, FwInput, FwSelect,
    FwTextArea, FwAlert
} from '../../Components/flowbite';
import { defineProps, ref, onMounted } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { SpinnerBars } from '../../Components/spinners/index'
import { CModal } from './partials/index';

import {
    solicitudService,
    resourseService as resourse,
    referenciasService
} from '../../Services/index'

import { ElMessage, ElLoading } from 'element-plus';

const props = defineProps({
    cliente: Object,
})

const form = useForm({
    ...solicitudService.model,
})
 


const loading = ref(false);
const modal = ref(false);
const alert = ref(false);
const disabledOptionReferencia = ref(false);
const disabledOptionGarantia = ref(false);
const isEdit = ref(false);

const tiposCreditos = ref([]);
const garantias = ref([]);
const plazos = ref([]);
const formasPago = ref([]);
const tasaInteres = ref([]);
const tipoInteres = ref([]);

const referencias = ref([]); 

onMounted(async () => {
    try {
        loading.value = true;
        const [/*_clientes,  */_garantias, _tiposCreditos, _plazos, _formasPago, _tasaInteres, _tipoInteres] = await Promise.all([
            /*resourse.getComboClientes(),
            
            */resourse.getGarantias(),
            resourse.getTipoCreditos(),
            resourse.getPlazos(),
            resourse.getFormasPago(),
            resourse.getTasaInteres(),
            resourse.getTipoInteres(),
        ]);
        /**/
        garantias.value = _garantias;
        tiposCreditos.value = _tiposCreditos;
        plazos.value = _plazos;
        formasPago.value = _formasPago;
        tasaInteres.value = _tasaInteres;
        tipoInteres.value = _tipoInteres; 
    } catch (error) {
        ElMessage({
            showClose: true,
            message: error.message,
            type: 'error'
        })
    } finally {
        loading.value = false;
    }
});


const postSolicitud = () => {
    try {

        ElLoading.service({ fullscreen: true, text: 'Generando solicitud...', background: 'rgba(0, 0, 0, 0.8)' });
        form.transform(data => ({
            ...data,
            CLIE_ID: props.cliente.CLIE_ID,
            SOLI_FECHA: new Date().toLocaleDateString(),
            SOLI_ESTADO: 0,
            SOLI_DISPERSAR: data.SOLI_DISPERSAR ? 1 : 0,
            SOLI_OMITIRDOM: data.SOLI_OMITIRDOM ? 1 : 0,
            SOLI_TIPOTASA: 0,
            SOLI_FECHAVENCIMIENTO: resourse.calcularPlazo(plazos.value.find(p => p.PLAZ_ID === data.PLAZ_ID).PLAZ_NOMBRE, true),
            SOLI_CATEGORIA: props.cliente.CLIE_CATEGORIA,
        })).post(route('solicitud.store'), {
            onSuccess: async (data) => {
                alert.value = true;
            },
            onError: (error) => {
                ElMessage({
                    showClose: true,
                    message: new Error(error).message,
                    type: 'error'
                })
            },
            onFinish: () => {
                ElLoading.service().close();
            }
        })
    } catch (error) {
        ElMessage({
            showClose: true,
            message: error.message,
            type: 'error'
        })
        ElLoading.service().close();
    }
}


const post = async () => {
    try {
        solicitudService.validation(form);
        const model = solicitudService.formToModel(form);
        model.CLIE_ID = props.cliente.CLIE_ID;
        model.SOLI_FECHA = new Date().toLocaleDateString();
        model.SOLI_ESTADO = 0;
        model.SOLI_DISPERSAR = model.SOLI_DISPERSAR ? 1 : 0;
        model.SOLI_OMITIRDOM = model.SOLI_OMITIRDOM ? 1 : 0;
        model.SOLI_TIPOTASA = 0;
        model.SOLI_FECHAVENCIMIENTO = resourse.calcularPlazo(plazos.value.find(p => p.PLAZ_ID === form.PLAZ_ID).PLAZ_NOMBRE, true);
        model.SOLI_CATEGORIA = props.cliente.CLIE_CATEGORIA;

        console.log(model)

        ElLoading.service({ fullscreen: true, text: 'Generando solicitud...', background: 'rgba(0, 0, 0, 0.8)' });
        const _solicitud = await solicitudService.create(model);
        form.SOLI_ID = _solicitud.SOLI_ID;
        alert.value = true;
        ElLoading.service().close();

    } catch (error) {
        if (error.response) {
            form.errors = error.response.data.errors
            console.log(error.response)
            ElLoading.service().close();
        }
        if (error instanceof Error) {

            ElMessage({
                showClose: true,
                message: error.message,
                type: 'error'
            })

            ElLoading.service().close();
            return;
        }

    }

}


const onClick = () => {
    try {
        solicitudService.validation(form);
        if (!isEdit.value) {
            const garantia = garantias.value.find(g => g.GARA_ID === form.GARA_ID);
            if (garantia.GARA_ID === '002') {
                modal.value = true;
                disabledOptionReferencia.value = false;
                disabledOptionGarantia.value = true;
                return;
            }


            if (garantia.GARA_ID === '003') { // prendaria
                modal.value = true;
                disabledOptionReferencia.value = true;
                disabledOptionGarantia.value = false;
                return;
            }

            if (garantia.GARA_ID === '005') { // finduciaria y prendaria
                modal.value = true;
                disabledOptionReferencia.value = false;
                disabledOptionGarantia.value = false;
                return;
            }
            post()
            return;
        }
    } catch (error) {
        ElMessage({
            showClose: true,
            message: error.message,
            type: 'error'
        })
    }
}


const onEdit = async () => {  
    try {
        solicitudService.validation(form);  
        const model = solicitudService.formToModel(form);
        model.CLIE_ID = props.cliente.CLIE_ID;
        model.SOLI_FECHA = new Date().toLocaleDateString();
        model.SOLI_ESTADO = 0;
        model.SOLI_DISPERSAR = model.SOLI_DISPERSAR ? 1 : 0;
        model.SOLI_OMITIRDOM = model.SOLI_OMITIRDOM ? 1 : 0;
        model.SOLI_TIPOTASA = 0;
        model.SOLI_FECHAVENCIMIENTO = resourse.calcularPlazo(plazos.value.find(p => p.PLAZ_ID === form.PLAZ_ID).PLAZ_NOMBRE, true);
        model.SOLI_CATEGORIA = props.cliente.CLIE_CATEGORIA; 
        ElLoading.service({ fullscreen: true, text: 'Generando solicitud...', background: 'rgba(0, 0, 0, 0.8)' }); 
        const _solicitud = await solicitudService.edit(model);
        console.log(_solicitud)  
        ElLoading.service().close();

    } catch (error) {
        if (error.response) {
            form.errors = error.response.data.errors
            console.log(error.response)
            ElLoading.service().close();
        }
        if (error instanceof Error) {

            ElMessage({
                showClose: true,
                message: error.message,
                type: 'error'
            })

            ElLoading.service().close();
            return;
        }
    }

}


const onSave = async (data) => { 
    await post();

    if(data.referencias.length > 0){
        data.referencias.map(r => {
            r.SOLI_ID = form.SOLI_ID;
        }) 
        console.log(data.referencias)
    }

    alert.value = true;
    modal.value = false;
    
}

const onConfirm = async () => {
    try {
        ElLoading.service({ fullscreen: true, text: 'Generando solicitud...', background: 'rgba(0, 0, 0, 0.8)' });
        const response = await solicitudService.changedStatus(form.SOLI_ID, 0); // 0 - Creado
        if (response.SOLI_ESTADO != form.SOLI_ESTADO) {
            ElMessage({
                showClose: true,
                message: 'Solicitud generada con exito',
                type: 'success'
            })
            form.reset();
        }
        alert.value = false;
        ElLoading.service().close();
    } catch (error) {
        console.log(error)
        ElMessage({
            showClose: true,
            message: error.message,
            type: 'error'
        })
        ElLoading.service().close();
    }

}

</script>

<template lang=""> 
    <navigation-layout title="Nuevo Credito"> 
        <!-- component -->
        <div class="px-12  mx-auto">  
            <div>
                <div class="flex items-center gap-x-3">
                    <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ cliente.NOMBRE }}</h2>

                    <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">Creditos</span>
                </div>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300"> 
                    {{ `${cliente.DIRECCION.PAIS},${cliente.DIRECCION.DEPARTAMENTO},${cliente.DIRECCION.MUNICIPIO} ${cliente.DIRECCION.LUGAR}`}}
                </p>
            </div>

            <fw-alert
                :show="alert"
                title="Importante"
                message="Porfavor confirme los datos antes de generar la solicitud"  
                :titleAction = "[ 'Editar', 'Confimar']"
                v-on:onClose="onConfirm"
                v-on:onAction="onEdit"
                class="mt-4"
            />

            <div class="border border-gray-200 dark:border-gray-700 md:rounded-lg p-4 px-4 mt-4 md:p-8 mb-6">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600"> 
                                    <!-- component -->
                                    <!-- This is an example component -->
                                    <div class="relative"> 

                                        <div class="flex"> 
                                            <div class="flex h-auto">  
                                                <div class="w-full relative" >  
                                                    <div class="flex w-full justify-between px-1 text-center items-center">
                                                        <div class="p-2 flex">
                                                            <div class="py-3 cursor-pointer text-sm text-gray-600  font-normal antialiased tracking-normal">
                                                                CATEGORIA 
                                                            </div>
                                                            <div class="flex  ">  
                                                                <div class="cursor-pointer ml-1 text-2xl text-gray-600  font-normal antialiased tracking-normal"> 
                                                                    <fw-badge
                                                                        :color="cliente.CLIE_CATEGORIA === 'A' ? 'green' : cliente.CLIE_CATEGORIA === 'B' ? 'yellow' : 'red'"
                                                                        textSize="text-lg"> 
                                                                    {{ cliente.CLIE_CATEGORIA}}
                                                                    </fw-badge>
                                                                </div>
                                                            </div>

                                                            <div class="py-3 cursor-pointer text-sm text-gray-600  font-normal antialiased tracking-normal">
                                                                SCORE 
                                                            </div>
                                                            <div class="flex  ">  
                                                                <div class="cursor-pointer ml-1 text-2xl text-gray-600  font-normal antialiased tracking-normal"> 
                                                                    <fw-badge 
                                                                        textSize="text-lg"
                                                                        color="blue"> 
                                                                    {{ cliente.CLIE_SCORE}}
                                                                    </fw-badge>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="flex mr-6"> 
                                                            <div class="p-2 rounded ml-2 hover:bg-blue-100 text-gray-700">
                                                                <svg class="h-5 w-5 " xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M15 13.442c-.633 0-1.204.246-1.637.642l-5.938-3.463c.046-.188.075-.384.075-.584s-.029-.395-.075-.583L13.3 6.025A2.48 2.48 0 0015 6.7c1.379 0 2.5-1.121 2.5-2.5S16.379 1.7 15 1.7s-2.5 1.121-2.5 2.5c0 .2.029.396.075.583L6.7 8.212A2.485 2.485 0 005 7.537c-1.379 0-2.5 1.121-2.5 2.5s1.121 2.5 2.5 2.5a2.48 2.48 0 001.7-.675l5.938 3.463a2.339 2.339 0 00-.067.546A2.428 2.428 0 1015 13.442z"/>
                                                                </svg>
                                                            </div>
                                                            <div class="p-2 rounded ml-2 hover:bg-blue-100 text-gray-700">
                                                                <svg class="h-5 w-5 " xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10.001 7.8a2.2 2.2 0 100 4.402A2.2 2.2 0 0010 7.8zm-7 0a2.2 2.2 0 100 4.402A2.2 2.2 0 003 7.8zm14 0a2.2 2.2 0 100 4.402A2.2 2.2 0 0017 7.8z"/>
                                                                </svg>
                                                            </div>
                                                        </div> -->
                                                        
                                                    </div>
                                                        <div class="flex overflow-auto">
                                                        <div class="mr-10" >
                                                            <!--
                                                            <div class="w-full px-2 hover:bg-blue-100 py-2 text-2xl font-semibold">
                                                                {{ `Score / ${cliente.CLIE_SCORE}`  }}
                                                            </div> -->
                                                            <div class="flex mt-1">   
                                                                <!--<div  class="flex py-1 px-3 mr-2 cursor-pointer bg-gray-200 hover:bg-gray-300 rounded">
                                                                    <svg class="h-5 w-5 text-gray-700" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.602 19.8c-1.293 0-2.504-.555-3.378-1.44-1.695-1.716-2.167-4.711.209-7.116l9.748-9.87c.988-1 2.245-1.387 3.448-1.06 1.183.32 2.151 1.301 2.468 2.498.322 1.22-.059 2.493-1.046 3.493l-9.323 9.44c-.532.539-1.134.858-1.738.922-.599.064-1.17-.13-1.57-.535-.724-.736-.828-2.117.378-3.337l6.548-6.63c.269-.272.705-.272.974 0s.269.714 0 .986l-6.549 6.631c-.566.572-.618 1.119-.377 1.364.106.106.266.155.451.134.283-.029.606-.216.909-.521l9.323-9.439c.64-.648.885-1.41.69-2.145a2.162 2.162 0 00-1.493-1.513c-.726-.197-1.48.052-2.12.7l-9.748 9.87c-1.816 1.839-1.381 3.956-.209 5.143 1.173 1.187 3.262 1.629 5.079-.212l9.748-9.87a.683.683 0 01.974 0 .704.704 0 010 .987L9.25 18.15c-1.149 1.162-2.436 1.65-3.648 1.65z"/></svg>
                                                                    <div  class="ml-2 text-sm text-gray-700  font-normal antialiased tracking-normal">
                                                                        Hitorial
                                                                    </div>
                                                                </div> 

                                                                
                                                                <div class="flex py-1 px-3 mr-1 cursor-pointer bg-gray-200 hover:bg-gray-300 rounded">
                                                                    <svg class="h-5 w-5 text-gray-700" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.859 14.691l-.81.805a1.814 1.814 0 01-2.545 0 1.762 1.762 0 010-2.504l2.98-2.955c.617-.613 1.779-1.515 2.626-.675a.992.992 0 101.397-1.407c-1.438-1.428-3.566-1.164-5.419.675l-2.98 2.956A3.719 3.719 0 002 14.244a3.72 3.72 0 001.108 2.658c.736.73 1.702 1.096 2.669 1.096s1.934-.365 2.669-1.096l.811-.805a.988.988 0 00.005-1.4.995.995 0 00-1.403-.006zm9.032-11.484c-1.547-1.534-3.709-1.617-5.139-.197l-1.009 1.002a.99.99 0 101.396 1.406l1.01-1.001c.74-.736 1.711-.431 2.346.197.336.335.522.779.522 1.252s-.186.917-.522 1.251l-3.18 3.154c-1.454 1.441-2.136.766-2.427.477a.99.99 0 10-1.396 1.406c.668.662 1.43.99 2.228.99.977 0 2.01-.492 2.993-1.467l3.18-3.153A3.732 3.732 0 0018 5.866a3.726 3.726 0 00-1.109-2.659z"/></svg>
                                                                    <div class="ml-2 text-sm text-gray-700  font-normal antialiased tracking-normal">
                                                                        Referencias
                                                                    </div>
                                                                </div> -->
                                                            </div>
                                                            <div class="items-center py-1 mt-5 mb-1 text-sm font-medium text-gray-800">
                                                                Direccion
                                                            </div>
                                                            <div class="flex-col p-2 rounded hover:bg-gray-200">
                                                                <div class="flex">
                                                                    <div class="h-5 w-5">
                                                                        <svg class="h-5 w-5 text-gray-600" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.8 10a2.2 2.2 0 004.4 0 2.2 2.2 0 00-4.4 0z"/></svg>
                                                                    </div>
                                                                    <div class="text-sm ml-1 text-gray-800 antialiased tracking-normal font-normal ">
                                                                        {{  `${cliente.DIRECCION.PAIS},${cliente.DIRECCION.DEPARTAMENTO},${cliente.DIRECCION.MUNICIPIO} ${cliente.DIRECCION.LUGAR}`}}
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                            <div class="items-center py-1 mt-5 text-sm font-medium text-gray-800">
                                                                Telefonos
                                                            </div>
                                                            <div class="flex-col p-2 rounded hover:bg-gray-200">
                                                                <div  class="flex">
                                                                    <div class="h-5 w-5">
                                                                        <svg class="h-5 w-5 text-gray-600" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.8 10a2.2 2.2 0 004.4 0 2.2 2.2 0 00-4.4 0z"/></svg>
                                                                    </div>
                                                                    <div v-for="(t, index) in cliente.TELEFONOS" class="text-sm ml-1 text-gray-800 antialiased tracking-normal font-normal ">
                                                                        {{ index == 0 ? '': ',' }} {{ t }} 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="items-center py-1 mt-5 text-sm font-medium text-gray-800">
                                                                Documentos
                                                            </div> 
                                                            <div class="flex-col p-2 rounded hover:bg-gray-200">
                                                                <div  class="flex">
                                                                    <div class="h-5 w-5">
                                                                        <svg class="h-5 w-5 text-gray-600" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.8 10a2.2 2.2 0 004.4 0 2.2 2.2 0 00-4.4 0z"/></svg>
                                                                    </div>
                                                                    <div v-for="(doc, i) in cliente.DOCUMENTOS"  class="text-sm ml-1 text-gray-800 antialiased tracking-normal font-normal ">   
                                                                        {{ `${doc}`  }}
                                                                    </div>
                                                                </div>
                                                            </div> 

                                                            <!-- component --> 
                                                            <div class="items-center py-1 mt-5 text-sm font-medium text-gray-800">
                                                                Informacion Laboral
                                                            </div> 
                                                            <div class="flex-col p-2 rounded hover:bg-gray-200">
                                                                <div   class="flex">
                                                                    <div class="h-5 w-5">
                                                                        <svg class="h-5 w-5 text-gray-600" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.8 10a2.2 2.2 0 004.4 0 2.2 2.2 0 00-4.4 0z"/></svg>
                                                                    </div>
                                                                    <div  class="text-sm ml-1 text-gray-800 antialiased tracking-normal font-normal ">
                                                                        {{ cliente.INFORMACIONLABORAL.TRABAJO }}
                                                                    </div>
                                                                </div>
                                                                <div class="flex">
                                                                    <div class="h-5 w-5">
                                                                        <svg class="h-5 w-5 text-gray-600" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.8 10a2.2 2.2 0 004.4 0 2.2 2.2 0 00-4.4 0z"/></svg>
                                                                    </div>
                                                                    <div  class="text-sm ml-1 text-gray-800 antialiased tracking-normal font-normal ">
                                                                        Ingresos: ${{ cliente.INFORMACIONLABORAL.INGRESOS }}
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="flex">
                                                                    <div class="h-5 w-5">
                                                                        <svg class="h-5 w-5 text-gray-600" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.8 10a2.2 2.2 0 004.4 0 2.2 2.2 0 00-4.4 0z"/></svg>
                                                                    </div>
                                                                    <div  class="text-sm ml-1 text-gray-800 antialiased tracking-normal font-normal ">
                                                                        Tel: ${{ cliente.INFORMACIONLABORAL.TRABAJOTEL }}
                                                                    </div> 
                                                                </div>
                                                            </div> 

                                                            <div v-if="cliente.INGRESO_ADICIONAL" class="items-center py-1 mt-5 text-sm font-medium text-gray-800">
                                                                Ingresos Adicionales
                                                            </div> 
                                                            <div v-if="cliente.INGRESO_ADICIONAL" class="flex-col p-2 rounded hover:bg-gray-200">
                                                                 
                                                                <div class="flex">
                                                                    <div class="h-5 w-5">
                                                                        <svg class="h-5 w-5 text-gray-600" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.8 10a2.2 2.2 0 004.4 0 2.2 2.2 0 00-4.4 0z"/></svg>
                                                                    </div>
                                                                    <div  class="text-sm ml-1 text-gray-800 antialiased tracking-normal font-normal ">
                                                                        Origen: {{ cliente.INGRESO_ADICIONAL.ORIGEN }}
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="items-center py-1 mt-5 text-sm font-medium text-gray-800">
                                                                Referencias
                                                            </div> 
                                                            <div class="md:h-full sm:pb-4 flex pt-4 flex-col">
                                                                     
                                                                     <div class="overflow-auto shadow bg-white"> 
                                                                        <table class="min-w-full  divide-y divide-gray-200  dark:divide-gray-700">
                                                                             <thead class="bg-gray-100 dark:bg-gray-700">
                                                                                 <tr> 
                                                                                     <th scope="col" class="py-3 px-6 text-xs  text-left text-gray-700 uppercase dark:text-gray-400">
                                                                                         Detalle
                                                                                     </th>
                                                                                     <th scope="col" class="py-3 px-6 text-xs font-medium   text-left text-gray-700 uppercase dark:text-gray-400">
                                                                                         Telefono
                                                                                     </th> 
                                                                                 </tr>
                                                                             </thead>
                                                                         <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                                                             <tr v-for="(r, index) in cliente.REFERENCIAS" class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                                                                  
                                                                                 <td class="py-4 px-6 text-sm font-medium text-gray-900 dark:text-white">{{ r.NOMBRE }}</td>
                                                                                 <td class="py-4 px-6 text-sm font-medium text-gray-500   dark:text-white">{{ r.TELEFONO }}</td> 
                                                                             </tr>  
                                                                         </tbody>
                                                                     </table>
 
                                                                     </div>
                                                                 </div>
                                                                
                                                            </div> 
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                            </div>

                        <div class="lg:col-span-2 md:pl-4"> 

                            <div v-if="loading" class="h-full flex justify-center items-center">
                                <spinner-bars/>
                            </div>
                            <div v-if="!loading" class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">  
                                <div class="md:col-span-2">
                                    <fw-select label="Tipo Credito"
                                        v-model:selected="form.TIPO_ID"
                                        defaultItem="Seleccione una opcion"> 

                                        <option v-for="(tp, index) in tiposCreditos" 
                                            :value="tp.TIPO_ID"> {{ tp.TIPO_NOMBRE }}</option>
                                    </fw-select> 

                                    <div v-show="form.errors.TIPO_ID" class="text-red-500 text-sm">
                                        {{  form.errors.TIPO_ID }}
                                    </div>
                                </div>   

                                <div class="md:col-span-5"> 
                                </div>

                                <div class="md:col-span-1">
                                    <fw-input label="Monto"
                                        v-model:value="form.SOLI_MONTO" 
                                        placeholder="" /> 
                                        <div v-show="form.errors.SOLI_MONTO" class="text-red-500 text-sm">
                                            {{  form.errors.SOLI_MONTO }}
                                        </div>
                                    
                                </div>

                                <div class="md:col-span-2">

                                    <fw-select label="Forma Pago"
                                            v-model:selected="form.FORM_ID"
                                            defaultItem="Seleccione una opcion"> 

                                            <option v-for="(f, index) in formasPago" 
                                                :value="f.FORM_ID"> {{ f.FORM_NOMBRE }}</option>
                                        </fw-select> 

                                        <div v-show="form.errors.FORM_ID" class="text-red-500 text-sm">
                                            {{  form.errors.FORM_ID }}
                                        </div>
                                    
                                </div>

                                <div class="md:col-span-2">  
                                        <fw-select label="Plazos"
                                            v-model:selected="form.PLAZ_ID"
                                            defaultItem="Seleccione una cuenta"> 
                                            <option v-for="(p, index) in plazos" 
                                                :value="p.PLAZ_ID"> {{ p.PLAZ_NOMBRE }}</option>
                                        </fw-select>
                                        <div v-show="form.errors.PLAZ_ID" class="text-red-500 text-sm">
                                            {{  form.errors.PLAZ_ID }}
                                        </div> 
                                </div>

                                <div class="md:col-span-2">
                                    <fw-select label="Tipos tasa interes"
                                        v-model:selected="form.TIPT_ID"
                                        defaultItem="Seleccione una opcion"> 

                                        <option v-for="(x, index) in tipoInteres" 
                                            :value="x.TIPO_ID"> {{ x.TIPO_NOMBRE }}</option>
                                    </fw-select> 

                                    <div v-show="form.errors.TIPT_ID" class="text-red-500 text-sm">
                                        {{  form.errors.TIPT_ID }}
                                    </div>
                                </div>

                                <div class="md:col-span-1"> 
                                    <fw-select label="Tasa Interes"
                                                v-model:selected="form.TASA_ID"
                                                defaultItem="Seleccione una cuenta"> 
                                                <option v-for="(tI, index) in tasaInteres" 
                                                    :value="tI.TASA_ID"> {{ tI.TASA_VALOR }}</option>
                                            </fw-select> 
                                        <div v-show="form.errors.TASA_ID" class="text-red-500 text-sm">
                                            {{  form.errors.TASA_ID }}
                                        </div> 
                                </div>

                                <div class="md:col-span-2"> 
                                    <fw-select label="Garantias"
                                        v-model:selected="form.GARA_ID"
                                        defaultItem="Seleccione una cuenta"> 
                                        <option v-for="(g, index) in garantias" 
                                            :value="g.GARA_ID"> {{ g.GARA_NOMBRE }}</option>
                                    </fw-select>
                                    <div v-show="form.errors.GARA_ID" class="text-red-500 text-sm">
                                        {{  form.errors.GARA_ID }}
                                    </div> 
                                </div>

                                <div class="md:col-span-5">
                                    <fw-input label="Condiciones"
                                        v-model:value="form.SOLI_CONDICIONES" 
                                        placeholder="" /> 
                                        <div v-show="form.errors.SOLI_CONDICIONES" class="text-red-500 text-sm">
                                        {{  form.errors.SOLI_CONDICIONES }}
                                    </div>
                                </div> 

                                <div class="md:col-span-1">
                                    <div class="inline-flex items-center pr-4">
                                        <el-checkbox v-model="form.SOLI_OMITIRDOM" label="Omitir Domigos" /> 
                                    </div>
                                </div> 
                                <div class="md:col-span-1"> 
                                    <div class="inline-flex items-center">
                                        <el-checkbox :disabled="!form.SOLI_OMITIRDOM" v-model="form.SOLI_DISPERSAR" label="Dispersar domingo" /> 
                                    </div> 
                                </div>

                                <div class="md:col-span-5">
                                    <fw-text-area label="Observaciones Ejecutivo"
                                        v-model:value="form.SOLI_OBSERVACION" 
                                        placeholder="Observaciones..."> 
                                    </fw-text-area>
                                    <div v-show="form.errors.SOLI_OBSERVACION" class="text-red-500 text-sm">
                                        {{  form.errors.SOLI_OBSERVACION }}
                                    </div>
                                </div>
                                
 
                                <div class="md:col-span-5 text-right">
                                    <div class="inline-flex items-end">
                                        <button :disabled="alert" v-on:click="onClick" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Generar</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        </div>
                    </div>
                </div> 
    </navigation-layout>  

    <c-modal
        :show="modal"
        :disabledOptionReferencia="disabledOptionReferencia"
        :disabledOptionGarantia="disabledOptionGarantia"
        v-on:close="modal = false"
        v-on:onSave="onSave"
        maxWidth="xl"
    /> 
</template>
