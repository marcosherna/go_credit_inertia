<script setup> 
import NavigationLayout from '@/Layouts/NavigationLayout.vue'; 
import CTable from './partials/CTable.vue';
import CSearchBar from './partials/CSearchBar.vue';
import CDropDownStatus from './partials/CDropDownStatus.vue'; 
import CButtonExport from './partials/CButtonExport.vue';

import { resourseService as Resourse, 
    solicitudService as SolicitudServices } from '../../Services/index.js'; 
    
import {ref } from 'vue';
import { FwModal, FwInput, FwSelect, FwButton, FwTextArea, FwRadioCheckbox} from '../../Components/flowbite';

import { ElNotification, ElLoading, ElMessage } from 'element-plus'
import { useForm } from '@inertiajs/vue3'; 

const props = defineProps({ 
    response: { 
        type: Object,  
    }, 
    count: { 
        type: Number,  
    },
})

const form = useForm({
    ...SolicitudServices.model
})

const modal = ref(false);
const solicitudes = ref(props.response); 
const clientes = ref([]);
const tiposCreditos = ref([]); 
const garantias = ref([]);
const plazos = ref([]); 
const formasPago = ref([]); 
const tasaInteres = ref([]); 
const tipoInteres = ref([]); 

const dispensaDomingoNo = ref(true);
const dispensaDomingoSi = ref(false);

const omitirDomingoNo = ref(true);
const omitirDomingoSi = ref(false);


const filleterByStatus = async () => {
    try { 
        ElLoading.service({ fullscreen: true, text: 'Cargando...', background: 'rgba(0, 0, 0, 0.8)' }) 
        const response = await SolicitudServices.filleter(0) 
        solicitudes.value = response;
    } catch (error) {
        ElNotification({
            title: 'Error',
            message: error.message,
            type: 'error'
        })
    }
    finally {
        ElLoading.service().close();
    }
}


const newSolicitud =  async () => {
    ElLoading.service({ fullscreen: true, text: 'Cargando...', background: 'rgba(0, 0, 0, 0.8)' }) 
    
    try {
        const [_clientes, _tiposCreditos, _garantias, _plazos, _formasPago, _tasaInteres, _tipoInteres] = await Promise.all([
            Resourse.getComboClientes(),
            Resourse.getTipoCreditos(),
            Resourse.getGarantias(),
            Resourse.getPlazos(),
            Resourse.getFormasPago(),
            Resourse.getTasaInteres(),
            Resourse.getTipoInteres(),
        ]);
        clientes.value = _clientes;
        tiposCreditos.value = _tiposCreditos;
        garantias.value = _garantias;
        plazos.value = _plazos;
        formasPago.value = _formasPago;
        tasaInteres.value = _tasaInteres;
        tipoInteres.value = _tipoInteres; 
        modal.value = true;
    } catch (error) {
        console.log(error);
    }finally {
        ElLoading.service().close();
    }
}

const submit = async  () => {
    form.transform(data => ({
        ...data,
        SOLI_FECHA: new Date(),
        SOLI_ESTADO: 0, 
        SOLI_OMITIRDOM: omitirDomingoSi.value ? 1 : 0,
        SOLI_DISPERSAR: dispensaDomingoSi.value ? 1 : 0,
        SOLI_TIPOTASA: SolicitudServices.tipoTasa.find(x => x.text == data.SOLI_TIPOTASA).value,
    })).post(route('solicitud.store'), {
        onSuccess: () => {
            modal.value = false;
            ElNotification({
                title: 'Exito',
                message: 'Solicitud creada correctamente',
                type: 'success'
            })
        },
        onError: () => {
            ElNotification({
                title: 'Error',
                message: 'Error al crear la solicitud',
                type: 'error'
            })
        }
    })
}

const findAll = async () => {
    try { 
        ElLoading.service({ fullscreen: true, text: 'Cargando...', background: 'rgba(0, 0, 0, 0.8)' }) 
        //const response = await SolicitudServices.findAll()   
        const responce = await SolicitudServices.filleter(null)
        solicitudes.value = responce;
    } catch (error) { 
        ElMessage({
            showClose: true,
            message: error.message,
            type: 'error'
        }) 
    }
    finally {
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
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Solicitudes</h2>

                        <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{ count  }} Creditos</span>
                    </div>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">These companies have purchased in the last 12 months.</p>
                </div>

                <div class="flex items-center mt-4 gap-x-3">
                    
                    <!-- Button exportar -->
                    <c-button-export
                        :data="solicitudes.data"
                    />

                    <button v-on:click="newSolicitud" class="flex items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        <span>Nueva Solicitud</span>
                    </button>
                </div>
            </div> 
            <div class="mt-6 md:flex md:items-center md:justify-between">
                <div class="inline-flex overflow-hidden bg-white border divide-x rounded-lg dark:bg-gray-900 rtl:flex-row-reverse dark:border-gray-700 dark:divide-gray-700">
                    <button v-on:click="findAll" class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 bg-gray-100 sm:text-sm dark:bg-gray-800 dark:text-gray-300">
                        Todos
                    </button>

                    <!--<button  class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                        Monitored
                    </button> -->
                    <c-drop-down-status
                        :options="SolicitudServices.SolicitudEstado"
                        @responce="solicitudes = $event"
                        label="filtrar"/>  
                </div>

                 <c-search-bar 
                    placeholder="Buscar" 
                    @search="console.log" />
            </div>

            <!-- Table -->
            <c-table 
                :items="solicitudes"/> 

        </section>
    </Navigation-layout>


    <fw-modal :show="modal" 
            maxWidth="lg"
            @close="modal = false">
            <template #header>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Creditos
                </h3> 
            </template>
            <template #body>
                <div>
                    <form @submit.prevent="submit" class="p-4 md:p-5"> 
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <fw-select label="Clientes"
                                    v-model:selected="form.CLIE_ID"
                                    defaultItem="Seleccione una cuenta"> 
                                    <option v-for="(c, index) in clientes" 
                                        :value="c.CLIE_ID"> {{ c.NOMBRE }}</option>
                                </fw-select>
                                <div v-show="form.errors.CUEB_NUMERO" class="text-red-500 text-sm">
                                    {{  form.errors.CUEB_NUMERO }}
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">  
                                <!--min fecha actual-->
                                <fw-input label="Monto"
                                    v-model:value="form.SOLI_MONTO" 
                                    placeholder="" /> 
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <fw-select label="Tasa Interes"
                                    v-model:selected="form.TASA_ID"
                                    defaultItem="Seleccione una cuenta"> 
                                    <option v-for="(tI, index) in tasaInteres" 
                                        :value="tI.TASA_ID"> {{ tI.TASA_VALOR }}</option>
                                </fw-select>
                                <div v-show="form.errors.CUEB_NUMERO" class="text-red-500 text-sm">
                                    {{  form.errors.CUEB_NUMERO }}
                                </div>
                            </div>
                            <div class="col-span-2 sm:col-span-1"> 
                                <fw-select label="Plazos"
                                    v-model:selected="form.PLAZ_ID"
                                    defaultItem="Seleccione una cuenta"> 
                                    <option v-for="(p, index) in plazos" 
                                        :value="p.PLAZ_ID"> {{ p.PLAZ_NOMBRE }}</option>
                                </fw-select>
                                <div v-show="form.errors.CUEB_NUMERO" class="text-red-500 text-sm">
                                    {{  form.errors.CUEB_NUMERO }}
                                </div>

                            </div>
                            
                            <div class="col-span-2 sm:col-span-1">
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
                            <div class="col-span-2 sm:col-span-1"> 
                                <fw-select label="Tipos Creditos"
                                    v-model:selected="form.TIPO_ID"
                                    defaultItem="Seleccione una opcion"> 

                                    <option v-for="(tp, index) in tiposCreditos" 
                                        :value="tp.TIPO_ID"> {{ tp.TIPO_NOMBRE }}</option>
                                </fw-select> 

                                <div v-show="form.errors.TIPO_ID" class="text-red-500 text-sm">
                                    {{  form.errors.TIPO_ID }}
                                </div>
                            </div>  

                            <div class="col-span-2 sm:col-span-1"> 
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

                            <div class="col-span-2 sm:col-span-1"> 
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
                            <div class="col-span-2 sm:col-span-1">
                                <fw-select label="Categorias"
                                    v-model:selected="form.SOLI_CATEGORIA"
                                    defaultItem="Seleccione una opcion"> 

                                    <option v-for="(c, index) in solicitudServices.categorias" 
                                        :value="c.text"> {{ c.text }}</option>
                                </fw-select> 

                                <div v-show="form.errors.SOLI_CATEGORIA" class="text-red-500 text-sm">
                                    {{  form.errors.SOLI_CATEGORIA }}
                                </div> 
 
                            </div>

                            <div class="col-span-2 sm:col-span-1">  
                                <!--min fecha actual-->
                                <fw-input label="Fecha Finalizacion"
                                    v-model:value="form.SOLI_FECHAVENCIMIENTO" 
                                    placeholder="Hasta"
                                    type="date"/> 
                            </div>


                            <div class="col-span-2 sm:col-span-1">
                                <fw-select label="Tipo Tasa"
                                    v-model:selected="form.SOLI_TIPOTASA"
                                    defaultItem="Seleccione una opcion"> 

                                    <option v-for="(c, index) in solicitudServices.tipoTasa" 
                                        :value="c.text"> {{ c.text }}</option>
                                </fw-select> 

                                <div v-show="form.errors.SOLI_TIPOTASA" class="text-red-500 text-sm">
                                    {{  form.errors.SOLI_TIPOTASA }}
                                </div> 
 
                            </div>


                            <div class="col-span-2 sm:col-span-1">
                                    <label for="name" class="block mb-2 
                                        text-sm font-medium text-gray-900 
                                        dark:text-white">Dispensar Domingos</label>

                                    <ul class="items-center w-full text-sm font-medium 
                                        text-gray-900 bg-white border border-gray-200 
                                        rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                            <fw-radio-checkbox
                                                v-model:checked="dispensaDomingoNo" 
                                                label="No"/>
                                        </li>
                                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                            <fw-radio-checkbox
                                                v-model:checked="dispensaDomingoSi" 
                                                label="Si"/>
                                        </li> 
                                    </ul>
                                </div> 

                                <div class="col-span-2 sm:col-span-1">
                                    <label for="name" class="block mb-2 
                                        text-sm font-medium text-gray-900 
                                        dark:text-white">Omitir Domingos</label>

                                    <ul class="items-center w-full text-sm font-medium 
                                        text-gray-900 bg-white border border-gray-200 
                                        rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                            <fw-radio-checkbox
                                                v-model:checked="omitirDomingoNo" 
                                                label="No"/>
                                        </li>
                                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                            <fw-radio-checkbox
                                                v-model:checked="omitirDomingoSi"
                                                label="Si"/>
                                        </li> 
                                    </ul>
                                </div> 


                            <div class="col-span-2">  
                                <!--min fecha actual-->
                                <fw-input label="Condiciones"
                                    v-model:value="form.SOLI_CONDICIONES" 
                                    placeholder="" /> 
                            </div>

                            <div class="col-span-2">
                                <fw-text-area label="Observaciones"
                                    v-model:value="form.SOLI_OBSERVACION" 
                                    placeholder="Observaciones..."> 
                                </fw-text-area>
                                <div v-show="form.errors.SOLI_OBSERVACION" class="text-red-500 text-sm">
                                    {{  form.errors.SOLI_OBSERVACION }}
                                </div>
                            </div> 
                        </div> 
                        
                        <div class="flex flex-row w-full justify-end">
                            <fw-button :disabled="form.processing" type="submit">Guardar</fw-button>
                        </div> 
                    </form>
                </div>
            </template> 
        </fw-modal> 
</template>
