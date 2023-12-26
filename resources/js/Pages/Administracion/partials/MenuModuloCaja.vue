<template lang="">
    <div class="col-span-12 max-h-md lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse ">
        <div class="intro-y box mt-5 rounded-md bg-white shadow-lg">
            <div class="relative flex items-center p-5">
                <div class="ml-4 mr-auto">
                    <div class="font-medium text-base">Operaciones de Caja</div> 
                    </div>
                </div>
                <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                    <Link :href="route('banco-layout')" class="flex items-center text-primary font-medium">
                        <i class="w-4 h-4 mr-2"></i> Aplicar Pago Cuota
                    </Link>
                    <Link :href="route('cuenta-banco-layout')" class="flex items-center mt-5">
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
                        <i class="w-4 h-4 mr-2"></i> Operaciones
                    </a>
                </div>
            </div>
        </div>
</template>
<script>
export default {

}
</script>
<style lang="">
    
</style>