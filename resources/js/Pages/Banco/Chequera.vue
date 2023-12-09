<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { PlusIcon, Table, ButtomToggleModal, FwInput, 
    FwSelect, FwCheckbox, FwButton, FwTextArea, FwTooltip, FwModal, 
    FwSearchBar, FwSkeleton, FwTable, FwBadge} from '../../Components/flowbite/index';
import NavigationLayout from '@/Layouts/NavigationLayout.vue';   
import MenuModuloBanco from './Partials/MenuModuloBanco.vue'; 
import controller from './controllers/chequeController.js'; 
 
import { ElNotification, ElLoading } from 'element-plus'

import n2words from 'n2words'

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
    ...controller.model
});

const form_cheque = useForm({
    ...controller.model_cheque
});

const isShowModal = ref(false) 
const isShowModalDetalle = ref(false)
const emitirChequeModal = ref(false)
const cheques = ref(null)
const loading = ref(false)

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

const numerToLetter = (number) => { 
    if(number != ''){ 
        try {
            form_cheque.errors.CHEM_MONTOLETRA = null; 
            let numbers = number.toString().split('.');
            let int = numbers[0];
            let decimal = numbers[1] || '00';  

            form_cheque.CHEM_MONTOLETRA = (n2words(int, { lang: 'es' }) + ' con ' + decimal + '/100').toUpperCase(); 
        } catch (error) {
            form_cheque.errors.CHEM_MONTOLETRA = 'Error al convertir el monto a letras'
        }   
    } 
}

const submit = () => {
    
    if(form.CHEQ_ID){
         
    }else{ 
        if(form.CHEQ_GENERACION != 0){ 
            form.errors.CHEQ_GENERACION = null

            if(form.CUEB_NUMERO != 0){
                form.errors.CHEQ_DESDE = null;
                form.errors.CHEQ_HASTA = null;  
                form.CHEQ_CANTIDAD = `${(parseInt(form.CHEQ_HASTA) - parseInt(form.CHEQ_DESDE)) + 1 }`

                form.transform(data => ({
                    ...data,
                    CHEQ_DESDE: parseInt(data.CHEQ_DESDE),
                    CHEQ_PENDIENTES: data.CHEQ_CANTIDAD, 
                    CHEQ_GENERACION : data.CHEQ_GENERACION == 1 ? 0 : 1
                })).post('/chequera-create/', {
                    preserveScroll: true,
                    onSuccess: (data) => { 
                        console.log(data)
                        lstChequeras.value = data.props.chequeras;
                        isShowModal.value = false  
                    },
                    onError: (error) => {
                        console.log(error);
                    }
                });

                

            } else { 
                form.errors.CUEB_NUMERO = 'Seleccione una opcion'
            }
            
        }else {  
            form.errors.CHEQ_GENERACION = 'Seleccione una opcion'
        }
    } 
}

const selectedItem = (item) =>{    
    form.CUEB_NUMERO = item.cuenta_banco.CUEB_NUMERO
    form.CHEQ_DESDE = item.CHEQ_DESDE.toString();
    form.CHEQ_HASTA = item.CHEQ_HASTA.toString();
    form.CHEQ_CANTIDAD = item.CHEQ_CANTIDAD.toString()
    form.CHEQ_GENERACION = item.CHEQ_GENERACION == 0 ? 1 : 2
    form.CHEQ_REFERENCIA = item.CHEQ_REFERENCIA
    isShowModal.value = true 
}

const onSelected = (item) => {
    console.log(item);
    isShowModalDetalle.value = true
}

const onchange = (e) => { 
    let cantida = (e - form.CHEQ_DESDE) + 1 
    form.CHEQ_CANTIDAD = cantida.toString()
}

const detelleCheque = async (id) => { 
    //router.push({name:'cheque', params:{id:id}}) navega hacia otra  
    cheques.value = null
    isShowModalDetalle.value = true
    try {
        const response = await controller.ObtenerCheques(id);
        cheques.value = response;
        
    } catch (error) {
        console.error(error);
        cheques.value = []
    }
}

const cambiarEstadoChequera = async (CHEQ_ID) => {

    ElLoading.service({ fullscreen: true, text: 'Cargando...', background: 'rgba(0, 0, 0, 0.8)' })
 
    try {  
        const response = await controller.cambiarEstadoCheque(CHEQ_ID);  
        if(response.error){  
            ElLoading.service().close()

            ElNotification({
                title: 'Precaucion',
                message: response.message,
                type: 'warning', 
                customClass: 'notification',
            }) 
        }


        ElLoading.service().close()
    } catch (error) {  
        ElNotification({
                title: 'Error',
                message: error.message,
                type: 'error',  
                customClass: 'notification',
            }) 

        ElLoading.service().close()    
    }
    
}



const seleccionarChequera = (chequera)=> { 
    emitirChequeModal.value = true
    form_cheque.CHEQ_ID = chequera.CHEQ_ID

    // CHEQ_VERIFICADOR - ultimo cheque  / CHEQ_DESDE - disponible
    form_cheque.CHEM_NUMERO = `${chequera.CHEQ_VERIFICADOR == 0 ? 
                        chequera.CHEQ_DESDE : chequera.CHEQ_VERIFICADOR + 1}`
}


const emitirCheque = () => { 
    form_cheque.transform( data => ({
        ...data
    })).post(route('chequera.create-cheque'), {
        preserveScroll: true,
        onSuccess: (data) => {
            emitirChequeModal.value = false 
            console.log(data);
        },
        onError: (error) => {
            console.log(error);
        }
    });
}


</script>  

<style>
    .notification{
        background-color: #E74C3C  !important; 
    }

    .notification .el-notification__title,
    .notification .el-notification__content {
        color: white !important; 
    }

</style>
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
                                        {{ chequera.cuenta_banco ? chequera.cuenta_banco.CUEB_NUMERO : '' }}
                                        <div class="text-gray-400"> 
                                            {{ chequera.cuenta_banco ? chequera.cuenta_banco.banco.BANC_NOMBRE : ''  }}
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
                                        @click="cambiarEstadoChequera(chequera.CHEQ_ID)"
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

                                    <button v-if="chequera.CHEQ_ESTADO == 1"
                                        href="#" 
                                        @click="seleccionarChequera(chequera)"
                                        class="font-medium text-green-600 mr-2 dark:text-green-500 hover:underline">Emitir</button>
                                    
                                    <button 
                                        href="#" 
                                    @click="selectedItem(chequera)"
                                        class="font-medium text-green-600 dark:text-green-500 hover:underline">Editar</button>
                                    <button v-if="chequera.CHEQ_ESTADO != 1" v-on:click="detelleCheque(chequera.CHEQ_ID)" class="px-3 font-medium text-green-600 dark:text-green-500 hover:underline">Ver</button>
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
                                    :min="1"
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
                                    type="number"
                                    placeholder="....."/>
                                    
                                <div v-show="form.errors.CHEQ_CANTIDAD" class="text-red-500 text-sm">
                                    {{  form.errors.CHEQ_CANTIDAD }}
                                </div>
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

        <fw-modal :show="isShowModalDetalle" 
            maxWidth="3xl"
            @close="isShowModalDetalle = false">
            <template #header>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    chequera
                </h3> 
            </template>
            <template #body>
                <fw-skeleton :show="cheques == null" />
                <fw-table  v-if="cheques != null">
                    <template #header>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                ID CHEQUE
                            </th>
                            <th scope="col" class="px-6 py-3">
                                DETALLE
                            </th>
                            <th scope="col" class="px-6 py-3">
                                ACCIONES
                            </th>
                        </tr>
                    </template>
                    <template #body>
                        <tr v-for="(cheque, index ) in cheques" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <p class="text-gray-900 font-bold pr-5" >{{ cheque.CHEM_ID }}</p>
                                <fw-badge>
                                    {{ `Cantidad: ${cheque.CHEM_MONTO}` }}
                                </fw-badge> 
                            </th>
                            <td class="px-6 py-4">
                                <div class="flex pb-2">
                                        <p class="text-gray-900 font-bold pr-5" >{{ cheque.CHEM_NOMBRE }}</p>
                                        <fw-badge>
                                            {{ controller.estadoCheque.find( x => x.value = cheque.CHEM_ESTADO) ? controller.estadoCheque.find( x => x.value = cheque.CHEM_ESTADO).text : '' }}
                                        </fw-badge>
                                    </div>
                                    <div class="text-gray-500 text-xs">
                                        <p class="text-gray-800 pb-1">Saldo: {{ cheque.CHEM_MONTO }}</p>
                                        <p>{{ (new Date(cheque.CHEM_FECHA)).toDateString()  +' ' + cheque.CHEM_LUGAR }}</p>
                                    </div> 
                            </td>
                            <td class="px-6 py-4">
                                <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                    <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                                <div id="dropdownDots" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                                    </li>
                                    </ul>
                                    <div class="py-2">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Separated link</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </fw-table>
            </template> 
        </fw-modal> 


        <fw-modal :show="emitirChequeModal" 
            maxWidth="sm"
            @close="emitirChequeModal = false">
            <template #header>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    chequera
                </h3> 
            </template>
            <template #body> 
                <form @submit.prevent="emitirCheque" class="p-4 md:p-5"> 
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2 ">
                                <fw-input label="No. Cheque" 
                                    v-model:value="form_cheque.CHEM_NUMERO"     
                                    type="number"
                                    :min="0"
                                    :disabled="true"
                                    placeholder="Desde"/>
                                <div v-show="form_cheque.errors.CHEM_NUMERO" class="text-red-500 text-sm">
                                    {{  form_cheque.errors.CHEM_NUMERO }}
                                </div>
                            </div>
                            <div class="col-span-2 sm:col-span-1"> 
                                <fw-input label="Fecha"
                                    v-model:value="form_cheque.CHEM_FECHA"
                                    :onUpdate:value="onchange"
                                    :min="parseInt(form.CHEM_FECHA)"
                                    placeholder="Hasta"
                                    type="date"/>
                                <div v-show="form_cheque.errors.CHEM_FECHA" class="text-red-500 text-sm">
                                    {{  form_cheque.errors.CHEM_FECHA }}
                                </div>

                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Lugar"
                                    v-model:value="form_cheque.CHEM_LUGAR"  
                                    placeholder="....."/>   
                                <div v-show="form_cheque.errors.CHEM_LUGAR" class="text-red-500 text-sm">
                                    {{  form_cheque.errors.CHEM_LUGAR }}
                                </div>
                            </div>

                            <div class="col-span-2"> 
                                <fw-input label="Monto"
                                    v-model:value="form_cheque.CHEM_MONTO"
                                    :onUpdate:value="numerToLetter"
                                    :min="0" :step="0.01" pattern="^\d+(?:\.\d{1,2})?$"  
                                    type="number"
                                    placeholder="....."/>
                            </div>
                            <div class="col-span-2"> 
                                <fw-input label="Monto Letras"
                                    v-model:value="form_cheque.CHEM_MONTOLETRA" 
                                    :disabled="true" 
                                    placeholder="....."/> 

                                <div v-show="form_cheque.errors.CHEM_MONTOLETRA" class="text-red-500 text-sm">
                                    {{  form_cheque.errors.CHEM_MONTOLETRA }}
                                </div>
                            </div>  

                            <div class="col-span-2">
                                <fw-input label="Paguese a: "
                                    v-model:value="form_cheque.CHEM_NOMBRE"  
                                    placeholder="....."/> 

                                <div v-show="form_cheque.errors.CHEM_NOMBRE" class="text-red-500 text-sm">
                                    {{  form_cheque.errors.CHEM_NOMBRE }}
                                </div>
                            </div>

                            <div class="col-span-2">
                                <fw-text-area label="Comentarios: "
                                    v-model:value="form_cheque.CHEM_COMENTARIOS" 
                                    placeholder="Referencias..."> 
                                </fw-text-area>
                                <div v-show="form_cheque.errors.CHEM_COMENTARIOS" class="text-red-500 text-sm">
                                    {{  form_cheque.errors.CHEM_COMENTARIOS }}
                                </div>
                            </div>

                        </div> 
                        
                        <div class="flex flex-row w-full justify-end">
                            <fw-button :disabled="form_cheque.processing" type="submit">Guardar</fw-button>
                        </div> 
                    </form>
            </template> 
        </fw-modal>

    </NavigationLayout>   
</template>
