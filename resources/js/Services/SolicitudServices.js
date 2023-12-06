//Estado Solicitud. 0-Creada 1-Aprobada 2-Rechazada 3-Cancelada 4-CreditoAbierto 5-Finalizada 6-Desembolsada
import { router } from '@inertiajs/vue3';
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
        SOLI_OMITIRDOM:null, //Omitir Domingos: 0->NO 1->SI
        SOLI_DISPERSAR:null, //Dispersar Domingo: 0->NO 1->SI
        SOLI_CATEGORIA:0, //Categoria Credito: A1,A2,B1,B2,C,D,E
        SOLI_FECHAAPROB:null, //Fecha Aprobacion Credito
        SOLI_FECHAVENCIMIENTO:null, //Fecha de Vencimiento
        SOLI_OBSERVACION:null, //Observaciones a Solicitud
        SOLI_CONDICIONES:null, //Condiciones Adicionales
        SOLI_OTROS:null, //Otras Observaciones
        SOLI_ESTADO:null, //Estado Solicitud. 0-Creada 1-Aprobada 2-Rechazada 3-Cancelada 4-CreditoAbierto 5-Finalizada 6-Desembolsada
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



export default {
    SolicitudEstado, 
    search, 
    filleter, 
    model,
    tipoTasa, 
    categorias, 
    findAll
};