<template lang="">
    <div>
        <div class="app-content content" style = "background-color: #f5f7fa; padding-top: 40px">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                   
                </div>
                <div class="content-body">
                    <div class="col-md-12">
                        <div class="card">
                            <br>
                            <div class="content-header-left col-md-6 col-12 mb-2">
                                <h3 style="padding-left: 15px;font-weight: bold;color: #1a4377;" class="content-header-title mb-0">Banco de mentefactos</h3>
                            </div>
                            <div v-if="seleccionado == false" class="content-header-left col-md-6 col-12 mb-2">
                                <h4 style="padding-left: 15px;" class="content-header-title mb-0">Selecciona una asignatura</h4>
                            </div>
                            <hr>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div v-if="loading" class="loader" style="width: 100%;">
                                            <Skeleton></Skeleton>
                                        </div>
                                        <div class="row" v-if="seleccionado == false">
                                            <div class="col-lg-3" v-for="(item, index) in asignaturas" :key="index" style="margin-bottom: 20px">
                                                <div  :id="'ra'+index" class="card_radio" @click="select_radio_2('ra'+index, 'cardmentefactos'+index)">
                                                    <input class="radio_b" :value="item.nombre" type="radio" name="asignatura_mentefactos" :id="'cardmentefactos'+index">
                                                    <label :for="'cardmentefactos'+index">
                                                        <img :src="'/img/asignaturas/'+item.imagen" width="200" height="145" alt="">
                                                    </label>
                                                </div>
                                            </div>
                                        </div> 
                                        <div v-else >
                                            <div class="content-header-left col-md-6 col-12 mb-2">
                                                <h4 style="padding-left: 0px;" class="content-header-title mb-0">Mentefactos de la asignatura <strong>{{asignatura_seleccionada}}</strong></h4>
                                            </div>
                                            <br>  
                                            <button @click="seleccionado = false" style="width: 84px;height: 81px;border-radius: 50% !important;font-size: 27px;position: absolute;right: 3%;top: 41px;border: 8px solid white;" class="btn btn-danger"><i class="fas fa-arrow-left"></i></button>
                                            <div class="buscador_mentefactos">
                                                <input @input="filtrarObjetos" v-model="busqueda" type="text" class="form-control" style="width: 90%; font-size: 25px; border-radius: 26px; background-color: #f9f9f9; padding: 24px;" placeholder="Filtrar mentefactos">
                                                <i style="font-size: 28px; position: absolute; top: 10px; right: 61px;" class="fas fa-search"></i>
                                            </div>
                                            <div class="row">
                                                <div style="padding: 30px" v-for="(image, index) in lista_mentefactos" :key="index" class="col-lg-4">
                                                    <p style="font-size: 20px !important" class="texto_metafacto">{{ image.tema }}</p>
                                                    <img  style="cursor: pointer; height: 80%; width: 100%;" @click.prevent="seleccionarImagen(image.ruta, image.tema)" :src="'/metafactos/'+image.ruta" alt="Imagen" :ref="'imageRef' + index" />
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
        </div>

        <div class="modal fade text-left" id="modImagenMentefactos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel15"
            aria-hidden="true">
            <div class="modal-dialog  modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success white">
                        <h4 class="modal-title" style="text-transform: capitalize;"><span>{{ tituloImagen }}</span></h4>
                    </div>
                    <div class="modal-body">
                        <div id='ListEval' style="width: 100%; height: 650px;overflow: auto;text-align: center;display: flex;justify-content: center;align-items: center;">
                            <inner-image-zoom style="height: 650px;" zoomScale="1.8" :src="imagenSeleccionada" />
                        </div>
                        <div style="text-align: center; margin-top: 10px;">
                            <button @click.prevent="descargarImagen"  type="button" class="btn btn-success"><i class="fas fa-cloud-download-alt"></i> Descargar</button>
                            <button style="margin-left: 20px;" type="button" id="btn_salir" class="btn btn-danger" data-dismiss="modal"><i class="ft-corner-up-left position-right"></i><i class="fas fa-times"></i> Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import * as mentefactosService from "../services/mentefactos";
import InnerImageZoom from 'vue-inner-image-zoom'
import Skeleton from './skeleton/skeletonImagen';

export default {
    components: {
        InnerImageZoom,
        Skeleton
    },
    data() {
        return {
            asignaturas: [
                {
                    nombre: 'LENGUAJE',
                    imagen: 'lenguaje.png'
                },
                {
                    nombre: 'MATEMÁTICAS',
                    imagen: 'matematicas.png'
                },
                {
                    nombre: 'INGLÉS',
                    imagen: 'ingles.png'
                },
                {
                    nombre: 'SOCIALES',
                    imagen: 'sociales.png'
                },
                { 
                    nombre:"CIENCIAS NATURALES",
                    imagen: 'cuencias_naturalez_me.png'
                },
                { 
                    nombre:"LECTURA CRÍTICA",
                    imagen: 'lectura_critica_me.png'
                },
                { 
                    nombre:"COMPETENCIAS CIUDADANAS",
                    imagen: 'competencia_ciudadana_me.png'
                },
                {
                    nombre: 'CÁTEDRA DE LA PAZ',
                    imagen: 'catedra_paz.png'
                },
            ],
            seleccionado: false,
            asignatura_seleccionada: "",
            lista_mentefactos: [],
            imagenSeleccionada: "",
            imagenSeleccionada: "",
            lista_original: [],
            loading: false,
            busqueda: ""
        }
    },
    methods: {
        select_radio_2(id, rb){
            for (let index = 0; index < this.asignaturas.length; index++) {
                document.querySelector('#cardmentefactos'+index).checked = false;
            }
        
            document.querySelector('#'+rb).checked = true;

            for (let index = 0; index < this.asignaturas.length; index++) {
                let id_l = "ra"+index;
                if(id == id_l){
                    document.getElementById(id_l).classList.remove("card_radio");    
                    document.getElementById(id_l).classList.add("card_radio_active");
                }else{
                    document.getElementById(id_l).classList.add("card_radio");    
                    document.getElementById(id_l).classList.remove("card_radio_active");
                }
            }   
            this.seleccionado = true;
            this.asignatura_seleccionada = $("input[name='asignatura_mentefactos']:checked").val();
            this.listarMentafactosAsignatura();
        },
        async listarMentafactosAsignatura(){
            this.loading = true; 
            await mentefactosService.listarMentafactosAsignatura(this.asignatura_seleccionada).then(respuesta => {
                this.lista_mentefactos = respuesta.data;
                this.lista_original = respuesta.data;
                this.loading = false; 
            });
        },
        seleccionarImagen(rutaSeleccionada, tituloImagenS) {
            this.imagenSeleccionada = '/metafactos/'+rutaSeleccionada;
            this.tituloImagen = tituloImagenS;
            $("#modImagenMentefactos").modal("show");
        },
        descargarImagen() {
            const link = document.createElement('a');
            link.href = this.imagenSeleccionada;
            link.download = this.tituloImagen+".png";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
        filtrarObjetos() {
            if (this.busqueda === "") {
                this.lista_mentefactos = this.lista_original;
            }else{
                this.lista_mentefactos = this.lista_original.filter(objeto => {
                    return objeto.tema.toLowerCase().includes(this.busqueda.toLowerCase());
                });
            }
        }
    },
}
</script>
<style scoped>
    .card_radio_active{
        border: 4px solid #21a129 !important;
        background-color: #55F961;
        padding: 20px;
        width: 100%;
        cursor: pointer;
        border-radius: 30px;
    }

    .card_radio_active input{
        position: absolute;
        right: 39px;
        bottom: 27px;
        scale: 2;
    } 

    .card_radio_active label{
        cursor: pointer;
        color: #ffff;
    } 

    .card_radio input{
        position: absolute;
        right: 39px;
        bottom: 27px;
        scale: 2;
    } 

    .card_radio label{
        cursor: pointer;
    } 

    .disabled_div {
        pointer-events: none;
        opacity: 0.5;
    }

    .disabled_div img {
        filter: grayscale(100%);
    }

    .buscador_mentefactos {
        width: 400px;
        font-size: 25px;
        position: relative;
        margin-top: 44px;
        left: 70%;
    }

    .loader {
        text-align: center;
        margin: 20px 0;
    }

</style>