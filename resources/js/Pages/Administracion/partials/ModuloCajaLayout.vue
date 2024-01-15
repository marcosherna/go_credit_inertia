<script setup>
import NavigationLayout from '@/Layouts/NavigationLayout.vue';
import { Link } from '@inertiajs/vue3';

import {
    FirstAidKit, DataLine, FolderChecked,
    Guide, CreditCard, Notebook, Sunrise, Briefcase, ElemeFilled,
    Ticket, Flag,
} from '@element-plus/icons-vue'
import { reactive } from 'vue'

import { CCardIndicator } from '@Components/Customs/index';


const appRouteNameFromUrl = (url) => {
    const urls = url.toString().split('/')
    return urls.pop();
}

const config = reactive({
    content: 'Element Plus',
    font: {
        fontSize: 16,
        color: 'rgba(0, 0, 0, 0.15)',
    },
    zIndex: -1,
    rotate: -22,
    gap: [100, 100],
    offset: [],
})

</script>
<template>
    <navigation-layout title="Modulo Caja">

        <el-watermark content="GO Credit">
        </el-watermark>
        <div class="px-6  mx-auto">
            <div>
                <div class="flex items-center gap-x-3">
                    <h2 class="text-lg font-medium text-gray-800 dark:text-white">Modulo de Caja</h2>

                    <span
                        class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">Caja</span>
                </div>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300"></p>
            </div> 

            <div class="md:border md:border-gray-200 dark:border-gray-700 md:rounded-lg md:p-8 mb-6">
                <div class="grid grid-cols-12 gap-6">
                    <!-- BEGIN: Menu -->
                    <div class="col-span-12 max-h-md lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse ">
                        <div class="intro-y box mt-5 rounded-md bg-white shadow-lg">
                            <div class="relative flex items-center p-5">
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium text-base uppercase">Operaciones de Caja</div>
                                </div>
                            </div>
                            <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                                <Link :href="appRoute('modulo-caja-layout')"
                                    class="flex items-center text-primary font-medium hover:translate-x-7 hover:scale-110 transition-transform ease-in-out"
                                    :class="appRoute().current() === 'modulo-caja-layout' ? 'text-green-500' : ''">
                                <el-icon size="20">
                                    <DataLine />
                                </el-icon>
                                <i class="w-4 h-4 mr-2 "></i> Aplicar Pago Cuota
                                <span v-if="appRoute().current() === 'modulo-caja-layout'"
                                    class="flex w-3 h-3 me-3 ml-4 bg-green-500 rounded-full"></span>
                                </Link>
                                <Link :href="appRoute('colecturia-layout')"
                                    class="flex items-center mt-5 text-primary font-medium hover:translate-x-7 hover:scale-110 transition-transform ease-in-out"
                                    :class="appRoute().current() === 'colecturia-layout' ? 'text-green-500' : ''">
                                <el-icon size="20">
                                    <FirstAidKit />
                                </el-icon>
                                <i class="w-4 h-4 mr-2"></i> Colecturia
                                <span v-if="appRoute().current() === 'colecturia-layout'"
                                    class="flex w-3 h-3 me-3 ml-4 bg-green-500 rounded-full"></span>
                                </Link>
                                <Link :href="appRoute('creditos-desembolsados-layout')"
                                    class="flex items-center mt-5 text-primary font-medium hover:translate-x-7 hover:scale-110 transition-transform ease-in-out"
                                    :class="appRoute().current() === 'creditos-desembolsados-layout' ? 'text-green-500' : ''">
                                <el-icon size="20">
                                    <FolderChecked />
                                </el-icon>
                                <i class="w-4 h-4 mr-2"></i> Creditos Desembolsados
                                <span v-if="appRoute().current() === 'creditos-desembolsados-layout'"
                                    class="flex w-3 h-3 me-3 ml-4 bg-green-500 rounded-full"></span>
                                </Link>
                                <Link :href="appRoute('remesas-layout')"
                                    class="flex items-center mt-5 text-primary font-medium hover:translate-x-7 hover:scale-110 transition-transform ease-in-out"
                                    :class="appRoute().current() === 'chequera-layout' ? 'text-green-500' : ''">
                                <el-icon size="20">
                                    <Guide />
                                </el-icon>
                                <i class="w-4 h-4 mr-2"></i> Remesas
                                <span v-if="appRoute().current() === 'chequera-layout'"
                                    class="flex w-3 h-3 me-3 ml-4 bg-green-500 rounded-full"></span>
                                </Link>
                                <Link :href="appRoute('pagos-diversos-layout')" class="flex items-center mt-5 text-primary font-medium hover:translate-x-7 hover:scale-110 transition-transform ease-in-out"
                                    :class="appRoute().current() === 'chequera-layout' ? 'text-green-500' : ''">
                                    <el-icon size="20">
                                        <CreditCard />
                                    </el-icon>
                                    <i class="w-4 h-4 mr-2"></i> Pagos Diversos
                                    <span v-if="appRoute().current() === 'pagos-diversos-layout'"
                                        class="flex w-3 h-3 me-3 ml-4 bg-green-500 rounded-full"></span>
                                </Link>
                                <Link :href="appRoute('arqueo-caja-layout')" class="flex items-center mt-5 text-primary font-medium hover:translate-x-7 hover:scale-110 transition-transform ease-in-out"
                                    :class="appRoute().current() === 'arqueo-caja-layout' ? 'text-green-500' : ''">
                                    <el-icon size="20">
                                        <Notebook />
                                    </el-icon>
                                    <i class="w-4 h-4 mr-2"></i> Arqueo de Caja
                                    <span v-if="appRoute().current() === 'arqueo-caja-layout'"
                                        class="flex w-3 h-3 me-3 ml-4 bg-green-500 rounded-full"></span>
                                </Link>
                                <a class="flex items-center mt-5 text-primary font-medium hover:translate-x-7 hover:scale-110 transition-transform ease-in-out"
                                    :class="appRoute().current() === 'chequera-layout' ? 'text-green-500': ''">
                                <el-icon size="20">
                                    <Sunrise />
                                </el-icon>
                                <i class="w-4 h-4 mr-2"></i> Opciones
                                <span v-if="appRoute().current() === 'chequera-layout'"
                                    class="flex w-3 h-3 me-3 ml-4 bg-green-500 rounded-full"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- END: Menu-->
                <!-- BEGIN: Contenido-->
                <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
                    <div class="overflow-x-auto">


                        <slot />
                    </div>
                </div>
            </div>
        </div>
    </div>
</navigation-layout></template>