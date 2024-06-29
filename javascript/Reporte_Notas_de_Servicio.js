function submitForm(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    
    const resultWindow = window.open('', '_blank');
    resultWindow.document.write('<html><head><title>Datos Guardados</title></head><body>');
    resultWindow.document.write('<h1>Datos Guardados</h1>');
    resultWindow.document.write('<h3>Datos de Cliente</h3>');
    resultWindow.document.write(`<p><strong>Cliente:</strong> ${data.cliente}</p>`);
    resultWindow.document.write(`<p><strong>Dirección:</strong> ${data.direccion}</p>`);
    resultWindow.document.write(`<p><strong>Teléfono:</strong> ${data.telefono}</p>`);
    resultWindow.document.write(`<p><strong>Email:</strong> ${data.email}</p>`);
    
    resultWindow.document.write('<h3>Datos de Orden de Servicio</h3>');
    resultWindow.document.write(`<p><strong>Empleado:</strong> ${data.empleado}</p>`);
    resultWindow.document.write(`<p><strong>Servicio:</strong> ${data.servicio}</p>`);
    resultWindow.document.write(`<p><strong>No Orden:</strong> ${data.no_orden}</p>`);
    resultWindow.document.write(`<p><strong>Código:</strong> ${data.codigo}</p>`);
    
    resultWindow.document.write('<h3>Descripción de la Falla</h3>');
    resultWindow.document.write(`<p>${data.descripcion_falla}</p>`);
    
    resultWindow.document.write('<h3>Detalles del Servicio</h3>');
    resultWindow.document.write('<table border="1"><tr><th>Cantidad</th><th>Descripción</th><th>Precio Unitario</th><th>Total</th></tr>');
    resultWindow.document.write(`<tr><td>${data.cantidad}</td><td>${data.descripcion}</td><td>${data.precio_unitario}</td><td>${data.total}</td></tr>`);
    resultWindow.document.write(`<tr><td colspan="3">TOTAL</td><td>${data.total_general}</td></tr>`);
    resultWindow.document.write('</table>');
    
    resultWindow.document.write('</body></html>');
    resultWindow.document.close();
}