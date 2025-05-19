async function buscarProductos(formData = null) {
    const tbody = document.getElementById('resultadosBusqueda');
    try {
        let url = '../Api/controllers/ProductoController.php?action=buscar';

        if (formData) {
            const id = formData.get('id');
            if (id) {
                url += `&id=${id}`;
            }
        }

        console.log('Realizando petición a:', url);

        const response = await fetch(url, {
            method: 'GET',
            headers: { 'Accept': 'application/json' },
            cache: 'no-cache'
        });

        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

        const texto = await response.text();
        console.log('Respuesta del servidor:', texto);

        let datos;
        try {
            datos = JSON.parse(texto);
        } catch (parseError) {
            console.error('Error al parsear JSON:', parseError);
            throw new Error('El servidor no devolvió un JSON válido');
        }

        if (!datos || typeof datos !== 'object') {
            throw new Error('Respuesta con formato inválido');
        }

        const productos = Array.isArray(datos.data) ? datos.data : [];
        mostrarResultados(productos);

    } catch (error) {
        console.error('Error completo:', error);
        tbody.innerHTML = `
            <tr>
                <td colspan="3" class="text-center text-danger">
                    <div class="alert alert-danger">
                        Error al cargar los productos: ${error.message}
                        <br><small>Revisa la consola (F12) para más detalles</small>
                    </div>
                </td>
            </tr>`;
    }
}

function mostrarResultados(productos) {
    const tbody = document.getElementById('resultadosBusqueda');
    tbody.innerHTML = '';

    if (!productos || productos.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="3" class="text-center">No se encontraron productos</td>
            </tr>`;
        return;
    }

    productos.forEach(producto => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${producto.id || ''}</td>
            <td>${producto.nombre || ''}</td>
            <td>${producto.descripcion || ''}</td>`;
        tbody.appendChild(tr);
    });
}

function limpiarBusqueda() {
    console.log('Limpiando búsqueda...');
    document.getElementById('formBusqueda').reset();
    buscarProductos();
}

document.addEventListener('DOMContentLoaded', () => {
    console.log('Página cargada, iniciando búsqueda inicial...');
    buscarProductos();
});

document.getElementById('formBusqueda').addEventListener('submit', async (e) => {
    e.preventDefault();
    console.log('Formulario enviado, realizando búsqueda...');
    const formData = new FormData(e.target);
    await buscarProductos(formData);
});
