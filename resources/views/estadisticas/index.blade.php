@extends('layouts.app')

@section('title', 'Panel de Estadísticas')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Panel de Estadísticas</h1>

    <div class="row">
        <!-- Tarjetas de resumen -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Clientes</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalClientes }}</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Empleados</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalEmpleados }}</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Productos</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalProductos }}</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Pedidos</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalPedidos }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Ventas por Mes -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Ventas por Mes (Total: Bs. {{ number_format($totalVentas, 2) }})</div>
                <div class="card-body">
                    <canvas id="ventasMesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Productos por Categoría -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Productos por Categoría</div>
                <div class="card-body">
                    <canvas id="productosCategoriaChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Productos más vendidos -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Top 5 Productos Más Vendidos</div>
                <div class="card-body">
                    <canvas id="productosChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Crecimiento mensual de ventas -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Crecimiento Mensual de Ventas</div>
                <div class="card-body">
                    <canvas id="crecimientoChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Métodos de pago más usados -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Métodos de Pago Más Utilizados</div>
                <div class="card-body">
                    <canvas id="metodosPagoChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Pedidos por Estado -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Distribución de Pedidos por Estado</div>
                <div class="card-body">
                    <canvas id="pedidosEstadoChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top clientes frecuentes -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Top 5 Clientes Frecuentes</div>
                <div class="card-body">
                    <canvas id="clientesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Actividad reciente -->
        <!-- <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Registro de Actividad Reciente</div>
                <div class="card-body">
                    @if($actividadReciente->isEmpty())
                        <p>No hay actividad reciente para mostrar.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Acción</th>
                                        <th>Tabla</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($actividadReciente as $actividad)
                                        <tr>
                                            <td>{{ $actividad->usuario_nombre }}</td>
                                            <td>{{ $actividad->accion }}</td>
                                            <td>{{ $actividad->tabla_afectada }}</td>
                                            <td>{{ $actividad->fecha }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div> -->
    </div>

    <!-- Productos Bajo Stock -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">Productos con Bajo Stock</div>
                <div class="card-body">
                    @if($productosBajoStock->isEmpty())
                        <p>No hay productos con bajo stock.</p>
                    @else
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad Disponible</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productosBajoStock as $producto)
                                    <tr>
                                        <td>{{ $producto->nombre_producto }}</td>
                                        <td>{{ $producto->cantidad_disponible }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ventas por mes
    const ventasMesCtx = document.getElementById('ventasMesChart').getContext('2d');
    new Chart(ventasMesCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($ventasPorMes->pluck('mes')) !!},
            datasets: [{
                label: 'Ventas en Bs.',
                data: {!! json_encode($ventasPorMes->pluck('total')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Bs. ' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Bs. ' + context.raw.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Productos por categoría
    const productosCategoriaCtx = document.getElementById('productosCategoriaChart').getContext('2d');
    new Chart(productosCategoriaCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode(array_keys($productosPorCategoria->toArray())) !!},
            datasets: [{
                data: {!! json_encode(array_values($productosPorCategoria->toArray())) !!},
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#8E44AD', '#2ECC71', '#E67E22',
                    '#3498DB', '#9B59B6', '#1ABC9C', '#F39C12', '#D35400', '#BDC3C7'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        }
    });

    // Productos más vendidos
    const productosChartCtx = document.getElementById('productosChart').getContext('2d');
    new Chart(productosChartCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($productosMasVendidos->pluck('nombre_producto')) !!},
            datasets: [{
                label: 'Unidades Vendidas',
                data: {!! json_encode($productosMasVendidos->pluck('total_vendidos')) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Crecimiento mensual de ventas
    const crecimientoCtx = document.getElementById('crecimientoChart').getContext('2d');
    new Chart(crecimientoCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($ventasCrecimiento->pluck('mes')) !!},
            datasets: [{
                label: 'Ventas Totales (Bs.)',
                data: {!! json_encode($ventasCrecimiento->pluck('total')) !!},
                fill: false,
                borderColor: 'rgba(153, 102, 255, 1)',
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Bs. ' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Bs. ' + context.raw.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Métodos de pago
    const metodosPagoCtx = document.getElementById('metodosPagoChart').getContext('2d');
    new Chart(metodosPagoCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($metodosPago->toArray())) !!},
            datasets: [{
                data: {!! json_encode(array_values($metodosPago->toArray())) !!},
                backgroundColor: ['#2ECC71', '#3498DB', '#E67E22', '#9B59B6', '#FF6384'],
                borderColor: ['#fff', '#fff', '#fff', '#fff', '#fff'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        }
    });

    // Pedidos por estado
    const pedidosEstadoCtx = document.getElementById('pedidosEstadoChart').getContext('2d');
    new Chart(pedidosEstadoCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($pedidosPorEstado->toArray())) !!},
            datasets: [{
                label: 'Cantidad de Pedidos',
                data: {!! json_encode(array_values($pedidosPorEstado->toArray())) !!},
                backgroundColor: 'rgba(255, 159, 64, 0.7)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });

    // Top clientes frecuentes
    const clientesChartCtx = document.getElementById('clientesChart').getContext('2d');
    new Chart(clientesChartCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($clientesFrecuentes->pluck('cliente')) !!},
            datasets: [{
                label: 'Cantidad de pedidos',
                data: {!! json_encode($clientesFrecuentes->pluck('pedidos')) !!},
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                borderColor: ['#fff', '#fff', '#fff', '#fff', '#fff'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + ' pedidos';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection