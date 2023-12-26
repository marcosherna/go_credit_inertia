<script setup>
import NavigationLayout from '@/Layouts/NavigationLayout.vue';
import { Link } from '@inertiajs/vue3';

</script>
<template>
    <navigation-layout title="Modulo Caja">
        <div class="px-12  mx-auto">  
            <div>
                <div class="flex items-center gap-x-3">
                    <h2 class="text-lg font-medium text-gray-800 dark:text-white">Modulo de Caja</h2>

                    <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">Caja</span>
                </div>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300"></p>
            </div>
 
            <slot name="header" /> 

            <div class="border border-gray-200 dark:border-gray-700 md:rounded-lg p-4 px-4 mt-4 md:p-8 mb-6">
                <div class="grid grid-cols-12 gap-6">
                            <!-- BEGIN: Menu --> 
                            <div class="col-span-12 max-h-md lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse ">
                                <div class="intro-y box mt-5 rounded-md bg-white shadow-lg">
                                    <div class="relative flex items-center p-5">
                                        <div class="ml-4 mr-auto">
                                            <div class="font-medium text-base">Operaciones de Caja</div> 
                                            </div>
                                        </div>
                                        <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                                            <Link :href="route('modulo-caja-layout')" class="flex items-center text-primary font-medium">
                                                <i class="w-4 h-4 mr-2"></i> Aplicar Pago Cuota
                                            </Link>
                                            <Link :href="route('creditos-desembolsados-layout')" class="flex items-center mt-5">
                                                <i class="w-4 h-4 mr-2"></i> Creditos Desembolsados
                                            </Link>
                                            <Link :href="route('chequera-layout')" class="flex items-center mt-5">
                                                <i class="w-4 h-4 mr-2"></i> Remesas
                                            </Link>
                                            <a class="flex items-center mt-5">
                                                <i class="w-4 h-4 mr-2"></i> Pagos Diversos
                                            </a>
                                            <a class="flex items-center mt-5">
                                                <i class="w-4 h-4 mr-2"></i> Arqueo de Caja
                                            </a>
                                            <a class="flex items-center mt-5">
                                                <i class="w-4 h-4 mr-2"></i> Opciones
                                            </a>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Menu--> 
                            <!-- BEGIN: Contenido--> 
                            <div class="col-span-12 lg:col-span-8 2xl:col-span-9">  
                                <div class="relative overflow-x-auto">
                                     <slot />
                                    </div>
                                </div>
                            </div> 
            </div>
        </div> 
    </navigation-layout>
</template>