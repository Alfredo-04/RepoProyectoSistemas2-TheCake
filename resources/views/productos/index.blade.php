@extends('layouts.app')

@section('title', 'Gestión de Productos')

@section('content')
<style>
    body {
    background: linear-gradient(135deg, #f8a29b, #ff6f61);
    color: #333;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    text-align: center;

}

h2 {
    font-size: 3rem;
    color: #fff;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    margin: 40px 0;
    animation: fadeIn 2s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.container {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 20px;
    padding: 30px;
    margin: 40px auto;
    max-width: 1200px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    animation: slideIn 1s ease-in-out;
}

@keyframes slideIn {
    from { transform: translateY(50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* Estilos específicos para el formulario */
form {
    position: relative;
    z-index: 10;
    background: rgba(255, 255, 255, 0.95);
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    margin-bottom: 30px;
}

.form-label {
    display: block;
    text-align: left;
    margin-bottom: 20px;
    font-weight: bold;
    color: #ff6f61;
    position: relative;
    z-index: 10;
}

.mb-3 {
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 10;
}

.form-control {
    border: 1px solid #ff6f61;
    border-radius: 10px;
    padding: 5px;
    font-size: 1rem;
    margin-bottom: 10px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-control:focus {
    border-color: #ff3b30;
    outline: none;
    box-shadow: 0 0 5px rgba(255, 111, 97, 0.5);
}

.btn-success {
    background: #ff6f61;
    border: none;
    padding: 12px 24px;
    border-radius: 10px;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
}

.btn-success:hover {
    background: #ff3b30;
    transform: scale(1.05);
}

.btn-warning {
    background: #ffbc0a;
    border: none;
    padding: 8px 16px;
    border-radius: 10px;
    color: #000;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
}

.btn-warning:hover {
    background: #f4a900;
    transform: scale(1.05);
}

.btn-danger {
    background: #ff6f61;
    border: none;
    padding: 8px 16px;
    border-radius: 10px;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
}

.btn-danger:hover {
    background: #ff3b30;
    transform: scale(1.05);
}

.btn-sm {
    padding: 6px 12px;
    margin: 0 4px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-sm i {
    margin-right: 5px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    margin-bottom: 30px;
}

thead {
    background: #ff6f61;
    color: white;
    font-size: 1.2rem;
}

th, td {
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
    text-align: center;
}

tbody tr:hover {
    background: rgba(255, 111, 97, 0.1);
    transition: background 0.3s;
}

/* Estilos para las imágenes en la tabla */
table img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out;
}

table img:hover {
    transform: scale(1.1);
}

#modalEditar {
    background: rgba(255, 255, 255, 0.9);
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    margin-top: 20px;
    display: none;
}

.navbar {
    background: rgba(255, 255, 255, 0.9);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.navbar-brand img {
    height: 60px;
    transition: transform 0.3s ease-in-out;
}

.navbar-brand img:hover {
    transform: rotate(10deg);
}

.nav-link {
    font-size: 1.1rem;
    color: #333 !important;
    transition: color 0.3s ease-in-out;
}

.nav-link:hover {
    color: #ff6f61 !important;
}

body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0) 70%);
    pointer-events: none;
    animation: float 6s infinite ease-in-out;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

@media (max-width: 768px) {
    .container {
        width: 90%;
        padding: 20px;
    }

    table {
        font-size: 0.9rem;
    }

    th, td {
        padding: 10px;
    }

    h2 {
        font-size: 2rem;
    }

    .btn-success, .btn-warning, .btn-danger {
        padding: 8px 16px;
        font-size: 0.9rem;
    }

    .footer-container {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .footer-section ul li {
        justify-content: center;
    }
}
    </style>
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-primary">Registro de Productos</h2>

    <!-- Agregar Producto -->
    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Nombre</label>
            <input type="text" class="form-control" name="nombre_producto" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Precio</label>
            <input type="number" class="form-control" name="precio" step="0.01" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Stock Mínimo</label>
            <input type="number" class="form-control" name="stock_minimo" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Categoría</label>
            <select class="form-select" name="categoria_producto_id" required>
                <option value="">Seleccione una categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Descripción</label>
            <textarea class="form-control" name="descripcion"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Imagen</label>
            <input type="file" class="form-control" name="imagen">
        </div>
        <button type="submit" class="btn btn-success">Agregar Producto</button>
    </form>

    <hr class="my-5">
    <h3 class="mb-3 text-secondary">Lista de Productos</h3>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock Mínimo</th>
                    <th>Categoría</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $row)
                    <tr>
                        <td>
                            @if ($row->imagen)
                                <img src="data:image/jpeg;base64,{{ base64_encode($row->imagen) }}" class="img-thumbnail" width="50">
                            @else
                                <span class="text-muted">Sin imagen</span>
                            @endif
                        </td>
                        <td>{{ $row->nombre_producto }}</td>
                        <td>{{ $row->precio }}</td>
                        <td>{{ $row->stock_minimo }}</td>
                        <td>{{ $row->nombre_categoria }}</td>
                        <td>{{ $row->descripcion }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm me-1"
                                onclick="editarProducto(
                                    {{ $row->id_producto }},
                                    '{{ $row->nombre_producto }}',
                                    {{ $row->precio }},
                                    {{ $row->stock_minimo }},
                                    {{ $row->categoria_producto_id }},
                                    `{{ $row->descripcion }}`
                                )">
                                <i class="fas fa-edit"></i>
                            </button>

                            <form action="{{ route('productos.destroy', $row->id_producto) }}" method="GET" class="d-inline" onsubmit="return confirmarEliminacion('{{ $row->nombre_producto }}');">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de Edición -->
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('productos.update') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Editar Producto</h5>
                <button type="button" class="btn-close" onclick="cerrarModal()"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_producto" id="edit_id">
                <input type="text" name="nombre_producto" id="edit_nombre" class="form-control mb-3" required>
                <input type="number" name="precio" id="edit_precio" class="form-control mb-3" step="0.01" required>
                <input type="number" name="stock_minimo" id="edit_stock" class="form-control mb-3" required>
                <select name="categoria_producto_id" id="edit_categoria" class="form-select mb-3" required>
                    <option value="">Seleccione una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</option>
                    @endforeach
                </select>
                <textarea name="descripcion" id="edit_descripcion" class="form-control mb-3"></textarea>
                <input type="file" name="imagen" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
    function editarProducto(id, nombre, precio, stock, categoria_id, descripcion) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nombre').value = nombre;
        document.getElementById('edit_precio').value = precio;
        document.getElementById('edit_stock').value = stock;
        document.getElementById('edit_categoria').value = categoria_id;
        document.getElementById('edit_descripcion').value = descripcion;

        const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
        modal.show();
    }

    function cerrarModal() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditar'));
        modal.hide();
    }

    function confirmarEliminacion(nombre) {
        return confirm(`¿Estás seguro de que deseas eliminar el producto "${nombre}"?`);
    }
</script>
@endsection