<script setup>
import NavigationLayout from '@/Layouts/NavigationLayout.vue';
import CTablePorAprobar from './partials/CTablePorAprobar.vue';
import CSearchBar from './partials/CSearchBar.vue';

import { ref } from 'vue';
import { FwModal, FwInput, FwSelect, FwButton, FwTextArea, FwRadioCheckbox } from '../../Components/flowbite';

import { ElNotification, ElLoading, ElMessage } from 'element-plus'
import { useForm, usePage } from '@inertiajs/vue3';

import { solicitudService } from './../../Services/index.js';

import jspdf, { jsPDF } from 'jspdf';
import html2pdf from 'html2pdf.js';

const props = defineProps({
    response: {
        type: Object,
    },
    count: {
        type: Number,
    },
})

const page = usePage();
const txtSearch = ref('');
const data = ref(props.response);

const onSearch = async () => {

    try {
        ElLoading.service({ fullscreen: true, text: 'Buscando...', background: 'rgba(0, 0, 0, 0.8)' });
        const _data = await solicitudService.searchSolicitud(txtSearch.value);
        data.value = _data;
        console.log(_data)
        ElLoading.service().close();

    } catch (error) {
        ElMessage({
            showClose: true,
            message: error.message,
            type: 'error'
        });
        ElLoading.service().close();
    }
}


const exportPdf = async () => {
    const printArea = document.getElementById('print-pdf');
    const pdfBlob = await html2pdf().from(printArea).set({
        jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' },
        filename: 'myfile.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        margin: [0, 0, 0, 0]
    }).output('blob');
    const pdfUrl = URL.createObjectURL(pdfBlob);
    window.open(pdfUrl, '_blank');
}

function formatearHora(fecha) {
    let horas = fecha.getHours();
    let minutos = fecha.getMinutes();

    // Convertir las horas y los minutos a formatos de dos dígitos
    horas = horas < 10 ? '0' + horas : horas;
    minutos = minutos < 10 ? '0' + minutos : minutos;

    return horas + ':' + minutos;
} 
</script> 

<template>
    <Navigation-layout title="Solicitudes">
        <section class="container px-4 mx-auto">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div>
                    <div class="flex items-center gap-x-3">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Solicitudes Por Aprobar</h2>

                        <span
                            class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{
                                count }} Creditos</span>
                    </div>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">These companies have purchased in the last 12
                        months.</p>
                </div>

                <div class="flex items-center mt-4 gap-x-3">

                </div>
            </div>
            <div class="mt-6 md:flex md:items-center md:justify-between">
                <div
                    class="inline-flex overflow-hidden bg-white border divide-x rounded-lg dark:bg-gray-900 rtl:flex-row-reverse dark:border-gray-700 dark:divide-gray-700">
                    <fw-button v-on:click="exportPdf">Exportar</fw-button>
                </div>

                <!-- Search bar  -->
                <c-search-bar v-model:value="txtSearch" v-on:keyup.enter="onSearch()" placeholder="Buscar" />
            </div>

            <c-table-por-aprobar :items="data" />
        </section>


        <div id="print-pdf">
            <div class="px-8 ">

                <div class="flex flex-row">
                    <div class="w-full text-xl text-center">
                        <h1>SOLUCIONES CREDITICIAS SALVADOREÑA, S.A DE CV <br> REPORTES CREDITICIOS</h1>
                    </div>

                    <div class="border border-black pl-2 py-2 pr-14 text-end bg-slate-200">
                        <div class="text-start">
                            <span class="font-bold">Detalle</span><br>
                            <span>{{ (new Date()).toLocaleDateString() }}</span><br>
                            <span>{{ formatearHora((new Date())) }}</span><br>
                            <span>{{ page.props.auth.user.USUA_LOGIN }}</span><br>
                        </div>
                    </div>
                </div>


                <div class="w-full flex flex-row space-x-10">
                    <table class="border-collapse">
                        <thead class="bg-gray-200">
                            <tr>
                                <th scope="col" class="px-2 pb-2 border border-gray-400   text-sm font-normal text-left rtl:text-right ">
                                    Numero de Solicitudes
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200 ">
                            <tr>
                                <td class="pl-2 pb-2 border border-gray-400 text-sm font-medium ">
                                    <div>
                                        <h2 class="font-medium  ">
                                            1
                                        </h2>
                                    </div>
                                </td>

                            </tr>
                        </tbody>

                    </table>


                    <table class="border-collapse ">
                        <thead class="bg-gray-200">
                            <tr> 
                                <th scope="col" class="px-4 pb-2 border border-gray-400 text-sm font-normal text-left rtl:text-right ">
                                    Monto totala de Solicitudes
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                            <tr>
                                <td class="pl-4 pb-2 border border-gray-400 text-sm font-medium ">
                                    <div>
                                        <h2 class="font-medium text-gray-800">
                                            1
                                        </h2>
                                    </div>
                                </td>

                            </tr>
                        </tbody>

                    </table>
                </div>

                <div class="w-full pt-8">
                    <table class="w-full divide-y divide-x divide-gray-200 ">
                        <thead class="bg-gray-200">
                            <tr>
                                <th scope="col" class="border pb-2 grip place-items-center border-gray-400 pl-4 text-sm font-normal text-left">
                                    <span>ID</span>
                                </th>
                                <th scope="col" class="pl-2 pb-2 border border-gray-400 text-sm font-normal text-left">
                                    FECHA APROBACION
                                </th>
                                <th scope="col" class="pl-2 pb-2 border border-gray-400 text-sm font-normal text-left">
                                    NOMBRE COMPLETO</th>
                                <th scope="col" class="pl-2 pb-2 border border-gray-400 text-sm font-normal text-left ">
                                    MONTO </th>
                                <th scope="col" class="pl-2 pb-2 border border-gray-400 text-sm font-normal text-left">
                                    CONDICIONES
                                </th>
                                <th scope="col" class="pl-2 pb-2 border border-gray-400 text-sm font-normal text-left ">
                                    FECHA VENC.
                                </th>
                                <th scope="col" class="pl-2 pb-2 border border-gray-400 text-sm font-normal text-left">
                                    ESTADO
                                </th>
                            </tr>

                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(s, index) in data.data">
                                <td class="pl-2 pb-2 border border-gray-400 text-sm font-medium ">
                                    <h2 class="font-medium text-gray-800">
                                        {{ s.SOLI_ID }}
                                    </h2>
                                </td>
                                <td class="pl-2 pb-2 border border-gray-400 text-sm whitespace-nowrap">
                                    <h4 class="text-gray-700">
                                        {{ s.SOLI_FECHAAPROB }}
                                    </h4>
                                </td>
                                <td class="pl-2 pb-2 border border-gray-400 text-sm whitespace-nowrap">
                                    <div class="object-cover w-6 h-6 -mx-1 border-2 border-white rounded-full  shrink-0">
                                        {{ s.cliente.NOMBRE }}
                                        {{ console.log(s) }}
                                    </div>
                                </td>
                                <td class="pl-2 pb-2 border border-gray-400 text-sm whitespace-nowrap">$
                                    {{ s.SOLI_MONTO }}
                                </td>
                                <td class="pl-2 pb-2 border border-gray-400 text-sm whitespace-nowrap">
                                    {{ `${s.plazo.PLAZ_NOMBRE} al ${s.tasa_interes.TASA_VALOR}% en pagos
                                                                        ${s.forma_pago.FORM_NOMBRE}` }}
                                </td>
                                <td class="pl-2 pb-2 border border-gray-400 text-sm whitespace-nowrap">
                                    {{ s.SOLI_FECHAVENCIMIENTO }}
                                </td>
                                <td class="pl-2 pb-2 border border-gray-400 text-sm whitespace-nowrap">
                                    {{ solicitudService.SolicitudEstado.find(x => x.value == s.SOLI_ESTADO).text }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </Navigation-layout>
</template>
