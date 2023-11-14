<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { PlusIcon, Table, ButtomToggleModal, FwInput, 
    FwSelect, FwCheckbox, FwButton, FwTextArea} from '../../Components/flowbite/index';
import NavigationLayout from '../../Layouts/NavigationLayout.vue';
import SearchBar from '../../Components/flowbite/SearchBar.vue';
import MenuModuloBanco from './Partials/MenuModuloBanco.vue';
import FwModal from '../../Components/Modal.vue';

defineProps({
    cuentaBancos:Array,
    bancos:Array,
    cuentasSucursales:Array,
    tiposCuenta:Array,
})


const form = useForm({
    CUEB_NUMERO : null, 
    CUEB_DETALLE :null, 
    CUEN_ID : 0, 
    BANC_ID : 0, 
    TIPC_ID : 0, 
    CUEB_ESTADO: true,
});

const isShowModal = ref(false)
const updateOrCreate = ref(false)

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
    form.BANC_ID = item.banco.BANC_ID;
    form.CUEB_ESTADO = item.CUEB_ESTADO == 1 ? true : false
    isShowModal.value = true
    updateOrCreate.value = true
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
                            text="Nuevo Banco"  @click="openModal">
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
                                <th scope="col" class="px-6 py-3">Estado</th>  
                                <th scope="col" class="px-6 py-3">Acciones</th> 
                        </template>

                        <template #body>  
                            <tr v-for="(cuentaBanco, index) in cuentaBancos" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="w-4 p-4 text-center">{{ cuentaBanco.CUEB_NUMERO }}</td>
                                <th scope="row">
                                    <div class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ cuentaBanco.banco.BANC_ID }}
                                        <div class="text-gray-400">
                                            {{ cuentaBanco.cuenta_sucursal.CUEN_NOMBRE }}
                                        </div>
                                    </div> 
                                   
                                </th>
                                <td class="px-6 py-4">
                                    <label class="relative inline-flex items-center mb-5 cursor-pointer">
                                        <input type="checkbox"  :checked="cuentaBanco.CUEB_ESTADO" value="" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                                    </label>
                                </td> 
                                <td class="px-6 py-4">
                                    <button 
                                        href="#" 
                                        @click="selectedItem(cuentaBanco)"
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
                                 Banco 
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

                            <div class="col-span-2">
                                <fw-select label="Bancos" 
                                    v-model:selected="form.BANC_ID" 
                                    defaultItem="Seleccione un banco">
                                    <option v-for="(banco, index) in bancos" :value="banco.BANC_ID">
                                        {{ banco.BANC_NOMBRE }}
                                    </option>
                                </fw-select>
                                <div v-if="form.errors.BANC_ID" class="text-red-600">
                                    {{ form.errors.BANC_ID }}
                                </div>
                            </div>

                            <div class="col-span-2">
                                <fw-select label="Cuenta Contable" 
                                    v-model:selected="form.CUEN_ID" 
                                    defaultItem="Seleccione una sucursal">
                                    <option v-for="(cuentasSucursale, index) in cuentasSucursales" :value="cuentasSucursale.CUEN_ID">
                                        <span>{{  cuentasSucursale.CUEN_NOMBRE + ' '+cuentasSucursale.sucursal.SUCU_NOMBRE   }}</span>
                                    </option>
                                </fw-select>
                                <div v-if="form.errors.CUEN_ID" class="text-red-600">
                                    {{ form.errors.CUEN_ID }}
                                </div>
                            </div>

                            <div class="col-span-2">
                                <fw-input label="Numero de Cuenta" 
                                    v-model:value="form.CUEB_NUMERO"
                                    placeholder="Numero de Cuenta" />

                                    <div v-if="form.errors.CUEB_NUMERO" class="text-red-600">
                                        {{ form.errors.CUEB_NUMERO }}
                                    </div>
                            </div>

                            <div class="col-span-2">
                                <fw-select label="Tipos de Cuenta" 
                                    v-model:selected="form.TIPC_ID" 
                                    defaultItem="Seleccione un tipo">
                                    <option v-for="(tipoCuenta, index) in tiposCuenta" :value="tipoCuenta.TIPO_ID">
                                        <span>{{  tipoCuenta.TIPO_NOMBRE   }}</span>
                                    </option>
                                </fw-select>

                                <div v-if="form.errors.TIPC_ID" class="text-red-600">
                                        {{ form.errors.TIPC_ID }}
                                </div>
                            </div> 

                            <div class="col-span-2">
                                <fw-text-area label="Detalle" 
                                    v-model:value="form.CUEB_DETALLE" 
                                    placeholder="Detalle..." />
                                <div v-if="form.errors.CUEB_DETALLE" class="text-red-600">
                                    {{ form.errors.CUEB_DETALLE }}
                                </div>
                            </div>

                        </div>

                        <div class="col-span-2"> 
                            <fw-checkbox label="Estado" 
                                :checked="form.CUEB_ESTADO" 
                                @update:checked="event => form.CUEB_ESTADO = event"/> 
                        </div>
                        <div class="flex flex-row w-full justify-end">
                            <fw-button :disabled="form.processing" type="submit">Guardar</fw-button>
                        </div>

                    </form>
                </div>
            </div>
        </div> 
    </fw-modal>
</NavigationLayout>  
    
</template>
