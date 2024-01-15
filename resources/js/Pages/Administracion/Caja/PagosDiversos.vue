<script setup> 
import ModuloCajaLayout from '@/Pages/Administracion/partials/ModuloCajaLayout.vue'; 
import { FolderAdd } from '@element-plus/icons-vue';
import { FwButton, FwModal, FwInput, FwTextArea, 
    FwSelect } from '@Components/flowbite';
import { ref } from 'vue';

import { ElLoading, ElMessage } from 'element-plus';
import { useForm } from '@inertiajs/vue3';


</script> 
<template > 
    <modulo-caja-layout> 
        <div  class="lg:col-span-2 md:pl-4 ">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                <div class="md:col-span-2">
                    <fw-input label="Codigo Referencia" placeholder="" />
                </div> 
                <div class="md:col-span-5">
                </div>

                <div class="md:col-span-1">
                    <fw-input label="Cant. Recibida" placeholder="" />

                </div>

                <div class="md:col-span-2">

                    <fw-select label="Tipo de Operacion" 
                        defaultItem="Seleccione una opcion">
                        <option v-for="item in tipoOperacion" :key="item.value"  :value="item.value" >{{ item.label }}</option>
                    </fw-select>
                </div>

                <div class="md:col-span-2">
                    <fw-input label="Monto A Pagar" placeholder="" />
                </div>
                <div class="md:col-span-5">
                    <fw-text-area label="Detalle de la Operacion" placeholder="Detalle...">
                    </fw-text-area>
                </div>

                <div class="md:col-span-1">
                    <span class="font-bold">Cambio</span> $ 0.00

                </div>


                <div class="md:col-span-5 text-right">
                    <div class="inline-flex items-end">
                        <button
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Abonar</button>
                    </div>
                </div>

            </div>
        </div> 
    </modulo-caja-layout>
</template>
