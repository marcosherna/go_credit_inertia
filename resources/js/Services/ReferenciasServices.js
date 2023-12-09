const model = {
    SOLI_ID:null,
    REFE_NOMBRES:null, //
    REFE_DIRECCION:null, //
    REFE_PARENTESCO:null, //
    REFE_TELEFONO:null, //
    REFE_DUI:null, //
    REFE_MAIL:null,
}


const isExist = async (DUI) => {
    try {
        const response = await axios.get(route('referencias.exist', DUI));
        return response.data;
    } catch (error) {
        throw error;
    }
}

export default {
    model,
    isExist
}