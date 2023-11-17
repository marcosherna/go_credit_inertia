import { ref } from 'vue';

export default {

    model: {
        CUEN_ID: null,
        CUEN_CONTA: null,
        CUEN_NOMBRE: 0,
        CUEN_SALDO: '0.00',
        CUEN_TIPO: 0,
        CUEN_CLASIF: ref(null),
        CUEN_CUENTA: 0,
        CUEN_MODO: 0,
        CUEN_PADRE: null,
        SUCU_ID: 0,
        CUEN_ESTADO: true, 
    },
    modoCuenta:{
        0: 'Resumen',
        1: 'Detalle'
    },
    clasificacion: [
        { value: 1, text: 'Deudor' },
        { value: 2, text: 'Acreedor' },
    ],
    tipos: [
        { value: 1, text: 'Activo' },
        { value: 2, text: 'Pasivo' },
        { value: 3, text: 'Patrimonio' },
        { value: 4, text: 'Costos/Costos' },
        { value: 5, text: 'Ingresos' },
        { value: 6, text: 'Liquiadoras' },
    ],
    filtrar: (array, condicion) => array.filter(condicion),
    numeroContable: (array, item) => {
        const cuenta = array.find(x => x.CUEN_ID == item);
        let padre = cuenta.CUEN_CONTA.toString();
        let numero;

        let hijos = array.filter(
            x => x.CUEN_CONTA.toString().startsWith(padre) &&
                x.CUEN_CONTA.toString().split('0').join('').length > padre.split('0').join('').length &&
                x.CUEN_CONTA.toString().split('0').join('').length <= padre.split('0').join('').length + 1
        );

        if (hijos.length > 0) {
            const mayor = hijos.reduce((prev, current) => (prev.CUEN_CONTA > current.CUEN_CONTA) ? prev : current);
            let numeros = mayor.CUEN_CONTA.toString().split('');
            numeros[numeros.length - 1] = parseInt(numeros[numeros.length - 1]) + 1;
            numero = numeros.join('');
        } else {
            padre = padre + '01';
            numero = padre;
        }

        return numero;
    },

}