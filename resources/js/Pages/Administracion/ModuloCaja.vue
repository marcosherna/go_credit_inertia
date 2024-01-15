<script setup>
import ModuloCajaLayout from '@/Pages/Administracion/partials/ModuloCajaLayout.vue';
import {
    FwTable, FwBadge, FwButton, FwModal,
    FwInput, FwTextArea, FwSelect, FwRadioCheckbox,
    FwSearchBar, FwButtonDropdown
} from '@Components/flowbite/index';
import { CCardIndicator } from '@Components/Customs/index';
import { SpinnerBars } from '@Components/spinners/index.js';
import { aplicarPagoService } from '../../Services/index.js';
import { FolderOpened, DocumentAdd, ElemeFilled, 
    Ticket, Flag, Briefcase, Notification, DataLine, Wallet} from '@element-plus/icons-vue'
import { ref } from 'vue';
import { ElLoading, ElMessage } from 'element-plus';   

const modal = ref(false);
const loading = ref(false);
const loadingTable = ref(false);
const creditos = ref([]);
const txtSearch = ref('');
const CREDIT_ID = ref('');
const credito = ref(null);

const data = async () => {
    try {
        const response = await aplicarPagoService.allCreditos();
        creditos.value = response;
    } catch (error) {
        ElLoading.value = false
        ElMessage({
            showClose: true,
            message: 'Algo salio mal, intente nuevamente',
            type: 'error'

        })
    }
}

const handleModal = async () => {
    modal.value = !modal.value;
    loading.value = true;
    await data();
    loading.value = false;

};

const onSearch = async () => {
    try {
        if (txtSearch.value == '') {
            await data();
            return;
        };

        loading.value = true;
        const response = await aplicarPagoService.search(txtSearch.value);
        creditos.value = response;
        console.log(response);
        loading.value = false;

    } catch (error) {
        loading.value = false;
        ElMessage({
            showClose: true,
            message: 'Algo salio mal, intente nuevamente',
            type: 'error'
        })
    }
};

const getById = async (ID_CREDITO) => {
    try {
        loadingTable.value = true;
        const response = await aplicarPagoService.getById(ID_CREDITO);
        console.log(response);
        loadingTable.value = false;
    } catch (error) {
        loadingTable.value = false;
        ElMessage({
            showClose: true,
            message: 'Algo salio mal, intente nuevamente',
            type: 'error'
        })  
    }
}

const clickSearch = async () => {

    try {
        if(CREDIT_ID.value ==  '') throw new Error('Digite el Id del credito')
        if(!parseInt(CREDIT_ID.value)) throw new Error('El Id del credito debe ser un numero')

        await getById(CREDIT_ID.value);

    } catch (error) {
        loadingTable.value = false;
        ElMessage({
            showClose: true, 
            message : error.message ? error.message : 'Algo salio mal, intente nuevamente',
            type: 'error'
        })
    }
    console.log(CREDIT_ID.value);
}

const seleccionCredito = async (creditoSeleccionado) => {
    try {
        modal.value = false;
        loadingTable.value = true;
        const _credito = await aplicarPagoService.detealleCredito(creditoSeleccionado.SOLI_ID);
        credito.value = _credito;
        console.log(_credito);
        loadingTable.value = false;
    } catch (error) {
        modal.value = false;
        credito.value = null;
        loadingTable.value = false;
        ElMessage({
            showClose: true,
            message: 'Algo salio mal, intente nuevamente',
            type: 'error'
        })
    }
} 
</script>
<template> 
    <modulo-caja-layout>  

        <h2 class="pb-5">Pago de Creditos</h2>

        <div class="relative flex">
            <fw-search-bar v-model="CREDIT_ID" v-on:keyup.enter="clickSearch" 
                class="w-full" 
                placeholder="Buscar..." />
            <fw-button :disabled="!(CREDIT_ID.length > 0)" class="mx-2" type="button" v-on:click="clickSearch">
                Buscar
            </fw-button>
            <fw-button type="button" v-on:click="handleModal">
                <el-icon size="17">
                    <DocumentAdd />
                </el-icon>
            </fw-button>
        </div> 
        <el-empty v-if="!(credito != null) && !loadingTable" description="Selecciona un credito" />
        <spinner-bars class="flex justify-center items-center h-72" :show="loadingTable" />
        <div v-if="credito != null && !loadingTable" class="bg-gray-50 py-5"> 
            <div class="w-full ">
                <div class="md:flex items-start">
                    <div class="px-5 py-6 md:w-6/12 border border-gray-200 rounded-lg">

                        <!-- component --> 
                        <div class="bg-white ">   
                            <div class="p-4">
                                <p class="tracking-wide text-sm font-bold text-gray-700"> .CREDITO No. {{ credito.SOLI_ID }}</p>
                                <p class="text-3xl text-gray-900">${{ credito.SOLI_MONTO }}</p>
                                <p class="text-gray-700"> 
                                    No. {{ credito.CLIENTE.CLIE_ID }}
                                    {{ credito.CLIENTE.NOMBRE_COMPLETO }}</p>
                            </div>
                            <div class="flex p-4 border-t border-gray-300 text-gray-700">
                                <div class="flex-1 inline-flex items-center">
                                    <el-icon size="24">
                                        <Notification />
                                    </el-icon>
                                    <p><span class="pl-2 text-gray-900 font-bold">${{ +credito.MONTO_CUOTA.toFixed(2) }}</span> Cuota</p>
                                </div>
                                <div class="flex-1 inline-flex items-center">
                                    <el-icon size="22"><DataLine /></el-icon>
                                    <p><span class="pl-2 text-gray-900 font-bold">{{ credito.CANTIDAD_CUOTAS }}</span> Cuotas</p>
                                </div> 
                            </div>

                            <div class="flex p-4 border-t border-gray-300 text-gray-700">
                                <div class="flex-1 inline-flex items-center">
                                    <el-icon size="22"><Wallet /></el-icon>
                                    <p><span class="pl-2 text-gray-900 font-bold">Aprobado </span>{{ credito.SOLI_FECHAAPROB }}</p>
                                </div> 
                            </div>

                            
                            <div class="flex p-4 border-t border-gray-300 text-gray-700">
                                <div class="flex-1 inline-flex items-center">
                                    <el-icon size="24">
                                        <Notification />
                                    </el-icon>
                                    <p><span class="pl-2 text-gray-900 font-bold">15%</span> Interes</p>
                                </div>
                                <div class="flex-1 inline-flex items-center">
                                    <el-icon size="22"><DataLine /></el-icon>
                                    <p><span class="pl-2 text-gray-900 font-bold">${{ credito.MONTO_TOTAL }}</span> Total</p>
                                </div> 
                            </div>


                            <div class="px-4 pt-3 pb-4 border-t border-gray-300 bg-gray-100">
                                <div class="text-xs uppercase font-bold text-gray-600 tracking-wide">Aproba por</div>
                                <div class="flex items-center pt-2"> 
                                    <div>
                                        <p class="font-bold text-gray-900">{{ credito.EMPLEADO.NOMBRE_COMPLETO }}</p> 
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="px-3 md:w-6/12">
                        <div
                            class="w-full mx-auto rounded-lg bg-white border border-gray-200 text-gray-800 font-light mb-6">
                            <div class="w-full p-3 border-b border-gray-200">
                                <div>
                                    <div class="mb-3">
                                        <label class="text-gray-600 font-semibold text-sm mb-2 ml-1">Referencia</label>
                                        <div>
                                            <input
                                                class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors"
                                                placeholder="0000" type="text" />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-gray-600 font-semibold text-sm mb-2 ml-1">Cantidad a
                                            Abonar</label>
                                        <div>
                                            <input
                                                class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors"
                                                placeholder="00.00" type="text" />
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="text-gray-600 font-semibold text-sm mb-2 ml-1">Total recivido</label>
                                        <div>
                                            <input
                                                class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors"
                                                placeholder="0000" type="text" />
                                        </div>
                                    </div>

                                    <div class="mb-3 -mx-2 flex items-end">
                                        <div class="px-2 w-1/4">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="w-full p-3 text-right">
                                <fw-button>Aplicar Pago</fw-button>
                            </div>

                        </div>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </modulo-caja-layout>

    <fw-modal :show="modal" v-on:close="modal = false">
        <template #header>
            Buscar Creditos
        </template>

        <template #body>
            <div class="px-5">
                <div class="relative flex py-4">
                    <fw-search-bar v-model="txtSearch" v-on:keyup.enter="onSearch" class="w-full" placeholder="Buscar..." />
                    <fw-button class="ml-3" type="button">Buscar</fw-button>
                </div>
                <div class="overflow-x-auto mt-5 pb-4">

                    <spinner-bars :show="loading" />

                    <table v-if="!loading" class="table-auto w-full">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">ID</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">CLIENTE</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">DUI</div>
                                </th>

                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-center">Acciones</div>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="text-sm divide-y divide-gray-100">

                        <tr v-for="(c, index) in creditos">
                            <td class="p-2 whitespace-nowrap">
                                {{ c.SOLI_ID }}
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="flex flex-col justify-center">
                                    <div class="font-medium text-gray-800">{{ c.CLIENTE.NOMBRE }}</div>
                                    <div class="text-left">DUI: {{ c.CLIENTE.DUI }}</div>
                                </div>
                            </td>

                            <td class="p-2 whitespace-nowrap">
                                <div class="text-left font-medium text-green-500">${{ c.MONTO }}</div>
                            </td>
                            <td class="p-2 whitespace-nowrap text-center">

                                <el-tooltip class="box-item" effect="dark" content="Precione Para Seleccionar"
                                    placement="left">
                                    <el-icon size="17" v-on:click="seleccionCredito(c)">
                                        <FolderOpened />
                                    </el-icon>
                                </el-tooltip>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </template>
</fw-modal></template>