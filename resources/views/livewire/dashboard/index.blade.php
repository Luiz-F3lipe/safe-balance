<div class="w-full">
    <x-header title="Dashboard" separator />

    {{-- Filtros de Data --}}
    <div class="card bg-base-100 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                <div>
                    <x-input
                        wire:model="startDate"
                        type="date"
                        label="Data Inicial"
                        icon="lucide.calendar"
                        class="input-sm"
                    />
                </div>
                <div>
                    <x-input
                        wire:model="endDate"
                        type="date"
                        label="Data Final"
                        icon="lucide.calendar"
                        class="input-sm"
                    />
                </div>
                <div class="flex items-end">
                    <x-button
                        wire:click="$refresh"
                        label="Filtrar"
                        icon="lucide.filter"
                        class="btn-success w-full"
                        spinner
                    />
                </div>
            </div>
        </div>
    </div>

    {{-- Cards de Resumo --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
        {{-- Card Total de Receitas --}}
        <div class="card bg-linear-to-br from-emerald-500 to-emerald-600 text-white shadow-lg">
            <div class="card-body p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium mb-1">Total de Receitas</p>
                        <p class="text-2xl sm:text-3xl font-bold">
                            R$ {{ number_format($this->totalIncome, 2, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <x-icon name="lucide.trending-up" class="w-8 h-8" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Total de Despesas --}}
        <div class="card bg-linear-to-br from-red-500 to-red-600 text-white shadow-lg">
            <div class="card-body p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium mb-1">Total de Despesas</p>
                        <p class="text-2xl sm:text-3xl font-bold">
                            R$ {{ number_format($this->totalExpenses, 2, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-white/20 rounded-full">
                        <x-icon name="lucide.trending-down" class="w-8 h-8" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráficos --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- Gráfico de Despesas por Categoria --}}
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-4">
                <h3 class="text-lg font-bold text-emerald-600 mb-4 flex items-center gap-2">
                    <x-icon name="lucide.pie-chart" class="w-5 h-5" />
                    Despesas por Categoria
                </h3>
                <div
                    x-data="categoryChart(@js($this->expensesByCategory), @js($this->totalExpenses))"
                    x-init="renderChart()"
                    wire:key="category-chart-{{ $startDate }}-{{ $endDate }}"
                >
                    <div id="category-chart" class="w-full"></div>
                </div>
            </div>
        </div>

        {{-- Gráfico de Despesas por Contato --}}
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-4">
                <h3 class="text-lg font-bold text-emerald-600 mb-4 flex items-center gap-2">
                    <x-icon name="lucide.pie-chart" class="w-5 h-5" />
                    Despesas por Contato
                </h3>
                <div
                    x-data="contactChart(@js($this->expensesByContact), @js($this->totalExpenses))"
                    x-init="renderChart()"
                    wire:key="contact-chart-{{ $startDate }}-{{ $endDate }}"
                >
                    <div id="contact-chart" class="w-full"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Saldo --}}
    <div class="card bg-base-100 shadow-sm mt-4">
        <div class="card-body p-4">
            <div class="text-center">
                <p class="text-sm text-base-content/70 mb-2">Saldo do Período</p>
                <p class="text-3xl font-bold {{ ($this->totalIncome - $this->totalExpenses) >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                    R$ {{ number_format($this->totalIncome - $this->totalExpenses, 2, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- Gráfico de Gastos Mensais --}}
    <div class="card bg-base-100 shadow-sm mt-4">
        <div class="card-body p-4">
            <h3 class="text-lg font-bold text-emerald-600 mb-4 flex items-center gap-2">
                <x-icon name="lucide.trending-up" class="w-5 h-5" />
                Evolução de Gastos (Últimos 12 Meses)
            </h3>
            <div
                x-data="monthlyExpensesChart(@js($this->monthlyExpenses))"
                x-init="renderChart()"
            >
                <div id="monthly-expenses-chart" class="w-full"></div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    Alpine.data('categoryChart', (data, total) => ({
        chart: null,
        renderChart() {
            const categories = data.map(item => item.category);
            const values = data.map(item => parseFloat(item.total));

            const options = {
                series: values.length > 0 ? values : [1],
                chart: {
                    type: 'donut',
                    height: 350,
                    fontFamily: 'inherit',
                },
                labels: categories.length > 0 ? categories : ['Sem dados'],
                colors: categories.length > 0 ? [
                    '#3b82f6', '#8b5cf6', '#ec4899', '#f59e0b',
                    '#10b981', '#ef4444', '#06b6d4', '#6366f1',
                    '#84cc16', '#f97316', '#14b8a6', '#a855f7',
                    '#0ea5e9', '#22c55e', '#eab308', '#db2777'
                ] : ['#e5e7eb'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total Gasto',
                                    fontSize: '14px',
                                    fontWeight: 600,
                                    color: '#10b981',
                                    formatter: function () {
                                        return 'R$ ' + total.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                    }
                                },
                                value: {
                                    fontSize: '20px',
                                    fontWeight: 700,
                                    color: '#10b981',
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val.toFixed(1) + '%';
                    },
                    style: {
                        fontSize: '12px',
                        fontWeight: 600,
                    },
                    dropShadow: {
                        enabled: false
                    }
                },
                legend: {
                    position: 'bottom',
                    fontSize: '12px',
                    fontWeight: 500,
                    offsetY: 5,
                    markers: {
                        width: 12,
                        height: 12,
                        radius: 2,
                    },
                    itemMargin: {
                        horizontal: 5,
                        vertical: 3
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 300
                        },
                        legend: {
                            position: 'bottom',
                            fontSize: '11px',
                        }
                    }
                }],
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return 'R$ ' + val.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        }
                    }
                }
            };

            if (this.chart) {
                this.chart.destroy();
            }

            this.chart = new ApexCharts(document.querySelector("#category-chart"), options);
            this.chart.render();
        }
    }));

    Alpine.data('contactChart', (data, total) => ({
        chart: null,
        renderChart() {
            const contacts = data.map(item => item.contact);
            const values = data.map(item => parseFloat(item.total));

            const options = {
                series: values.length > 0 ? values : [1],
                chart: {
                    type: 'donut',
                    height: 350,
                    fontFamily: 'inherit',
                },
                labels: contacts.length > 0 ? contacts : ['Sem dados'],
                colors: contacts.length > 0 ? [
                    '#3b82f6', '#8b5cf6', '#ec4899', '#f59e0b',
                    '#10b981', '#ef4444', '#06b6d4', '#6366f1',
                    '#84cc16', '#f97316', '#14b8a6', '#a855f7',
                    '#0ea5e9', '#22c55e', '#eab308', '#db2777'
                ] : ['#e5e7eb'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total Gasto',
                                    fontSize: '14px',
                                    fontWeight: 600,
                                    color: '#10b981',
                                    formatter: function () {
                                        return 'R$ ' + total.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                    }
                                },
                                value: {
                                    fontSize: '20px',
                                    fontWeight: 700,
                                    color: '#10b981',
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val.toFixed(1) + '%';
                    },
                    style: {
                        fontSize: '12px',
                        fontWeight: 600,
                    },
                    dropShadow: {
                        enabled: false
                    }
                },
                legend: {
                    position: 'bottom',
                    fontSize: '12px',
                    fontWeight: 500,
                    offsetY: 5,
                    markers: {
                        width: 12,
                        height: 12,
                        radius: 2,
                    },
                    itemMargin: {
                        horizontal: 5,
                        vertical: 3
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 300
                        },
                        legend: {
                            position: 'bottom',
                            fontSize: '11px',
                        }
                    }
                }],
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return 'R$ ' + val.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(\d))/g, '.');
                        }
                    }
                }
            };

            if (this.chart) {
                this.chart.destroy();
            }

            this.chart = new ApexCharts(document.querySelector("#contact-chart"), options);
            this.chart.render();
        }
    }));

    Alpine.data('monthlyExpensesChart', (data) => ({
        chart: null,
        renderChart() {
            const months = data.map(item => item.label);
            const values = data.map(item => parseFloat(item.total));

            const options = {
                series: [{
                    name: 'Gastos',
                    data: values
                }],
                chart: {
                    type: 'area',
                    height: 350,
                    fontFamily: 'inherit',
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                colors: ['#10b981'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.2,
                        stops: [0, 90, 100]
                    }
                },
                xaxis: {
                    categories: months,
                    labels: {
                        rotate: -45,
                        rotateAlways: true,
                        style: {
                            fontSize: '11px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            return 'R$ ' + val.toFixed(0);
                        }
                    }
                },
                grid: {
                    borderColor: '#e5e7eb',
                    strokeDashArray: 5,
                },
                markers: {
                    size: 5,
                    colors: ['#10b981'],
                    strokeColors: '#fff',
                    strokeWidth: 2,
                    hover: {
                        size: 7
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return 'R$ ' + val.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 300
                        },
                        xaxis: {
                            labels: {
                                style: {
                                    fontSize: '10px'
                                }
                            }
                        }
                    }
                }]
            };

            if (this.chart) {
                this.chart.destroy();
            }

            this.chart = new ApexCharts(document.querySelector("#monthly-expenses-chart"), options);
            this.chart.render();
        }
    }));
</script>
@endscript

@assets
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endassets
