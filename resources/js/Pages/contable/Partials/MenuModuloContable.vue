<script setup> 
import { Link } from '@inertiajs/vue3';  
defineProps({
    Link,
}) 
</script> 

<template lang="">
    <div class="col-span-12 max-h-md lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse ">
        <div class="intro-y box mt-5 rounded-md bg-white shadow-lg">
            <div class="relative flex items-center p-5">
                <div class="ml-4 mr-auto">
                    <div class="font-medium text-base">Modulo Contable</div>
                        <div class="text-slate-500">go credit</div>
                    </div>
                </div>
                <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                    <a  class="flex items-center text-primary font-medium">
                        <i class="w-4 h-4 mr-2"></i> Partida Contable
                    </a>
                    <a class="flex items-center mt-5">
                        <i class="w-4 h-4 mr-2"></i> Cierre Contable
                    </a>
                    <Link :href="route('catalogo-cuentas-layout')" class="flex items-center mt-5">
                        <i class="w-4 h-4 mr-2"></i> Catalogos de Cuentas
                    </Link>
                <a class="flex items-center mt-5">
                    <i class="w-4 h-4 mr-2"></i> Crear Partida
                </a>
            </div>
        </div>
    </div>
</template>
