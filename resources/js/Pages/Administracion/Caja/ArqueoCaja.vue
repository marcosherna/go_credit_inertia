<script setup>
import ModuloCajaLayout from '@/Pages/Administracion/partials/ModuloCajaLayout.vue';
import { Calendar, Coin, Goods, ReadingLamp, Brush, Money } from '@element-plus/icons-vue';
import { FwTextArea, FwButton, FwInput } from '@Components/flowbite';
import { ElLoading, ElMessage } from 'element-plus';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue'

const form = useForm({
    concepto: '',
    monto: '',
    tipo: '',
    fecha: '',
    hora: '',
    usuario: '',
    estado: '',
    observaciones: '',
    id: '',
})


const procesar = async () => {
    try {
        ElLoading.service({ fullscreen: true, text: 'Procesando...', background: 'rgba(0, 0, 0, 0.7)' });
        setTimeout(() => {
            ElLoading.service().close();
            ElMessage({
                showClose: true,
                message: 'Procesado correctamente',
                type: 'success'
            })
        }, 2000);
    } catch (error) {
        ElLoading.service().close();
        ElMessage({
            showClose: true,
            message: error.message,
            type: 'error'
        })
    }
}

const billetes = [
    { model: 0, valor: 100, total: ref(0) },
    { model: 0, valor: 50, total: ref(0) },
    { model: 0, valor: 20, total: ref(0) },
    { model: 0, valor: 10, total: ref(0) },
    { model: 0, valor: 5, total: ref(0) },
    { model: 0, valor: 1, total: ref(0) }];

const monedas = [
    { model: 0, valor: 1, total: ref(0) },
    { model: 0, valor: 0.50, total: ref(0) },
    { model: 0, valor: 0.25, total: ref(0) },
    { model: 0, valor: 0.10, total: ref(0) },
    { model: 0, valor: 0.05, total: ref(0) },
    { model: 0, valor: 0.01, total: ref(0) }];

</script>
<template >
    <modulo-caja-layout>
        <div class="flex-grow sm:text-left rounded-lg text-center mt-6 px-4 py-5">
            <div class="flex">
                <div class="py-3 cursor-pointer text-sm text-gray-600  font-normal antialiased tracking-normal">
                    CIERRE DIARIO
                </div>
                <div class="flex ml-2 mt-3">
                    <div class="bg-red-500 mt-1 rounded h-4 w-4 p-1">
                        <svg class="h-2 w-2 text-white" fill="currentColor " xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a7 7 0 10.001 13.999A7 7 0 0010 3z" />
                        </svg>
                    </div>
                    <div class="cursor-pointer ml-1 text-sm text-gray-600  font-normal antialiased tracking-normal">
                        SONSONATE
                    </div>
                </div>
            </div>

            <div class="py-4">
                <div class="flex mt-1">
                    <div class="flex py-1 px-3 mr-2 cursor-pointer bg-gray-200 hover:bg-gray-300 rounded">
                        <el-icon>
                            <Calendar />
                        </el-icon>
                        <div class="ml-2 text-sm text-gray-700  font-normal antialiased tracking-normal">
                            {{ (new Date()).toLocaleDateString() }}
                        </div>
                    </div>

                    <div class="py-1 px-2 cursor-pointer bg-gray-200 hover:bg-gray-300 rounded">
                        <svg class="h-4 w-4 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.516 7.548c.436-.446 1.043-.481 1.576 0L10 11.295l3.908-3.747c.533-.481 1.141-.446 1.574 0 .436.445.408 1.197 0 1.615-.406.418-4.695 4.502-4.695 4.502a1.095 1.095 0 01-1.576 0S4.924 9.581 4.516 9.163c-.409-.418-.436-1.17 0-1.615z" />
                        </svg>
                    </div>
                </div>

            </div>
            <div class="md:flex  pb-3 text-gray-800 text-center">
                <div class="w-full md:w-1/2 flex">
                    <div class="w-1/2  ">
                        <el-icon size="20">
                            <Money />
                        </el-icon>
                        <h2 class="text-gray-500">Saldo Sistema</h2>
                        <p>$00.0</p>
                    </div>
                    <div class="w-1/2  ">
                        <el-icon size="20">
                            <Coin />
                        </el-icon>
                        <h2 class="text-gray-500">Saldo Contable</h2>
                        <p>$00.0</p>
                    </div>
                </div>
                <div class="w-full md:w-1/2 flex">
                    <div class="w-1/2  ">
                        <el-icon size="20">
                            <ReadingLamp />
                        </el-icon>
                        <h2 class="text-gray-500">Saldo Caja</h2>
                        <p>$00.00</p>
                    </div>
                    <div class="w-1/2 ">
                        <el-icon size="20">
                            <Brush />
                        </el-icon>
                        <h2 class="text-gray-500">Total TXNS</h2>
                        <p>0</p>
                    </div>
                </div>
            </div>

            <div class="md:flex text-gray-800 border-t-[1px] pt-3 text-center">
                <div class="w-full md:w-1/3 flex space-x-3">
                    <div class="w-full ">
                        <h2 class="text-gray-500">Total Ingresos</h2>
                        <p>$00.0</p>
                    </div>

                </div>
                <div class="w-full md:w-1/3 flex space-x-3">
                    <div class="w-full ">
                        <h2 class="text-gray-500">Total Egresos</h2>
                        <p>$00.0</p>
                    </div>
                </div>
                <div class="w-full md:w-1/3 flex space-x-3">
                    <div class="w-full  ">
                        <h2 class="text-gray-500">Faltante/Sobrante</h2>
                        <p>$00.00</p>
                    </div>
                </div>
            </div>
            <div class="items-center flex space-x-4 py-1 mt-5 text-sm font-medium text-gray-800">
                <fw-input label="" placeholder="Concepto" />
                <fw-button v-on:click="procesar">Procesar</fw-button>
            </div>

            <div class="md:flex text-gray-800 border-t-[1px] pt-3 text-center">
                <div class="w-full md:w-1/3 flex space-x-3">
                    <div class="w-full ">
                        <div class="w-full max-w-2xl mx-auto bg-white shadow-md rounded-sm border border-gray-200">
                            <header class="px-5 py-4 border-b border-gray-100">
                                <h2 class="font-semibold text-gray-800">BILLETES</h2>
                            </header>
                            <div class="p-3">
                                <div class="overflow-x-auto">
                                    <table class="table-auto w-full">
                                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                            <tr>
                                                <th class="p-2 whitespace-nowrap">
                                                    <div class="font-semibold text-left">DETALLE</div>
                                                </th>
                                                <th class="p-2 whitespace-nowrap">
                                                    <div class="font-semibold text-center">cantidad</div>
                                                </th>
                                                <th class="p-2 whitespace-nowrap">
                                                    <div class="font-semibold text-center">total</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-sm divide-y divide-gray-100">
                                            <tr v-for="(b, index) in billetes">
                                                <td class="p-2 whitespace-nowrap">
                                                    <div class="text-left">{{ `BILLETE ${b.valor}` }}</div>
                                                </td>
                                                <td class="whitespace-nowrap p-2">
                                                    <div class="text-lg text-center">
                                                        <input v-model="b.model" v-on:input="" type="number"
                                                            class="w-20 border text-gray-900 bg-gray-50 border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" />
                                                        <!--
                                        <input type="number" class="  w-12   text-sm   focus:border-primary-600 block   "/>-->
                                                    </div>

                                                </td>
                                                <td class="p-2 whitespace-nowrap">
                                                    <div class="text-lg text-center">{{ b.total }}</div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="w-full md:w-1/3 flex space-x-3">
                    <div class="w-full ">
                        <div class="w-full max-w-2xl mx-auto bg-white shadow-md rounded-sm border border-gray-200">
                            <header class="px-5 py-4 border-b border-gray-100">
                                <h2 class="font-semibold text-gray-800">MONEDAS</h2>
                            </header>
                            <div class="p-3">
                                <div class="overflow-x-auto">
                                    <table class="table-auto w-full">
                                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                            <tr>
                                                <th class="p-2 whitespace-nowrap">
                                                    <div class="font-semibold text-left">DETALLE</div>
                                                </th>
                                                <th class="p-2 whitespace-nowrap">
                                                    <div class="font-semibold text-center">cantidad</div>
                                                </th>
                                                <th class="p-2 whitespace-nowrap">
                                                    <div class="font-semibold text-center">total</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-sm divide-y divide-gray-100">
                                            <tr v-for="(m, index) in monedas">
                                                <td class="p-2 whitespace-nowrap">
                                                    <div class="text-left">{{ `BILLETE ${m.valor}` }}</div>
                                                </td>
                                                <td class="whitespace-nowrap p-2">
                                                    <div class="text-lg text-center">
                                                        <input v-model="m.model" v-on:input="" type="number"
                                                            class="w-20 border text-gray-900 bg-gray-50 border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" />
                                                        <!--
                                        <input type="number" class="  w-12   text-sm   focus:border-primary-600 block   "/>-->
                                                    </div>

                                                </td>
                                                <td class="p-2 whitespace-nowrap">
                                                    <div class="text-lg text-center">{{ m.total }}</div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/3 flex space-x-3">
                    <div class="w-full  ">
                        <div class="w-full max-w-2xl mx-auto bg-white shadow-md border border-gray-200">
                            <header class="px-5 py-4 border-b border-gray-100">
                                <h2 class="font-semibold text-gray-800">CHEQUE</h2>
                            </header>
                            <div class="p-3">
                                <div class="overflow-x-auto">
                                    <table class="table-auto w-full"> 
                                        <tbody class="text-sm divide-y divide-gray-100">
                                            <tr v-for="(b, index) in billetes">
                                                <td class="p-2 whitespace-nowrap">
                                                    <input   v-on:input="" 
                                                            class="w-full border text-gray-900 bg-gray-50 border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" />
                                                </td>
                                                <td class="whitespace-nowrap p-2">
                                                    <input  v-on:input="" 
                                                            class="w-full border text-gray-900 bg-gray-50 border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" /> 

                                                </td>
                                                <td class="p-2 whitespace-nowrap">
                                                    <input   v-on:input="" 
                                                            class="w-full border text-gray-900 bg-gray-50 border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2" class="p-2 whitespace-nowrap"> 
                                                    <input  v-on:input="" 
                                                            class="w-full border text-gray-900 bg-gray-50 border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" /> 
                                                </td>
                                                <td class="p-2 whitespace-nowrap"> 
                                                </td>
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


</modulo-caja-layout></template>
 