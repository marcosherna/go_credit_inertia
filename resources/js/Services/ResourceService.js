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


const calcularPlazo = (plazo, omitirDomingos) => {
    const matches = plazo.match(/(\d+)\s*(\w+)/);
    const cantidad = parseInt(matches[1]);
    const unidad = matches[2].toLowerCase();

    const fechaActual = new Date();
    let fechaSalida;

    switch (unidad) {
        case 'días':
        case 'día':
            fechaSalida = new Date(fechaActual.getTime() + cantidad * 24 * 60 * 60 * 1000);
            break;

        case 'meses':
        case 'mes': 
            fechaSalida = new Date(fechaActual);
            fechaSalida.setMonth(fechaSalida.getMonth() + cantidad);
            break;

        case 'años':
        case 'año':
            fechaSalida = new Date(fechaActual);
            fechaSalida.setFullYear(fechaSalida.getFullYear() + cantidad);
            break;

        default:
            // Si no se reconoce la unidad, asumir días por defecto
            fechaSalida = new Date(fechaActual.getTime() + cantidad * 24 * 60 * 60 * 1000);
            break;
    }
 
    if (omitirDomingos) {
        while (fechaSalida.getDay() === 0) { // 0 representa el domingo
            fechaSalida.setDate(fechaSalida.getDate() + 1); // Agregar un día
        }
    }
   
    const dd = String(fechaSalida.getDate()).padStart(2, '0');
    const mm = String(fechaSalida.getMonth() + 1).padStart(2, '0'); // Meses comienzan desde 0
    const yy = String(fechaSalida.getFullYear());

    return `${yy}-${mm}-${dd}`;	
};


export default {
    getComboClientes, 
    getTipoCreditos, 
    getGarantias, 
    getPlazos, 
    getFormasPago, 
    getTasaInteres, 
    getTipoInteres, 
    calcularPlazo
}