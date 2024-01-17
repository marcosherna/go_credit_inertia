<script setup>
import ModuloCajaLayout from '@/Pages/Administracion/partials/ModuloCajaLayout.vue';
import { ref } from 'vue'
import { FwSelect, FwInput, FwTextArea } from '@Components/flowbite'
import { SpinnerBars } from '@Components/spinners'

import { Opportunity } from '@element-plus/icons-vue'

const value = ref('')
const loading = ref(false)

const options = [
    {
        value: 'Option1',
        label: 'GoEAT',
    },
    {
        value: 'Option2',
        label: 'SOLUCREDIS',
    },
    {
        value: 'Option3',
        label: 'STV',
    },
    {
        value: 'Option4',
        label: 'DISAN',
    },
    {
        value: 'Option5',
        label: 'GUANASOFT',
    },
    {
        value: 'Option6',
        label: 'TODOYO',
    },
]


const tipoOperacion = [ { value: 'Option1', label: 'Abono' }, { value: 'Option2', label: 'Pago' } ]


const change = async (value) => {
    await handlerAnimation()
}

const handlerAnimation = async () => {
    try {
        loading.value = true
        await new Promise(resolve => setTimeout(resolve, 2000))
        loading.value = false
    } catch (error) {
        console.log(error)
    }
}

</script>
<template>
    <modulo-caja-layout>
        <div class="flew flex-row text-end">
            <el-icon size="20"><Opportunity /></el-icon>
            <el-select v-model="value" class="m-2" placeholder="Select" size="large" @change="change"> 
                <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value" />
            </el-select>
        </div>
        
        <div class="text-center px-4 py-5 text-xl font-bold">
            {{ value != '' ?  options.find(option => option.value === value).label : '' }}
        </div>

        <spinner-bars :show="loading"/>
        <el-empty  v-if="value == ''" description="Seleccione una opcion" />
        <div v-if="!loading && value != ''" class="lg:col-span-2 md:pl-4">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                <div class="md:col-span-2">
                    <fw-input label="Codigo Referencia" placeholder="" />
                </div> 
                <div class="md:col-span-5">
                </div>

                <div class="md:col-span-1">
                    <fw-input label="Cantidad Recibida" placeholder="" />  
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