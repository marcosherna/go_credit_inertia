<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { PlusIcon, Table, ButtomToggleModal, FwInput, 
    FwSelect, FwCheckbox, FwButton, FwTextArea, FwTooltip} from '../../Components/flowbite/index';
import NavigationLayout from '../../Layouts/NavigationLayout.vue';
import SearchBar from '../../Components/flowbite/SearchBar.vue';
import MenuModuloBanco from './Partials/MenuModuloBanco.vue';
import FwModal from '../../Components/Modal.vue';

defineProps({
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
    CHEQ_VERIFICADOR:null,
    CHEQ_ESTADO:null,
});

const isShowModal = ref(false) 
const isShowModalDetalle = ref(false)

const openModal = ()=>{
    form.reset()
    isShowModal.value = true
}

const onSearch = (text) =>{
    console.log(text);
}

const submit = () => {
    if(updateOrCreate.value){
        console.log('actualizar');
        form.transform(data => ({
            ...data,
            CUEB_ESTADO: data.CUEB_ESTADO ? 1 : 0,
        })).put('cuenta-banco-update', {
            onSuccess: () => {
                form.reset()
                isShowModal.value = false
                updateOrCreate.value = false
            },
        })
    }else{
        console.log('crear');
        form.transform(data => ({
            ...data,
            CUEB_ESTADO: data.CUEB_ESTADO ? 1 : 0,
        })).post(route('cuenta-banco.store'), {
            onSuccess: () => {
                form.reset()
                isShowModal.value = false
            },
        });
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
                        <SearchBar 
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
                            <tr v-for="(chequera, index) in chequeras" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
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
            maxWidth="sm">
            <div class="overflow-y-auto overflow-x-hidden justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"> 
                <div class="relative w-full max-w-md max-h-full"> 
                     <!-- Modal content --> 
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                             <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                 Chequera
                            </h3> 
                            <button @click="isShowModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round" 
                                        stroke-width="2" 
                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Cerrar Modal</span>
                            </button>
                        </div>
                    <!-- Modal body -->
                    <form @submit.prevent="submit" class="p-4 md:p-5"> 
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Desde" 
                                    v-model:value="form.CHEQ_DESDE"
                                    type="number"
                                    placeholder="Desde"/>
                            </div>
                            <div class="col-span-2 sm:col-span-1"> 
                                <fw-input label="Hasta"
                                    v-model:value="form.CHEQ_HASTA"
                                    placeholder="Hasta"
                                    type="number"/>

                            </div>
                            <div class="col-span-2">
                                <fw-select label="Cuenta de Bancos"
                                    v-model:selected="form.CUEB_NUMERO"
                                    defaultItem="Seleccione una cuenta"
                                    placeholder="Cuenta Banco"> 
                                    <option v-for="(cuenta, index) in cuentasBanco" 
                                        :value="cuenta.CUEB_NUMERO"> {{ cuenta.banco.BANC_NOMBRE }}</option>
                                </fw-select>
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Disponibles"
                                    v-model:value="form.CHEQ_CANTIDAD" 
                                    disabled="true"
                                    placeholder="....."/>
                            </div>
                            <div class="col-span-2 sm:col-span-1"> 
                                <fw-select label="Generacion"
                                    v-model:selected="form.CHEQ_GENERACION"
                                    defaultItem="Seleccione una opcion"
                                    placeholder="Cuenta Banco"> 

                                    <option value="1">Manual</option>
                                    <option value="2">Auto</option>
                                </fw-select> 
                            </div>  

                            <div class="col-span-2">
                                <fw-text-area label="Referencias"
                                    v-model:value="form.CHEQ_REFERENCIA" 
                                    placeholder="Referencias..."> 
                                </fw-text-area>
                            </div>
                        </div> 
                        
                        <div class="flex flex-row w-full justify-end">
                            <fw-button :disabled="form.processing" type="submit">Guardar</fw-button>
                        </div>

                    </form>
                </div>
            </div>
        </div> 
        </fw-modal>
 

        <fw-modal :show="isShowModalDetalle" 
            maxWidth="2xl">
            <div class="overflow-y-auto overflow-x-hidden justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"> 
                <div class="relative w-full max-w-md sm:max-w-2xl max-h-full"> 
                     <!-- Modal content --> 
                    <div class="relative bg-white  rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                             <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                 Chequera
                            </h3> 
                            <button @click="isShowModalDetalle = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round" 
                                        stroke-width="2" 
                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Cerrar Modal</span>
                            </button>
                        </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 ">  
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Product name
                                        </th>
                                        <th scope="col" class="px-6 py-3">Color</th>
                                        <th scope="col" class="px-6 py-3">Category</th>
                                        <th scope="col" class="px-6 py-3">Price</th>
                                        <th scope="col" class="px-6 py-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Apple MacBook Pro 17"
                                        </th>
                                        <td class="px-6 py-4">
                                            Silver
                                        </td>
                                        <td class="px-6 py-4">Laptop</td>
                                        <td class="px-6 py-4">$2999</td>
                                        <td class="px-6 py-4">
                                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                        </td>
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </fw-modal>

</NavigationLayout>  
    
</template>
