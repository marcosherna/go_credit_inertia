import axios from "axios";  

const getComboClientes = async () => {
    try { 
        const response = await axios.get(route('creditos.combo-box-cliente'));
        return response.data; 
    } catch (error) {
        throw error;
    }
}

const getTipoCreditos = async () => {
    try { 
        const response = await axios.get(route('tipos-creditos-resource'));
        return response.data; 
    } catch (error) {
        throw error;
    }
}


const getGarantias = async () => {    
    try { 
        const response = await axios.get(route('garantias-resource'));
        return response.data; 
    } catch (error) {
        throw error;
    }
}

const getPlazos = async () => {
    try { 
        const response = await axios.get(route('plazos-resource'));
        return response.data; 
    } catch (error) {
        throw error;
    }
}

const getFormasPago = async () => {  
    try { 
        const response = await axios.get(route('formas-pago-resource'));
        return response.data; 
    } catch (error) {
        throw error;
    }
}

const getTasaInteres = async () => {
    try {
        const response = await axios.get(route('tasa-interes-resource'));
        return response.data;
    } catch (error) {
        throw error;
    }
}

const getTipoInteres = async () => {   
    try { 
        const response = await axios.get(route('tipo-interes-resource'));
        return response.data; 
    } catch (error) {
        throw error;
    }
}


export default {
    getComboClientes, 
    getTipoCreditos, 
    getGarantias, 
    getPlazos, 
    getFormasPago, 
    getTasaInteres, 
    getTipoInteres
}