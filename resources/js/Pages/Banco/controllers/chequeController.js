import axios from 'axios';
const ObtenerCheques = async (id) => {
    try {
        const response = await axios.get(route('chequera.get-cheques', id));
        return response.data;
    } catch (error) {
        console.error(error);
    }
}

const model = {
    CHEQ_ID:null,
    CUEB_NUMERO:0,
    CHEQ_DESDE:null,
    CHEQ_HASTA:null,
    CHEQ_CANTIDAD:null,
    CHEQ_PENDIENTES:null,
    CHEQ_REFERENCIA:null,
    CHEQ_FECHA:null,
    CHEQ_GENERACION:0,
    CHEQ_VERIFICADOR:0,
    CHEQ_ESTADO:0,
}

const model_cheque = {
    CHEM_ID:null,
    CHEQ_ID:null,
    CHEM_NUMERO:0,
    CHEM_FECHA:null,
    CHEM_LUGAR:null,
    CHEM_NOMBRE:null,
    CHEM_MONTO: 0,
    CHEM_MONTOLETRA:null,
    CHEM_COMENTARIO:null,
    CHEM_FECHACAMBIO:null,
    USUA_ID:null,
    CHEM_ESTADO:0,

}

const estadoCheque = [
    { value: 0, text: 'Generado' },
    { value: 1, text: 'Transito' },
    { value: 2, text: 'Pagado' },
    { value: 3, text: 'Anulado' },
]

export default {
    ObtenerCheques, 
    model, 
    estadoCheque
}