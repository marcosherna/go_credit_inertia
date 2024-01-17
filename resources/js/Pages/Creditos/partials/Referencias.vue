<script setup>
import { ref } from 'vue';
import { referenciasService } from '../../../Services/index.js';
import { ElLoading, ElMessage } from 'element-plus';
import { FwInput, FwSelect, FwTextArea, FwButton } from '@Components/flowbite'
import { useForm } from '@inertiajs/vue3';

defineProps({
    response : {
        type: Object,
        default: () => ({})
    }
})

const emit = defineEmits(['response']);
 
const form = useForm({
    ...referenciasService.model 
})

const submit = async () => {
    try { 
        ElLoading.service({ fullscreen: true, text: 'Guardando...', background: 'rgba(0, 0, 0, 0.8)' });

        const res = await referenciasService.isExist(form.REFE_DUI);

        if(res.isExist){
            ElMessage({
                showClose: true,
                message: 'El DUI ya existe',
                type: 'error'
            })  
        } else { 
            emit('response', form);
        }

    } catch (error) {
        ElMessage({
            showClose: true,
            message: error.message,
            type: 'error'
        })
    } finally { 
        ElLoading.service().close();
    }
} 
</script>
<template>
    <div>
        <form @submit.prevent="submit" class="md:p-5">
            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                    <fw-input label="Nombres: " 
                        v-model:value="form.REFE_NOMBRES"  
                        placeholder="Nombre" />
                    <div v-show="form.errors.REFE_NOMBRES" class="text-red-500 text-sm">
                        {{ form.errors.REFE_NOMBRES }}
                    </div>
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <fw-input label="Dui: " 
                        v-model:value="form.REFE_DUI"
                        placeholder="" />

                    <div v-show="form.errors.REFE_DUI" class="text-red-500 text-sm">
                        {{ form.errors.REFE_DUI }}
                    </div>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <fw-input label="Telefono: " 
                        v-model:value="form.REFE_TELEFONO"
                        placeholder="" />

                    <div v-show="form.errors.REFE_TELEFONO" class="text-red-500 text-sm">
                        {{ form.errors.REFE_TELEFONO }}
                    </div>
                </div>

                

                <div class="col-span-2">
                    <fw-input label="Correo Electronico: " 
                        v-model:value="form.REFE_MAIL"
                        placeholder="" />
                    <div v-show="form.errors.REFE_MAIL" class="text-red-500 text-sm">
                        {{ form.errors.REFE_MAIL }}
                    </div>

                </div>  
                  
                <div class="col-span-2">
                    <fw-input label="Parentesco: " 
                        v-model:value="form.REFE_PARENTESCO"
                        placeholder="" />
                    <div v-show="form.errors.REFE_PARENTESCO" class="text-red-500 text-sm">
                        {{ form.errors.REFE_PARENTESCO }}
                    </div>

                </div>  
                <div class="col-span-2">
                    <fw-text-area label="Direccion: " 
                        v-model:value="form.REFE_DIRECCION"
                        placeholder="Referencias...">
                    </fw-text-area>
                    <div v-show="form.errors.REFE_DIRECCION" class="text-red-500 text-sm">
                        {{ form.errors.REFE_DIRECCION }}
                    </div>
                </div>
            </div>

            <div class="flex flex-row w-full justify-end">
                <fw-button :disabled="form.processing" type="submit">Guardar</fw-button>
            </div>
        </form>
    </div>
</template>
