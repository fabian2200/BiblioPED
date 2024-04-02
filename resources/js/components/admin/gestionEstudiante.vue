<template lang="">
    <div>
        <h1>Gestión de Estudiantes</h1>
        <hr>
        <section class="users-list-wrapper">
            <div class="users-list-filter px-1">
                <form>
                    <div class="row border border-light rounded py-2 mb-2">
                        <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
                            <button type="button" data-toggle="modal" data-target="#modalRegistroEstudiante" class="btn btn-block btn-primary glow"><i class="fas fa-user-plus"></i> Nuevo Estudiante</button>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-5">
                            
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <label for="users-list-status">Estado</label>
                            <fieldset class="form-group">
                                <select v-model="filtro" class="form-control" id="users-list-status">
                                    <option value="todos">Todos</option>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-1  d-flex align-items-center">
                            <button @click="filtrarDatos" type="button" class="btn btn-block btn-warning glow"><i class="fas fa-search"></i></button>
                        </div>
                       
                    </div>
                </form>
            </div>
            <div class="users-list-table">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <!-- datatable start -->
                            <div class="table-responsive">
                                <table id="users-list-datatable" class="table">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Sexo</th>
                                            <th>Grado</th>
                                            <th>Grupo</th>
                                            <th>Jornada</th>
                                            <th>E-mail</th>
                                            <th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in estudiantesFiltrados" :key="index">
                                            <td>{{ item.nombre }}</td>
                                            <td>{{ item.sexo }}</td>
                                            <td>{{ item.grado }}</td>
                                            <td>{{ item.grupo }}</td>
                                            <td>{{ item.jornada }}</td>
                                            <td>{{ item.correo }}</td>
                                            <td style="text-align: center">
                                                <span v-if="item.estado == undefined || item.estado == 'Activo'" class="badge badge-success">Activo</span>
                                                <span v-else class="badge badge-danger">Inactivo</span>
                                            </td>
                                            <td style="text-align: center">
                                                <a  @click="datosEditar = item" style="margin-left: 10px; text-align: center; padding: 0.35rem 0.5rem !important;"  data-toggle="modal" data-target="#modalEditarEstudiante" class="btn btn-warning" type="button"><i style="color: white" class="fas fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- datatable ends -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade text-left" id="modalRegistroEstudiante" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel17" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="margin-top: 4%;">
                <div class="modal-content">
                    <div class="modal-body">
                        <section class="row flexbox-container">
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <div class="col-lg-12 col-md-8 col-10  p-0">
                                    <div class="card border-grey border-lighten-3 px-1 py-1 m-0" style="box-shadow: none">
                                        <div class="card-header border-0">
                                            <div class="card-title text-center">
                                                <img src="img/logo_1.png" style="height: 90px;"
                                                    alt="branding logo">
                                            </div>

                                        </div>
                                        <div class="card-content">
                                            <p
                                                class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                                <span>Ingrese los siguientes datos</span></p>
                                            <div class="card-body">
                                                <form class="form-horizontal" id="miFormulario2" method="POST">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input type="text" class="form-control" v-model="datosRegistro.nombre" name="nombre"
                                                                    placeholder="Ingrese su nombre" required>
                                                                <div class="form-control-position">
                                                                    <i class="feather icon-user"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-5">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <select v-model="datosRegistro.sexo" name="sexo" class="form-control">
                                                                    <option value="">Seleccione su sexo</option>
                                                                    <option value="Masculino">Masculino</option>
                                                                    <option value="Femenino">Femenino</option>
                                                                </select>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-user"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-1" style="padding-top: 4px">
                                                            <div class="avatar">
                                                                <img style="width: 155%; max-width: 154%;"
                                                                    data-toggle="modal" data-target="#modal_avatar2"
                                                                    id="imagen_avatar2"
                                                                    src="avatars/default.png"
                                                                    alt="avatar">
                                                                <i></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <select v-model="datosRegistro.grado" name="grado" class="form-control">
                                                                    <option value="">Seleccione su grado</option>
                                                                    <option value="1">1º</option>
                                                                    <option value="2">2º</option>
                                                                    <option value="3">3º</option>
                                                                    <option value="4">4º</option>
                                                                    <option value="5">5º</option>
                                                                    <option value="6">6º</option>
                                                                    <option value="7">7º</option>
                                                                    <option value="8">8º</option>
                                                                    <option value="9">9º</option>
                                                                    <option value="10">10º</option>
                                                                    <option value="11">11º</option>
                                                                </select>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-graduation-cap"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-4">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <select v-model="datosRegistro.grupo" name="grupo" class="form-control">
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
                                                        <div class="col-4">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <select v-model="datosRegistro.jornada" name="jornada" class="form-control">
                                                                    <option value="">Jornada</option>
                                                                    <option value="Mañana">Mañana</option>
                                                                    <option value="Tarde">Tarde</option>
                                                                    <option value="Continua">Continua</option>
                                                                </select>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-sun"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input v-model="datosRegistro.correo" type="text" class="form-control" name="correo"
                                                                    placeholder="Ingrese un email" required>
                                                                <div class="form-control-position">
                                                                    <i class="feather icon-mail"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input type="password_" autocomplete="off" class="form-control"
                                                                    name="password_re" v-model="datosRegistro.password" placeholder="Ingrese su contraseña"
                                                                    >
                                                                <div class="form-control-position">
                                                                    <i class="fa fa-key"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </form>
                                            </div>
                                            <div class="card-body"
                                                style="display: flex; padding: 0.5rem; justify-content: space-between;">
                                                <button @click="registro_estudiante()" style="width: 48%" id="btnRegistrar"
                                                    class="btn btn-outline-success btn-block"><i
                                                        class="feather icon-user"></i> Registrar estudiante</button>
                                                <button data-dismiss="modal" aria-label="Close"
                                                    style="width: 48%; margin: 0"
                                                    class="btn btn-outline-danger btn-block"><i
                                                        class="feather icon-x"></i> Cancelar</button>
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

        <div class="modal fade text-left" id="modalEditarEstudiante" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel17" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="margin-top: 4%;">
                <div class="modal-content">
                    <div class="modal-body">
                        <section class="row flexbox-container">
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <div class="col-lg-12 col-md-8 col-10  p-0">
                                    <div class="card border-grey border-lighten-3 px-1 py-1 m-0" style="box-shadow: none">
                                        <div class="card-header border-0">
                                            <div class="card-title text-center">
                                                <img src="img/logo_1.png" style="height: 90px;"
                                                    alt="branding logo">
                                            </div>

                                        </div>
                                        <div class="card-content">
                                            <p
                                                class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                                <span>Ingrese los siguientes datos</span></p>
                                            <div class="card-body">
                                                <form class="form-horizontal" id="miFormulario2" method="POST">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input type="text" class="form-control" v-model="datosEditar.nombre" name="nombre"
                                                                    placeholder="Ingrese su nombre" required>
                                                                <div class="form-control-position">
                                                                    <i class="feather icon-user"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-5">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <select v-model="datosEditar.sexo" name="sexo" class="form-control">
                                                                    <option value="">Seleccione su sexo</option>
                                                                    <option value="Masculino">Masculino</option>
                                                                    <option value="Femenino">Femenino</option>
                                                                </select>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-user"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-1" style="padding-top: 4px">
                                                            <div class="avatar">
                                                                <img style="width: 155%; max-width: 154%;"
                                                                    id="imagen_avatar2"
                                                                    src="avatars/default.png"
                                                                    alt="avatar">
                                                                <i></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <select v-model="datosEditar.grado" name="grado" class="form-control">
                                                                    <option value="">Seleccione su grado</option>
                                                                    <option value="1">1º</option>
                                                                    <option value="2">2º</option>
                                                                    <option value="3">3º</option>
                                                                    <option value="4">4º</option>
                                                                    <option value="5">5º</option>
                                                                    <option value="6">6º</option>
                                                                    <option value="7">7º</option>
                                                                    <option value="8">8º</option>
                                                                    <option value="9">9º</option>
                                                                    <option value="10">10º</option>
                                                                    <option value="11">11º</option>
                                                                </select>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-graduation-cap"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-4">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <select v-model="datosEditar.grupo" name="grupo" class="form-control">
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
                                                        <div class="col-4">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <select v-model="datosEditar.jornada" name="jornada" class="form-control">
                                                                    <option value="">Jornada</option>
                                                                    <option value="Mañana">Mañana</option>
                                                                    <option value="Tarde">Tarde</option>
                                                                    <option value="Continua">Continua</option>
                                                                </select>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-sun"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-5">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input v-model="datosEditar.correo" type="text" class="form-control" name="correo"
                                                                    placeholder="Ingrese un email" required>
                                                                <div class="form-control-position">
                                                                    <i class="feather icon-mail"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-4">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input type="password_" autocomplete="off" class="form-control"
                                                                    name="password_re" v-model="datosEditar.password" placeholder="Ingrese su contraseña"
                                                                    >
                                                                <div class="form-control-position">
                                                                    <i class="fa fa-key"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-3" style="padding: 0">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <select class="form-control" name="estado" id="estado" v-model="datosEditar.estado">
                                                                    <option value="Activo">Activo</option>
                                                                    <option value="Inactivo">Inactivo</option>
                                                                </select>
                                                                <div class="form-control-position">
                                                                    <i v-if="datosEditar.estado == 'Activo'" style="color: green" class="fas fa-toggle-on"></i>
                                                                    <i v-else style="color: red" class="fas fa-toggle-off"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </form>
                                            </div>
                                            <div class="card-body"
                                                style="display: flex; padding: 0.5rem; justify-content: space-between;">
                                                <button @click="editar_estudiante()" style="width: 48%" id="btnRegistrar"
                                                    class="btn btn-outline-success btn-block"><i
                                                        class="feather icon-user"></i> Editar estudiante</button>
                                                <button data-dismiss="modal" aria-label="Close"
                                                    style="width: 48%; margin: 0"
                                                    class="btn btn-outline-danger btn-block"><i
                                                        class="feather icon-x"></i> Cancelar</button>
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

        <div class="modal fade text-left" id="modal_avatar2" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel17" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="max-width: 820px;">
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
                                <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1"
                                    href="#tab1" role="tab" aria-selected="true">Primaria</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                                    href="#tab2" role="tab" aria-selected="false">Secundaria</a>
                            </li>
                        </ul>
                        <div class="tab-content px-1 pt-1">
                            <div class="tab-pane active" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                                <div class="row">
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL2('avatars/1.png')"
                                            src="avatars/1.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL2('avatars/2.png')"
                                            src="avatars/2.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL2('avatars/3.png')"
                                            src="avatars/3.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL2('avatars/4.png')"
                                            src="avatars/4.png" alt="1.png"></div>
                                </div>
                                <div class="row">
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL2('avatars/5.png')"
                                            src="avatars/5.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL2('avatars/6.png')"
                                            src="avatars/6.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL2('avatars/7.png')"
                                            src="avatars/7.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL2('avatars/8.png')"
                                            src="avatars/8.png" alt="1.png"></div>
                                </div>
                                <div class="row">
                                    <div class="col-3"><img class="img_avatar_sel" @click="asignarURL2('avatars/9.png')"
                                            src="avatars/9.png" alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/10.png')" src="avatars/10.png"
                                            alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/11.png')" src="avatars/11.png"
                                            alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/12.png')" src="avatars/12.png"
                                            alt="1.png"></div>
                                </div>
                                <div class="row">
                                    <div class="col-3"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/13.png')" src="avatars/13.png"
                                            alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/14.png')" src="avatars/14.png"
                                            alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/15.png')" src="avatars/15.png"
                                            alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/16.png')" src="avatars/16.png"
                                            alt="1.png"></div>
                                </div>
                                <div class="row">
                                    <div class="col-3"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/17.png')" src="avatars/17.png"
                                            alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/18.png')" src="avatars/18.png"
                                            alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/19.png')" src="avatars/19.png"
                                            alt="1.png"></div>
                                    <div class="col-3"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/20.png')" src="avatars/20.png"
                                            alt="1.png"></div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                                <div class="row">
                                    <div class="col-4 colavatar"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/21.png')" src="avatars/21.png"
                                            alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/22.png')" src="avatars/22.png"
                                            alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/23.png')" src="avatars/23.png"
                                            alt="1.png"></div>
                                </div>
                                <div class="row">
                                    <div class="col-4 colavatar"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/24.png')" src="avatars/24.png"
                                            alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/25.png')" src="avatars/25.png"
                                            alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/26.png')" src="avatars/26.png"
                                            alt="1.png"></div>
                                </div>
                                <div class="row">
                                    <div class="col-4 colavatar"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/27.png')" src="avatars/27.png"
                                            alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/28.png')" src="avatars/28.png"
                                            alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/29.png')" src="avatars/29.png"
                                            alt="1.png"></div>
                                </div>
                                <div class="row">
                                    <div class="col-4 colavatar"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/30.png')" src="avatars/30.png"
                                            alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/31.png')" src="avatars/31.png"
                                            alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/32.png')" src="avatars/32.png"
                                            alt="1.png"></div>
                                </div>
                                <div class="row">
                                    <div class="col-4 colavatar"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/33.png')" src="avatars/33.png"
                                            alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/34.png')" src="avatars/34.png"
                                            alt="1.png"></div>
                                    <div class="col-4 colavatar"><img class="img_avatar_sel"
                                            @click="asignarURL2('avatars/35.png')" src="avatars/35.png"
                                            alt="1.png"></div>
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

export default {
    components: {
       
    },
    data() {
        return {
            datosRegistro: {
                nombre: "",
                sexo: "",
                grado: "",
                grupo: "",
                jornada: "",
                correo: "",
                password: "",
                imagen: "avatars/default.png",
                tipo_registro: "estudiante",
            },
           loading: false,
           estudiantes: [],
           estudiantesFiltrados: [],
           filtro: "todos",
           datosEditar: {},
        };
    },
    mounted() {
        this.listarEstudiantes();
        document.title = 'Gestión estudiantes - BiblioPED';
    },
    methods: {
        dataTables() {
            $("#users-list-datatable").DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                'columnDefs': [{
                    "orderable": false,
                    "targets": [7]
                }]
            });
        },
        async registro_estudiante(){
            this.loading = true;
            try {
                if(this.datosRegistro.nombre != "" && this.datosRegistro.sexo != "" && this.datosRegistro.grado != "" && this.datosRegistro.grupo != "" && this.datosRegistro.jornada != "" && this.datosRegistro.correo != "" && this.datosRegistro.password != ""){
                    await adminService.registro_estudiante(this.datosRegistro).then(respuesta => {
                        var respuesta_ok = respuesta.data;
                        if(respuesta_ok[1] == 1){
                            toastr.success(respuesta_ok[0]);
                            $('#modalRegistroEstudiante').modal('hide');
                            this.listarEstudiantes();
                        }else{
                            toastr.error(respuesta_ok[0]);
                        }
                    });
                }else{
                    toastr.warning("Todos los campos son obligatorios");
                }
            } catch (error) {
                console.log(error);
            }
        },
        async editar_estudiante(){
            if(this.datosEditar.nombre != "" && this.datosEditar.sexo != "" && this.datosEditar.grado != "" && this.datosEditar.grupo != "" && this.datosEditar.jornada != "" && this.datosEditar.correo != "" && this.datosEditar.password != ""){
                this.datosEditar._id = this.datosEditar._id.$oid;
                await adminService.editar_estudiante(this.datosEditar).then(respuesta => {
                    var respuesta_ok = respuesta.data;
                    if(respuesta_ok[1] == 1){
                        toastr.success(respuesta_ok[0]);
                        $('#modalEditarEstudiante').modal('hide');
                    }else{
                        toastr.error(respuesta_ok[0]);
                    }
                });
            }else{
                toastr.warning("Todos los campos son obligatorios");
            }
        },
        listarEstudiantes: async function () {
            this.loading = true;
            try {
                await adminService.listarEstudiantes().then(respuesta => {
                    this.estudiantesFiltrados = respuesta.data;
                    this.estudiantes = respuesta.data;
                    this.loading = false;
                    $('#users-list-datatable').DataTable().destroy();
                    setTimeout(() => {
                        this.dataTables();
                    }, 200);
                });
            } catch (error) {
                console.log(error);
            }
        },
        filtrarDatos(){
            if (this.filtro == 'todos') {
                this.estudiantesFiltrados =  this.estudiantes;
            } else {
                this.estudiantesFiltrados = this.estudiantes.filter(item => item.estado == this.filtro);
            }

            $('#users-list-datatable').DataTable().destroy();
            setTimeout(() => {
                this.dataTables();
            }, 200);
        },
        asignarURL2(url){
            var url_nueva = url;
            $('#modal_avatar2').modal('hide');
            $("#imagen_avatar2").attr("src", url_nueva);
            this.datosRegistro.imagen = url;
        }
    },
};
</script>
<style lang="">
    
</style>