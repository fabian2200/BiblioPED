<template>
    <div class="app-content content" v-if="!loading">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row"></div>
            <div class="content-body">
                <div class="row match-height">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Estadisticas biblioped</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-top-border no-hover-bg" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="base-tab11" style="font-size: 20px;" data-toggle="tab" aria-controls="tab11" href="#tab11" role="tab" aria-selected="true">Busquedas</a>
                                        </li>
                                       
                                    </ul>
                                    <div class="tab-content px-1 pt-1">
                                        <div class="tab-pane active" id="tab11" role="tabpanel" aria-labelledby="base-tab11">
                                           <div class="row">
                                                <div class="col-xl-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title titulo_card_biblioped">REGISTRO DE HISTORIAL DE BÚSQUEDAS</h4>
                                                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                        </div>
                                                        <div class="card-content">
                                                            <div class="card-body">
                                                                <div id="products-sales" class="height-500">
                                                                    <div class="hello" ref="chartdiv"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title titulo_card_biblioped">HISTORIAL DE BÚSQUEDAS MENSUALES</h4>
                                                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                        </div>
                                                        <div class="card-content">
                                                            <div class="card-body">
                                                                <div id="products-sales" class="height-500">
                                                                    <div class="hello" ref="chartdivmeses"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title titulo_card_biblioped">ANÁLISIS DEL PORCENTAJE DE BÚSQUEDAS SEGÚN DÍAS DE LA SEMANA</h4>
                                                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                        </div>
                                                        <div class="card-content">
                                                            <div class="card-body">
                                                                <div id="products-sales" class="height-500">
                                                                    <div class="hello" ref="chartdivpie"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title titulo_card_biblioped">ANÁLISIS DE TENDENCIAS DE BÚSQUEDA: PALABRAS MÁS BUSCADAS</h4>
                                                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                        </div>
                                                        <div class="card-content">
                                                            <div class="card-body">
                                                                <div id="products-sales" class="height-500">
                                                                    <div class="hello" ref="chartdivpalabras"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title titulo_card_biblioped">ANÁLISIS DE BÚSQUEDAS HORARIAS: REPRESENTACIÓN GRÁFICA DE CALOR</h4>
                                                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                        </div>
                                                        <div class="card-content">
                                                            <div class="card-body">
                                                                <div id="products-sales" class="height-600">
                                                                    <div class="hello2" ref="chartdivheatmap"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                           </div>
                                        </div>
                                        <div class="tab-pane" id="tab12" role="tabpanel" aria-labelledby="base-tab12">
                                            <p>Sugar plum tootsie roll biscuit caramels. Liquorice brownie pastry cotton candy oat cake fruitcake jelly chupa chups. Pudding caramels pastry powder cake soufflé wafer caramels. Jelly-o pie cupcake.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";
import * as adminService from "../../services/admin";

am4core.useTheme(am4themes_animated);

export default {
    data() {
        return {
            datos: null,
            chart: null,
            chart2: null,
            chart3: null,
            chart4: null,
            chart5: null
        };
    },
    mounted() {
        this.obtenerdatos();
        document.title = 'Estadistica - BiblioPED';
    },
    methods: {
        async obtenerdatos() {
            this.loading = true;
            await adminService.estadisticaData().then(respuesta => {
                this.datos = respuesta.data;
                this.generarGrafico(this.datos.busquedas_agrupadas);
                this.generarGraficoDias(this.datos.data_por_dia);
                this.generarGraficoMeses(this.datos.data_por_dmes);
                this.generarGraficopalabras(this.datos.palabras_mas_buscadas);
                this.generarMapaCalor(this.datos.mapaCalor);
            });
        },
        generarGrafico(data_grafica) {

            let chart = am4core.create(this.$refs.chartdiv, am4charts.XYChart);

            chart.paddingRight = 20;

            let data = [];
            let visits = 10;

            data_grafica.forEach(element => {
                data.push({
                    date: element.fecha,
                    name: element._id,
                    value: element.cantidad,
                });
            });

            chart.data = data;

            let dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            dateAxis.renderer.grid.template.location = 0;

            let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.tooltip.disabled = true;
            valueAxis.renderer.minWidth = 35;

            let series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.dateX = "date";
            series.dataFields.valueY = "value";

            series.tooltipText = "{valueY.value}";
            chart.cursor = new am4charts.XYCursor();

            let scrollbarX = new am4charts.XYChartScrollbar();
            scrollbarX.series.push(series);
            chart.scrollbarX = scrollbarX;

            this.chart = chart;

            this.loading = false;
        },
        generarGraficoDias(data_grafica) {

            let chart2 = am4core.create(this.$refs.chartdivpie, am4charts.PieChart3D);

            chart2.paddingRight = 50;

            chart2.data = [
                {
                    "country": "Lunes",
                    "litres": data_grafica[0]
                }, {
                    "country": "Martes",
                    "litres": data_grafica[1]
                }, {
                    "country": "Miércoles",
                    "litres": data_grafica[2]
                }, {
                    "country": "Jueves",
                    "litres": data_grafica[3]
                }, {
                    "country": "Viernes",
                    "litres": data_grafica[4]
                }, {
                    "country": "Sábado",
                    "litres": data_grafica[5]
                }, {
                    "country": "Domingo",
                    "litres": data_grafica[6]
                },
            ];

            var pieSeries = chart2.series.push(new am4charts.PieSeries3D());
            pieSeries.dataFields.value = "litres";
            pieSeries.dataFields.category = "country";

            this.chart2 = chart2;

            this.loading = false;
        },
        generarGraficoMeses(data_grafica) {
            let chart = am4core.create(this.$refs.chartdivmeses, am4charts.XYChart3D);

            chart.paddingRight = 20;

            let data = [];

            let i = 0;
            var meses_del_anio = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
            data_grafica.forEach(element => {
                data.push({
                    category: meses_del_anio[i],
                    value: element,
                });
                i++;
            });

            chart.data = data;

            let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "category";
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.renderer.minGridDistance = 10;

            let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.tooltip.disabled = true;
            valueAxis.renderer.minWidth = 35;

            let series = chart.series.push(new am4charts.ColumnSeries3D());
            series.dataFields.valueY = "value";
            series.dataFields.categoryX = "category";
            series.columns.template.fillOpacity = 0.8;

            series.columns.template.tooltipText = "{valueY.value}";
            chart.cursor = new am4charts.XYCursor();

            var columnTemplate = series.columns.template;
            columnTemplate.strokeWidth = 2;
            columnTemplate.strokeOpacity = 1;
            columnTemplate.stroke = am4core.color("#FFFFFF");

            columnTemplate.adapter.add("fill", function (fill, target) {
                return chart.colors.getIndex(target.dataItem.index);
            })

            columnTemplate.adapter.add("stroke", function (stroke, target) {
                return chart.colors.getIndex(target.dataItem.index);
            })

            this.chart3 = chart;
            this.loading = false;

        },
        generarGraficopalabras(data_grafica) {

            data_grafica.sort(function (a, b) {
                return a.count - b.count;
            });

            let chart = am4core.create(this.$refs.chartdivpalabras, am4charts.XYChart);

            chart.paddingRight = 20;

            let data = [];

            data_grafica.forEach(element => {
                data.push({
                    category: element.key,
                    value: element.count,
                });
            });

            chart.data = data;

            let categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "category";
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.renderer.minGridDistance = 10;

            let valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
            valueAxis.tooltip.disabled = true;
            valueAxis.renderer.minWidth = 35;

            let series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueX = "value";
            series.dataFields.categoryY = "category";
            series.columns.template.fill = am4core.color("#FF5733");

            series.columns.template.tooltipText = "{valueX.value}";
            chart.cursor = new am4charts.XYCursor();


            this.chart4 = chart;

            this.loading = false;
        },
        generarMapaCalor(data_grafica) {
            let chart = am4core.create(this.$refs.chartdivheatmap, am4charts.XYChart);

            chart.maskBullets = false;

            var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            var yAxis = chart.yAxes.push(new am4charts.CategoryAxis());

            xAxis.dataFields.category = "weekday";
            yAxis.dataFields.category = "hour";

            xAxis.renderer.grid.template.disabled = true;
            xAxis.renderer.minGridDistance = 40;

            yAxis.renderer.grid.template.disabled = true;
            yAxis.renderer.inversed = true;
            yAxis.renderer.minGridDistance = 30;

            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.categoryX = "weekday";
            series.dataFields.categoryY = "hour";
            series.dataFields.value = "value";
            series.sequencedInterpolation = true;
            series.defaultState.transitionDuration = 3000;

            var bgColor = new am4core.InterfaceColorSet().getFor("background");

            var columnTemplate = series.columns.template;
            columnTemplate.strokeWidth = 1;
            columnTemplate.strokeOpacity = 0.2;
            columnTemplate.stroke = bgColor;
            columnTemplate.tooltipText = "{weekday}, {hour}: {value.workingValue.formatNumber('#.')}";
            columnTemplate.width = am4core.percent(100);
            columnTemplate.height = am4core.percent(100);

            series.heatRules.push({
                target: columnTemplate,
                property: "fill",
                min: am4core.color("#F8C733"),
                max: am4core.color("#fe131a"),
            });

            // heat legend
            var heatLegend = chart.bottomAxesContainer.createChild(am4charts.HeatLegend);
            heatLegend.width = am4core.percent(100);
            heatLegend.series = series;
            heatLegend.valueAxis.renderer.labels.template.fontSize = 9;
            heatLegend.valueAxis.renderer.minGridDistance = 30;

            // heat legend behavior
            series.columns.template.events.on("over", function (event) {
                handleHover(event.target);
            })

            series.columns.template.events.on("hit", function (event) {
                handleHover(event.target);
            })

            function handleHover(column) {
                if (!isNaN(column.dataItem.value)) {
                    heatLegend.valueAxis.showTooltipAt(column.dataItem.value)
                }
                else {
                    heatLegend.valueAxis.hideTooltip();
                }
            }

            series.columns.template.events.on("out", function (event) {
                heatLegend.valueAxis.hideTooltip();
            })

            chart.data = data_grafica;
            
            this.chart5 = chart;
            this.loading = false;
        },
        beforeDestroy() {
            if (this.chart) {
                this.chart.dispose();
            }
            if (this.chart2) {
                this.chart2.dispose();
            }
            if (this.chart3) {
                this.chart3.dispose();
            }
            if (this.chart4) {
                this.chart4.dispose();
            }
        },
    }
}   
</script>
<style>
.hello {
    width: 100%;
    height: 500px;
}

.hello2 {
    width: 100%;
    height: 600px;
}

.titulo_card_biblioped {
    font-size: 1.52rem !important;
    margin-bottom: 0 !important;
    color: #e83e8c !important;
    font-weight: bold !important;
}
</style>
