<script setup> 
import { FwModal, FwSearchBar } from '../../Components/flowbite';
import { ref, onMounted} from 'vue';
import solicitudServices from '../../services/solicitudServices';
import { ElMessage } from 'element-plus'; 
import {FolderOpened } from '@element-plus/icons-vue'
import { SpinnerBars } from '../../Components/spinners/index.js'
 
const showModal = ref(false)   
const clientes = ref([])
const search = ref('')
const loading = ref(false)
 

const onSearch = async () => {
    try {
        loading.value = true
        const response = await solicitudServices.search(search.value) 
        clientes.value = response   
    } catch (error) {
        ElMessage({
            showClose: true,
            message: error.message,
            type: 'error'
        })
    } finally{
        loading.value = false
    }
}

const onSelection = (c) => {
    console.log(c)
}

const handlerClose = () => {
    search.value = ''
    clientes.value = []
    showModal.value = false
}
 
</script> 
<template lang="">
     <button v-on:click="showModal = true" class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Crear Creditos</button>

     <fw-modal :show="showModal" 
        maxWidth="xl"
        @close="handlerClose">
        
        <template #header>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Seleccionar Cliente
            </h3>
        </template>
        <template #body> 
            <div class="p-4 md:p-5">
                <!-- This is an example component -->
                <div class="max-w-2xl mx-auto">

                    <div class="flex items-center">   
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input v-model="search" v-on:keyup.enter="onSearch" type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Search" required>
                        </div>
                        <button v-on:click="onSearch" type="submit" class="p-2.5 ml-2 text-sm font-medium text-white bg-green-500 rounded-lg border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div> 
                </div>

                <div class="overflow-x-auto mt-5">
                    <div v-if="loading" class="w-full flex flex-row justify-center">
                        <spinner-bars/>
                    </div>
                    <table v-if="!loading" class="table-auto w-full">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Id</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Nombre</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Telefono</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Acciones</div>
                                </th>
                            </tr>
                        </thead>
                        
                        <tbody class="text-sm divide-y divide-gray-100"> 
                            
                            <tr v-for="(c, index) in clientes" >
                                <td class="p-2 whitespace-nowrap">
                                    {{ c.CLIE_ID }}
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="flex flex-col justify-center"> 
                                        <div class="font-medium text-gray-800">{{ c.NOMBRE }}</div>
                                        <div class="text-left">{{ c.MAIL }}</div>
                                    </div>
                                </td>
                                
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left font-medium text-green-500">{{ c.TELEFONO }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap text-center">

                                    <el-tooltip
                                        class="box-item"
                                        effect="dark"
                                        content="Precione Para Seleccionar"
                                        placement="left"
                                        >
                                            <el-icon v-on:click="onSelection(c.CLIE_ID)" size="17">
                                                <FolderOpened />
                                            </el-icon>
                                    </el-tooltip>  
                                </td>
                            </tr>  
                        </tbody>
                    </table>
                </div> 

            </div> 
        </template> 
    </fw-modal> 
</template> 