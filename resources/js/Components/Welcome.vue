<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Welcome" />

    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Catalogos</h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Menu -->
        <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse bg-white rounded-md">
            <div class="intro-y box mt-5">
                <div class="relative flex items-center p-5">

                    <div class="ml-4 mr-auto">
                        <div class="font-medium text-base">Modulo de Banco</div>
                        <div class="text-slate-500">go credit</div>
                    </div>
                </div>
                <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                    <a class="flex items-center text-primary font-medium">
                        <i data-lucide="activity" class="w-4 h-4 mr-2"></i> Bancos
                    </a>
                    <a class="flex items-center mt-5" >
                        <i data-lucide="activity" class="w-4 h-4 mr-2"></i> Cuentas Banco
                    </a>
                    <a class="flex items-center mt-5" >
                        <i data-lucide="box" class="w-4 h-4 mr-2"></i> Chequera
                    </a>
                    <a class="flex items-center mt-5">
                        <i data-lucide="lock" class="w-4 h-4 mr-2"></i> Control Chequera
                    </a>
                </div>
            </div>
        </div>


        <!-- END: Menu-->

        <!-- BEGIN: Contenido-->
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
        </div>
        <!-- END: Contenido-->
    </div>
</template>
