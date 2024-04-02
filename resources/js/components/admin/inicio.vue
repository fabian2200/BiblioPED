<template lang="">
    <div>
        <div class="app-content content" v-if="!loading">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <!-- Stats -->
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="media align-items-stretch">
                                        <div class="p-2 text-center bg-primary bg-darken-2">
                                            <i class="fas fa-user-tie fa-3x white"></i>
                                        </div>
                                        <div class="p-2 bg-gradient-x-primary white media-body">
                                            <h5 style="font-weight: bold">Docentes</h5>
                                            <h5 style="font-size: 30px;" class="text-bold-400 mb-0">{{ datos.numero_docentes }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="media align-items-stretch">
                                        <div class="p-2 text-center bg-danger bg-darken-2">
                                            <i class="fas fa-user-graduate fa-3x white"></i>                                        </div>
                                        <div class="p-2 bg-gradient-x-danger white media-body">
                                            <h5 style="font-weight: bold">Estudiantes</h5>
                                            <h5 style="font-size: 30px;" class="text-bold-400 mb-0">{{ datos.numero_estudiantes }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="media align-items-stretch">
                                        <div class="p-2 text-center bg-warning bg-darken-2">
                                            <i class="fas fa-search fa-3x white"></i>                                        </div>
                                        <div class="p-2 bg-gradient-x-warning white media-body">
                                            <h5 style="font-weight: bold">Busquedas</h5>
                                            <h5 style="font-size: 30px;" class="text-bold-400 mb-0">{{ datos.numero_busquedas }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="media align-items-stretch">
                                        <div class="p-2 text-center bg-success bg-darken-2">
                                            <i class="fas fa-edit fa-3x white"></i>                                        </div>
                                        <div class="p-2 bg-gradient-x-success white media-body">
                                            <h5 style="font-weight: bold;">Apuntes</h5>
                                            <h5 style="font-size: 30px;" class="text-bold-400 mb-0">{{ datos.numero_apuntes }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Stats -->
                    <!--Product sale & buyers -->
                    <div class="row match-height" style="height: 750px !important">
                        <div class="col-xl-8 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Historial de busquedas</h4>
                                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div id="products-sales" class="height-500">
                                            <Line v-if="!loading" :data="dataChart" :options="options" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-12" v-if="!loading">
                            <div  style="height: 703px !important; background-color: #fff;margin-bottom: 1.875rem; border: none; border-radius: 0; box-shadow: 0 10px 40px 0 rgba(62, 57, 107, 0.07), 0 2px 9px 0 rgba(62, 57, 107, 0.06);">
                                <div class="card-header">
                                    <h4 class="card-title">Busquedas por dia</h4>
                                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content px-1">
                                    <div id="recent-buyers" class="media-list height-300 position-relative">
                                        <a href="#" class="media border-0" style="display: flex; align-items: center; border-bottom: 1px solid #ada9a9c4 !important; margin-top: 10px;">
                                            <div class="media-left pr-1">
                                                <div style="height: 45px; width: 66px;" class="avatar avatar-online avatar-md"><img class="media-object" style="border-radius: 0% !important;" src="/img/dias/0.png" alt="Generic placeholder image">
                                                    <i></i>
                                                </div>
                                            </div>
                                            <div class="media-body w-100">
                                                 <span style="padding: 0px !important; margin-left: 20px" class="font-medium-4  pt-1"><strong>{{ datos.data_por_dia[0] }}</strong> Busquedas</span>
                                            </div>
                                        </a>
                                        <a href="#" class="media border-0" style="display: flex; align-items: center; border-bottom: 1px solid #ada9a9c4 !important; margin-top: 10px;">
                                            <div class="media-left pr-1">
                                                <div style="height: 45px; width: 66px;" class="avatar avatar-online avatar-md"><img class="media-object" style="border-radius: 0% !important;" src="/img/dias/1.png" alt="Generic placeholder image">
                                                    <i></i>
                                                </div>
                                            </div>
                                            <div class="media-body w-100">
                                                 <span style="padding: 0px !important; margin-left: 20px" class="font-medium-4  pt-1"><strong>{{ datos.data_por_dia[1] }}</strong> Busquedas</span>
                                            </div>
                                        </a>
                                        <a href="#" class="media border-0" style="display: flex; align-items: center; border-bottom: 1px solid #ada9a9c4 !important; margin-top: 10px;">
                                            <div class="media-left pr-1">
                                                <div style="height: 45px; width: 66px;" class="avatar avatar-online avatar-md"><img class="media-object" style="border-radius: 0% !important;" src="/img/dias/2.png" alt="Generic placeholder image">
                                                    <i></i>
                                                </div>
                                            </div>
                                            <div class="media-body w-100">
                                                 <span style="padding: 0px !important; margin-left: 20px" class="font-medium-4  pt-1"><strong>{{ datos.data_por_dia[2] }}</strong> Busquedas</span>
                                            </div>
                                        </a>
                                        <a href="#" class="media border-0" style="display: flex; align-items: center; border-bottom: 1px solid #ada9a9c4 !important; margin-top: 10px;">
                                            <div class="media-left pr-1">
                                                <div style="height: 45px; width: 66px;" class="avatar avatar-online avatar-md"><img class="media-object" style="border-radius: 0% !important;" src="/img/dias/3.png" alt="Generic placeholder image">
                                                    <i></i>
                                                </div>
                                            </div>
                                            <div class="media-body w-100">
                                                 <span style="padding: 0px !important; margin-left: 20px" class="font-medium-4  pt-1"><strong>{{ datos.data_por_dia[3] }}</strong> Busquedas</span>
                                            </div>
                                        </a>
                                        <a href="#" class="media border-0" style="display: flex; align-items: center; border-bottom: 1px solid #ada9a9c4 !important; margin-top: 10px;">
                                            <div class="media-left pr-1">
                                                <div style="height: 45px; width: 66px;" class="avatar avatar-online avatar-md"><img class="media-object" style="border-radius: 0% !important;" src="/img/dias/4.png" alt="Generic placeholder image">
                                                    <i></i>
                                                </div>
                                            </div>
                                            <div class="media-body w-100">
                                                 <span style="padding: 0px !important; margin-left: 20px" class="font-medium-4  pt-1"><strong>{{ datos.data_por_dia[4] }}</strong> Busquedas</span>
                                            </div>
                                        </a>
                                        <a href="#" class="media border-0" style="display: flex; align-items: center; border-bottom: 1px solid #ada9a9c4 !important; margin-top: 10px;">
                                            <div class="media-left pr-1">
                                                <div style="height: 45px; width: 66px;" class="avatar avatar-online avatar-md"><img class="media-object" style="border-radius: 0% !important;" src="/img/dias/5.png" alt="Generic placeholder image">
                                                    <i></i>
                                                </div>
                                            </div>
                                            <div class="media-body w-100">
                                                 <span style="padding: 0px !important; margin-left: 20px" class="font-medium-4  pt-1"><strong>{{ datos.data_por_dia[5] }}</strong> Busquedas</span>
                                            </div>
                                        </a>
                                        <a href="#" class="media border-0" style="display: flex; align-items: center; border-bottom: 1px solid #ada9a9c4 !important; margin-top: 10px;">
                                            <div class="media-left pr-1">
                                                <div style="height: 45px; width: 66px;" class="avatar avatar-online avatar-md"><img class="media-object" style="border-radius: 0% !important;" src="/img/dias/6.png" alt="Generic placeholder image">
                                                    <i></i>
                                                </div>
                                            </div>
                                            <div class="media-body w-100">
                                                 <span style="padding: 0px !important; margin-left: 20px" class="font-medium-4  pt-1"><strong>{{ datos.data_por_dia[6] }}</strong> Busquedas</span>
                                            </div>
                                        </a>
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
import * as adminService from "../../services/admin";

import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
} from 'chart.js';

import { Line } from 'vue-chartjs'


ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
)

export default {
    components: {
        Line
    },
    data() {
        return {
            datos: {
            },
            loading: true,
            dataChart: {
                labels: [],
                datasets: [
                    {
                        label: 'Ultimos 15 dias',
                        backgroundColor: '#f87979',
                        data: []
                    }
                ]
            },
            options:{
                responsive: true,
                maintainAspectRatio: false
            }
        };
    },
    mounted() {
        this.obtenerdatos();
        document.title = 'Dashboard - BiblioPED';
    },
    methods: {
        async obtenerdatos(){
            this.loading = true;
            await adminService.obtenerdatos().then(respuesta => {
                this.datos = respuesta.data;
                this.dataChart.labels = respuesta.data.labels;
                this.dataChart.datasets[0].data = respuesta.data.dataG;
                this.loading = false;
            });
        },
    }
}
</script>
<style lang="">
    
</style>