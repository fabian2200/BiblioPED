<template>
    <div id="fondo_imagen">
        <div class="app-content container center-layout mt-2 pagina_resultado">
            <div class="content-overlay"></div>
            <div class="content-wrapper" style="padding: 0.8rem">
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-12 mb-2">
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
                                        <button @click.prevent="BuscarResultadoNuevamente" style="width: 100%" class="btn btn-primary btn-md">
                                            <i class="feather icon-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!--Search Navbar-->
                            <TipoBusqueda :tipo="'imagenes'"></TipoBusqueda>
                            <!--/ Search Navbar-->
                            <!--Search Result-->
                            <div id="search-results" class="card-body">
                                <h4 style="padding-left: 18px; text-decoration: underline; font-style: italic;" v-if="corregidoTexto">Quizás querías decir: <strong>{{ texto }}</strong></h4>
                                <p style="padding-left: 18px" class="text-muted font-small-3">Cerca de {{ numero_registros_imagenes }} resultados ({{ tiempoConsulta  }} segundos) </p>
                                <br>
                                <div class="row">
                                    <div class="col-12 col-md-12 contenedor_imagenes">
                                        <div v-for="(image, index) in images" :key="index" class="imagen_busqueda">
                                            <img style="height: 80%; width: 100%;" @click.prevent="seleccionarImagen(image.src, image.titulo)" :src="image.src" alt="Imagen" :ref="'imageRef' + index" />
                                            <p class="texto_imagen"><router-link :to="image.ruta">{{ image.titulo }}</router-link> </p>
                                        </div>
                                        <div v-if="loading" class="loader" style="width: 100%;">
                                            <Skeleton></Skeleton>
                                        </div>
                                    </div>
                                    <div v-if="images.length == 0 && consultadoPrimeraVez == true" style="padding-left: 20px;">
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
                                    <div class="col-12 text-center">
                                        <button @click.prevent="AumentarPaginaImagen" v-if="images.length > 0" class="btn btn-primary btn-md">Mostrar más...</button>
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
            <div class="modal-dialog  modal-lg" role="document" style="margin-top: 9%;">
                <div class="modal-content">
                    <div class="modal-header bg-success white">
                        <h4 class="modal-title" style="text-transform: capitalize;"><span>{{ tituloImagen }}</span></h4>
                    </div>
                    <div class="modal-body">
                        <div id='ListEval' style="height: 400px; overflow: auto;text-align: center;display: flex;justify-content: center;align-items: center;">
                            <img style="height: 85%;" :src="imagenSeleccionada" alt="">
                        </div>
                        
                        <button @click.prevent="descargarImagen"  type="button" class="btn btn-success"><i class="fas fa-cloud-download-alt"></i> Descargar</button>
                        <button style="margin-left: 20px;" type="button" id="btn_salir" class="btn btn-danger" data-dismiss="modal"><i class="ft-corner-up-left position-right"></i><i class="fas fa-times"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import * as busquedaService from "../services/busqueda";
import Skeleton from './skeleton/skeletonImagen.vue';
import cheerio from 'cheerio';
import TipoBusqueda from './tipoBusqueda';
import headerColegio from './header/header';

export default {
    components: {
        Skeleton,
        TipoBusqueda,
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
            corregidoTexto: false,
            consultadoPrimeraVez: false
        };
    },
    mounted() {
        this.texto = this.$route.params.texto;
        this.tipo = this.$route.params.tipo;
        this.verificarConexion();
        this.BuscarResultadoNuevamente();
    },
    methods: {
        async BuscarResultadoNuevamente() {
            this.loading = true; 
            const inicio = Date.now();
            this.images = [];
            this.consultadoPrimeraVez = false;
            this.$router.replace({ path: '/resultado-imagenes/' + this.texto + '/' + this.tipo  });
            try {
                await busquedaService.corregirCadena(this.texto).then(respuesta => {
                    this.texto = respuesta.data.cadena;
                    document.title = 'Resultados - '+this.texto;
                    this.corregidoTexto = respuesta.data.corregido;
                    busquedaService.busqueda(this.texto, this.tipo, this.pagina).then(respuesta => {
                        var html_array = respuesta.data;
                        this.obtenerImagenesDesdeHTML(html_array);
                        const finalizacion = Date.now();
                        const tiempoTranscurrido = (finalizacion - inicio) / 1000;
                    
                        this.tiempoConsulta = tiempoTranscurrido;
                        if (html_array.length == 0) {
                            this.consultadoPrimeraVez = true;
                        }
                    });
                });
            } catch (error) {
                console.error(error);
                this.loading = false; 
            }
        },
        async obtenerImagenesDesdeHTML(html_array) {
            html_array.forEach(elemento => {
                const $ = cheerio.load(elemento.datos.cont_documento);
                $('img').each((index, element) => {
                    const src = $(element).attr('src');
                    if (src) {
                        this.images.push({
                            src: src,
                            titulo: elemento.datos.titulo,
                            ruta: '/contenido/' + elemento.datos.id_contenido + '/' + elemento.datos.tipo_contenido
                        });
                    }
                });
            });
            this.numero_registros_imagenes = this.images.length;
            this.loading = false; 
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
                    self.BuscarResultadoNuevamente();
                }

            }
            recognition.start();
        },
        async verificarConexion() {
            await busquedaService.verificarConexion().then(response => {
                if (response.data == 0) {
                    document.getElementById("microfono").style.display = "none";
                }
                console.log(response);
            });
        },
        async  AumentarPaginaImagen(){
            this.pagina +=1;
            this.loading = true; 
            await busquedaService.corregirCadena(this.texto).then(respuesta => {
                this.texto = respuesta.data.cadena;
                this.corregidoTexto = respuesta.data.corregido;
                busquedaService.busqueda(this.texto, this.tipo, this.pagina).then(respuesta => {
                    var html_array = respuesta.data;
                    this.obtenerImagenesDesdeHTML(html_array);
                    this.loading = false;
                });
            });
        },
        seleccionarImagen(rutaSeleccionada, tituloImagenS) {
            this.imagenSeleccionada = rutaSeleccionada;
            this.tituloImagen = tituloImagenS;
            $("#modImagen").modal("show");
        },
        descargarImagen() {
            const link = document.createElement('a');
            link.href = this.imagenSeleccionada;
            link.download = this.tituloImagen+".png";
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

#fondo_imagen{
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

</style>
