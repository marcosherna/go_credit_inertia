import axios from "axios" 

const model = {
    CLIE_ID: null,
    CLIE_NOMBRE: null, //
    CLIE_NOMBRE2: null, //
    CLIE_NOMBRE3: null, //
    CLIE_APELLIDO:null, //
    CLIE_APELLIDO2:null,//
    CLIE_APELLIDO3:null, 
    CLIE_SEXO:0, //
    ESTA_ID:0, //
    PAIS_NAC:0, //
    DEPA_NAC:0, //
    CLIE_FECHANAC:null,
    CLIE_DOCIDEN:null, //
    CLIE_DOCIDENVEN:null, //
    CLIE_DOCFISCAL:null, //
    CLIE_PASAPORTE:null, //
    CLIE_OTRODOC:null, //
    CLIE_OTRODOC2:null, 
    CLIE_ANTECEDENTES:null, //
    PAIS_ID:null, //----------------
    DEPA_ID:null, //------------
    MUNI_ID:0, //
    CLIE_DIRECCION:null, //
    CLIE_TEL:null,  //
    CLIE_TEL2:null, //
    CLIE_MAIL:null, //
    CLIE_MAIL2:null, //-------
    CLIE_TIPOCASA:0, // 
    CLIE_PROFESION:null, // 
    CLIE_TIPOEMPLEO:0,// 
    CLIE_TRABAJO:null, //
    CLIE_TRABAJODIR:null, //
    CLIE_TRABAJOTEL:null,  //
    CLIE_INGRESOPROM:0, //
    CLIE_INGRESOS:null, //
    CLIE_INGRESOADIC:null,// 
    CLIE_INGRESOORIGEN:null, //
    CLIE_REF1NOMBRE:null, //
    CLIE_REF1PARENTESCO:null,// 
    CLIE_REF1DIRECCION:null, //
    CLIE_REF1TELEFONO:null, //
    CLIE_REF2NOMBRE:null, //
    CLIE_REF2PARENTESCO:null,// 
    CLIE_REF2DIRECCION:null, //
    CLIE_REF2TELEFONO:null, //
    CLIE_REF3NOMBRE:null,//
    CLIE_REF3PARENTESCO:null,/// 
    CLIE_REF3DIRECCION:null, //
    CLIE_REF3TELEFONO:null, // 
    CLIE_COMENTARIOS:null, // 
    CLIE_OBSERVACIONES:null, // 
    CLIE_TIPOCLIENTE:null, //
    CLIE_CATEGORIA:0, //
    CLIE_SCORE:null, 
    CLIE_ESTADO:null,
    SUCU_ID:0, // 
    EMPR_ID:0, //
    USUA_LOGIN:null, 
    FECHA_CAMBIO:null,
}

const estadoCliente = [
    { value: 0, text: 'Bloqueado', color : 'red' },
    { value: 1, text: 'Activo' , color : 'green' },
    { value: 2, text: 'Lista N.', color : 'purple' },
]

const tipoCasa = [
    { value: 0, text: 'Propia' },
    { value: 1, text: 'Rentada' },
    { value: 2, text: 'Hipotecada' },
    { value: 3, text: 'Familiar' },
]

const tipoEmpleo = [
    { value: 0, text: 'Propio' },
    { value: 1, text: 'Privado' },
    { value: 2, text: 'Publico' },
    { value: 3, text: 'Ama de Casa' },
]

const genero = [
    { value: 0, text: 'No Definido'},
    { value: 1, text: 'Masculino' },
    { value: 2, text: 'Femenino' },
]

const categorias = [
    { value: 0, text: 'A1' },
    { value: 2, text: 'A2' },
    { value: 3, text: 'B1' }, 
    { value: 4, text: 'B2' }, 
    { value: 5, text: 'C' }, 
    { value: 6, text: 'D'},
    { value: 7, text: 'E' }
]


const ingresoPromedio = [
    { value: 0, text: 'Menor' },
    { value: 1, text: 'Minimo' },
    { value: 2, text: 'Mayor el minimo' },
];
const getPaises = async () => {
    try {
        const response = await axios.get(route('pais.all-resource'))
        return response.data
    } catch (error) {
        throw error
    }
}

const getDepartamentos = async (pais_id) => {
    try {
        const response = await axios.get(route('pais.departamentos-pais-resource', pais_id)) 
        return response.data
    } catch (error) {
        throw error
    }
}

const getMunicipios = async (depa_id) => {
    try {
        const response = await axios.get(route('pais.municipios-departamento-resource', depa_id))
        return response.data
    } catch (error) {
        throw error
    }
}

const getEstadosCivil = async () => {
    try {
        const response = await axios.get(route('estado-civil.all-resource'))  
        return response.data
    } catch (error) { 
        throw error
    }
}

const getAllSolicitudes = async (idCliente) => {
    try {
        const response = await axios.get(route('cliente.solicitudes-resource', idCliente))  
        return response.data
    } catch (error) { 
        throw error
    }
}

const getSolicitudById = async (idSolicitud) => {
    try { 
        const response = await axios.get(route('solicitud.detalle-resource', idSolicitud))   
        return response.data
    } catch (error) { 
        throw error
    }
}

const getCuotasById = async (idSolicitud) => {
    try { 
        const response = await axios.get(route('solicitud.cuotas-resource', idSolicitud))   
        return response.data
    } catch (error) { 
        throw error
    }
}

const cantidaCuotas = (plazo_total, plazo_cuota) => {
    let cuota = 0;
    cuota = plazo_total / plazo_cuota;

    const decimal = cuota - Math.floor(cuota);    
    const precision = 0.5;

    if (decimal >= precision) {
        cuota = Math.floor(cuota) + 1;
    }
    return parseInt(cuota);
}

const calcularCuota = (monto, interes, cantida_cuotas) => {
    let cuota = 0;

    const interes_decimal = interes / 100;
    monto = monto + (monto * interes_decimal);
    cuota = monto / cantida_cuotas;

    return cuota.toFixed(2);
}

//Estado Solicitud. 0-Creada 1-Aprobada 2-Rechazada 3-Cancelada 4-CreditoAbierto 5-Finalizada 6-Desembolsada
const estadoSolicitud = [
    { value: 0, text: 'Creada', color : 'blue' },
    { value: 1, text: 'Aprobada', color : 'green' },
    { value: 2, text: 'Rechazada', color : 'red' },
    { value: 3, text: 'Cancelada', color : 'red' },
    { value: 4, text: 'Credito Abierto', color : 'blue' },
    { value: 5, text: 'Finalizada', color : 'blue' },
    { value: 6, text: 'Desembolsada', color : 'blue'}
]


const takeCreditos = async (CLIEN_ID, TAKE) => {
    try {
        const response = await axios.get(route('solicitud.take-cliente-creditos-resource', { id: CLIEN_ID, take: TAKE}))  
        return response.data
    } catch (error) { 
        throw error
    }
}


export default {
    model,
    tipoCasa,
    tipoEmpleo, 
    getPaises,
    getDepartamentos,
    getMunicipios,
    getEstadosCivil,
    estadoCliente, 
    genero, 
    categorias, 
    ingresoPromedio, 
    getAllSolicitudes, 
    estadoSolicitud, 
    getSolicitudById, 
    getCuotasById, 
    cantidaCuotas, 
    calcularCuota, 
    takeCreditos
}