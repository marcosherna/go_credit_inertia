<script setup>
import { computed, onMounted, onUnmounted, watch, ref } from 'vue';
import referencias from './Referencias.vue';
import garantias from './Garantias.vue';
import { Delete } from '@element-plus/icons-vue'
import { ElMessage } from 'element-plus';
 
const lstReferencias = ref([]);
const lstGarantias = ref([]);

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    solicitud: {
        type: Object,
        default: () => ({})
    }
});

const selection = ref(false);

const emit = defineEmits(['close']);

watch(() => props.show, () => {
    if (props.show) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = null;
    }
});

const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});

const addReferencia = (data) => {

    const referencia = lstReferencias.value.find(r => r.REFE_DUI === data.REFE_DUI) || null;
    if(referencia){
        ElMessage({
            showClose: true,
            message: 'El DUI ya existe',
            type: 'error'
        })
        return;
    }

    if(lstReferencias.value.length < 3){ 
        lstReferencias.value.push(data);   
        ElMessage({
            showClose: true,
            message: 'Guardado',
            type: 'success'
        })
    }  else {
        ElMessage({
            showClose: true,
            message: 'Solo se permite 3 referencias',
            type: 'error'
        })
    }
}

const addGarantias = (data) => {
    if(lstGarantias.value.length < 3){ 
        lstGarantias.value.push(data);   
        
        ElMessage({
            showClose: true,
            message: 'Guardado',
            type: 'success'
        })
    }  else {
        ElMessage({
            showClose: true,
            message: 'Solo se permite 3 garantias',
            type: 'error'
        })
    }
}

const removeReferencia = (index) => {
    lstReferencias.value.splice(index, 1);
}

const removeGarantias = (index) => {
    lstGarantias.value.splice(index, 1);
}

const maxWidthClass = computed(() => {
    return {
        'sm': 'sm:max-w-sm',
        'md': 'sm:max-w-md',
        'lg': 'sm:max-w-lg',
        'xl': 'sm:max-w-xl',
        '2xl': 'sm:max-w-2xl',
        '3xl': 'sm:max-w-3xl'
    }[props.maxWidth];
});


const items = {
    header : [ { 
            onSelected: ref(true), 
            title: 'Fiador', 
            icon: 'M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z',
            component: 'referencias'  }, 
        { 
            onSelected: ref(false), 
            title: 'Garantias', 
            icon: 'M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z',
            component: 'garantias' 
        },
        { 
            onSelected: ref(false), 
            title: 'Disabled', 
            icon:'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z', 
            component: 'disabled' },
    ],  
} 

const onSelected =   (component, index) => {
    
    if(!items.header[index].onSelected.value){
        items.header.forEach((item, i) => {
            if(i === index){ 
                items.header[i].onSelected.value = true;
            }else{ 
                items.header[i].onSelected.value = false;
            }
        });
    }
    
} 
</script>

<template>
    <teleport to="body">
        <transition leave-active-class="duration-200">
            <div v-show="show" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" scroll-region>
                <transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0"
                    enter-to-class="opacity-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100"
                    leave-to-class="opacity-0">
                    <div v-show="show" class="fixed inset-0 transform transition-all" @click="close">
                        <div class="absolute inset-0 bg-slate-900 opacity-20" />
                    </div>
                </transition>

                <transition enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div v-show="show" class="overflow-hidden  transform transition-all sm:w-full sm:mx-auto"
                        :class="maxWidthClass">


                        <div v-if="show" class="overflow-y-auto overflow-x-hidden 
                            justify-center items-center w-full md:inset-0 
                            h-[calc(100%-1rem)] max-h-full">

                            <div class="relative w-full max-h-full" :class="maxWidthClass">
                                <!-- Modal content -->
                                <div class="md:flex">
                                    <ul
                                        class="flex-column space-y space-y-4 text-sm font-medium text-gray-500 dark:text-gray-400 md:me-4 mb-4 md:mb-0">
                                        <li v-for="(item, index) in items.header">
                                            <a href="#"
                                                class="inline-flex shadow-xl items-center px-4 py-3  rounded-lg active w-full"
                                                v-on:click="onSelected(item.component, index)"
                                                :class="{'bg-green-500 text-white': item.onSelected.value, 'bg-gray-50' : !item.onSelected.value}" 
                                                aria-current="page">
                                                <svg class="w-4 h-4 me-2" aria-hidden="true"
                                                    :class="{'text-white': item.onSelected.value, 'text-gray-500' : !item.onSelected.value}"
                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        :d="item.icon" />
                                                </svg>
                                                {{ item.title }}
                                            </a>
                                        </li>  
                                    </ul>
                                    <div
                                        class="p-3 bg-gray-50 shadow-xl text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full"> 
 
                                        <referencias  v-if="items.header[0].onSelected.value" 
                                            v-on:response="data => addReferencia(data)"/>
                                        <garantias v-on:response="data => addGarantias(data)" v-if="items.header[1].onSelected.value" /> 

                                        <div v-if="items.header[2].onSelected.value"> 
                                            <div v-if="lstReferencias.length > 0" class="relative flex flex-col min-w-0 break-words w-full mb-6"> 
                                                <div class="block w-full overflow-x-auto">
                                                    <table  class="items-center w-full border-collapse text-blueGray-700 ">
                                                        <thead class="thead-light ">
                                                            <tr>
                                                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                                    REFERENCIAS
                                                                </th> 
                                                                <th class="px-6 bg-blueGray-50 text-blueGray-700 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left min-w-140-px">
                                                                    
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(r, index) in lstReferencias">
                                                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                                    
                                                                   {{ r.REFE_DUI }}  / {{ r.REFE_NOMBRES  }}
                                                                    <div>
                                                                        <span class="mr-2"> {{ r.REFE_TELEFONO }} /{{ r.REFE_DIRECCION  }}</span>
                                                                    </div>
                                                                </th> 
                                                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                                    <div class="flex items-center">
                                                                        <span class="mr-2">
                                                                            <el-icon v-on:click="removeReferencia(index)" :size="17">
                                                                                <Delete />
                                                                            </el-icon>
                                                                        </span> 
                                                                    </div>
                                                                </td>
                                                            </tr> 
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div> 


                                            <div v-if="lstGarantias.length > 0" class="relative flex flex-col min-w-0 break-words w-full mb-6"> 
                                                <div class="block w-full overflow-x-auto">
                                                    <table  class="items-center w-full border-collapse text-blueGray-700 ">
                                                        <thead class="thead-light ">
                                                            <tr>
                                                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                                    GARANTIAS
                                                                </th> 
                                                                <th class="px-6 bg-blueGray-50 text-blueGray-700 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left min-w-140-px">
                                                                    
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(g, index) in lstGarantias">
                                                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                                     
                                                                    $ {{ g.PREN_PRECIO }} /{{ g.PREN_NOMBRE }} - {{g.PREN_MARCA }}, {{ g.PREN_MODELO }}
                                                                    <div>
                                                                        <span class="mr-2"> {{ g.PREN_DETALLE }}</span>
                                                                    </div>
                                                                </th> 
                                                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                                    <div class="flex items-center">
                                                                        <span class="mr-2">
                                                                            <el-icon v-on:click="removeGarantias(index)" :size="17">
                                                                                <Delete />
                                                                            </el-icon>
                                                                        </span> 
                                                                    </div>
                                                                </td>
                                                            </tr> 
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>   
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </transition>
    </teleport>
</template>
