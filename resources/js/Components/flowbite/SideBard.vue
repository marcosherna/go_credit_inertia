<script setup>
import DropdownNav from './DropdownNav.vue'
import DropdownNavItem from './DropdownNavItem.vue';
import { ref } from 'vue';
import  CrearSolicitud from '../../Pages/Creditos/CrearSolicitud.vue';

defineProps({
    DropdownNav,
    DropdownNavItem
})

const showModal = ref(false)

</script> 

<template lang="">
    <div>
        <aside
                class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
                aria-label="Sidenav" id="drawer-navigation">
                <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
                     
                    <ul class="space-y-2">
                        <li>
                            <a href="#"
                                class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <svg aria-hidden="true"
                                    class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                </svg>
                                <span class="ml-3">Panel de Control</span>
                            </a>
                        </li>
                        <li>
                            <DropdownNav title="Contabilidad" dropdownId="dropdown-item-crap">
                                <template #icon>
                                    <path d="M1 13a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6H1v7Zm5.293-3.707a1 1 0 0 1 1.414 0L8 9.586V8a1 1 0 0 1 2 0v1.586l.293-.293a1 1 0 0 1 1.414 1.414l-2 2a1 1 0 0 1-1.416 0l-2-2a1 1 0 0 1 .002-1.414ZM17 0H1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1Z"/>
                                </template> 
                                <template #items> 
                                    <DropdownNavItem :href="route('banco-layout')" title="Banco" /> 
                                    <DropdownNavItem :href="route('partida-contable-layout')" title="Contabilidad" /> 
                                </template>
                             </DropdownNav>
                        </li> 
                        <li>
                            <DropdownNav title="Administrar" dropdownId="dropdown-administracion">
                                <template #icon>
                                    <path d="M1 13a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6H1v7Zm5.293-3.707a1 1 0 0 1 1.414 0L8 9.586V8a1 1 0 0 1 2 0v1.586l.293-.293a1 1 0 0 1 1.414 1.414l-2 2a1 1 0 0 1-1.416 0l-2-2a1 1 0 0 1 .002-1.414ZM17 0H1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1Z"/>
                                </template> 
                                <template #items> 
                                    <DropdownNavItem :href="route('clientes-layout')" title="Clientes" /> 
                                    <DropdownNavItem :href="route('modulo-caja-layout')" title="Caja" /> 
                                </template>
                             </DropdownNav>
                        </li> 
                        <li>
                            <DropdownNav title="Creditos" dropdownId="dropdown-creditos">
                                <template #icon>
                                    <path d="M1 13a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6H1v7Zm5.293-3.707a1 1 0 0 1 1.414 0L8 9.586V8a1 1 0 0 1 2 0v1.586l.293-.293a1 1 0 0 1 1.414 1.414l-2 2a1 1 0 0 1-1.416 0l-2-2a1 1 0 0 1 .002-1.414ZM17 0H1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1Z"/>
                                </template> 
                                <template #items> 
                                    <crear-solicitud />
                                     
                                    <DropdownNavItem :href="route('creditos-por-aprobar-layout')" title="Por Aprobar" />  
                                    <DropdownNavItem :href="route('creditos-por-procesar-layout')" title="Por Procesar"/>  
                                    <DropdownNavItem :href="route('creditos-layout')" title="Cartera" /> 
                                </template>
                             </DropdownNav>
                        </li> 
                         
                    </ul> 
                </div> 
            </aside> 
    </div>

    

</template>
