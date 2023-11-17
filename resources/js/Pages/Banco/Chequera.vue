<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { PlusIcon, Table, ButtomToggleModal, FwInput, 
    FwSelect, FwCheckbox, FwButton, FwTextArea, FwTooltip, FwModal, FwSearchBar} from '../../Components/flowbite/index';
import NavigationLayout from '../../Layouts/NavigationLayout.vue';   
import MenuModuloBanco from './Partials/MenuModuloBanco.vue'; 
import { fromPairs } from 'lodash';

const props = defineProps({
    chequeras: Array,
    cuentasBanco: Array,
}) 

const chequeraEstado = [
    'Sellada',
    'Activa',
    'Terminada',
    'Archivada'
];

const form = useForm({
    CHEQ_ID:null,
    CUEB_NUMERO:0,
    CHEQ_DESDE:null,
    CHEQ_HASTA:null,
    CHEQ_CANTIDAD:null,
    CHEQ_PENDIENTES:null,
    CHEQ_REFERENCIA:null,
    CHEQ_FECHA:null,
    CHEQ_GENERACION:0,
    CHEQ_VERIFICADOR:0,
    CHEQ_ESTADO:0,
});

const isShowModal = ref(false) 
const isShowModalDetalle = ref(false)
let lstChequeras = ref([])
lstChequeras.value = props.chequeras

const openModal = ()=>{
    form.reset()
    isShowModal.value = true
}

const onSearch = (text) =>{
    lstChequeras.value = props.chequeras.filter((item) => {
        return item.cuenta_banco.banco.BANC_NOMBRE.toUpperCase().includes(text.toUpperCase()) ||
            item.CHEQ_ID.includes(text) ||
            item.cuenta_banco.CUEB_NUMERO.toUpperCase().includes(text.toUpperCase())
    });
    
    if(text == ''){
        lstChequeras.value = props.chequeras;
    }

}

const submit = () => {
    
    if(form.CHEQ_ID){
         
    }else{ 
        if(form.CHEQ_GENERACION != 0){ 
            form.errors.CHEQ_GENERACION = null

            if(form.CUEB_NUMERO != 0){
                form.transform(data => ({
                    ...data,
                    CHEQ_PENDIENTES: data.CHEQ_CANTIDAD, 
                    CHEQ_GENERACION : data.CHEQ_GENERACION == 1 ? 0 : 1
                }))

                form.CHEQ_PENDIENTES = form.CHEQ_CANTIDAD
                form.CHEQ_GENERACION = form.CHEQ_GENERACION == 1 ? 0 : 1

                console.log(form);
            } else { 
                form.errors.CUEB_NUMERO = 'Seleccione una opcion'
            }
            
        }else {  
            form.errors.CHEQ_GENERACION = 'Seleccione una opcion'
        }
    } 
}
const selectedItem = (item) =>{
    Object.assign(form, item) 
    form.CHEQ_GENERACION = item.CHEQ_GENERACION == 0 ? 1 : 2
    isShowModal.value = true 
}

const onSelected = (item) => {
    console.log(item);
    isShowModalDetalle.value = true
}

const onchange = (e) => { 
    let cantida = (e - form.CHEQ_DESDE)+1 
    form.CHEQ_CANTIDAD = cantida.toString()
}

</script>  
<template>
    <NavigationLayout title="Modulo Banco"> 
        <div class="intro-y flex items-center mt-6">
            <h2 class="text-lg font-medium mr-auto">Catalogos</h2> 
        </div> 

        <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Menu --> 
        <MenuModuloBanco/>
        <!-- END: Menu-->  

        <!-- BEGIN: Contenido--> 
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">  
            <div class="relative overflow-x-auto">
                <div class="flex flex-colum sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
                    <div> 
                        <ButtomToggleModal 
                            text="Nuevo Chequera" @click="openModal">
                            <PlusIcon/>
                        </ButtomToggleModal>

                        
                    </div> 
                    <div class="relative">  
                        <fw-search-bar 
                            @search="onSearch"
                            placeholder="Buscar cuenta de banco..."/>
                    </div>
                </div> 

                <!--TABLE BANCO-->
                    <Table>
                        <template #head> 
                                <th scope="col" class="p-4">ID</th> 
                                <th scope="col" class="px-6 py-3">Banco</th>
                                <th scope="col" class="px-6 py-3">Generacion</th>
                                <th scope="col" class="px-6 py-3">Cheq. Pendientes</th>
                                <th scope="col" class="px-6 py-3">Estado</th>  
                                <th scope="col" class="px-6 py-3">Acciones</th> 
                        </template>

                        <template #body>  
                            <tr v-for="(chequera, index) in lstChequeras" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="w-4 p-4 text-center">
                                    {{ chequera.CHEQ_ID }}
                                    <span class="text-slate-600"> {{ 'Cantida: '+ chequera.CHEQ_CANTIDAD }}</span>
                                </td>
                                <th scope="row">
                                    <div class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ chequera.cuenta_banco.CUEB_NUMERO }}
                                        <div class="text-gray-400"> 
                                            {{ chequera.cuenta_banco.banco.BANC_NOMBRE  }}
                                        </div>
                                    </div> 
                                   
                                </th>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ chequera.CHEQ_GENERACION  == 0 ? 'Manual':'Auto' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ chequera.CHEQ_PENDIENTES }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">  
                                    <fw-tooltip v-if="chequera.CHEQ_ESTADO == 1" 
                                        @click="onSelected(chequera)"
                                        class="bg-green-100 text-green-800 dark:text-green-400 border-green-400"
                                        :label="chequeraEstado[chequera.CHEQ_ESTADO]" 
                                        content="Precione para ver el detalle" 
                                        :target="chequeraEstado[chequera.CHEQ_ESTADO]+ '-'+index"/>

                                    <fw-tooltip v-else-if="chequera.CHEQ_ESTADO == 0" 
                                        @click="onSelected(chequera)"
                                        class="bg-blue-100 text-blue-800 dark:text-blue-400 border-blue-400"
                                        :label="chequeraEstado[chequera.CHEQ_ESTADO]" 
                                        content="Precione para ver activar" 
                                        :target="chequeraEstado[chequera.CHEQ_ESTADO]+ '-'+index"/> 

                                    <fw-tooltip v-else
                                        class="bg-red-100 text-red-800 dark:text-red-400 border-red-400"
                                        @click="onSelected(chequera)"
                                        :label="chequeraEstado[chequera.CHEQ_ESTADO]" 
                                        content="Precione para ver el detalle" 
                                        :target="chequeraEstado[chequera.CHEQ_ESTADO]+ '-'+index"/>  
 
                                </td> 
                                <td class="px-6 py-4">
                                    <button 
                                        href="#" 
                                        @click="selectedItem(chequera)"
                                        class="font-medium text-green-600 dark:text-green-500 hover:underline">Editar</button>
                                    <a href="#" class="px-3 font-medium text-green-600 dark:text-green-500 hover:underline">Ver</a>
                                </td>
                            </tr> 
                        </template> 
                    </Table>
                </div>
            </div>
        </div>

        <!-- Main modal -->   
        <fw-modal :show="isShowModal" 
            maxWidth="sm"
            @close="isShowModal = false">
            <template #header>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    chequera
                </h3> 
            </template>
            <template #body>
                <div>
                    <form @submit.prevent="submit" class="p-4 md:p-5"> 
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Desde" 
                                    v-model:value="form.CHEQ_DESDE"     
                                    type="number"
                                    :min="0"
                                    placeholder="Desde"/>
                                <div v-show="form.errors.CHEQ_DESDE" class="text-red-500 text-sm">
                                    {{  form.errors.CHEQ_DESDE }}
                                </div>
                            </div>
                            <div class="col-span-2 sm:col-span-1"> 
                                <fw-input label="Hasta"
                                    v-model:value="form.CHEQ_HASTA"
                                    :onUpdate:value="onchange"
                                    :min="parseInt(form.CHEQ_DESDE)"
                                    placeholder="Hasta"
                                    type="number"/>
                                <div v-show="form.errors.CHEQ_HASTA" class="text-red-500 text-sm">
                                    {{  form.errors.CHEQ_HASTA }}
                                </div>

                            </div>
                            <div class="col-span-2">
                                <fw-select label="Cuenta de Bancos"
                                    v-model:selected="form.CUEB_NUMERO"
                                    defaultItem="Seleccione una cuenta"> 
                                    <option v-for="(cuenta, index) in cuentasBanco" 
                                        :value="cuenta.CUEB_NUMERO"> {{ cuenta.banco.BANC_NOMBRE }}</option>
                                </fw-select>
                                <div v-show="form.errors.CUEB_NUMERO" class="text-red-500 text-sm">
                                    {{  form.errors.CUEB_NUMERO }}
                                </div>
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Disponibles"
                                    v-model:value="form.CHEQ_CANTIDAD" 
                                    :disabled="true"
                                    placeholder="....."/>
                            </div>
                            <div class="col-span-2 sm:col-span-1"> 
                                <fw-select label="Generacion"
                                    v-model:selected="form.CHEQ_GENERACION"
                                    defaultItem="Seleccione una opcion"> 

                                    <option value="1">Manual</option>
                                    <option value="2">Auto</option>
                                </fw-select> 

                                <div v-show="form.errors.CHEQ_GENERACION" class="text-red-500 text-sm">
                                    {{  form.errors.CHEQ_GENERACION }}
                                </div>
                            </div>  

                            <div class="col-span-2">
                                <fw-text-area label="Referencias"
                                    v-model:value="form.CHEQ_REFERENCIA" 
                                    placeholder="Referencias..."> 
                                </fw-text-area>
                                <div v-show="form.errors.CHEQ_REFERENCIA" class="text-red-500 text-sm">
                                    {{  form.errors.CHEQ_REFERENCIA }}
                                </div>
                            </div>
                        </div> 
                        
                        <div class="flex flex-row w-full justify-end">
                            <fw-button :disabled="form.processing" type="submit">Guardar</fw-button>
                        </div> 
                    </form>
                </div>
            </template> 
        </fw-modal> 
    </NavigationLayout>   
</template>
