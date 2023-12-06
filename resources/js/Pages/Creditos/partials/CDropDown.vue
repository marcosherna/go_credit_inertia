<script setup>
import {
    ArrowDown,
    Check,
    CircleCheck,
    CirclePlus,
    CirclePlusFilled,
    Plus, 
  } from '@element-plus/icons-vue'

import { ElLoading } from 'element-plus';  

const options = {
    fullscreen: true, 
    text: 'Cargando...',   
    background: 'rgba(0, 0, 0, 0.7)'
}


const props = defineProps({  
    selection: {
        type: Object,
        required: false
    }
})




const handlerStatusAprobar = async () => { 
    ElLoading.service(options);
    console.log(props.selection) 
    setTimeout(() => {
        ElLoading.service().close();
    }, 2000);
}


const handlerStatusRechazar = async () => {
    ElLoading.service(options);
    console.log(props.selection) 
    setTimeout(() => {
        ElLoading.service().close();
    }, 2000);
}


const handlerStatusCancelar = async () => {
    ElLoading.service(options);
    console.log(props.selection) 
    setTimeout(() => {
        ElLoading.service().close();
    }, 2000);
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
                <el-dropdown-item v-on:click="handlerStatusAprobar" :icon="Check">Aprobar</el-dropdown-item> 
                <el-dropdown-item v-on:click="handlerStatusRechazar" :icon="Plus">Rechazar</el-dropdown-item> 
                <el-dropdown-item v-on:click="handlerStatusCancelar" :icon="CirclePlusFilled">
                    Cancelar
                </el-dropdown-item>
                
            </el-dropdown-menu>
          </template>
        </el-dropdown>
  </template>
  
   