<script setup>
import {
    ArrowDown,
    Check,
    CircleCheck,
    CirclePlus,
    CirclePlusFilled,
    Plus, 
  } from '@element-plus/icons-vue'

import { ElLoading, ElMessage } from 'element-plus'; 
import { solicitudService } from '../../../Services/index.js'; 
import { FwModal, FwTextArea, FwButton } from '@Components/flowbite';
import { ref } from 'vue';

const options = {
    fullscreen: true, 
    text: 'Cargando...',   
    background: 'rgba(0, 0, 0, 0.7)'
}

const modal = ref(false)
const observaciones = ref('');

const props = defineProps({  
    selection: {
        type: Object,
        required: false
    }
}) 

const handlerStatusAprobar = async () => { 
    try{
        ElLoading.service(options);
        const _data = await solicitudService.changedStatus(props.selection.SOLI_ID, 4); 
        ElMessage({
            showClose: true,
            message: 'Solicitud Aprobada',
            type: 'success'
        });
        window.location.reload();
        ElLoading.service().close();
    }catch(error){
        ElLoading.service().close();
        ElMessage({
            showClose: true,
            message: error.message,
            type: 'error'
        });
    }

}


const handlerStatusRechazar = async () => {
    try{
        ElLoading.service(options);
        const _data = await solicitudService.changedStatus(props.selection.SOLI_ID, 2); 
        ElMessage({
            showClose: true,
            message: 'Solicitud Rechazada',
            type: 'success'
        });
        window.location.reload();
        
        ElLoading.service().close();
    }catch(error){
        ElLoading.service().close();
        ElMessage({
            showClose: true,
            message: error.message,
            type: 'error'
        });
    }
}


const handlerStatusCancelar = async () => {
    try{
        ElLoading.service(options);
        const _data = await solicitudService.changedStatus(props.selection.SOLI_ID, 0); 
        ElMessage({
            showClose: true,
            message: 'Solicitud Observada',
            type: 'success'
        });
        window.location.reload();
        ElLoading.service().close();
    }catch(error){
        ElLoading.service().close();
        ElMessage({
            showClose: true,
            message: error.message,
            type: 'error'
        });
    }
}



const handlerStatusObservar = async () => {
    try{
        modal.value = true;
        ElLoading.service(options);
        props.selection.SOLI_OBSERVACION = `${props.selection.SOLI_OBSERVACION} [OBSERVADO]-[${new Date().toLocaleString()}] ${observaciones.value}`;
        const _data = await solicitudService.observar(props.selection);
        console.log(_data);
        ElMessage({
            showClose: true,
            message: 'Solicitud Observada',
            type: 'success'
        });
        modal.value = false;
        await window.location.reload();
        ElLoading.service().close();
    }catch(error){
        ElLoading.service().close();
        ElMessage({
            showClose: true,
            message: error.message,
            type: 'error'
        });
        modal.value = false;
    }
}

</script>
  
<template>
    <el-dropdown>
          <span class="el-dropdown-link">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
            </svg>
          </span>
          <template #dropdown>
            <el-dropdown-menu>
                <el-dropdown-item v-on:click="handlerStatusAprobar" :icon="Check">Aprobar Credito</el-dropdown-item> 
                <el-dropdown-item v-on:click="handlerStatusRechazar" :icon="Plus">Rechazar</el-dropdown-item> 
                <el-dropdown-item v-on:click="modal = true" :icon="CirclePlusFilled">
                    Observar
                </el-dropdown-item>
                
            </el-dropdown-menu>
          </template>
        </el-dropdown>

        <fw-modal :show="modal" v-on:close="modal = false"
            maxWidth="md">
            <template #header>
                <h3 class="text-lg font-medium text-gray-800 dark:text-white">Observar Solicitud</h3>
            </template>
            <template #body>
                <div class=" p-4">
                    <div class="flex flex-col">
                        <fw-text-area v-model:value="observaciones" 
                            label="Observaciones"  
                            placeholder="Observaciones"/>
                    </div>
                    <div class="flex flex-row justify-end mt-4"> 
                        <fw-button v-on:click="handlerStatusObservar"  type="primary"  ><span>Enviar</span></fw-button>
                    </div>
                </div>
            </template>
        </fw-modal>

  </template>
  
   