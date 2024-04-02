<template lang="">
    <div>
        <div class="content-center p-5" style="background-color: #f5f7fa">
            <div class="row">
                <div class="col-3">
                    <div class="content-overlay"></div>
                    <div class="content-wrapper">
                        <h1 class="text-left">Mis Apuntes</h1>
                        <hr>                        
                    </div>
                </div>
                <div class="col-9" id="html2PdfPrueba">
                    <div class="content-overlay"></div>
                    <div class="content-wrapper">
                        <div class="content-header row">
                        </div>
                        <div class="content-body">
                            <!-- email app overlay -->
                            <div class="app-content-overlay"></div>
                            <div class="email-app-area">
                                <!-- Email list Area -->
                                <div class="email-app-list-wrapper">
                                    <div class="email-app-list">
                                        <!-- email user list start -->
                                        <div class="email-user-list list-group" style="background-color: white;padding: 12px;border-radius: 20px;margin: 10px;box-shadow: 0px -1px 17px 0px #bfbcbf; margin-bottom: 40px">
                                            <h4 class="titulo_card">Lista de Apuntes</h4>
                                            <ul class="users-list-wrapper media-list">
                                                <div v-if="loading" style="height: 400px">
                                                    <Skeleton></Skeleton>
                                                </div>
                                                <li v-for="(item2, index2) in datos" :key="index2" class="media mail-read" style="border-bottom: 1px solid #dbdbdb;display: flex; align-items: center;">
                                                    <div class="pr-50">
                                                        <div class="avatar" style="height: 40px; width: 40px; border-radius: 0px">
                                                            <img style="border-radius: 0px" src="app-assets/images/portrait/small/apunte.png" alt="avtar img holder">
                                                        </div>
                                                    </div>
                                                    <div class="media-body" style="margin-left: 10px">
                                                        <div class="row">
                                                            <div class="col-11">
                                                                <div class="user-details">
                                                                    <div class="mail-items">
                                                                        <span class="list-group-item-text text-truncate"><strong><router-link style="color: #009c9f;" :to="'/'+item2.ruta">{{ item2.titulo }}</router-link></strong></span>
                                                                    </div>
                                                                </div>
                                                                <div class="mail-message">
                                                                    <p class="list-group-item-text truncate mb-0">
                                                                        <strong>Agregado el {{ item2.fecha }} a las {{ item2.horas }}</strong>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="user-action">
                                                        <div>
                                                            <div class="custom-control" style="display: flex; justify-content: center; align-items: center;">
                                                                <button data-toggle="tooltip" data-placement="top" title="Generar PDF" type="button" class="btn btn-outline-primary" @click="convertirHTMLtoPDF(item2)"><i class="fas fa-file-pdf"></i></button>
                                                                <a :href="'ver-apunte/'+item2.id_contenido+'/'+item2.tipo_contenido" data-toggle="tooltip" data-placement="top" title="Ver Apunte" type="button" class="btn btn-outline-success" style="margin-left: 10px"><i class="fas fa-eye"></i></a>
                                                                <button data-toggle="tooltip" data-placement="top" title="Eliminar Apunte" type="button" class="btn btn-outline-danger" @click="eliminarApunte(item2)" style="margin-left: 10px"><i class="fas fa-trash"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade text-left" id="modalPDF" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning white">
                        <h4 class="modal-title" id="myModalLabel17">{{ tituloModal }}</h4>
                    </div>
                    <div class="modal-body">
                        <embed :src="pdfUrl" type="application/pdf" id="pdfEmbed" class="pdf-embed" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn red btn-outline-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <loading v-model:active="isLoading"
            :can-cancel="true"
            :on-cancel="onCancel"
            :is-full-page="fullPage"
            :height="height"
            :width="width"
            :color="color"
            :loader="loader"
            opacity="0.8"
            :background-color="bgColor">
            <template #default v-if="useSlot">
                <div class="text-center">
                    <img src="/img/libro.gif" width="80" height="80" alt="">
                    <h2 style="color: #fc4f00">Generando PDF...</h2>
                </div>
            </template>
        </loading>
    </div>
</template>
<script>
import Skeleton from './skeleton/skeletonSmall.vue';
import * as usuarioService from "../services/usuario";
import Swal from 'sweetalert2';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';

export default {
    components: {
        Skeleton,
        Loading
    },
    data() {
        return {
            datos: {},
            loading: true,
            inputValue: "todo",
            pdfUrl: '',
            tituloModal: '',
            isLoading: false,
            fullPage: true,
            color: '#fc4f00',
            bgColor: '#ffffff',
            height: 100,
            width: 100,
            useSlot: true,
            loader: 'dots'
        };
    },
    mounted() {
        this.ListarApuntes();
        this.verificarLogin();
        document.title = 'Mis apuntes - BiblioPED';
    },
    methods: {
        convertirHTMLtoPDF(item){
            const $elementoParaConvertir = document.createElement("div");
            $elementoParaConvertir.innerHTML = item.data;
            var self = this;
            self.tituloModal = item.titulo;
            self.isLoading = true;
            html2pdf()
                .set({
                    margin: 0.4,
                    filename: item.titulo+'.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    pagebreak: { mode: ['avoid-all', 'css', 'legacy'] },
                    html2canvas: {
                        scale: 3,
                        letterRendering: true,
                    },
                    jsPDF: {
                        unit: "in",
                        format: "a4",
                        orientation: 'portrait'
                    }
                })
                .from($elementoParaConvertir)
                .outputPdf('blob')
                .then(function(pdfData) {
                    var pdfDataUrl = URL.createObjectURL(pdfData);
                    $('#modalPDF').modal('show');
                    setTimeout(function() {
                        var embedElement = document.getElementById('pdfEmbed');
                        embedElement.setAttribute('title', self.tituloModal+".pdf");
                        self.pdfUrl = pdfDataUrl;
                        self.isLoading = false;
                    }, 500);
                })
                .catch(err => console.log(err)
            );
        },
        async verificarLogin(){
            var navigate = this.$router;
            await usuarioService.verificarLogin().then(respuesta => {
                if(respuesta.data == 0){
                    navigate.push({ name: 'paginaBusqueda'})
                }
            });
        },
        ListarApuntes: async function () {
            this.loading = true;
            this.datos = [];
            try {
                await usuarioService.listarApuntes().then(respuesta => {
                    this.datos = respuesta.data;
                    this.loading = false;
                });
            } catch (error) {
                console.log(error);
            }
        },
        async eliminarApunte(id){
            Swal.fire({
                title: '¿Estas seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, borrar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.eliminarOKA(id._id.$oid);
                }
            })
            
        },
        async eliminarOKA(id){
            await usuarioService.eliminarApunte(id).then(respuesta => {
                this.ListarApuntes();
            });
        },
        async exportarApuntesPDF(item){
            this.isLoading = true;
            this.tituloModal = item.titulo;
            var data = {
                titulo: item.titulo,
                id: item._id.$oid
            }

            await usuarioService.exportarApuntesPDF(data).then(respuesta => {        
                this.pdfUrl = "";
                $("#modalPDF").modal('show');
                setTimeout(() => {
                    this.pdfUrl = "/pdfgenerados/"+respuesta.data;
                }, 1000)
                this.isLoading = false;
            });
        },
        closeModal() {
            this.pdfUrl = '';
        },
    }
}
</script>
<style>
    .pdf-embed {
        width: 100%;
        height: 80vh;
    }    

    .titulo_card {
        margin: 20px;
        padding-bottom: 16px;
        border-bottom: 2px solid rgb(219, 217, 217);
        color: rgb(0, 156, 159);
        font-weight: bold;
    }
</style>