<script setup>
import { defineProps, ref } from 'vue';
import ModuloContableLayout from './Partials/ModuloContableLayout.vue';
import {FwButton, PlusIcon, FwTable, 
    FwCheckbox, FwModal, FwInput, FwSelect, FwRadioCheckbox } from '../../Components/flowbite/index.js';
import { useForm } from '@inertiajs/vue3';
import CuentaSucursal from './Partials/CuentaSucursal.js';

const props = defineProps({
    cuentasSucursales: Array,
    cuentaBancos:Array,
    order:Array
})

const form = useForm({
    ...CuentaSucursal, 
    numero_cuenta: null,
    resumen: ref(true),
    detalle: ref(false),
});

console.log(props.order);

const isShowModal = ref(false);

const openModal = () => {
    form.reset();
    isShowModal.value = true;
    
}

</script>

<template lang="">
    <modulo-contable-layout> 
        <template #opctions> 
            <fw-button v-on:click="openModal" dtype="button">
                <plus-icon class="w-4 h-4 me-2"/>
                Nueva Cuenta
            </fw-button>
        </template>

        <template #content> 
            <fw-table>

                <template #head>
                    <th class="py-3 px-6 text-left">Código</th>
                    <th class="py-3 px-6 text-left">Descripción</th>
                    <th class="py-3 px-6 text-left">Tipo</th>
                    <th class="py-3 px-6 text-left">Estado</th>
                    <th class="py-3 px-6 text-left">Acciones</th>
                </template>

                <template #body>
                    <tr v-for="(cuenta, index) in cuentasSucursales" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4 text-center">{{ index }}</td>
                        <th scope="row">
                            <div class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{cuenta }}
                                <div class="text-gray-400">
                                    asdasdasdsd
                                </div>
                            </div>
                        </th>
                        <th scope="row">
                            <div class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">nomnbreasd
                                <div class="text-gray-400">
                                    asdasdasdsd
                                </div>
                            </div>
                        </th>
                        <td class="px-6 py-4"> 
                            <fw-checkbox checked/>
                        </td>
                        <td class="px-6 py-4">
                            <button href="#" class="font-medium text-green-600 dark:text-green-500 hover:underline">Editar</button>
                            <a href="#" class="px-3 font-medium text-green-600 dark:text-green-500 hover:underline">Ver</a>
                        </td>
                    </tr>  
                </template> 
            </fw-table>
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
                        <fw-input label="Cod. Cuenta Contable"
                            v-model:value="form.numero_cuenta"
                            placeholder="110101..."/>
                    </div>
                    <div class="col-span-2 sm:col-span-1"> 
                        <fw-select label="Pertence a"
                            v-model:selected="form.CUEN_CONTA"
                            defaultItem="Seleccione un codigo" >
                            <option v-for="(cuenta, index) in cuentasSucursales" 
                                :value="cuenta.CUEN_ID">{{ cuenta.CUEN_CONTA }}</option> 
                        </fw-select>
                    </div>
                    <div class="col-span-2">
                        <fw-select label="Cuenta de Bancos"
                            v-model:selected="form.CUEN_NOMBRE"
                            defaultItem="Seleccione una cuenta"
                            placeholder="Cuenta Banco"> 
                            <option v-for="(cuentaBanco, index) in cuentaBancos" 
                                :value="cuentaBanco.CUEB_NUMERO">
                                {{ cuentaBanco.banco.BANC_NOMBRE }}
                            </option>
                        </fw-select>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <fw-select label="Tipo de Cuenta"
                            v-model:selected="form.CUEN_TIPO"
                            defaultItem="Seleccione una opcion"> 
                            <option value="1">Activo</option>
                            <option value="1">Pasivo</option>
                            <option value="1">Patrimonio</option>
                            <option value="1">Costos/Gastos</option>
                            <option value="1">Ingresos</option>
                            <option value="1">Liquidadoras</option>
                        </fw-select>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <fw-input label="Saldo Inicial"
                            v-model:value="form.CUEN_SALDO" 
                            placeholder="...."/>
                    </div>
                    <div class="col-span-2">
                        <fw-select label="Sucursal"
                            v-model:selected="form.SUCU_ID"
                            defaultItem="Seleccione una opcion"> 
                            <option v-for="(cuenta, index) in cuentasSucursales" :value="cuenta.CUEN_ID">{{ cuenta.CUEN_NOMBRE }}</option>
                        </fw-select>
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
                        <fw-select label="Clasificacion"
                            v-model:selected="form.CUEN_TIPO"
                            defaultItem="Seleccione una opcion"> 
                            <option value="1">Deudor</option>
                            <option value="1">Acreedor</option> 
                        </fw-select>
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
