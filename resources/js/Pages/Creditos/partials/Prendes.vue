<script setup>
import { ref } from 'vue'; 
import { prendasServices } from '../../../Services/index.js';
import { ElLoading, ElMessage } from 'element-plus';

const prendas = ref({
    ...prendasServices.model
})

const sumit = async () => {
    try{
        ElLoading.service({ fullscreen: true, text: 'Guardando...', background: 'rgba(0, 0, 0, 0.8)' });
    

    }catch(error){
        ElMessage({
            showClose: true,
            message: error.message,
            type: 'error'
        })
    }finally{
        ElLoading.service().close();
    }
}

</script>
<template>
</template>
