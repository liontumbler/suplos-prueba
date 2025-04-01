const API_URL = 'api.php';
let resultadoReporte = [];

// Crear una oferta
async function crearOferta(oferta) {
    const response = await fetch(API_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(oferta)
    });
    console.log(response, 'fff');
    
    return await response.json();
}

// Obtener todas las ofertas
async function obtenerOfertas() {
    const response = await fetch(API_URL);
    return await response.json();
}

async function obtenerOferta(oferta) {
    const response = await fetch(`${API_URL}?id=${oferta.id}&objeto=${oferta.objeto}&comprador=${oferta.comprador}&estado=${oferta.estado}`);
    return await response.json();
}

// Actualizar una oferta
async function actualizarOferta(id, estado) {
    const response = await fetch(`${API_URL}?id=${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ estado })
    });
    return await response.json();
}

// reporte
async function reporteOferta() {
    fetch('api.php', {
        method: 'OPTIONS',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({data: resultadoReporte})
    })
    .then(response => response.blob())
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'reporte_ofertas.xls';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    })
    .catch(error => console.error('Error generando el reporte:', error));
}

// Eliminar una oferta
async function eliminarOferta(id) {
    const response = await fetch(`${API_URL}?id=${id}`, {
        method: 'DELETE'
    });
    return await response.json();
}

function pintarTabla(resultado) {
    const tbody = document.getElementById('tbody')
    let tbodyText = ''
    for (const element of resultado) {
        console.log(element);
        tbodyText += `
            <tr>
                <th scope="row">${element.id_oferta}</th>
                <td>${0}</td>
                <td>${element.objeto}</td>
                <td>${element.descripcion}</td>
                <td>${element.fecha_inicio}</td>
                <td>${element.fecha_cierre}</td>
                <td>${element.estado}</td>
                <td>${element.creador_oferta}</td>
                <td>${'acciones'}</td>
            </tr>
        `
    }

    tbody.innerHTML = tbodyText
}

// Event listener para el formulario de creación
document.getElementById('ofertaForm').addEventListener('submit', async function(event) {
    event.preventDefault();

    let objeto = document.getElementById('objeto')
    let descripcion = document.getElementById('descripcion')
    let moneda = document.getElementById('moneda')
    let presupuesto = document.getElementById('presupuesto')
    
    const oferta = {
        objeto: objeto.value,
        actividad: document.getElementById('actividad').value,
        descripcion: descripcion.value,
        moneda: moneda.value,
        presupuesto: presupuesto.value,
    };

    const resultado = await crearOferta(oferta);
    alert(resultado.message);

    document.getElementById('cerrarModalCrear').click();

    objeto.value = ''
    descripcion.value = ''
    presupuesto.value = ''
});

document.getElementById('consultarModal').addEventListener('submit', async function(event) {
    event.preventDefault();
    
    const oferta = {
        id: document.getElementById('id').value,
        objeto: document.getElementById('objeto').value,
        comprador: document.getElementById('comprador').value,
        estado: document.getElementById('estado').value,
    };

    console.log('xxx', oferta);
    
    resultadoReporte = await obtenerOferta(oferta);
    pintarTabla(resultadoReporte)
});

const myModal = document.getElementById('consultarModal')

myModal.addEventListener('shown.bs.modal', async () => {
    resultadoReporte = await obtenerOfertas();
    pintarTabla(resultadoReporte)
})

document.getElementById('reporte').addEventListener('click', async function(event) {
    reporteOferta()
})




