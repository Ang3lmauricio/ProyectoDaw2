// Cargar categorías al cargar la página
document.addEventListener('DOMContentLoaded', cargarCategorias);

async function cargarCategorias() {
    try {
        const response = await fetch('../Api/controllers/ProductoController.php?action=categorias');
        const resultado = await response.json();

        if (!resultado.success) {
            throw new Error('Error al cargar las categorías');
        }

        const selectCategoria = document.getElementById('categoria_id');
        resultado.data.forEach(categoria => {
            const option = document.createElement('option');
            option.value = categoria.id;
            option.textContent = categoria.nombre;
            selectCategoria.appendChild(option);
        });

    } catch (error) {
        console.error('Error al cargar categorías:', error);
        mostrarError('Error al cargar las categorías');
    }
}

async function crearProducto(event) {
    event.preventDefault();
    
    if (!validarFormulario()) {
        return;
    }

    const formData = new FormData(event.target);
    
    try {
        const response = await fetch('../Api/controllers/ProductoController.php?action=crear', {
            method: 'POST',
            body: formData
        });

        const resultado = await response.json();

        if (!resultado.success) {
            throw new Error(resultado.message || 'Error al crear el producto');
        }

        alert('Producto creado correctamente');
        window.location.href = '../public/js/index.html';

    } catch (error) {
        console.error('Error:', error);
        mostrarError(error.message);
    }
}

function validarFormulario() {
    const nombre = document.getElementById('nombre').value.trim();
    const precio = parseFloat(document.getElementById('precio').value);
    const stock = parseInt(document.getElementById('stock').value);
    const categoria = document.getElementById('categoria_id').value;

    if (!nombre) {
        mostrarError('El nombre del producto es requerido');
        return false;
    }

    if (isNaN(precio) || precio < 0) {
        mostrarError('El precio debe ser un número válido mayor o igual a 0');
        return false;
    }

    if (isNaN(stock) || stock < 0) {
        mostrarError('El stock debe ser un número válido mayor o igual a 0');
        return false;
    }

    if (!categoria) {
        mostrarError('Debe seleccionar una categoría');
        return false;
    }

    return true;
}

function mostrarError(mensaje) {
    const mensajeError = document.getElementById('mensajeError');
    mensajeError.textContent = mensaje;
    mensajeError.style.display = 'block';
    setTimeout(() => {
        mensajeError.style.display = 'none';
    }, 5000);
}
