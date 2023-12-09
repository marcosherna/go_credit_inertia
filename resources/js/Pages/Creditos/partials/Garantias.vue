<script setup>
import { ref } from 'vue'; 
import { prendasServices } from '../../../Services/index.js';
import { ElLoading, ElMessage } from 'element-plus';
import { FwInput, FwSelect, FwTextArea, FwButton } from '../../../Components/flowbite/index.js';
import { useForm } from '@inertiajs/vue3';
import { UploadFilled } from '@element-plus/icons-vue'

const form = useForm({
    ...prendasServices.model 
})

const emit = defineEmits(['response']);

const submit = async () => {
    try{
        ElLoading.service({ fullscreen: true, text: 'Guardando...', background: 'rgba(0, 0, 0, 0.8)' });
        ElMessage({
            showClose: true,
            message: 'Guardado',
            type: 'success'
        })
        emit('response', form)
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

const beforeUpload = (img) => {
    console.log(img)
    return true;
}
</script>
<template>

    

    <form @submit.prevent="submit" class="md:p-3">
            <el-upload 
                drag  
                :before-upload="beforeUpload"
                :auto-upload="false"
                :limit="1">

                <el-icon class="el-icon--upload"><upload-filled /></el-icon>
                <div class="el-upload__text">
                Arrastra <em>click para seleccionar </em>
                </div>
                <template #tip>
                <div class="el-upload__tip">
                    jpg/png Archivos 500kb
                </div>
                </template>
            </el-upload>

            <div class="grid gap-4 mb-4 pt-3 grid-cols-2">
                <div class="col-span-2">
                    <fw-input label="Nombres: " 
                        v-model:value="form.PREN_NOMBRE"  
                        placeholder="Nombre" />
                    <div v-show="form.errors.PREN_NOMBRE" class="text-red-500 text-sm">
                        {{ form.errors.PREN_NOMBRE }}
                    </div>
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <fw-input label="Marca" 
                        v-model:value="form.PREN_MARCA"
                        placeholder="" />

                    <div v-show="form.errors.PREN_MARCA" class="text-red-500 text-sm">
                        {{ form.errors.PREN_MARCA }}
                    </div>
                </div> 
                
                <div class="col-span-2 sm:col-span-1">
                    <fw-input label="Precio: " 
                        v-model:value="form.PREN_PRECIO"
                        placeholder="" />
                    <div v-show="form.errors.PREN_PRECIO" class="text-red-500 text-sm">
                        {{ form.errors.PREN_PRECIO }}
                    </div>

                </div> 

                <div class="col-span-2">
                    <fw-input label="Modelo: " 
                        v-model:value="form.PREN_MODELO"
                        placeholder="" />

                    <div v-show="form.errors.PREN_MODELO" class="text-red-500 text-sm">
                        {{ form.errors.PREN_MODELO }}
                    </div>
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <fw-input label="Precio Garantia: " 
                        v-model:value="form.PREN_PRECIOGARANTA"
                        placeholder="" />
                    <div v-show="form.errors.PREN_PRECIOGARANTA" class="text-red-500 text-sm">
                        {{ form.errors.PREN_PRECIOGARANTA }}
                    </div>

                </div>  
                  
                <div class="col-span-2 sm:col-span-1">   
                    <fw-input label="Año de Fabricacion: " 
                        v-model:value="form.PREN_ANOFABRICACION"
                        placeholder="" />
                    <div v-show="form.errors.PREN_ANOFABRICACION" class="text-red-500 text-sm">
                        {{ form.errors.PREN_ANOFABRICACION }}
                    </div> 
                </div>  
                <div class="col-span-2 ">
                    <fw-text-area label="Detalle: " 
                        v-model:value="form.PREN_DETALLE" 
                        placeholder="Detalle...">
                    </fw-text-area>
                    <div v-show="form.errors.PREN_DETALLE" class="text-red-500 text-sm">
                        {{ form.errors.PREN_DETALLE }}
                    </div>
                </div>
            </div>

            <div class="flex flex-row w-full justify-end">
                <fw-button :disabled="form.processing" type="submit">Guardar</fw-button>
            </div>
        </form>

</template>   