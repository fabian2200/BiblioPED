<template lang="">
    <div>
        <div class="app-content content" style = "background-color: #f5f7fa; padding-top: 15px">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-12 mb-2">
                        <h3 class="content-header-title mb-0">Manuales de uso por tipo de usuario</h3>
                    </div>
                </div>
                <div class="content-body">
                    <!-- account setting page start -->
                    <section id="page-account-settings">
                        <div class="row">
                            <!-- left menu section -->
                            <div class="col-md-3 mb-2 mb-md-0">
                                <ul class="nav nav-pills flex-column mt-md-0 mt-1">
                                    <li class="nav-item">
                                        <a class="nav-link d-flex active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                                            <i class="fas fa-user-shield"></i>
                                            Manual de Administrador
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link d-flex" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
                                            <i class="fas fa-chalkboard-teacher"></i>
                                            Manual de Docente
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link d-flex" id="account-pill-password" data-toggle="pill" href="#account-vertical-password-2" aria-expanded="false">
                                            <i class="fas fa-user-alt"></i>
                                            Manual de Usuario
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- right content section -->
                            <div class="col-md-9" v-if="loading" style="background-color: #fff">
                                <Skeleton></Skeleton>
                            </div>
                            <div class="col-md-9" v-if="!loading">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                                                    <embed src="/manual/MANUAL USUARIO ADMINISTRADOR.pdf" type="application/pdf" id="pdfEmbed" class="pdf-embed" />
                                                </div>
                                                <div class="tab-pane fade " id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                                    <embed src="/manual/MANUAL USUARIO DOCENTE.pdf" type="application/pdf" id="pdfEmbed" class="pdf-embed" />
                                                </div>
                                                <div class="tab-pane fade " id="account-vertical-password-2" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                                    <embed src="/manual/MANUAL USUARIO.pdf" type="application/pdf" id="pdfEmbed" class="pdf-embed" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- account setting page end -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Skeleton from './skeleton/skeletonSmall.vue';

export default {
    components: {
        Skeleton
    },
    data() {
        return {
            
        };
    },
    mounted() {
        document.title = 'Manuales - BiblioPED';
    },
    methods: {
    }
}
</script>
<style lang="">
    
</style>