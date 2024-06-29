function autofillDelegacionZona() {
    const cp = document.getElementById('cp').value;
    const delegacionField = document.getElementById('delegacion');
    const zonaField = document.getElementById('zona');

    if (cp.length === 5) {
        const cpPrefix = cp.substring(0, 2);

        let delegacion = '';
        let zona = '';

        switch (cpPrefix) {
            case '07':
                delegacion = 'Gustavo A. Madero';
                zona = 'Noroeste de CDMX';
                break;
            case '08':
                delegacion = 'Iztacalco';
                zona = 'Noroeste de CDMX';
                break;
            case '09':
                delegacion = 'Iztapalapa';
                zona = 'Noroeste de CDMX';
                break;
            case '15':
                delegacion = 'Venustiano Carranza';
                zona = 'Noroeste de CDMX';
                break;
            case '12':
                delegacion = 'Milpa Alta';
                zona = 'Suroeste de CDMX';
                break;
            case '13':
                delegacion = 'Tláhuac';
                zona = 'Suroeste de CDMX';
                break;
            case '16':
                delegacion = 'Xochimilco';
                zona = 'Suroeste de CDMX';
                break;
            case '10':
                delegacion = 'La Magdalena Contreras';
                zona = 'Sureste de CDMX';
                break;
            case '14':
                delegacion = 'Tlalpan';
                zona = 'Sureste de CDMX';
                break;
            case '01':
                delegacion = 'Alvaro Obregon';
                zona = 'Noreste de CDMX';
                break;
            case '02':
                delegacion = 'Azcapotzalco';
                zona = 'Noreste de CDMX';
                break;
            case '03':
                delegacion = 'Benito Juarez';
                zona = 'Noreste de CDMX';
                break;
            case '04':
                delegacion = 'Coyoacan';
                zona = 'Noreste de CDMX';
                break;
            case '05':
                delegacion = 'Cuajimalpa';
                zona = 'Noreste de CDMX';
                break;
            case '06':
                delegacion = 'Cuauhtemoc';
                zona = 'Noreste de CDMX';
                break;
            case '11':
                delegacion = 'Miguel Hidalgo';
                zona = 'Noreste de CDMX';
                break;
            default:
                delegacion = 'Delegación no encontrada';
                zona = 'Zona no encontrada';
        }

        delegacionField.value = delegacion;
        zonaField.value = zona;
    } else {
        delegacionField.value = '';
        zonaField.value = '';
    }
}
