<script setup> 
import ModuloCajaLayout from '@/Pages/Administracion/partials/ModuloCajaLayout.vue'; 
import { FolderAdd } from '@element-plus/icons-vue';
import { FwButton, FwModal, FwInput, FwTextArea, 
    FwSelect } from '@Components/flowbite';
import { ref } from 'vue';

import { ElLoading, ElMessage } from 'element-plus';
import { useForm } from '@inertiajs/vue3';

const modal = ref(false);

const form = useForm({
    cod_referencia: '',
    monto: '',
    banco: 0,
    referencia: '',
});

const openModal = () => { 
    form.errors = {};
    modal.value = true;
};

const submit =  () => {
    try {
        if(form.banco == 0){
            form.errors.banco = 'Debe seleccionar un banco';
            throw new Error('Debe seleccionar un banco'); 
        }
        ElLoading.service({ fullscreen: true, text: 'Cargando...', background: 'rgba(0, 0, 0, 0.5)' });
        setTimeout(() => {
            ElLoading.service().close();
            modal.value = false;
        }, 2000);

    } catch (error) {
        ElLoading.service().close();
        ElMessage({
            message: error.message,
            type: 'error'
        });
    }
}

</script> 
<template> 
    <modulo-caja-layout> 
        <div class="text-end">
            <fw-button :disabled="modal" v-on:click="openModal" size="small">Salida de efectivo</fw-button>
        </div>
    </modulo-caja-layout>
    <fw-modal 
        :show="modal" v-on:close="modal = false" maxWidth="md"> 
        <template #header>
            <h3 class="text-lg font-medium text-gray-800 dark:text-white">Salida de efectivo</h3>
        </template> 
        <template #body>
            <div>
                <form @submit.prevent="submit" class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2 sm:col-span-1">
                            <fw-input v-model:value="form.cod_referencia" label="Cod. Referencia"  
                                placeholder="" /> 
                            <div v-if="form.errors.cod_referencia" class="text-red-500 text-sm"> 
                                {{ form.errors.cod_referencia  }}
                            </div>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <fw-input label="Monto"  v-model:value="form.monto" placeholder="" /> 
                            <div v-if="form.errors.monto" class="text-red-500 text-sm"> 
                                {{ form.errors.monto }}
                            </div>
                        </div>
                        <div class="col-span-2">
                            <fw-select v-model:selected="form.banco" label="Bancos" 
                                defaultItem="Seleccione una cuenta"> 
                            </fw-select> 
                            <div v-if="form.errors.banco" class="text-red-500 text-sm"> 
                                {{ form.errors.banco  }}
                            </div>
                        </div> 
                        <div class="col-span-2">
                            <fw-text-area v-model:value="form.referencia" label="Referencias"  
                                placeholder="Referencias...">
                            </fw-text-area>
                            <div v-if="form.errors.referencia" class="text-red-500 text-sm"> 
                                {{ form.errors.referencia  }}
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-row w-full justify-end">
                        <fw-button type="submit">Transferir</fw-button>
                    </div>
                </form>
            </div>
        </template>
    </fw-modal>
</template>
