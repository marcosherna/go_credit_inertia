<script setup>

import FwModal from '../../../Components/';

</script> 
<template lang="">
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
 
</template>
