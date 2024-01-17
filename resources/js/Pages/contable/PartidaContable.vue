<script setup>
import ModuloContableLayout from './Partials/ModuloContableLayout.vue';
import {FwButton, PlusIcon, FwTable, FwCheckbox} from '@Components/flowbite'

defineProps({
    cuentasSucursales: Array
})

</script>

<template lang="">
    <modulo-contable-layout> 
        <template #opctions> 
            <fw-button type="button">
                <plus-icon class="w-4 h-4 me-2"/>
                Nueva Partida 
            </fw-button>
        </template>

        <template #content> 
            <fw-table>

                <template #head>
                    <th class="py-3 px-6 text-left">Código</th>
                    <th class="py-3 px-6 text-left">Descripción</th>
                    <th class="py-3 px-6 text-left">Tipo</th>
                    <th class="py-3 px-6 text-left">Estado</th>
                    <th class="py-3 px-6 text-left">Acciones</th>
                </template>

                <template #body>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4 text-center">0000000123</td>
                        <th scope="row">
                            <div class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">nomnbreasd
                                <div class="text-gray-400">
                                    asdasdasdsd
                                </div>
                            </div>
                        </th>
                        <th scope="row">
                            <div class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">nomnbreasd
                                <div class="text-gray-400">
                                    asdasdasdsd
                                </div>
                            </div>
                        </th>
                        <td class="px-6 py-4"> 
                            <fw-checkbox checked/>
                        </td>
                        <td class="px-6 py-4">
                            <button href="#" class="font-medium text-green-600 dark:text-green-500 hover:underline">Editar</button>
                            <a href="#" class="px-3 font-medium text-green-600 dark:text-green-500 hover:underline">Ver</a>
                        </td>
                    </tr>  
                </template> 
            </fw-table>
        </template> 
    </modulo-contable-layout>
</template>
