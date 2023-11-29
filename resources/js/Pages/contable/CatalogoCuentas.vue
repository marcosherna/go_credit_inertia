<script setup>
import { defineProps, ref } from 'vue';
import ModuloContableLayout from './Partials/ModuloContableLayout.vue';
import {FwButton, PlusIcon, FwTable, 
    FwCheckbox, FwModal, FwInput, FwSelect, FwRadioCheckbox } from '../../Components/flowbite/index.js';
import { useForm } from '@inertiajs/vue3';
import controller from './Partials/CuentaSucursal.js';

const props = defineProps({
    cuentasSucursales: Array,
    cuentaBancos:Array,
    order:Array
})


const activos = props.cuentasSucursales.filter(x => x.CUEN_CUENTA == 1);
const pasivos = props.cuentasSucursales.filter(x => x.CUEN_CUENTA == 2);
const patrimonio = props.cuentasSucursales.filter(x => x.CUEN_CUENTA == 3);
const costos = props.cuentasSucursales.filter(x => x.CUEN_CUENTA == 4);
const ingresos = props.cuentasSucursales.filter(x => x.CUEN_CUENTA == 5);
const liquidadoras = props.cuentasSucursales.filter(x => x.CUEN_CUENTA == 6);

const cuentaContables = [
    activos,
    pasivos,
    patrimonio,
    costos,
    ingresos,
    liquidadoras
]; 

let sucursales = [];
let numeros_contables = [];

const form = useForm({
    ...controller.model,  
    resumen: ref(true),
    detalle: ref(false),
    caja:false, 
    generales:true
});
 

const isShowModal = ref(false);

const openModal = () => {
    sucursales = props.cuentasSucursales;
    numeros_contables = props.cuentasSucursales;
    form.reset();
    isShowModal.value = true;  
}

const filterCuentasContables = (selected)=>{ 
    const acreedores = [1,4,6];
    const deudor = [2,3,5]; 
    sucursales = props.cuentasSucursales; 
    if(selected != 0){   
        sucursales = props.cuentasSucursales.filter(
            x => x.CUEN_CUENTA == selected
        ); 
        form.SUCU_ID = 0
    } 
    if(acreedores.includes(selected)){
        form.CUEN_CLASIF = 'Acreedor';
    }
    if(deudor.includes(selected)){
        form.CUEN_CLASIF = 'Deudor';
    }
}

const assingNumeroContable = (item)=>{ 
    form.CUEN_CONTA = controller.numeroContable( sucursales, item); 
}

const submit = ()=>{  
    form.CUEN_NOMBRE = sucursales.find(x => x.CUEN_ID == form.SUCU_ID).CUEN_NOMBRE;
    form.CUEN_CONTA = numeros_contables.find(x => x.CUEN_ID == form.CUEN_CONTA).CUEN_CONTA; 
}

</script>

<template>
    <modulo-contable-layout> 
        <template #opctions> 
            <fw-button v-on:click="openModal" type="button">
                <plus-icon class="w-4 h-4 me-2"/>
                Nueva Cuenta
            </fw-button>
        </template>

        <template #content> 

            <div class="flex items-end flex-col min-w-full p-3">
                <h2 class="text-slate-800 pb-4">
                    Cuentas Contables
                </h2>

                <div id="accordion-collapse" data-accordion="collapse" class="min-w-full">
                    <div v-for="(cuenta, index) in cuentaContables" >
                        <h2 id="accordion-collapse-heading-1">
                            <button type="button" 
                                class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" 
                                :data-accordion-target="`#accordion-collapse-body-${ index+1 }`" 
                                :aria-expanded=" index == 0 ? 'true' : 'false' " 
                                :aria-controls="`accordion-collapse-body-${ index+1 }`">
                                
                                <span>Cuenta Contable de : {{  controller.tipos[index].text }}</span>
                                <svg data-accordion-icon class="animate-bounce w-3 h-3 rotate-180 shrink-0" 
                                    aria-hidden="true" 
                                    xmlns="http://www.w3.org/2000/svg" 
                                    fill="none" 
                                    viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                </svg>
                            </button>
                        </h2>
                        <div :id="`accordion-collapse-body-${index+1}`" 
                            class="hidden" 
                            :aria-labelledby="`accordion-collapse-heading-${index+1}`">

                            <div v-for="(subCuenta, subIndex) in cuentaContables[index]" 
                                class=" p-2 px-5 border border-b-0 
                                border-gray-200 
                                dark:border-gray-700 
                                dark:bg-gray-900
                                flex flex-row justify-between m-1">
                                <div class="">
                                    <div class="flex pb-2">
                                        <p class="text-gray-900 font-bold pr-5" >{{ subCuenta.CUEN_NOMBRE }}</p>
                                        <span class="bg-green-100 text-green-800 
                                            text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">{{ subCuenta.CUEN_CONTA }}</span>
                                    </div>
                                    <div class="text-gray-500 text-xs">
                                        <p class="text-gray-800 pb-1">Saldo: {{ subCuenta.CUEN_SALDO }}</p>
                                        <p>{{ (new Date(subCuenta.CUEN_FECHA)).toDateString()  +' ' + subCuenta.sucursal.SUCU_NOMBRE }}</p>
                                    </div>
                                </div>
                                <div>
                                    <button :id="`dropdownMenuIconButton${subIndex}}`" 
                                        :data-dropdown-toggle="`dropdownDots${subIndex}`" 
                                        class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" 
                                        type="button">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                                        </svg>
                                    </button>
                                    <!-- Dropdown menu -->
                                    <div :id="`dropdownDots${subIndex}`" 
                                        class="z-10 hidden bg-white divide-y 
                                        divide-gray-100 rounded-lg shadow w-44 
                                        dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" :aria-labelledby="`dropdownMenuIconButton${subIndex}`">
                                            <li>
                                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                                            </li>
                                            <li>
                                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                                            </li>
                                            <li>
                                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                                            </li>
                                        </ul>
                                        <div class="py-2">
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Separated link</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>  
                </div>
            </div>
 
        </template> 
    </modulo-contable-layout>

    <fw-modal :show="isShowModal" 
        maxWidth="lg"
        @close="isShowModal = false"> 

        <template #header>
            <h3 class="text-lg font-semibold
                text-gray-900 dark:text-white">
                Nueva Cuenta
            </h3> 
        </template>

        <template #body>
            <form @submit.prevent="submit" class="p-4 md:p-5"> 
                <div class="grid gap-4 mb-4 grid-cols-2">

                    <div class="col-span-2 sm:col-span-1">
                        <fw-select label="Tipo de Cuenta" 
                            v-model:selected="form.CUEN_TIPO"
                            :onUpdate:selected="filterCuentasContables"
                            defaultItem="Seleccione una opcion"> 
                            <option value="1">Activo</option>
                            <option value="2">Pasivo</option>
                            <option value="3">Patrimonio</option>
                            <option value="4">Costos/Gastos</option>
                            <option value="5">Ingresos</option>
                            <option value="6">Liquidadoras</option>
                        </fw-select>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <fw-input label="Saldo Inicial"
                            :disabled="true"    
                            v-model:value="form.CUEN_SALDO" 
                            placeholder="...."/>
                    </div>
                    <div class="col-span-2">
                        <fw-select label="Cuenta"
                            v-model:selected="form.SUCU_ID"
                            :onUpdate:selected="assingNumeroContable"
                            defaultItem="Seleccione una opcion">  

                            <option v-for="x in sucursales"    
                                :value="x.CUEN_ID">
                                <span class="text-green-600 font-bold">{{ x.CUEN_CONTA }}</span>
                                {{ ' ---- ' +x.CUEN_NOMBRE + ' '+x.sucursal.SUCU_NOMBRE }}
                            </option>
                        </fw-select>
                    </div>

                    <div class="col-span-2">
                        <fw-input label="Nombre de la Cuenta contable"
                            v-model:value="form.numero_cuenta"
                            placeholder="Cuenta..."/>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <fw-input label="Cod. Cuenta Contable"
                            v-model:value="form.CUEN_CONTA"
                            placeholder="110101..."/>
                    </div>
                    <div class="col-span-2 sm:col-span-1"> 
                        <div class="col-span-2 sm:col-span-1">
                            <label for="name" class="block mb-2 
                                text-sm font-medium text-gray-900 
                                dark:text-white">Tipo</label>

                            <ul class="items-center w-full text-sm font-medium 
                                text-gray-900 bg-white border border-gray-200 
                                rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <fw-radio-checkbox
                                        v-model:checked="form.generales"
                                        v-on:click="form.caja = false"
                                        label="Generales"/>
                                </li>
                                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <fw-radio-checkbox
                                        v-model:checked="form.caja"
                                        v-on:click="form.generales = false" 
                                        label="Caja"/>
                                </li>
                            </ul>
                        </div>
                    </div> 
                    
                    <div class="col-span-2 sm:col-span-1">
                        <label for="name" class="block mb-2 
                            text-sm font-medium text-gray-900 
                            dark:text-white">Modo</label>

                        <ul class="items-center w-full text-sm font-medium 
                            text-gray-900 bg-white border border-gray-200 
                            rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <fw-radio-checkbox
                                    v-model:checked="form.detalle"
                                    v-on:click="form.resumen = false"
                                    label="Resumen"/>
                            </li>
                            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                <fw-radio-checkbox
                                    v-model:checked="form.resumen"
                                    v-on:click="form.detalle = false" 
                                    label="Detalle"/>
                            </li>
                        </ul>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <fw-input label="Clasificacion"
                            :disabled="true"    
                            v-model:value="form.CUEN_CLASIF" 
                            placeholder="..."/>
                    </div> 
                </div> 
                <div class="flex flex-row w-full justify-between">
                    <fw-checkbox label="Estado" 
                            :checked="form.CUEN_ESTADO" 
                            @update:checked="event => form.CUEN_ESTADO = event"/>
                    <fw-button type="submit">Guardar</fw-button>
                </div>
            </form>
        </template>

    </fw-modal>

</template>
