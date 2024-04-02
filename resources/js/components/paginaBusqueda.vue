<template lang="">
    <div id="fondo">
        <div class="app-content container center-layout mt-2" id="pagina_busqueda">
        <div class="content-overlay"></div>
        <div class="content-wrapper" style="padding: 0rem">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="row full-height-vh-with-nav">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <form id="form-data" style="width: 100%; top: -36px; position: relative;" class="d-flex align-items-center justify-content-center"
                            action="{{ route('busqueda') }}" method="GET">
                            <div class="col-lg-6 col-10">
                                <img class="mx-auto d-block pb-3 pt-4 width-65-per" id="img_logo_biblioped"
                                :src="`img/logo_1_2.png`" alt="Stack Search">
                                <fieldset class="form-group position-relative">
                                    <input id="speechToText" name="textoBusqueda" type="text"
                                        class="form-control form-control-lg input-lg round" 
                                        placeholder="Ingresa la palabra clave..." @keyup.enter="BuscarConTexto">
                                    <div class="form-control-position" style="right: 16px">
                                        <i ref="microfono" style="cursor: pointer" class="feather icon-mic font-medium-4" id="microfono"
                                        @click.prevent="BuscarConAudio"></i>
                                    </div>
                                </fieldset>
                                <div class="row py-2">
                                    <div class="col-12 text-center">
                                        <button type="submit" style="width: 208px; height: 44px; padding-top: 13px;"
                                        @click.prevent="BuscarConTexto" class="btn btn-primary btn-md"><i
                                                class="feather icon-search"></i> Buscar</button>
                                        <div class="btn-group mr-1" style="margin-left: 10px">
                                            <select id="tipoBusqueda" name="tipoBusqueda" style="width: 208px;    background-color: #fc4f00 !important;width: 208px;border-color: #fc4f00 !important;" class="btn btn-warning">
                                                <option class="text-left" value="contenido"><i class="feather icon-globe"></i> Buscar Contenido</option>
                                                <option class="text-left" value="imagenes"><i class="fa fa-file-image-o"></i> Buscar Imagenes</option>
                                                <option class="text-left" value="videos"><i class="feather icon-video"></i> Buscar Videos</option>
                                                <option class="text-left" value="metafactos"><i class="feather icon-video"></i> Buscar Mentefactos</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>
<script>
import * as busquedaService from "../services/busqueda";

export default {
    data() {
        return {
        text: '',
        correctedText: '',
        hunspell: null,
        };
    },
    mounted() {
        this.verificarConexion();
    },
    methods: {
        async BuscarConAudio() {
            var navigate = this.$router;
            var elemento = this.$refs.microfono;
            elemento.style.color = "green";
            var recognition = new webkitSpeechRecognition();
            recognition.lang = "es-US";
            
            recognition.onresult = function (event) {

                var resultadovoz = document.getElementById('speechToText').value = event.results[0][0].transcript;
                elemento.style.color = "#404e67";

                if (resultadovoz != "") {

                    var tipo = document.getElementById("tipoBusqueda").value;
                    var texto = document.getElementById("speechToText").value;
                    setTimeout(()=>{
                        if(tipo == "contenido"){
                            navigate.push({ name: 'ResultadoBusqueda', params: { texto: texto, tipo: tipo, pagina: 1 } })
                        }else{
                            if(tipo == "imagenes"){
                                navigate.push({ name: 'ResultadoImagenes', params: { texto: texto, tipo: tipo } })
                            }else{
                                if(tipo == "videos"){
                                    navigate.push({ name: 'ResultadoVideos', params: { texto: texto, tipo: tipo, pagina: 1} })
                                }else{
                                    navigate.push({ name: 'ResultadoMetafactos', params: { texto: texto, tipo: tipo, pagina: 1} })
                                }
                            }
                        }
                    }, 1000)
                    
                }

            }
            recognition.start();
        },
        async BuscarConTexto() {
            var navigate = this.$router;
            var tipo = document.getElementById("tipoBusqueda").value;
            var texto = document.getElementById("speechToText").value;
            
            await this.corregir(texto);
            if(texto != ""){
                if(tipo == "contenido"){
                    navigate.push({ name: 'ResultadoBusqueda', params: { texto: texto, tipo: tipo, pagina: 1 } })
                }else{
                    if(tipo == "imagenes"){
                        navigate.push({ name: 'ResultadoImagenes', params: { texto: texto, tipo: tipo } })
                    }else{
                        if(tipo == "videos"){
                            navigate.push({ name: 'ResultadoVideos', params: { texto: texto, tipo: tipo, pagina: 1} })
                        }else{
                            navigate.push({ name: 'ResultadoMetafactos', params: { texto: texto, tipo: tipo, pagina: 1} })
                        }
                    }
                }
            }else{
                toastr.warning("¡Debe escribir algo para buscar!");
            }
        },
        async verificarConexion() {
            await busquedaService.verificarConexion().then(response => { 
                if (response.data == 0) {
                    document.getElementById("microfono").style.display = "none";
                    return 0;
                }else{
                    return 1;
                }
            });
        },
        async corregir(texto){
           
        }
    }
}
</script>
<style>
    #fondo{
        background-image: url('/img/fondo_inicio.png') !important; 
        background-size: 100% 100%;
    }  

    #pagina_busqueda {
        max-width: 100%; 
        height: 90vh; 
        margin-top: 0.5rem !important;
        backdrop-filter: blur(4px);
    }

    .pt-4, .py-4 {
        padding-top: 4.5rem !important;
    }
    .pb-3, .py-3 {
        padding-bottom: 1rem !important;
    }

    #img_logo_biblioped {
        position: relative; 
        left: -2%;
        width: 740px !important;
    }

    @media (max-width: 1370px) {
        #img_logo_biblioped {
           width: 100% !important;
        }  
    }
</style>