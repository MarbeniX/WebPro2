function addRow(section) {
    const table = document.getElementById(section);
    const row = table.insertRow(table.rows.length - 1);

    if (section === 'costosTable') {
        row.insertCell(0).innerHTML = '<input type="date" oninput="calculateTotals()">';
        row.insertCell(1).innerHTML = '<input type="text" oninput="calculateTotals()">';
        row.insertCell(2).innerHTML = '<input type="text" oninput="calculateTotals()">';
    } else if (section === 'materialesTable') {
        row.insertCell(0).innerHTML = '<input type="text" oninput="calculateTotals()">';
        row.insertCell(1).innerHTML = '<input type="text" oninput="calculateTotals()">';
        row.insertCell(2).innerHTML = '<input type="text" readonly>';
    }
}

function calculateTotals() {
    // Costos Table
    let costosTotal = 0;
    const costosTable = document.getElementById('costosTable');
    for (let i = 1; i < costosTable.rows.length - 1; i++) {
        const cells = costosTable.rows[i].cells;
        const costo = parseFloat(cells[3].firstChild.value) || 0;
        costosTotal += costo;
    }
    costosTable.rows[costosTable.rows.length - 1].cells[1].innerText = costosTotal.toFixed(2);

    // Materiales Utilizados 
    let materialesTotal = 0;
    const materialesTable = document.getElementById('materialesTable');
    for (let i = 1; i < materialesTable.rows.length - 1; i++) {
        const cells = materialesTable.rows[i].cells;
        const cantidad = parseFloat(cells[1].firstChild.value) || 0;
        const precioUnitario = parseFloat(cells[2].firstChild.value) || 0;
        const total = cantidad * precioUnitario;
        cells[3].firstChild.value = total.toFixed(2);
        materialesTotal += total;
    }
    materialesTable.rows[materialesTable.rows.length - 1].cells[1].innerText = materialesTotal.toFixed(2);
}

function getClientesOptions() {
    return `
        <select oninput="calculateTotals()">
            <option value="Cliente 1">JUAN</option>
            <option value="Cliente 2">SOTO</option>
            <option value="Cliente 3">PEDRO</option>
        </select>
    `;
}

function getMaterialesOptions() {
    return `
        <select oninput="calculateTotals()">
            <option value="Detergente">Detergente</option>
            <option value="Desinfectante">Desinfectante</option>
            <option value="Escoba">Escoba</option>
            <option value="Trapeador">Trapeador</option>
        </select>
    `;
}

function populateExamples() {
    
    const costosTable = document.getElementById('costosTable');
    const costoExamples = [
        { cliente: 'JUAN', fecha: '2024-06-10', servicio: 'Limpieza de oficina', costo: 150 },
        { cliente: 'SOTO', fecha: '2024-06-12', servicio: 'Limpieza de almacén', costo: 200 }
    ];
    for (const example of costoExamples) {
        const row = costosTable.insertRow(costosTable.rows.length - 1);
        row.insertCell(0).innerHTML = `<select oninput="calculateTotals()">
            <option value="JUAN" ${example.cliente === 'JUAN' ? 'selected' : ''}>JUAN</option>
            <option value="SOTO" ${example.cliente === 'SOTO' ? 'selected' : ''}>SOTO</option>
            <option value="PEDRO" ${example.cliente === 'PEDRO' ? 'selected' : ''}>PEDRO</option>
        </select>`;
        row.insertCell(1).innerHTML = `<input type="date" value="${example.fecha}" oninput="calculateTotals()">`;
        row.insertCell(2).innerHTML = `<input type="text" value="${example.servicio}" oninput="calculateTotals()">`;
        row.insertCell(3).innerHTML = `<input type="text" value="${example.costo}" oninput="calculateTotals()">`;
    }

    
    const materialesTable = document.getElementById('materialesTable');
    const materialExamples = [
        { material: 'Detergente', cantidad: 10, precio: 2.5 },
        { material: 'Desinfectante', cantidad: 5, precio: 3.0 },
        { material: 'Escoba', cantidad: 2, precio: 4.5 },
        { material: 'Trapeador', cantidad: 3, precio: 3.5 }
    ];
    for (const example of materialExamples) {
        const row = materialesTable.insertRow(materialesTable.rows.length - 1);
        row.insertCell(0).innerHTML = `<select oninput="calculateTotals()">
            <option value="Detergente" ${example.material === 'Detergente' ? 'selected' : ''}>Detergente</option>
            <option value="Desinfectante" ${example.material === 'Desinfectante' ? 'selected' : ''}>Desinfectante</option>
            <option value="Escoba" ${example.material === 'Escoba' ? 'selected' : ''}>Escoba</option>
            <option value="Trapeador" ${example.material === 'Trapeador' ? 'selected' : ''}>Trapeador</option>
        </select>`;
        row.insertCell(1).innerHTML = `<input type="text" value="${example.cantidad}" oninput="calculateTotals()">`;
        row.insertCell(2).innerHTML = `<input type="text" value="${example.precio}" oninput="calculateTotals()">`;
        row.insertCell(3).innerHTML = `<input type="text" readonly>`;
    }

    calculateTotals();
}

window.onload = populateExamples;