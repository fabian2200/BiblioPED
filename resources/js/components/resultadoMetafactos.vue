<template>
    <div id="fondo_metafacto">
        <div class="app-content container center-layout mt-2 pagina_resultado">
            <div class="content-overlay"></div>
            <div class="content-wrapper" style="padding: 0.8rem">
                <div class="content-header row">
                    <div  style="display: flex; flex-direction: column; justify-content: center;" class="content-header-left col-md-6 col-12 mb-2">
                        <h3 class="content-header-title mb-0">
                            Resultado de la búsqueda
                        </h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a @click.prevent="getAboutLink(0)" href="#">Inicio</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="#">Búsqueda</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="#">Búsqueda de Imágenes</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <headerColegio></headerColegio>
                </div>
                <div class="content-body">
                    <!-- Search form-->
                    <section id="search-website" class="card overflow-hidden">
                        <div class="card-header">
                           
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                   
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-11">
                                        <fieldset class="form-group position-relative mb-0">
                                            <input type="text" class="form-control form-control-xl input-xl" v-model="texto"
                                                id="textoBusqueda" placeholder="Explore Stack ..." @keyup.enter="BuscarResultadoNuevamente" />
                                            <div class="form-control-position">
                                                <i ref="microfono" class="feather icon-mic font-medium-4" id="microfono"
                                                    @click.prevent="BuscarConAudio"></i>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-1">
                                        <button @click.prevent="BuscarResultadoNuevamente(0)" style="width: 100%" class="btn btn-primary btn-md">
                                            <i class="feather icon-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!--Search Navbar-->
                            <TipoBusqueda :tipo="'metafactos'"></TipoBusqueda>
                            <!--/ Search Navbar-->
                            <!--Search Result-->
                            <div id="search-results" class="card-body">
                                <p style="padding-left: 18px" class="text-muted font-small-3">Cerca de {{ numero_registros_imagenes }} resultados ({{ tiempoConsulta  }} segundos) </p>
                                <br>
                                <div class="row">
                                    <div class="col-12 col-md-12 contenedor_imagenes">
                                        <div v-for="(image, index) in images" :key="index" class="imagen_busqueda espacio">
                                            <img style="height: 80%; width: 100%;" @click.prevent="seleccionarImagen(image.datos.ruta, image.datos.tema)" :src="'/metafactos/'+image.datos.ruta" alt="Imagen" :ref="'imageRef' + index" />
                                            <p class="texto_metafacto">{{ image.datos.tema }}</p>
                                        </div>
                                        <div v-if="loading" class="loader" style="width: 100%;">
                                            <Skeleton></Skeleton>
                                        </div>
                                    </div>
                                    <div v-if="images.length == 0 && !loading" style="padding-left: 34px;">
                                        <p>No se han encontrado resultados para tu búsqueda <strong> ({{ texto }})</strong></p>
                                        <p>Sugerencias: </p>
                                        <ul>
                                            <li>Asegúrate de que todas las palabras estén escritas correctamente.</li>
                                            <li>Prueba diferentes palabras clave.</li>
                                            <li>Prueba palabras clave más generales.</li>
                                            <li>Prueba menos palabras clave.</li>
                                        </ul>
                                        <br>
                                        <img src="/img/no_results.gif" style="position: absolute; width: 465px; right: 15%; top: 39%;" alt="">
                                    </div>
                                    <hr>
                                    <div v-if="!mostrado_todo" class="col-12 text-center">
                                        <button @click.prevent="AumentarPaginaImagen" v-if="images.length > 0" class="btn btn-primary btn-md">Mostrar más...</button>
                                    </div>
                                    <div v-else class="col-12 text-center">
                                        <hr>
                                        <h3>Parece que llegaste al final...</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="modImagen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel15"
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
import * as busquedaService from "../services/busqueda";
import Skeleton from './skeleton/skeletonImagen';
import cheerio from 'cheerio';
import TipoBusqueda from './tipoBusqueda';
import 'vue-inner-image-zoom/lib/vue-inner-image-zoom.css';
import InnerImageZoom from 'vue-inner-image-zoom';
import headerColegio from './header/header'

export default {
    components: {
        Skeleton,
        TipoBusqueda,
        InnerImageZoom,
        headerColegio
    },
    data() {
        return {
            images: [],
            texto: '',
            tipo: '',
            loading: false, 
            pagina: 1,
            imagenSeleccionada: '',
            tituloImagen: '',
            tiempoConsulta : 0,
            numero_registros_imagenes: 0,
            mostrado_todo: false
        };
    },
    mounted() {
        this.texto = this.$route.params.texto;
        this.tipo = this.$route.params.tipo;

        this.verificarConexion();
        this.BuscarResultadoNuevamente(0); 
        document.title = 'Resultados - '+this.texto;
    },
    methods: {
        async BuscarResultadoNuevamente(mode) {
            if(mode == 0){
                this.images = [];
                this.pagina = 1;
                this.mostrado_todo = false;
            }
            const inicio = Date.now();
            this.$router.replace({ path: '/resultado-metafactos/' + this.texto + '/' + this.tipo + '/' + this.pagina});
            try {
                this.loading = true; 
                await busquedaService.busqueda(this.texto, this.tipo, this.pagina).then(respuesta => {
                    var array_images = respuesta.data; 

                    if(array_images.length == 0) {
                        this.mostrado_todo = true;
                    }

                    array_images.forEach(element => {
                        this.images.push(element);
                    });

                    this.numero_registros_imagenes = this.images.length;
                    const finalizacion = Date.now();
                    const tiempoTranscurrido = (finalizacion - inicio) / 1000;
                    this.tiempoConsulta = tiempoTranscurrido;
                });
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false; 
            }
        },
        async BuscarConAudio() {
            var elemento = this.$refs.microfono;
            elemento.style.color = "green";
            var recognition = new webkitSpeechRecognition();
            recognition.lang = "es-US";

            var self = this;

            recognition.onresult = function (event) {

                var resultadovoz = event.results[0][0].transcript;
                elemento.style.color = "#404e67";

                if (resultadovoz != "") {
                    self.texto = resultadovoz;
                    self.BuscarResultadoNuevamente(0);
                }

            }
            recognition.start();
        },
        async verificarConexion() {
            await busquedaService.verificarConexion().then(response => {
                if (response.data == 0) {
                    document.getElementById("microfono").style.display = "none";
                }
            });
        },
        async  AumentarPaginaImagen(){
            this.pagina +=1;
            this.loading = true; 
            this.BuscarResultadoNuevamente(1);
        },
        seleccionarImagen(rutaSeleccionada, tituloImagenS) {
            this.imagenSeleccionada = '/metafactos/'+rutaSeleccionada;
            this.tituloImagen = tituloImagenS;
            $("#modImagen").modal("show");
        },
        descargarImagen() {
            const link = document.createElement('a');
            link.href = this.imagenSeleccionada;
            link.download = this.temaImagen+".png";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
    },
};
</script>

<style>
.loader {
    text-align: center;
    margin: 20px 0;
}

#fondo_metafacto{
    background-image: url('/img/fondo_imagen.png') !important; 
    background-repeat: repeat;
}  

.pagina_resultado {
    max-width: 100%; 
    margin-top: 0.7rem !important;
    padding-top: 20px;
    padding-left: 5%;
    padding-right: 5%;
}


.texto_metafacto{
    width: 90%;
    overflow: hidden;
    font-size: 12px !important;
    margin-top: 7px;
    text-decoration: underline;
    font-weight: bold;
    color: #009c9f;
}

.espacio{
    margin-bottom: 30px;
}

.iiz__img{
    height: 650px !important;
}
</style>
