async function buscarProducto() {
    const productId = document.getElementById('buscarId').value;
    const mensajeError = document.getElementById('mensajeError');
    
    try {
        mensajeError.style.display = 'none';
        
        if (!productId || productId <= 0) {
            throw new Error('Por favor, ingrese un ID de producto válido');
        }

        const response = await fetch(`../Api/controllers/ProductoController.php?action=obtener_uno&id=${productId}`);
        
        if (!response.ok) {
            throw new Error(`Error del servidor: ${response.status}`);
        }

        const resultado = await response.json();

        if (!resultado.success || !resultado.data) {
            throw new Error(`No se encontró el producto con el ID: ${productId}`);
        }

        const producto = resultado.data;

        document.getElementById('busquedaProducto').style.display = 'none';
        document.getElementById('formActualizarProducto').style.display = 'block';
        
        document.getElementById('id').value = producto.id;
        document.getElementById('nombre').value = producto.nombre;
        document.getElementById('descripcion').value = producto.descripcion;
        document.getElementById('precio').value = producto.precio;
        document.getElementById('stock').value = producto.stock;

        await cargarCategorias(producto.categoria_id);

    } catch (error) {
        console.error('Error:', error);
        mostrarError(error.message);
        document.getElementById('formActualizarProducto').style.display = 'none';
        document.getElementById('busquedaProducto').style.display = 'block';
    }
}

async function cargarCategorias(categoriaSeleccionada = null) {
    try {
        const response = await fetch('../Api/controllers/ProductoController.php?action=categorias');
        const resultado = await response.json();
        
        if (!resultado.success) {
            throw new Error('Error al cargar las categorías');
        }

        const selectCategoria = document.getElementById('categoria_id');
        selectCategoria.innerHTML = '<option value="">Seleccione una categoría</option>';

        resultado.data.forEach(categoria => {
            const option = document.createElement('option');
            option.value = categoria.id;
            option.textContent = categoria.nombre;
            if (categoriaSeleccionada && categoria.id == categoriaSeleccionada) {
                option.selected = true;
            }
            selectCategoria.appendChild(option);
        });

    } catch (error) {
        console.error('Error al cargar categorías:', error);
        mostrarError('Error al cargar las categorías');
    }
}

async function actualizarProducto(event) {
    event.preventDefault();
    
    if (!validarFormulario()) {
        return;
    }

    const formData = new FormData(event.target);
    
    try {
        const response = await fetch('../Api/controllers/ProductoController.php?action=actualizar', {
            method: 'POST',
            body: formData
        });

        const resultado = await response.json();

        if (!resultado.success) {
            throw new Error(resultado.message || 'Error al actualizar el producto');
        }

        alert('Producto actualizado correctamente');
        window.location.href = 'productos.html';

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
