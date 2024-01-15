//Estado Solicitud. 0-Creada 1-Aprobada 2-Rechazada 3-Cancelada 4-CreditoAbierto 5-Finalizada 6-Desembolsada
import { router, usePage } from '@inertiajs/vue3';
import axios from 'axios'; 

const SolicitudEstado = [
    { text: 'Creada', value: 0 },
    { text: 'Aprobada', value: 1 },
    { text: 'Rechazada', value: 2 },
    { text: 'Cancelada', value: 3 },
    { text: 'Credito Abierto', value: 4 },
    { text: 'Finalizada', value: 5 },
    { text: 'Desembolsada', value: 6 }
]

const estado = [
    { text: 'Pendiente', value: 0, color: 'green' },
    { text: 'Aprobada', value: 1, color: 'blue' },
    { text: 'Rechazada', value: 2, color: 'yellow' },
    { text: 'Cancelada', value: 3, color: 'red' },
    { text: 'Credito Abierto', value: 4, color: 'green' },
    { text: 'Finalizada', value: 5, color: 'blue'},
    { text: 'Desembolsada', value: 6, color: 'green'}
]

const tipoTasa = [  
    { text: 'Mensual', value: 0 },
    { text: 'Anual', value: 1 },
    { text: 'Fija', value: 2 }
]

const categorias = [
    {text: 'A1', value:0},
    {text: 'A2', value:1},
    {text: 'B1', value:2},
    {text: 'B2', value:3},
    {text: 'C',  value:4},
    {text: 'D',  value:5},
    {text: 'E',  value:6}
]

const model = {
        SOLI_ID: null, // Id Solicitud
        SOLI_FECHA: null, // Fecha de CreaciÃ³n
        EMPL_ID: null, // Ejecutivo que la Crea
        CLIE_ID: 0, // ID Cliente. Ref tabla cliente
        SOLI_MONTO: null, //Monto Solicitado
        TIPO_ID: 0, //Tipo de Credito Ref. Tabla Tipo_credito
        GARA_ID: 0, //Garantia del CreditoTipo Ref. Tabla Garantias
        PLAZ_ID: 0, //Plazo del Credito. Ref Tabla Plazos
        FORM_ID: 0, //Periodo de Pago. Ref. tabla Formas de Pago
        TIPT_ID: 0, //Tipo Tasa Interes. Ref. Tabla tipo_interes
        TASA_ID: 0, //Tasa de Interes. Ref. Tabla tasa_interes
        SOLI_TIPOTASA: 0, //0 -> Mensual; 1-> Anual 2-> Fija
        SOLI_OMITIRDOM:false, //Omitir Domingos: 0->NO 1->SI
        SOLI_DISPERSAR:false, //Dispersar Domingo: 0->NO 1->SI
        SOLI_CATEGORIA:0, //Categoria Credito: A1,A2,B1,B2,C,D,E
        SOLI_FECHAAPROB:null, //Fecha Aprobacion Credito
        SOLI_FECHAVENCIMIENTO:null, //Fecha de Vencimiento
        SOLI_OBSERVACION:null, //Observaciones a Solicitud
        SOLI_CONDICIONES:null, //Condiciones Adicionales
        SOLI_OTROS:null, //Otras Observaciones
        SOLI_ESTADO:null, //Estado Solicitud. 0-Creada 1-Aprobada 2-Rechazada 3-Cancelada 4-CreditoAbierto 5-Finalizada 6-Desembolsada
}

const validation = (form) => {  
    form.errors = {};
    if(form.TIPO_ID == 0){
        form.errors.TIPO_ID = 'Debe seleccionar un tipo de credito';
        throw new Error('Debe seleccionar un tipo de credito') ;
    }

    if(form.GARA_ID == 0){
        form.errors.GARA_ID = 'Debe seleccionar un tipo de garantia';
        throw new Error ('Debe seleccionar un tipo de garantia');
    }

    if(form.PLAZ_ID == 0){
        form.errors.PLAZ_ID = 'Debe seleccionar un plazo';
        throw new Error('Debe seleccionar un plazo');
    }

    if(form.FORM_ID == 0){
        form.errors.FORM_ID = 'Debe seleccionar un periodo de pago';
        throw new Error ('Debe seleccionar un periodo de pago');
    }

    if(form.TIPT_ID == 0){
        form.errors.TIPT_ID = 'Debe seleccionar un tipo de tasa';
        throw new Error('Debe seleccionar un tipo de tasa');
    }

    if(form.TASA_ID == 0){
        form.errors.TASA_ID = 'Debe seleccionar una tasa';
        throw new Error('Debe seleccionar una tasa');
    }

    if(form.SOLI_MONTO == null){
        form.errors.SOLI_MONTO = 'Debe ingresar un monto';
        throw new Error('Debe ingresar un monto');
    } 

}


const filleter = async (filter) => {
    try {
        const response = await axios.get(route('creditos.fillter-by-status', {status: filter}));
        return response.data;
    } catch (error) {
        throw error;
    } 
}

const findAll = async () => {
    try {
        const response = await axios.get(route('creditos.findAll-resourse'));
        return response.data;
    } catch (error) {
        throw error;
    }
}

const search = async (query) => {
    try {
        const response = await axios.get(route('cliente.search-resource', {query: query}));
        return response.data;
    } catch (error) {
        throw error;
    }

}

const changedStatus = async (id, status) => {
    try {
        const response = await axios.put(route('solicitud-status.update', { id:id ,status: status}));
        return response.data;
    } catch (error) {
        throw error;
    }
}

const find = async (solicitud) => {
    try {
        const response = await axios.get(route('solicitud.find-resource', solicitud));
        return response.data;
    } catch (error) {
        throw error;
    }
}

const formToModel = (form) => {
    return {
        SOLI_ID: form.SOLI_ID, // Id Solicitud
        SOLI_FECHA: form.SOLI_FECHA, // Fecha de CreaciÃ³n
        EMPL_ID: form.EMPL_ID, // Ejecutivo que la Crea
        CLIE_ID: form.CLIE_ID, // ID Cliente. Ref tabla cliente
        SOLI_MONTO: form.SOLI_MONTO, //Monto Solicitado
        TIPO_ID: form.TIPO_ID, //Tipo de Credito Ref. Tabla Tipo_credito
        GARA_ID: form.GARA_ID, //Garantia del CreditoTipo Ref. Tabla Garantias
        PLAZ_ID: form.PLAZ_ID, //Plazo del Credito. Ref Tabla Plazos
        FORM_ID: form.FORM_ID, //Periodo de Pago. Ref. tabla Formas de Pago
        TIPT_ID: form.TIPT_ID, //Tipo Tasa Interes. Ref. Tabla tipo_interes
        TASA_ID: form.TASA_ID, //Tasa de Interes. Ref. Tabla tasa_interes
        SOLI_TIPOTASA: form.SOLI_TIPOTASA, //0 -> Mensual; 1-> Anual 2-> Fija
        SOLI_OMITIRDOM:form.SOLI_OMITIRDOM, //Omitir Domingos: 0->NO 1->SI
        SOLI_DISPERSAR:form.SOLI_DISPERSAR, //Dispersar Domingo: 0->NO 1->SI
        SOLI_CATEGORIA:form.SOLI_CATEGORIA, //Categoria Credito: A1,A2,B1,B2,C,D,E
        SOLI_FECHAAPROB:form.SOLI_FECHAAPROB, //Fecha Aprobacion Credito
        SOLI_FECHAVENCIMIENTO:form.SOLI_FECHAVENCIMIENTO, //Fecha de Vencimiento
        SOLI_OBSERVACION:form.SOLI_OBSERVACION, //Observaciones a Solicitud
        SOLI_CONDICIONES:form.SOLI_CONDICIONES, //Condiciones Adicionales
        SOLI_OTROS:form.SOLI_OTROS
    };
}


const create = async (form) => {
    try {
        const response = await axios.post(route('solicitud.store'), form);
        return response.data;
    } catch (error) { 
        throw error;
    }
}

const searchSolicitud = async ( query ) => { 
    try {
        const response = await axios.get(route('solicitud.search-resource', {query: query}));
        return response.data;
    } catch (error) {
        
        
        throw error;
    }
}

const edit = async (id, body) => {
    try {
        const response = await axios.put(route('solicitud.edit-resource', {id:id}), body);
        return response.data;
    } catch (error) {
        throw error;
    }
}

const observar = async (observaciones) => {
    try {
        const response = await axios.put(route('creditos-por-aprobar-observar-credito'), observaciones);
        return response.data;
    } catch (error) {
        console.log(error);
        throw  new Error('Error al observar la solicitud');
    }
}

const navEditPage = (CLIE_ID, SOLI_ID) => {
    router.visit(route('detalle-creditos-layout', { CLIE_ID: CLIE_ID, SOLI_ID: SOLI_ID })) 

}

export default {
    SolicitudEstado, 
    search, 
    filleter, 
    model,
    tipoTasa, 
    categorias, 
    findAll, 
    validation, 
    changedStatus,
    find, 
    formToModel,
    create, 
    searchSolicitud,
    edit, 
    estado, 
    observar, 
    navEditPage
};