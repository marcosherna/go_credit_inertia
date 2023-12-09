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
import { solicitudService as solicitudServices } from '../../../Services/index.js'


defineProps({
    label: String,
    options: {
        type: Array,
        required: true
    }
})

const emit = defineEmits(['responce']);


const onClick = async (op) => {  
    try {
        ElLoading.service({
            fullscreen: true, 
            text: 'Cargando...',   
            background: 'rgba(0, 0, 0, 0.7)'
        }); 
        const response = await solicitudServices.filleter(op.value)  
        emit('responce', response)
    } catch (error) {
        ElMessage({
            showClose: true,
            message: `Oops, ${error.message}`,
            type: 'error',
        });
    } finally {
        ElLoading.service().close();
    } 
}

</script>

<template> 
    <div class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
        <el-dropdown>

            <span class="el-dropdown-link">
                {{ label }}
                <el-icon class="el-icon--right">
                    <arrow-down />
                </el-icon>
            </span> 
          <template #dropdown>
            <el-dropdown-menu>
                <el-dropdown-item v-for="(op, index) in options" v-on:click="onClick(op)">
                    {{  op.text }}
                </el-dropdown-item> 
            </el-dropdown-menu>
          </template>
        </el-dropdown>   
    </div>
</template>