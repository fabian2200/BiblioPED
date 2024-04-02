<template lang="">
    <div>
        <div v-if="loading" style="width: 100%; position: fixed; z-index: 1000; top: 0px; height: 100%">
            <SkeletonTabla :mensaje="'Guardando el contenido...'"></SkeletonTabla>
        </div>
        <div style="padding-left: 80px; padding-right: 80px" class="app-content content">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-12 mb-2">
                        <h3 class="content-header-title mb-0">
                            Registro de contenido
                        </h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="/">Inicio</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="/registro-contenido"
                                            >Registro de contenido</a
                                        >
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body">
                    <!-- Form wizard with icon tabs section start -->
                    <section id="icon-tabs">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title"></h4>
                                        <a class="heading-elements-toggle"
                                            ><i
                                                class="fa fa-ellipsis-h font-medium-3"
                                            ></i
                                        ></a>
                                        <div class="heading-elements">
                                            <ul class="list-inline mb-0">
                                                <li>
                                                    <a @click="goBack"
                                                        ><i
                                                            class="fas fa-arrow-left"
                                                        ></i
                                                    ></a>
                                                </li>
                                                <li>
                                                    <a data-action="expand"
                                                        ><i
                                                            class="fas fa-compress"
                                                        ></i
                                                    ></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body" style="padding-bottom: 40px">
                                            <div class="container-fluid">
                                                <div class="row justify-content-center">
                                                    <div class="col-12">
                                                        <div>
                                                            <h2 id="heading">Siga los pasos para registrar un nuevo contenido</h2>
                                                            <p>Todos los campos son obloigatorios</p>
                                                            <form id="msform">
                                                                <ul id="progressbar">
                                                                    <li class="active" id="account"><strong>Tipo  contenido</strong></li>
                                                                    <li id="personal"><strong>Asignatura</strong></li>
                                                                    <li id="payment"><strong>Grado</strong></li>
                                                                    <li id="confirm"><strong>Contenido</strong></li>
                                                                </ul>
                                                                <br> <!-- fieldsets -->
                                                                <fieldset>
                                                                    <div class="form-card">
                                                                        <div class="row">
                                                                            <div class="col-7">
                                                                                <h2 class="fs-title">Donde desea subir el contenido</h2>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <h2 class="steps">Paso 1 - 4</h2>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="row">
                                                                            <div class="col-lg-4">
                                                                                <div id="r01" class="card_radio" @click="select_radio_0('r01', 'card01')">
                                                                                    <input class="radio_b" value="asignatura"  type="radio" name="tipo_subida" id="card01">
                                                                                    <label for="card01">
                                                                                        <img src="/img/asignatura.png" width="170" height="120" alt="">
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4">
                                                                                <div id="r02" class="card_radio" @click="select_radio_0('r02', 'card02')">
                                                                                    <input class="radio_b" value="modulo transversal"  type="radio" name="tipo_subida" id="card02">
                                                                                    <label for="card02">
                                                                                        <img src="/img/modulo.png" width="170" height="120" alt="">
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4">
                                                                                <div id="r03" class="card_radio" @click="select_radio_0('r03', 'card03')">
                                                                                    <input class="radio_b" value="modulo e"  type="radio" name="tipo_subida" id="card03">
                                                                                    <label for="card03">
                                                                                        <img src="/img/modulo_e.png" width="170" height="120" alt="">
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <br>
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <h2 class="fs-title">Tipo de contenido</h2>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-4">
                                                                                <div id="r1" class="card_radio" @click="select_radio_1('r1', 'card1')">
                                                                                    <input class="radio_b" value="normal" type="radio" name="tipo_contenido" id="card1">
                                                                                    <label for="card1">
                                                                                        <img src="/img/contenido_icon.png" width="170" height="120" alt="">
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4">
                                                                                <div id="r2" class="card_radio" @click="select_radio_1('r2', 'card2')">
                                                                                    <input class="radio_b" value="video" type="radio" name="tipo_contenido" id="card2">
                                                                                    <label for="card2">
                                                                                        <img src="/img/video_icon.png" width="170" height="120" alt="">
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-4">
                                                                                <div id="r3" class="card_radio" @click="select_radio_1('r3', 'card3')">
                                                                                    <input class="radio_b" value="metafacto" type="radio" name="tipo_contenido" id="card3">
                                                                                    <label for="card3">
                                                                                        <img src="/img/imagen_icon.png" width="170" height="120" alt="">
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div> 
                                                                    </div> 
                                                                    <br>
                                                                    <button  name="next" type="button" class="next_btn btn btn-primary mr-sm-1 mb-1 mb-sm-0">Siguiente <i class="fas fa-arrow-right"></i></button>
                                                                </fieldset>
                                                                <fieldset>
                                                                    <div class="form-card">
                                                                        <div class="row">
                                                                            <div class="col-7">
                                                                                <h2 class="fs-title">Asignatura a la cual cargara el contenido:</h2>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <h2 class="steps">Paso 2 - 4</h2>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-3" v-for="(item, index) in asignaturas_filtradas" :key="index" style="margin-bottom: 20px">
                                                                                <div  :id="'ra'+index" class="card_radio" @click="select_radio_2('ra'+index, 'carda'+index)">
                                                                                    <input class="radio_b" :value="item.nombre" type="radio" name="asignatura" :id="'carda'+index">
                                                                                    <label :for="'carda'+index">
                                                                                        <img :src="'/img/asignaturas/'+item.imagen" width="170" height="115" alt="">
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div> 
                                                                    </div>
                                                                    <button  name="previous" type="button" class="previous_btn btn btn-secondary mr-sm-1 mb-1 mb-sm-0"><i class="fas fa-arrow-left"></i> Anterior</button>
                                                                    <button  name="next" type="button" class="next_btn btn btn-primary mr-sm-1 mb-1 mb-sm-0">Siguiente <i class="fas fa-arrow-right"></i></button>
                                                                </fieldset>
                                                                <fieldset>
                                                                    <div class="form-card">
                                                                        <div class="row">
                                                                            <div class="col-7">
                                                                                <h2 class="fs-title">Grado para el cual va dirigido el contenido:</h2>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <h2 class="steps">Paso 3 - 4</h2>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="row" v-if="tipo_subida != 'modulo e'">
                                                                            <div class="col-lg-3" v-for="(item, index) in grados" :key="index" style="margin-bottom: 20px">
                                                                                <div  :id="'rg'+item" :class="grado == item ? 'card_radio_active' : 'card_radio'" @click="select_radio_3('rg'+item, 'cardg'+item)">
                                                                                    <input class="radio_b" :value="item" v-model="grado" type="radio" name="grado" :id="'cardg'+item">
                                                                                    <label :for="'cardg'+item">
                                                                                        <img :src="'/img/grados/'+item+'.png'" :width="item < 10 ? '120' : '200'" height="100" alt="">
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="row" v-if="tipo_subida == 'modulo e'">
                                                                            <div class="col-lg-3" v-for="(item, index) in grados_modulo_e" :key="index" style="margin-bottom: 20px">
                                                                                <div  :id="'rg'+item" :class="grado == item ? 'card_radio_active' : 'card_radio'" @click="select_radio_3('rg'+item, 'cardg'+item)">
                                                                                    <input class="radio_b" :value="item" v-model="grado" type="radio" name="grado" :id="'cardg'+item">
                                                                                    <label :for="'cardg'+item">
                                                                                        <img :src="'/img/grados/'+item+'.png'" :width="item < 10 ? '120' : '200'" height="100" alt="">
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div> 
                                                                    </div> 
                                                                    <button  name="previous" type="button" class="previous_btn btn btn-secondary mr-sm-1 mb-1 mb-sm-0"><i class="fas fa-arrow-left"></i> Anterior</button>
                                                                    <button  name="next" type="button" class="next_btn btn btn-primary mr-sm-1 mb-1 mb-sm-0">Siguiente <i class="fas fa-arrow-right"></i></button>
                                                                </fieldset>
                                                                <fieldset>
                                                                    <div class="form-card">
                                                                        <div class="row">
                                                                            <div class="col-7">
                                                                                <h2 class="fs-title" >Ingrese el título del tema</h2>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <h2 class="steps">Paso 4 - 4</h2>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <input type="text" class="form-control" v-model="tema">
                                                                            </div>    
                                                                        </div>

                                                                        <div class="row" style="margin-top: 30px">
                                                                            <div class="col-12">
                                                                                <h2 class="fs-title" v-if="tipo_contenido=='normal'">Ingrese el enunciado</h2>
                                                                                <h2 class="fs-title" v-if="tipo_contenido=='metafacto'">Seleccione la imagen que desea cargar</h2>
                                                                                <h2 class="fs-title" v-if="tipo_contenido=='video'">Seleccione el video que desea cargar</h2>
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div v-if="tipo_contenido=='normal' || tipo_contenido=='video'">
                                                                            <QuillEditor  style="height: 300px;" theme="snow" toolbar="full" />
                                                                            <br>
                                                                            <br>
                                                                        </div>
                                                                        <div v-if="tipo_contenido=='metafacto'">
                                                                            <form style="display: flex; align-items: center; justify-content: center;" @click="openFileInput" action="#" class="dropzone dropzone-area" id="dpz-single-file">
                                                                                <input type="file" accept="image/*" ref="fileInput" style="display: none" @change="handleFileChange" />
                                                                                <div v-if="!selectedImage" style="display: flex; align-items: center; justify-content: center; flex-direction: column; width: 70%; height: 400px; text-align: center">
                                                                                    <img src="/img/upload_icon.png" width="150" height="135" alt="">
                                                                                    <h3><strong>Cargar Imagen</strong></h3>
                                                                                </div>
                                                                                <div v-if="selectedImage" style="display: flex; align-items: center; justify-content: center; width: 70%; height: 400px; text-align: center">
                                                                                    <img style="width: 80%; max-height: 100%;" :src="selectedImage" alt="Imagen cargada" />
                                                                                    <div class="btn_eliminar"><i @click="eliminarImagen" style="color: white" class="fas fa-trash fa-3x"></i></div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div v-if="tipo_contenido=='video'">
                                                                            <form style="display: flex; align-items: center; justify-content: center;" @click="openFileInputVideo" action="#" class="dropzone dropzone-area" id="dpz-single-file">
                                                                                <input accept="video/*" type="file" ref="fileInputVideo" style="display: none" @change="handleFileChangeVideo" />
                                                                                <div v-if="!selectedVideo" style="display: flex; align-items: center; justify-content: center; flex-direction: column; width: 70%; height: 400px; text-align: center">
                                                                                    <img src="/img/upload_icon2.png" width="150" height="135" alt="">
                                                                                    <h3><strong>Cargar Video</strong></h3>
                                                                                </div>
                                                                                <div v-if="selectedVideo" style="display: flex; align-items: center; justify-content: center; width: 70%; height: 400px; text-align: center">
                                                                                    <video style="width: 71%; height: 90%;" controls>
                                                                                        <source :src="selectedVideo" type="video/mp4" />
                                                                                        Tu navegador no admite la reproducción de video.
                                                                                    </video>
                                                                                    <div class="btn_eliminar"><i @click="eliminarVideo" style="color: white" class="fas fa-trash fa-3x"></i></div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <button  name="previous" type="button" class="previous_btn btn btn-secondary mr-sm-1 mb-1 mb-sm-0"><i class="fas fa-arrow-left"></i> Anterior</button>
                                                                    <button  name="next" @click.prevent="guardarDatosContenido" type="button" class="save btn btn-primary mr-sm-1 mb-1 mb-sm-0">Guardar <i class="fas fa-save"></i></button>
                                                                </fieldset>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import * as adminService from "../../services/admin";
import SkeletonTabla from '../skeleton/skeletonTabla.vue';

export default {
    components: {
        QuillEditor,
        SkeletonTabla
    },
    data(){
        return {
            grados: [1,2,3,4,5,6,7,8,9,10,11],
            grados_modulo_e: [3,5,7,9,11],
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
                    nombre: 'EDUCACIÓN AMBIENTAL',
                    imagen: 'educacion_ambiental.png'
                },
                {
                    nombre: 'CÁTEDRA DE LA PAZ',
                    imagen: 'catedra_paz.png'
                },
                {
                    nombre: 'EDUCACIÓN SEXUAL',
                    imagen: 'educacion_sexual.png'
                },
                {
                    nombre: 'QUÍMICA',
                    imagen: 'quimica.png'
                },
                {
                    nombre: 'BIOLOGÍA',
                    imagen: 'biologia.png'
                },
                {
                    nombre: 'INGLÉS',
                    imagen: 'ingles.png'
                },
                {
                    nombre: 'CONSTITUCIÓN POLÍTICA',
                    imagen: 'constitucion_politica.png'
                },
                {
                    nombre: 'SOCIALES',
                    imagen: 'sociales.png'
                },
                {
                    nombre: 'FILOSOFIA',
                    imagen: 'filosofia.png'
                },
                {
                    nombre: 'FÍSICA',
                    imagen: 'fisica.png'
                }
            ],
            modulos: [
                {
                    nombre: 'URBANIDAD, ÉTICA Y VALORES',
                    imagen: 'etica.png'
                },
                {
                    nombre: 'TECNOLOGÍA E INFORMÁTICA',
                    imagen: 'informatica.png'
                },
                {
                    nombre: 'RELIGION',
                    imagen: 'religion.png'
                },
                {
                    nombre: 'EMPRENDIMIENTO',
                    imagen: 'emprendimiento.png'
                }
            ],
            modulos_e: [
                { 
                    nombre:"CIENCIAS NATURALES",
                    imagen: 'cuencias_naturalez_me.png'
                },
                { 
                    nombre:"Competencia Ciudadana",
                    imagen: 'competencia_ciudadana_me.png'
                },  
                { 
                    nombre:"INGLÉS",
                    imagen: 'ingles_me.png'
                },
                { 
                    nombre:"LECTURA CRÍTICA",
                    imagen: 'lectura_critica_me.png'
                },
                { 
                    nombre:"LENGUAJE",
                    imagen: 'lenguaje_me.png'
                },
                { 
                    nombre:"MATEMATICAS",
                    imagen: 'matematicas_me.png'
                },
                { 
                    nombre:"COMPETENCIAS CIUDADANAS",
                    imagen: 'competencia_ciudadana_me.png'
                },
            ],
            selectedImage: null,
            selectedVideo: null,
            asignaturas_filtradas: [],
            tipo_subida: '',
            tipo_contenido: '',
            asignatura: '',
            grado: '',
            tema: '',
            imageFile: null,
            videoFile: null,
            loading: false
        }
    },  
    mounted() {
        $(document).ready(function(){

            var current_fs, next_fs, previous_fs;
            var opacity;
            var paso_actual = 0;
        

            $(".next_btn").click(function(){
                paso_actual++;
                current_fs = $(this).parent();
                next_fs = $(this).parent().next();

                var li = $("#progressbar li").eq($("fieldset").index(next_fs));
                li.prevObject[paso_actual].classList.add("active");

                next_fs.show();
                current_fs.animate({opacity: 0}, {
                    step: function(now) {
                        opacity = 1 - now;
                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        next_fs.css({'opacity': opacity});
                    },
                    duration: 500
                });
            });

            $(".previous_btn").click(function(){
                current_fs = $(this).parent();
                previous_fs = $(this).parent().prev();

                var li = $("#progressbar li").eq($("fieldset").index(next_fs));
                li.prevObject[paso_actual].classList.remove("active");
                
                paso_actual--;

                previous_fs.show();

                current_fs.animate({opacity: 0}, {
                step: function(now) {
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({'opacity': opacity});
                },
                    duration: 500
                });
            });

            $(".submit").click(function(){
                return false;
            })

        });

        document.title = 'Registrar contenido - BiblioPED';
    },
    created() {
        document.title = "Registrar - Contenido";
    },
    methods: {
        goBack() {
            this.$router.go(-1);
        },
        select_radio_0(id, rb){
           document.querySelector('#card01').checked = false;
           document.querySelector('#card02').checked = false;
           document.querySelector('#card03').checked = false;

           document.querySelector('#'+rb).checked = true;

            for (let index = 1; index <= 3; index++) {
                let id_l = "r0"+index;
                if(id == id_l){
                    document.getElementById(id_l).classList.remove("card_radio");    
                    document.getElementById(id_l).classList.add("card_radio_active");
                }else{
                    document.getElementById(id_l).classList.add("card_radio");    
                    document.getElementById(id_l).classList.remove("card_radio_active");
                }
            }  
            
            this.tipo_subida = $("input[name='tipo_subida']:checked").val();
            
            if(this.tipo_subida == "asignatura"){
                this.asignaturas_filtradas = this.asignaturas;
            }else{
                if(this.tipo_subida == "modulo transversal"){
                    this.asignaturas_filtradas = this.modulos;
                }else{
                    this.asignaturas_filtradas = this.modulos_e;
                    this.select_radio_1('r3', 'card3');
                }
            }

            if(this.tipo_subida == "modulo e"){
                document.getElementById("r3").classList.remove("disabled_div");
                for (let index = 1; index < 3; index++) {
                    let id_l = "r"+index;
                    document.getElementById(id_l).classList.add("disabled_div");
                }
            } else{
                document.getElementById("r3").classList.add("disabled_div");
                document.querySelector('#card3').checked = false;
                document.getElementById("r3").classList.add("card_radio");    
                document.getElementById("r3").classList.remove("card_radio_active");
                for (let index = 1; index < 3; index++) {
                    let id_l = "r"+index;
                    document.getElementById(id_l).classList.remove("disabled_div");
                }
            }
        },
        select_radio_1(id, rb){
            document.querySelector('#card1').checked = false;
            document.querySelector('#card2').checked = false;
            document.querySelector('#card3').checked = false;

            document.querySelector('#'+rb).checked = true;

           for (let index = 1; index < 4; index++) {
               let id_l = "r"+index;
               if(id == id_l){
                   document.getElementById(id_l).classList.remove("card_radio");    
                   document.getElementById(id_l).classList.add("card_radio_active");
               }else{
                   document.getElementById(id_l).classList.add("card_radio");    
                   document.getElementById(id_l).classList.remove("card_radio_active");
               }
           }   

           this.tipo_contenido = $("input[name='tipo_contenido']:checked").val();
        },
        select_radio_2(id, rb){
            for (let index = 0; index < this.asignaturas_filtradas.length; index++) {
                document.querySelector('#carda'+index).checked = false;
            }
        
            document.querySelector('#'+rb).checked = true;

            for (let index = 0; index < this.asignaturas_filtradas.length; index++) {
                let id_l = "ra"+index;
                if(id == id_l){
                    document.getElementById(id_l).classList.remove("card_radio");    
                    document.getElementById(id_l).classList.add("card_radio_active");
                }else{
                    document.getElementById(id_l).classList.add("card_radio");    
                    document.getElementById(id_l).classList.remove("card_radio_active");
                }
            }   

            this.asignatura = $("input[name='asignatura']:checked").val();
        },
        select_radio_3(id, rb){
            for (let index = 1; index <= 11; index++) {
                document.querySelector('#cardg'+index).checked = false;
            }
        
            document.querySelector('#'+rb).checked = true;

            for (let index = 1; index <= 11; index++) {
                let id_l = "rg"+index;
                if(id == id_l){
                    document.getElementById(id_l).classList.remove("card_radio");    
                    document.getElementById(id_l).classList.add("card_radio_active");
                }else{
                    document.getElementById(id_l).classList.add("card_radio");    
                    document.getElementById(id_l).classList.remove("card_radio_active");
                }
            }   

            this.grado = $("input[name='grado']:checked").val();
        },
        openFileInput() {
            this.$refs.fileInput.click();
        },
        handleFileChange(event) {
            const file = event.target.files[0];
            this.imageFile = event.target.files[0];
            if (file) {
                this.selectedImage = URL.createObjectURL(file);
            }
        },
        eliminarImagen(){
            this.selectedImage = null;
        },
        openFileInputVideo() {
            this.$refs.fileInputVideo.click();
        },
        handleFileChangeVideo(event) {
            const file = event.target.files[0];
            this.videoFile = event.target.files[0];
            if (file) {
                this.selectedVideo = URL.createObjectURL(file);
            }
        },
        eliminarVideo(){
            this.selectedVideo = null;
        },
        async guardarDatosContenido() {
            var navigate = this.$router;
            const formData = new FormData();
            formData.append('tipo_subida', this.tipo_subida);
            formData.append('tipo_contenido', this.tipo_contenido);
            formData.append('asignatura', this.asignatura);
            formData.append('grado', this.grado);
            formData.append('tema', this.tema);

            switch (this.tipo_contenido) {
                case "normal":
                    formData.append('contenido', document.querySelector(".ql-editor").innerHTML);
                    break;
                case "metafacto":
                    formData.append('multimedia', this.imageFile);
                    break;
                case "video":+
                    formData.append('contenido', document.querySelector(".ql-editor").innerHTML);
                    formData.append('multimedia', this.videoFile);
                    break;
            }

            if(this.tipo_contenido != "" && this.tipo_subida != "" && this.grado != "" && this.tema != "" && this.asignatura != ""){
                var bandera = false;
                if(this.tipo_contenido == "normal" && document.querySelector(".ql-editor").innerHTML == ""){
                    bandera = true;
                }

                if(this.tipo_contenido == "metafacto" && this.imageFile == null){
                    bandera = true;
                }

                if(this.tipo_contenido == "video" && this.videoFile == null){
                    bandera = true;
                }
                
                if(!bandera){
                    this.loading = true;
                    try {
                        const response = await adminService.guardarDatosContenido(formData);
                        const respuesta_ok = response.data;
                        if (respuesta_ok.estado === 1) {
                            toastr.success(respuesta_ok.mensaje);
                        } else {
                            toastr.error(respuesta_ok.mensaje);
                        }

                        this.loading = false;
                        setTimeout(() => {
                            navigate.push({ name: 'listaContenido' })
                        }, 1000)
                    } catch (error) {
                        toastr.error('Error al guardar los datos'+ error);
                        this.loading = false;
                    }
                }else{
                    toastr.error('¡Debe llenar todos los campos del paso 4!');
                }
            }else{
                toastr.error('¡Todos los campos son obligatorios!');
            }
        }
    },
    beforeUnmount() {
        if (this.selectedVideo) {
        URL.revokeObjectURL(this.selectedVideo);
        }
    },
};
</script>
<style>
    .btn_eliminar {
        padding: 20px;
        background-color: #ff0000c7;
        border-radius: 50%;
        position: absolute;
        border: 4px solid #fff;
        cursor: pointer;
        z-index: 3;
    }

    .btn_eliminar:hover {
        background-color: #e40f0ff6;
    }

    #dpz-single-file {
        cursor: pointer;
        z-index: 1;
    }

    #heading {
        text-transform: uppercase;
        color: #0A1B26;
        font-weight: 500;
    }

    #msform {
        text-align: center;
        position: relative;
        margin-top: 20px;
    }

    #msform fieldset {
        background: white;
        border: 0 none;
        border-radius: 0.5rem;
        box-sizing: border-box;
        width: 100%;
        margin: 0;
        padding-bottom: 20px;
        position: relative;
    }

    .form-card {
        text-align: left;
    }

    #msform fieldset:not(:first-of-type) {
        display: none;
    }


    .next_btn {
        position: absolute;
        right: 0;
        bottom: 5;
        width: 130px;
    }

    .save {
        position: absolute;
        right: 0;
        bottom: 5;
        width: 130px;
    }

    .previous_btn {
        position: absolute;
        right: 155px;
        bottom: 5;
        width: 130px;
    }

    .card {
        z-index: 0;
        border: none;
        position: relative;
    }

    .fs-title {
        font-size: 25px;
        color: #0A1B26;
        margin-bottom: 15px;
        font-weight: 500;
        text-align: left;
    }

    .purple-text {
        color: #038C8C;
        font-weight: normal;
    }

    .steps {
        font-size: 25px;
        color: gray;
        margin-bottom: 10px;
        font-weight: normal;
        text-align: right;
    }

    .fieldlabels {
        color: gray;
        text-align: left;
    }

    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        color: lightgrey;
    }

    #progressbar .active {
        color: #F24405;
    }

    #progressbar li {
        list-style-type: none;
        font-size: 15px;
        width: 25%;
        float: left;
        position: relative;
        font-weight: 400;
    }

    #progressbar #account:before {
        font-family: FontAwesome;
        content: "\f1c8";
    }

    #progressbar #personal:before {
        font-family: FontAwesome;
        content: "\f02d";
    }

    #progressbar #payment:before {
        font-family: FontAwesome;
        content: "\f19d";
    }

    #progressbar #confirm:before {
        font-family: FontAwesome;
        content: "\f044";
    }

    #progressbar li:before {
        width: 50px;
        height: 50px;
        line-height: 45px;
        display: block;
        font-size: 20px;
        color: #ffffff;
        background: lightgray;
        border-radius: 50%;
        margin: 0 auto 10px auto;
        padding: 2px;
    }

    #progressbar li:after {
        content: "";
        width: 100%;
        height: 2px;
        background: lightgray;
        position: absolute;
        left: 0;
        top: 25px;
        z-index: -1;
    }

    #progressbar li.active:before,
    #progressbar li.active:after {
        background: #F24405;
    }

    .progress {
        height: 20px;
    }

    .progress-bar {
        background-color: #F24405;
    }

    .fit-image {
        width: 100%;
        object-fit: cover;
    }

    .card_radio{
        border: 4px solid rgb(209, 209, 209) !important;
        padding: 20px;
        width: 100%;
        cursor: pointer;
        border-radius: 30px;
    }

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
        right: 63px;
        bottom: 37px;
        scale: 3;
    } 

    .card_radio_active label{
        cursor: pointer;
        color: #ffff;
    } 

    .card_radio input{
        position: absolute;
        right: 63px;
        bottom: 37px;
        scale: 3;
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
</style>
