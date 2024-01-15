<script setup> 
import { Link } from '@inertiajs/vue3';  

import {   Wallet, Coin, 
    TrophyBase, OfficeBuilding
} from '@element-plus/icons-vue'
 
</script> 

<template lang="">
    <div class="col-span-12 max-h-md lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse ">
        <div class="intro-y box mt-5 rounded-md bg-white shadow-lg">
            <div class="relative flex items-center p-5">
                <div class="ml-4 mr-auto">
                    <div class="font-medium text-base">Modulo de Banco</div>
                        <div class="text-slate-500">go credit</div>
                    </div>
                </div>
                <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                    <Link :href="appRoute('banco-layout')" class="flex items-center text-primary font-medium"
                        :class="appRoute().current() === 'banco-layout' ? 'text-green-500' : ''">
                        <el-icon size="20"><TrophyBase /></el-icon>
                        <i class="w-4 h-4 mr-2"></i> Bancos
                        <span v-if="appRoute().current() === 'banco-layout'"
                                    class="flex w-3 h-3 me-3 ml-4 bg-green-500 rounded-full">
                                </span>
                    </Link>
                    <Link :href="appRoute('cuenta-banco-layout')" class="flex items-center mt-5"
                        :class= "appRoute().current() == 'cuenta-banco-layout' ? 'text-green-500' : ''">
                        <el-icon size="20">
                                    <el-icon><Coin /></el-icon>
                                </el-icon>
                        <i class="w-4 h-4 mr-2"></i> Cuentas Banco
                        <span v-if="appRoute().current() === 'cuenta-banco-layout'"
                                    class="flex w-3 h-3 me-3 ml-4 bg-green-500 rounded-full">
                                </span>
                    </Link>
                    <Link :href="appRoute('chequera-layout')" class="flex items-center mt-5"
                        :class="appRoute().current() == 'chequera-layout' ? 'text-green-500' : ''" >
                        <el-icon size="20"><Wallet /></el-icon>
                        <i class="w-4 h-4 mr-2"></i> Chequera
                        <span v-if="appRoute().current() === 'chequera-layout'"
                                    class="flex w-3 h-3 me-3 ml-4 bg-green-500 rounded-full">
                                </span>
                    </Link>
                    <a class="flex items-center mt-5">
                        <el-icon size="20"><OfficeBuilding /></el-icon>  
                        <i class="w-4 h-4 mr-2"></i> Control Chequera
                    </a>
            </div>
        </div>
    </div> 
</template>
