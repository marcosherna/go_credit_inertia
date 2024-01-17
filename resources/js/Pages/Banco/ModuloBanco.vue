<script setup>
import { Link, Head, useForm, router } from '@inertiajs/vue3';
import { defineProps, ref, defineEmits } from 'vue';
import MyModal from '@Components/Modal.vue';
import ModuloBancoLayout from '@/Pages/Banco/Partials/ModuloBancoLayout.vue';

import {
    SearchBar, Table,
    ButtomToggleModal, PlusIcon,
    FwSkeleton, FwSearchBar
} from '@Components/flowbite'

import { CPagination } from '@Components/Customs';

const props = defineProps({
    paginate: Object,
    sucursales: Array,
})
 

const isShowModal = ref(false);
const loading = ref(false);
const lstBancos = ref(props.paginate.data);
lstBancos.value = props.paginate.data;



const banco = useForm({
    BANC_ID: null,
    BANC_NOMBRE: null,
    BANC_DETALLE: null,
    SUCU_ID: 0,
    BANC_ESTADO: true,
});

const selectedItem = (banco_selected) => {
    Object.assign(banco, banco_selected);
    banco.BANC_ESTADO = banco_selected.BANC_ESTADO == 1 ? true : false;
    isShowModal.value = true;
};

const submit = (e) => {
    if (banco.BANC_ID) {
        banco.transform((data) => ({
            ...data,
            BANC_ESTADO: banco.BANC_ESTADO ? 1 : 0,
        })).put(route('banco.update', banco.BANC_ID), {
            onSuccess: () => {
                banco.reset();
                isShowModal.value = false;
            },
        });
    } else {
        banco.transform((data) => ({
            BANC_NOMBRE: data.BANC_NOMBRE.toUpperCase(),
            BANC_DETALLE: data.BANC_DETALLE.toUpperCase(),
            SUCU_ID: data.SUCU_ID,
            BANC_ESTADO: banco.BANC_ESTADO ? 1 : 0,
        })).post(route('banco.store'), {
            onSuccess: () => {
                banco.reset();
                isShowModal.value = false;
            },

        });
    }
}

const onSearch = (text) => {
    lstBancos.value = props.bancos.filter((item) => {
        return item.BANC_ID.includes(text) ||
            item.BANC_NOMBRE.toUpperCase().includes(text.toUpperCase()) ||
            item.sucursal.SUCU_NOMBRE.toUpperCase().includes(text.toUpperCase());
    });

    if (text == '') {
        lstBancos.value = props.bancos;
    }
}

const changedStatus = (id) => {
    loading.value = true;

    banco.put('banco-status/' + id, {
        onSuccess: (data) => {
            lstBancos.value = data.props.bancos
            loading.value = false;
        },
        onFinish: () => {
            loading.value = false;
        },
    });
}


const openModal = () => {
    banco.reset();
    isShowModal.value = true;
}

</script> 


<template lang="">  
    <modulo-banco-layout title='Banco'> 
        <div class="flex flex-colum sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
            <div> 
                <ButtomToggleModal 
                    text="Nuevo Banco"  @click="openModal">
                    <PlusIcon/>
                </ButtomToggleModal>
            </div> 
            <div class="relative">  
                <fw-search-bar 
                    @search="onSearch"
                    placeholder="Buscar banco..."/>
            </div>
        </div> 
        <fw-skeleton :show="loading" />
        <Table v-if="!loading">
            <template #head>
                <th scope="col" class="p-4">ID</th> 
                <th scope="col" class="px-6 py-3">Banco</th>
                <th scope="col" class="px-6 py-3">Estado</th>  
                <th scope="col" class="px-6 py-3">Acciones</th> 
            </template>

            <template #body>  
                <tr v-for="(banco, index) in lstBancos" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-transform duration-500 ease-in-out hover:scale-x-105 hover:shadow-lg">
                    <td class="w-4 p-4 text-center">{{ banco.BANC_ID }}</td>
                    <th scope="row">
                        <div class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ banco.BANC_NOMBRE }}
                            <div class="text-gray-400">
                                {{ banco.sucursal.SUCU_NOMBRE }}
                            </div>
                        </div> 
                    
                    </th>
                    <td class="px-6 py-4">
                        <label class="relative inline-flex items-center mb-5 cursor-pointer">
                            <input type="checkbox" v-on:click="changedStatus(banco.BANC_ID)"  :checked="banco.BANC_ESTADO" value="" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                        </label>
                    </td> 
                    <td class="px-6 py-4">
                        <button 
                            href="#" 
                            @click="selectedItem(banco)"
                            class="font-medium text-green-600 dark:text-green-500 hover:underline">Editar</button>
                        <a href="#" class="px-3 font-medium text-green-600 dark:text-green-500 hover:underline">Ver</a>
                    </td>
                </tr> 
            </template> 
        </Table>

        <c-pagination :items="paginate"/>

    </modulo-banco-layout>
    
    <MyModal :show="isShowModal" 
        @close="isShowModal = false"
        maxWidth="sm">
        <div class="overflow-y-auto overflow-x-hidden justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"> 
            <div class="relative w-full max-w-md max-h-full"> 
                 <!-- Modal content --> 
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                         <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ banco.BANC_ID ? 'Actualizar': 'Nuevo' }} Banco 
                        </h3> 
                        <button @click="isShowModal = false"
                            type="button" 
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">

                                <svg class="w-3 h-3" 
                                    aria-hidden="true" 
                                    xmlns="http://www.w3.org/2000/svg" 
                                    fill="none" 
                                    viewBox="0 0 14 14">

                                    <path stroke="currentColor" 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round" 
                                        stroke-width="2" 
                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            <span class="sr-only">Cerrar Modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form @submit.prevent="submit" class="p-4 md:p-5">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">

                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>

                                <input type="text" name="name" id="name" v-model="banco.BANC_NOMBRE"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 focus:ring-green-500 focus:border-green-500"
                                    placeholder="Nombre..." required="">

                                <div v-if="banco.errors.BANC_NOMBRE" class="text-red-500 py-2">{{ banco.errors.BANC_NOMBRE }}
                                </div>
                            </div>

                            <div class="col-span-2">
                                <select id="category" v-model="banco.SUCU_ID"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                                    <option value="0" >Seleccione una Sucursal</option>
                                    <option v-for="(sucursal, index) in sucursales" :value="sucursal.SUCU_ID">{{ sucursal.SUCU_NOMBRE }}
                                    </option>
                                </select>

                                <div v-if="banco.errors.SUCU_ID" class="text-red-500 py-2">{{ banco.errors.SUCU_ID }}
                                </div>
                            </div>

                            <div class="col-span-2">
                                <label for="description"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripcion</label>
                                <textarea id="description" rows="3" v-model="banco.BANC_DETALLE"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                                    placeholder="Digite una descripcion breve...">
                                        </textarea>
                                <div v-if="banco.errors.BANC_DETALLE" class="text-red-500 py-2">{{ banco.errors.BANC_DETALLE }}
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label class="relative inline-flex items-center mb-5 cursor-pointer">
                                <input v-model="banco.BANC_ESTADO" type="checkbox" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                </div>
                                <span class="px-3">Estado</span>
                            </label>
                        </div>

                        <div class="flex flex-row w-full justify-end">
                            <button type="submit" :disabled="banco.processing"
                                class="text-white inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">

                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd">
                                    </path>
                                </svg>
                                Agregar
                            </button> 
                        </div>
                    </form>
                </div>
            </div>
        </div> 
    </MyModal>  
</template>


 