<script setup>  
import { useForm } from '@inertiajs/vue3';
import NavigationLayout from '../../../Layouts/NavigationLayout.vue'; 
import { FwTable, FwBadge, FwButton, FwModal, 
    FwInput, FwTextArea, FwSelect, FwRadioCheckbox, FwSearchBar} from '../../../Components/flowbite/index.js';
import controller from './ClienteController.js';
import { defineProps, ref } from 'vue';
import { ElMessage } from 'element-plus';

const form = useForm({ 
    ...controller.model,   
}) 

const props = defineProps({
    paises:Array,
    estadosCiviles:Array,
    sucursales:Array, 
    empresas:Array,
})

const paises = ref(props.paises);
const departamentos = ref([]);
const municipios = ref([]); 

// antecedentes
const antecentesSi = ref(false);
const antecentesNo = ref(true);

// ingresos adicionales
const ingresosAdicionalesSi = ref(false);
const ingresosAdicionalesNo = ref(true);

// tipo cliente 
const juridico  = ref(false);
const natural = ref(true);

const openModalAdd = async () => {
    modalAdd.value = true;
    paises.value = paises.value.length == 0 ? await controller.getPaises() : paises.value;   
}

const filtrarDepartamentos = async (id_pais) => {
    departamentos.value = await controller.getDepartamentos(id_pais);
}

const filtrarMunicipios = async (id_departamento) => {
    municipios.value =  await controller.getMunicipios(id_departamento); 
} 

const hasAntecendetes  =  (value, text) => { 
    form.CLIE_ANTECEDENTES = value ? 1 : 0;
    
    if (text == 'si'){
        antecentesNo.value = false;
    }else{
        antecentesSi.value = false;
    }
}

const hasIngresosAdicionales  = (value, text) => { 
    form.CLIE_INGRESOADIC =  value ? 1 : 0;

    if (text == 'si'){
        ingresosAdicionalesNo.value = false;
    }else{
        ingresosAdicionalesSi.value = false;
    } 
}

const tipoCliente = (value, text) => {
    form.CLIE_TIPOCLIENTE = value ? 1 : 0;

    if (text == 'juridico'){
        natural.value = false;
    }else{
        juridico.value = false;
    }
}

const validation = () => {
    if(form.CLIE_SEXO == '0'){ 
            form.errors.CLIE_SEXO = 'Seleccione una opcion';
            throw new Error('Seleccione un genero');
        }

        if(form.ESTA_ID == '0'){ 
            form.errors.ESTA_ID = 'Seleccione una opcion';
            throw new Error('Seleccione una opcion');
        }

        if(form.PAIS_NAC == '0'){ 
            form.errors.PAIS_NAC = 'Seleccione una opcion';
            throw new Error('Seleccione un pais');
        }

        if(form.DEPA_NAC == '0'){ 
            form.errors.DEPA_NAC = 'Seleccione una opcion';
            throw new Error('Seleccione un departamento');
        }

        if(form.MUNI_ID == '0'){ 
            form.errors.MUNI_ID = 'Seleccione una opcion';
            throw new Error('Seleccione un municipio')
        }

        if(form.SUCU_ID == '0'){ 
            form.errors.SUCU_ID = 'Seleccione una opcion'
            throw new Error('Seleccione una sucursal')
        }

        if(form.CLIE_CATEGORIA == '0'){ 
            form.errors.CLIE_CATEGORIA = 'Seleccione una opcion';
            throw new Error('Seleccione una categiria')
        }

        if(form.CLIE_TIPOEMPLEO == '0'){ 
            form.errors.CLIE_TIPOEMPLEO = 'Seleccione una opcion';
            throw new Error('Seleccione un tipo de empleo');
        }

        if(form.CLIE_TIPOCASA == '0'){ 
            form.errors.CLIE_TIPOCASA = 'Seleccione una opcion';
            throw new Error('Seleccione un tipo de casa');
        }

        if(form.CLIE_INGRESOPROM == '0'){ 
            form.errors.CLIE_INGRESOPROM = 'Seleccione una opcion';
            throw new Error('Seleccione un ingreso promedio');
        }
}


const submit = () => {
 
    try{
        
        validation();

        const genero  =  controller.genero.find((g) => g.text == form.CLIE_SEXO);
        const estadoCivil = props.estadosCiviles.find((e) => e.ESTA_ID == form.ESTA_ID);
        const tipoCasa = controller.tipoCasa.find((t) => t.text == form.CLIE_TIPOCASA);
        const categoria = controller.categorias.find((c) => c.text == form.CLIE_CATEGORIA);
        const promingres = controller.ingresoPromedio.find((i) => i.text == form.CLIE_INGRESOPROM);
        const tipoEmpleado = controller.tipoEmpleo.find((t) => t.text == form.CLIE_TIPOEMPLEO); 
        const pais = props.paises.find((p) => p.PAIS_ID == form.PAIS_NAC);
        const departamento = departamentos.value.find((d) => d.DEPA_ID == form.DEPA_NAC);
        const municipio = municipios.value.find((m) => m.MUNI_ID == form.MUNI_ID);
        const sucursal = props.sucursales.find((s) => s.SUCU_ID == form.SUCU_ID); 

        const nombres = form.CLIE_NOMBRE.split(' ');
        const apellidos = form.CLIE_APELLIDO.split(' ');
        

        form.transform( data => ({
            ...data, 
            CLIE_NOMBRE: nombres[0],
            CLIE_NOMBRE2: nombres.length > 1 ? nombres[1] : null,
            CLIE_NOMBRE3: nombres.length == 3 ? nombres[2] : null,
            CLIE_APELLIDO: apellidos[0],
            CLIE_APELLIDO2: apellidos.length > 1 ? apellidos[1] : null,
            CLIE_APELLIDO3: apellidos.length == 3 ? apellidos[2] : null, 
            CLIE_SEXO: `${genero.value}`,
            ESTA_ID: estadoCivil.ESTA_ID,
            CLIE_TIPOCASA: tipoCasa.value,
            CLIE_CATEGORIA: categoria.text,
            CLIE_INGRESOPROM: promingres.value,
            CLIE_TIPOEMPLEO: tipoEmpleado.value,
            PAIS_NAC: pais.PAIS_ID,
            DEPA_NAC: departamento.DEPA_ID,
            MUNI_ID: municipio.MUNI_ID,
            SUCU_ID: sucursal.SUCU_ID,
            CLIE_ANTECEDENTES: antecentesSi.value ? antecentesSi.value  : antecentesNo.value,
            CLIE_TIPOCLIENTE: juridico.value ? juridico.value : natural.value,
            CLIE_INGRESOADIC: ingresosAdicionalesSi.value ? ingresosAdicionalesSi.value : ingresosAdicionalesNo.value,
        })).post(route('cliente.create'), {
            preserveScroll: true,
            onError: (errors) => {
                console.log(errors);
                ElMessage({ 
                    message: errors,
                    type: 'error'
                })
            },
            onSuccess: () => {
                ElMessage({ 
                    message: 'Cliente creado correctamente',
                    type: 'success'
                })
                form.reset(); 
            },
        });


    }catch(e){
        ElMessage({ 
            message: e.message,
            type: 'error'
        })
        console.log(e);
    }
    
}

</script>

<template lang=""> 
    <navigation-layout title="Detalle Cliente">   
        <form @submit.prevent="submit" class="lg:px-40 p-4 md:p-5"> 
            <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Nombres" 
                                    v-model:value="form.CLIE_NOMBRE" 
                                    placeholder="nombres..."/>
                                <div v-show="form.errors.CLIE_NOMBRE" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_NOMBRE }}
                                </div>
                            </div>
                            <div class="col-span-2 sm:col-span-1">   
                                <fw-input label="Apellidos" 
                                    v-model:value="form.CLIE_APELLIDO" 
                                    placeholder="apellidos..."/>
                                <div v-show="form.errors.CLIE_APELLIDO" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_APELLIDO }}
                                </div>
                            </div> 

                            <div class="col-span-2 sm:col-span-1">
                                <fw-select label="Genero"
                                    v-model:selected="form.CLIE_SEXO"  
                                    defaultItem="Seleccione una cuenta"> 
                                    <option v-for="(g, index) in controller.genero" :value="g.text">{{ g.text}}</option> 
                                </fw-select>
                                <div v-show="form.errors.CLIE_SEXO" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_SEXO }}
                                </div>
                            </div> 
 
                            <div class="col-span-2 sm:col-span-1">
                                <fw-select label="Estado Civil"
                                    v-model:selected="form.ESTA_ID" 
                                    defaultItem="Seleccione una cuenta"> 
                                    <option v-for="(estado, index) in estadosCiviles" 
                                        :value="estado.ESTA_ID"> {{ estado.ESTA_NOMBRE }}</option>
                                </fw-select>
                                <div v-show="form.errors.ESTA_ID" class="text-red-500 text-sm">
                                    {{  form.errors.ESTA_ID }}
                                </div>
                            </div> 

                            <div class="col-span-2">
                                <label for="input-group-1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo Electronico</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                            <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                                            <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
                                        </svg>
                                    </div>
                                    <input v-model="form.CLIE_MAIL" type="text" id="input-group-1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="name@gmail.com">
                                </div>
                            </div>

                            <div class="col-span-2">
                                <label for="input-group-1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Otro. Correo Electronico</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                            <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                                            <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
                                        </svg>
                                    </div>
                                    <input v-model="form.CLIE_MAIL2" type="text" id="input-group-1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="name@gmail.com">
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Fecha nacimiento"
                                    type="date"
                                    v-model:value="form.CLIE_FECHANAC"
                                    placeholder="">  
                                </fw-input>
                                <div v-show="form.errors.CLIE_FECHANAC" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_FECHANAC }}
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <fw-select label="Pais de Nacimiento"
                                    v-model:selected="form.PAIS_NAC"
                                    :onUpdate:selected="filtrarDepartamentos"
                                    defaultItem="Seleccione una cuenta"> 
                                    <option v-for="(pais, index) in paises" 
                                        :value="pais.PAIS_ID"> {{ pais.PAIS_NOMBRE }}</option>
                                </fw-select>
                                <div v-show="form.errors.PAIS_NAC" class="text-red-500 text-sm">
                                    {{  form.errors.PAIS_NAC }}
                                </div>
                            </div> 
                            <div class="col-span-2">
                                <fw-select label="Departamento"
                                    v-model:selected="form.DEPA_NAC" 
                                    :onUpdate:selected="filtrarMunicipios" 
                                    defaultItem="Seleccione una cuenta"> 
                                    <option v-for="(departamento, index) in departamentos" 
                                        :value="departamento.DEPA_ID"> {{ departamento.DEPA_NOMBRE }}</option>
                                </fw-select>
                                <div v-show="form.errors.DEPA_NAC" class="text-red-500 text-sm">
                                    {{  form.errors.DEPA_NAC }}
                                </div>
                            </div> 
                            <div class="col-span-2">
                                <fw-select label="Municipio"
                                    v-model:selected="form.MUNI_ID"  
                                    defaultItem="Seleccione una cuenta"> 
                                    <option v-for="(municipio, index) in municipios" 
                                        :value="municipio.MUNI_ID"> {{ municipio.MUNI_NOMBRE }}</option>
                                </fw-select>
                                <div v-show="form.errors.MUNI_ID" class="text-red-500 text-sm">
                                    {{  form.errors.MUNI_ID }}
                                </div>
                            </div> 

                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Telefono" 
                                    v-model:value="form.CLIE_TEL" 
                                    placeholder="telefono..."/>
                                <div v-show="form.errors.CLIE_TEL" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_TEL }}
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Telefono Casa" 
                                    v-model:value="form.CLIE_TEL2" 
                                    placeholder="telefono..."/>
                                <div v-show="form.errors.CLIE_TEL2" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_TEL2 }}
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Dui" 
                                    v-model:value="form.CLIE_DOCIDEN" 
                                    placeholder="dui..."/>
                                <div v-show="form.errors.CLIE_DOCIDEN" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_DOCIDEN }}
                                </div>
                            </div> 

                            <div class="col-span-2 sm:col-span-1"> 
                                <fw-input label="Fecha Vencimiento Dui" 
                                    v-model:value="form.CLIE_DOCIDENVEN" 
                                    type="date"
                                    placeholder="fecha dui..."/>
                                <div v-show="form.errors.CLIE_DOCIDENVEN" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_DOCIDENVEN }}
                                </div>
                            </div>

                            <div class="col-span-2">
                                <fw-input label="NIT" 
                                    v-model:value="form.CLIE_DOCFISCAL" 
                                    placeholder="nit..."/>
                                <div v-show="form.errors.CLIE_DOCFISCAL" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_DOCFISCAL }}
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Pasaporte" 
                                    v-model:value="form.CLIE_PASAPORTE" 
                                    placeholder="pasaporte..."/>
                                <div v-show="form.errors.CLIE_PASAPORTE" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_PASAPORTE }}
                                </div>
                            </div> 
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="name" class="block mb-2 
                                        text-sm font-medium text-gray-900 
                                        dark:text-white">Antecedentes Penales</label>

                                    <ul class="items-center w-full text-sm font-medium 
                                        text-gray-900 bg-white border border-gray-200 
                                        rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                            <fw-radio-checkbox
                                                v-model:checked="antecentesSi"
                                                v-on:click="hasAntecendetes(antecentesSi, 'si')"
                                                label="Si"/>
                                        </li>
                                        <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                            <fw-radio-checkbox
                                                v-model:checked="antecentesNo"
                                                v-on:click="hasAntecendetes(antecentesNo, 'no')" 
                                                label="No"/>
                                        </li> 
                                    </ul>
                                </div> 

                            <div class="col-span-2">
                                <fw-input label="Otro Ducomento" 
                                    v-model:value="form.CLIE_OTRODOC" 
                                    placeholder="otro documento..."/>
                                <div v-show="form.errors.CLIE_OTRODOC" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_OTRODOC }}
                                </div>
                            </div>


                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Direccion" 
                                    v-model:value="form.CLIE_DIRECCION" 
                                    placeholder="direccion..."/>
                                <div v-show="form.errors.CLIE_DIRECCION" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_DIRECCION }}
                                </div>
                            </div>  

                            <div class="col-span-2 sm:col-span-1">
                                <label for="name" class="block mb-2 
                                        text-sm font-medium text-gray-900 
                                        dark:text-white">Tipo de Cliente</label>
                                <ul class="items-center w-full text-sm font-medium 
                                        text-gray-900 bg-white border border-gray-200 
                                        rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <fw-radio-checkbox
                                            v-model:checked="juridico"
                                            v-on:click="tipoCliente(juridico, 'juridico')"
                                            label="Juridico"/>
                                    </li>
                                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <fw-radio-checkbox
                                            v-model:checked="natural"
                                            v-on:click="tipoCliente(natural, 'natural')" 
                                            label="Natural"/>
                                    </li> 
                                </ul>
                            </div>
 

                            <div class="col-span-2 sm:col-span-1">
                                <fw-select label="Categoria"
                                    v-model:selected="form.CLIE_CATEGORIA" 
                                    defaultItem="Seleccione una opcion"> 
                                    <option v-for="(c, index) in controller.categorias" 
                                        :value="c.text">{{ c.text }}</option> 
                                </fw-select>
                                <div v-show="form.errors.CLIE_CATEGORIA" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_CATEGORIA }}
                                </div>
                            </div> 

                            <div class="col-span-2 sm:col-span-1">
                                <fw-select label="Tipo Empleo"
                                    v-model:selected="form.CLIE_TIPOEMPLEO" 
                                    defaultItem="Seleccione una opcion"> 
                                    <option v-for="(tp, index) in controller.tipoEmpleo" 
                                        :key="index" :value="tp.text">{{ tp.text }}</option> 
                                </fw-select>
                                <div v-show="form.errors.CLIE_TIPOEMPLEO" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_TIPOEMPLEO }}
                                </div>
                            </div> 

                            <div class="col-span-2 sm:col-span-1">
                                <fw-select label="Tipo Casa"
                                    v-model:selected="form.CLIE_TIPOCASA" 
                                    defaultItem="Seleccione una opcion"> 
                                    <option v-for="(t, index) in controller.tipoCasa" :value="t.text">
                                        {{ t.text }}
                                    </option> 
                                </fw-select>
                                <div v-show="form.errors.CLIE_TIPOCASA" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_TIPOCASA }}
                                </div>
                            </div> 

                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Profesion" 
                                    v-model:value="form.CLIE_PROFESION" 
                                    placeholder="profesion..."/>
                                <div v-show="form.errors.CLIE_PROFESION" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_PROFESION }}
                                </div>
                            </div>

                            <div class="col-span-2">
                                <fw-input label="Trabajo" 
                                    v-model:value="form.CLIE_TRABAJO" 
                                    placeholder="trabajo..."/>
                                <div v-show="form.errors.CLIE_TRABAJO" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_TRABAJO }}
                                </div>
                            </div>

                            <div class="col-span-2">
                                <fw-input label="Direccion Trabajo" 
                                    v-model:value="form.CLIE_TRABAJODIR" 
                                    placeholder="direccion..."/>
                                <div v-show="form.errors.CLIE_TRABAJODIR" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_TRABAJODIR }}
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Telefono Trabajo" 
                                    v-model:value="form.CLIE_TRABAJOTEL" 
                                    placeholder="telefono..."/>
                                <div v-show="form.errors.CLIE_TRABAJOTEL" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_TRABAJOTEL }}
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <!--Ingresos Promedios 0-Menor 300 1-minimo 2-300a500 3-500a1000 4-arribamil-->
                                <fw-select label="Ingresos Promedios"
                                    v-model:selected="form.CLIE_INGRESOPROM" 
                                    defaultItem="Seleccione una opcion"> 
                                    <option v-for="(c, index) in controller.ingresoPromedio" 
                                        :key="index" :value="c.text">{{ c.text }}</option> 
                                </fw-select>
                                <div v-show="form.errors.CLIE_INGRESOPROM" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_INGRESOPROM }}
                                </div>
                            </div> 

                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Ingresos" 
                                    v-model:value="form.CLIE_INGRESOS" 
                                    placeholder="Ingresos..."/>
                                <div v-show="form.errors.CLIE_INGRESOS" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_INGRESOS }}
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="name" class="block mb-2 
                                        text-sm font-medium text-gray-900 
                                        dark:text-white">Ingresos adicionales</label>
                                <ul class="items-center w-full text-sm font-medium 
                                        text-gray-900 bg-white border border-gray-200 
                                        rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <fw-radio-checkbox
                                            v-model:checked="ingresosAdicionalesSi"
                                            v-on:click="hasIngresosAdicionales(ingresosAdicionalesSi, 'si')"
                                            label="Si"/>
                                    </li>
                                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <fw-radio-checkbox
                                            v-model:checked="ingresosAdicionalesNo"
                                            v-on:click="hasIngresosAdicionales(ingresosAdicionalesNo, 'no')" 
                                            label="No"/>
                                    </li> 
                                </ul>
                            </div>


                            <div class="col-span-2">
                                <fw-input label="Origen Ingresos" 
                                    v-model:value="form.CLIE_INGRESOORIGEN" 
                                    placeholder="origen..."/>
                                <div v-show="form.errors.CLIE_INGRESOORIGEN" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_INGRESOORIGEN }}
                                </div>
                            </div>

                            <!--Referencias Personales-->
                            <div class="flex flex-row col-span-2 items-center">
                                <label for="name" class="block mb-2 
                                        text-sm font-medium text-gray-900 
                                        dark:text-white">Referencias</label>
                                <div class="ml-3 h-px w-full bg-slate-800"></div>
                            </div>
                            <div class="col-span-2">
                                <fw-input label="Referencia Personal" 
                                    v-model:value="form.CLIE_REF1NOMBRE" 
                                    placeholder="nombre..."/>
                                <div v-show="form.errors.CLIE_REF1NOMBRE" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_REF1NOMBRE }}
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Referencia Parentesco" 
                                    v-model:value="form.CLIE_REF1PARENTESCO" 
                                    placeholder="nombre..."/>
                                <div v-show="form.errors.CLIE_REF1PARENTESCO" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_REF1PARENTESCO }}
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Telefono" 
                                    v-model:value="form.CLIE_REF1TELEFONO" 
                                    placeholder="telefono..."/>
                                <div v-show="form.errors.CLIE_REF1TELEFONO" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_REF1TELEFONO }}
                                </div>
                            </div>

                            <div class="col-span-2">
                                <fw-input label="Direccion" 
                                    v-model:value="form.CLIE_REF1DIRECCION" 
                                    placeholder="nombre..."/>
                                <div v-show="form.errors.CLIE_REF1DIRECCION" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_REF1DIRECCION }}
                                </div>
                            </div>



                            <!--persona 2-->
                            <div class="col-span-2">
                                <fw-input label="Persona 2" 
                                    v-model:value="form.CLIE_REF2NOMBRE" 
                                    placeholder="nombre..."/>
                                <div v-show="form.errors.CLIE_REF2NOMBRE" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_REF2NOMBRE }}
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Referencia Parentesco" 
                                    v-model:value="form.CLIE_REF2PARENTESCO" 
                                    placeholder="nombre..."/>
                                <div v-show="form.errors.CLIE_REF2PARENTESCO" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_REF2PARENTESCO }}
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Telefono" 
                                    v-model:value="form.CLIE_REF2TELEFONO" 
                                    placeholder="telefono..."/>
                                <div v-show="form.errors.CLIE_REF2TELEFONO" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_REF2TELEFONO }}
                                </div>
                            </div>

                            <div class="col-span-2">
                                <fw-input label="Direccion" 
                                    v-model:value="form.CLIE_REF2DIRECCION" 
                                    placeholder="nombre..."/>
                                <div v-show="form.errors.CLIE_REF2DIRECCION" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_REF2DIRECCION }}
                                </div>
                            </div>


                        <!--persona 3-->
                            <div class="col-span-2">
                                <fw-input label="Persona 3" 
                                    v-model:value="form.CLIE_REF3NOMBRE" 
                                    placeholder="nombre..."/>
                                <div v-show="form.errors.CLIE_REF3NOMBRE" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_REF3NOMBRE }}
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Referencia Parentesco" 
                                    v-model:value="form.CLIE_REF3PARENTESCO" 
                                    placeholder="nombre..."/>
                                <div v-show="form.errors.CLIE_REF3PARENTESCO" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_REF3PARENTESCO }}
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Telefono" 
                                    v-model:value="form.CLIE_REF3TELEFONO" 
                                    placeholder="telefono..."/>
                                <div v-show="form.errors.CLIE_REF3TELEFONO" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_REF3TELEFONO }}
                                </div>
                            </div>

                            <div class="col-span-2">
                                <fw-input label="Direccion" 
                                    v-model:value="form.CLIE_REF3DIRECCION" 
                                    placeholder="nombre..."/>
                                <div v-show="form.errors.CLIE_REF3DIRECCION" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_REF3DIRECCION }}
                                </div>
                            </div>

                            <div class="col-span-2">
                                <fw-text-area label="Comentarios"
                                    v-model:value="form.CLIE_COMENTARIOS" 
                                    placeholder="comentarios..."> 
                                </fw-text-area>
                                <div v-show="form.errors.CLIE_COMENTARIOS" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_COMENTARIOS }}
                                </div>
                            </div>

                            <div class="col-span-2">
                                <fw-text-area label="Observaciones"
                                    v-model:value="form.CLIE_OBSERVACIONES" 
                                    placeholder="observaciones..."> 
                                </fw-text-area>
                                <div v-show="form.errors.CLIE_OBSERVACIONES" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_OBSERVACIONES }}
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1"> 
                                <fw-select label="Sucursales"
                                    v-model:selected="form.SUCU_ID" 
                                    defaultItem="Seleccione una opcion">  
                                    <option v-for="(s, index) in sucursales" 
                                        :key="index" :value="s.SUCU_ID">{{ s.SUCU_NOMBRE }}</option>
                                </fw-select>
                                <div v-show="form.errors.SUCU_ID" class="text-red-500 text-sm">
                                    {{  form.errors.SUCU_ID }}
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <fw-input label="Score" 
                                    v-model:value="form.CLIE_SCORE" 
                                    type="number"
                                    placeholder=""/>
                                <div v-show="form.errors.CLIE_SCORE" class="text-red-500 text-sm">
                                    {{  form.errors.CLIE_SCORE }}
                                </div>
                            </div>  
                        </div>  
                        <div class="flex flex-row w-full justify-end">
                            <fw-button :disabled="form.processing" type="submit">Guardar</fw-button>
                        </div> 
                    </form> 
    </navigation-layout>
   
</template>
