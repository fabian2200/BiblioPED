<template lang="">
    <div>
        <div class="app-content content" style = "background-color: #f5f7fa; padding-top: 40px">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-12 mb-2">
                        <h3 class="content-header-title mb-0">CONFIGURACIÓN DE CUENTA</h3>
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
                                            <i class="feather icon-globe"></i>
                                            General
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link d-flex" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
                                            <i class="feather icon-lock"></i>
                                            Cambiar la contraseña
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- right content section -->
                            <div class="col-md-9" v-if="loading" style="background-color: #fff">
                                <Skeleton></Skeleton>
                            </div>
                            <div class="col-md-9" v-if="!loading">
                                <div class="card" v-if="datos.tipo_registro == 'estudiante'">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                                                    <div class="media">
                                                        <a href="javascript: void(0);">
                                                            <img id="imagen_avatar2" :src="datos.imagen" class="rounded mr-75" alt="profile image" height="64" width="64">
                                                        </a>
                                                        <div class="media-body mt-75">
                                                            <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                                                <label data-toggle="modal" data-target="#modal_avatar_2" class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer" for="account-upload">Cambiar de avatar</label>
                                                            </div>
                                                            <p class="text-muted ml-75 mt-50"><small>Permitido JPG, GIF o PNG. máx.
                                                                    tamaño de
                                                                    800kB</small></p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input type="text" class="form-control" v-model="datos.nombre" name="nombre" placeholder="Ingrese su nombre" required>
                                                                <div class="form-control-position">
                                                                    <i class="feather icon-user"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <select v-model="datos.sexo" name="sexo" class="form-control">
                                                                    <option value="">Seleccione su sexo</option>
                                                                    <option value="Masculino">Masculino</option>
                                                                    <option value="Femenino">Femenino</option>
                                                                </select>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-user"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <select v-model="datos.grado" name="grado" class="form-control">
                                                                    <option value="">Seleccione su grado</option>
                                                                    <option value="1">Grado 1º</option>
                                                                    <option value="2">Grado 2º</option>
                                                                    <option value="3">Grado 3º</option>
                                                                    <option value="4">Grado 4º</option>
                                                                    <option value="5">Grado 5º</option>
                                                                    <option value="6">Grado 6º</option>
                                                                    <option value="7">Grado 7º</option>
                                                                    <option value="8">Grado 8º</option>
                                                                    <option value="9">Grado 9º</option>
                                                                    <option value="10">Grado 10º</option>
                                                                    <option value="11">Grado 11º</option>
                                                                </select>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-graduation-cap"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <select v-model="datos.grupo" name="grupo" class="form-control">
                                                                    <option value="">Seleccione su grupo</option>
                                                                    <option value="Grupo 1">Grupo 1</option>
                                                                    <option value="Grupo 2">Grupo 2</option>
                                                                    <option value="Grupo 3">Grupo 3</option>
                                                                    <option value="Grupo 4">Grupo 4</option>
                                                                    <option value="Grupo 5">Grupo 5</option>
                                                                    <option value="Grupo 6">Grupo 6</option>
                                                                    <option value="Grupo 7">Grupo 7</option>
                                                                    <option value="Grupo 8">Grupo 8</option>
                                                                    <option value="Grupo 9">Grupo 9</option>
                                                                    <option value="Grupo 10">Grupo 10</option>
                                                                </select>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-users"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input v-model="datos.correo" type="text" class="form-control" name="correo" placeholder="Ingrese un email" required>
                                                                <div class="form-control-position">
                                                                    <i class="feather icon-mail"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <select v-model="datos.jornada" name="jornada" class="form-control">
                                                                    <option value="">Jornada</option>
                                                                    <option value="Mañana">Jornada Mañana</option>
                                                                    <option value="Tarde">Jornada Tarde</option>
                                                                    <option value="Continua">Jornada Continua</option>
                                                                </select>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-sun"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end" style="padding: 0">
                                                        <button @click="editarUsuarioEstudiante" type="button" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0"><i class="fas fa-save"></i> Guardar Cambios</button>
                                                        <button type="reset" class="btn btn-light"><i class="fas fa-times"></i> Cancelar</button>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade " id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                                    <form novalidate>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label for="account-old-password">Contraseña anterior</label>
                                                                        <input v-model="passwordOld" type="password" class="form-control" id="account-old-password" required placeholder="Contraseña anterior" data-validation-required-message="This old password field is required">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label for="account-new-password">Nueva contraseña</label>
                                                                        <input v-model="passwordNew" type="password" name="password" id="account-new-password" class="form-control" placeholder="Nueva contraseña" required data-validation-required-message="The password field is required" minlength="6">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label for="account-retype-new-password">Reescriba la nueva contraseña</label>
                                                                        <input v-model="passwordNew2" type="password" name="con-password" class="form-control" required id="account-retype-new-password" data-validation-match-match="password" placeholder="Reescriba la nueva contraseña" data-validation-required-message="The Confirm password field is required" minlength="6">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                <button @click="cambiarPassword" type="button" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0"><i class="fas fa-save"></i> Guardar Cambios</button>
                                                                <button type="reset" class="btn btn-light"><i class="fas fa-times"></i> Cancelar</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" v-if="datos.tipo_registro == 'docente'">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                                                    <div class="media">
                                                        <a href="javascript: void(0);">
                                                            <img id="imagen_avatar2" :src="datos.imagen" class="rounded mr-75" alt="profile image" height="64" width="64">
                                                        </a>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input type="text" class="form-control" v-model="datos.identificacion" name="identificacion" placeholder="Ingrese su identificación" required>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-id-card-alt"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input type="text" class="form-control" v-model="datos.nombre" name="nombre" placeholder="Ingrese su nombre" required>
                                                                <div class="form-control-position">
                                                                    <i class="feather icon-user"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <select v-model="datos.sexo" name="sexo" class="form-control">
                                                                    <option value="">Seleccione su sexo</option>
                                                                    <option value="Masculino">Masculino</option>
                                                                    <option value="Femenino">Femenino</option>
                                                                </select>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-user"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input type="text" class="form-control" v-model="datos.telefono" name="telefono" placeholder="Ingrese su número de telefono" required>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-mobile"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input v-model="datos.correo" type="text" class="form-control" name="correo" placeholder="Ingrese un email" required>
                                                                <div class="form-control-position">
                                                                    <i class="feather icon-mail"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input v-model="datos.direccion" type="text" class="form-control" name="direccion" placeholder="Ingrese su dirección" required>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-street-view"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end" style="padding: 0">
                                                        <button @click="editarUsuarioEstudiante" type="button" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0"><i class="fas fa-save"></i> Guardar Cambios</button>
                                                        <button type="reset" class="btn btn-light"><i class="fas fa-times"></i> Cancelar</button>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade " id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                                    <form novalidate>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label for="account-old-password">Contraseña anterior</label>
                                                                        <input v-model="passwordOld" type="password" class="form-control" id="account-old-password" required placeholder="Contraseña anterior" data-validation-required-message="This old password field is required">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label for="account-new-password">Nueva contraseña</label>
                                                                        <input v-model="passwordNew" type="password" name="password" id="account-new-password" class="form-control" placeholder="Nueva contraseña" required data-validation-required-message="The password field is required" minlength="6">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label for="account-retype-new-password">Reescriba la nueva contraseña</label>
                                                                        <input v-model="passwordNew2" type="password" name="con-password" class="form-control" required id="account-retype-new-password" data-validation-match-match="password" placeholder="Reescriba la nueva contraseña" data-validation-required-message="The Confirm password field is required" minlength="6">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                <button @click="cambiarPassword" type="button" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0"><i class="fas fa-save"></i> Guardar Cambios</button>
                                                                <button type="reset" class="btn btn-light"><i class="fas fa-times"></i> Cancelar</button>
                                                            </div>
                                                        </div>
                                                    </form>
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
        

        <div class="modal fade text-left" id="modal_avatar_2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel17">Selecciona tu avatar favorito</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab11" href="#tab11" role="tab" aria-selected="true">Primaria</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab22" href="#tab22" role="tab" aria-selected="false">Secundaria</a>
                            </li>
                        </ul>
                        <div class="tab-content px-1 pt-1">
                            <div class="tab-pane active" id="tab11" role="tabpanel" aria-labelledby="base-tab1">
                                <div class="row">
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/1.png')" src="avatars/1.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/2.png')" src="avatars/2.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/3.png')" src="avatars/3.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/4.png')" src="avatars/4.png" alt="1.png"></div>
                                </div>
                                <div class="row">
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/5.png')" src="avatars/5.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/6.png')" src="avatars/6.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/7.png')" src="avatars/7.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/8.png')" src="avatars/8.png" alt="1.png"></div>
                                </div>
                                <div class="row">
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/9.png')" src="avatars/9.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/10.png')" src="avatars/10.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/11.png')" src="avatars/11.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/12.png')" src="avatars/12.png" alt="1.png"></div>
                                </div>
                                <div class="row">
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/13.png')" src="avatars/13.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/14.png')" src="avatars/14.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/15.png')" src="avatars/15.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/16.png')" src="avatars/16.png" alt="1.png"></div>
                                </div>
                                <div class="row">
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/17.png')" src="avatars/17.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/18.png')" src="avatars/18.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/19.png')" src="avatars/19.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL('avatars/20.png')" src="avatars/20.png" alt="1.png"></div>
                                </div>                        </div>
                            <div class="tab-pane" id="tab22" role="tabpanel" aria-labelledby="base-tab2">
                                <div class="row">
                                    <div class="col-4 colavatar"><img class="img_avatar_sel" @click="asignarURL('avatars/21.png')" src="avatars/21.png" alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel" @click="asignarURL('avatars/22.png')" src="avatars/22.png" alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel" @click="asignarURL('avatars/23.png')" src="avatars/23.png" alt="1.png"></div>
                                </div>
                                <div class="row">
                                    <div class="col-4 colavatar"><img class="img_avatar_sel" @click="asignarURL('avatars/24.png')" src="avatars/24.png" alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel" @click="asignarURL('avatars/25.png')" src="avatars/25.png" alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel" @click="asignarURL('avatars/26.png')" src="avatars/26.png" alt="1.png"></div>
                                </div>
                                <div class="row">
                                    <div class="col-4 colavatar"><img class="img_avatar_sel" @click="asignarURL('avatars/27.png')" src="avatars/27.png" alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel" @click="asignarURL('avatars/28.png')" src="avatars/28.png" alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel" @click="asignarURL('avatars/29.png')" src="avatars/29.png" alt="1.png"></div>
                                </div>
                                <div class="row">
                                    <div class="col-4 colavatar"><img class="img_avatar_sel" @click="asignarURL('avatars/30.png')" src="avatars/30.png" alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel" @click="asignarURL('avatars/31.png')" src="avatars/31.png" alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel" @click="asignarURL('avatars/32.png')" src="avatars/32.png" alt="1.png"></div>
                                </div>
                                <div class="row">
                                    <div class="col-4 colavatar"><img class="img_avatar_sel" @click="asignarURL('avatars/33.png')" src="avatars/33.png" alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel" @click="asignarURL('avatars/34.png')" src="avatars/34.png" alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel" @click="asignarURL('avatars/35.png')" src="avatars/35.png" alt="1.png"></div>
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
import * as usuarioService from "../services/usuario";
import Skeleton from './skeleton/skeletonSmall.vue';

export default {
    components: {
        Skeleton
    },
    data() {
        return {
            datos: {
                tio_registro: null,
            },
            loading: false,
            passwordOld: "",
            passwordNew: "",
            passwordNew2: "",
        };
    },
    mounted() {
        this.misDatos();
        this.verificarLogin();
        document.title = 'Mi Perfil - BiblioPED';
    },
    methods: {
        async verificarLogin(){
            var navigate = this.$router;
            await usuarioService.verificarLogin().then(respuesta => {
                if(respuesta.data == 0){
                    navigate.push({ name: 'paginaBusqueda'})
                }
            });
        },
        misDatos: async function () {
            this.loading = true;
            try {
                await usuarioService.misDatos().then(respuesta => {
                    this.datos = respuesta.data;
                    this.loading = false;
                });
            } catch (error) {
                console.log(error);
            }
        },
        asignarURL(url) {
            var url_nueva = url;
            $('#modal_avatar_2').modal('hide');
            $("#imagen_avatar2").attr("src", url_nueva);
            this.datos.imagen = url;
        },
        async editarUsuarioEstudiante(){
            await usuarioService.editar_usuario_estudiante(this.datos).then(respuesta => {
                var respuesta_ok = respuesta.data;
                if(respuesta_ok[1] == 1){
                    toastr.success(respuesta_ok[0]);
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }else{
                    toastr.error(respuesta_ok[0]);
                }
            });
        },
        async cambiarPassword(){

            const datos = {
                password_old: this.passwordOld,
                password_new: this.passwordNew,
            };

            if(this.passwordNew == this.passwordNew2){
                await usuarioService.cambiar_password(datos).then(respuesta => {
                    var respuesta_ok = respuesta.data;
                    if(respuesta_ok[1] == 1){
                        toastr.success(respuesta_ok[0]);
                        this.passwordOld = "";
                        this.passwordNew = "";
                        this.passwordNew2 = "";
                    }else{
                        toastr.error(respuesta_ok[0]);
                    }
                });
            }else{
                toastr.error("Las contraseñas no coinciden.");
            }
        }
    }
}
</script>
<style lang="">
    
</style>