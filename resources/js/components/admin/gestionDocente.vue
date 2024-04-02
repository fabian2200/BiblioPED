<template lang="">
    <div>
        <h1>Gestión de Docentes</h1>
        <hr>
        <section class="users-list-wrapper">
            <div class="users-list-filter px-1">
                <form>
                    <div class="row border border-light rounded py-2 mb-2">
                        <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
                            <button type="button" data-toggle="modal" data-target="#modalregistroDocente" class="btn btn-block btn-primary glow"><i class="fas fa-user-plus"></i> Nuevo Docente</button>
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
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Sexo</th>
                                            <th>Teléfono</th>
                                            <th>Email</th>
                                            <th>Direccion</th>
                                            <th>Estado</th>
                                            <th>Editar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in docentesFiltrados" :key="index">
                                            <td>{{ item.identificacion }}</td>
                                            <td>{{ item.nombre }}</td>
                                            <td>{{ item.sexo }}</td>
                                            <td>{{ item.telefono }}</td>
                                            <td>{{ item.correo }}</td>
                                            <td>{{ item.direccion }}</td>
                                            <td><span :class="item.estado == 'Activo' ? 'badge badge-success' : 'badge badge-danger'">{{ item.estado }}</span></td>
                                            <td>
                                                <a  @click="datosEditar = item" style="margin-left: 10px; text-align: center; padding: 0.35rem 0.5rem !important;"  data-toggle="modal" data-target="#modalEditarDocente" class="btn btn-warning" type="button"><i style="color: white" class="fas fa-edit"></i></a>
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

        <div class="modal fade text-left" id="modalregistroDocente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <section class="row flexbox-container">
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <div class="col-lg-12 col-md-8 col-10  p-0">
                                    <div class="card border-grey border-lighten-3 px-1 py-1 m-0" style="box-shadow: none">
                                        <div class="card-header border-0">
                                            <div class="card-title text-center">
                                                <img src="img/logo_1.png" style="height: 90px;" alt="branding logo">
                                            </div>
                                        
                                        </div>
                                        <div class="card-content">
                                            <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1"><span>Ingrese los siguientes datos</span></p>
                                            <div class="card-body">
                                                <form class="form-horizontal" id="formularioRegistroDocente" method="POST" validate>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input type="text" class="form-control" v-model="datosRegistro.identificacion" name="identificacion" placeholder="Ingrese su identificación" required>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-id-card"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input type="text" class="form-control" v-model="datosRegistro.nombre" name="nombre" placeholder="Ingrese su nombre" required>
                                                                <div class="form-control-position">
                                                                    <i class="feather icon-user"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <select name="sexo" v-model="datosRegistro.sexo" class="form-control">
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
                                                                <input v-model="datosRegistro.telefono" type="text" class="form-control" name="telefono" placeholder="Ingrese su número  de teléfono" required>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-phone-volume"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input v-model="datosRegistro.correo" type="text" class="form-control" name="correo" placeholder="Ingrese un usuario" required>
                                                                <div class="form-control-position">
                                                                    <i class="feather icon-user"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input v-model="datosRegistro.password" type="password" class="form-control" name="password" placeholder="Ingrese una contraseña" required>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-unlock-alt"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input v-model="datosRegistro.direccion" type="text" class="form-control" name="direccion" placeholder="Ingrese su dirección" required>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-street-view"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                   
                                                </form>
                                            </div>
                                            <div class="card-body" style="display: flex; padding: 0.5rem; justify-content: space-between;">
                                                <button style="width: 48%" @click="registro_docente" class="btn btn-outline-success btn-block"><i class="feather icon-user"></i> Registrate</button>
                                                <button data-dismiss="modal" aria-label="Close" style="width: 48%; margin: 0" class="btn btn-outline-danger btn-block"><i class="feather icon-x"></i> Cancelar</button>
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

        <div class="modal fade text-left" id="modalEditarDocente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <section class="row flexbox-container">
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <div class="col-lg-12 col-md-8 col-10  p-0">
                                    <div class="card border-grey border-lighten-3 px-1 py-1 m-0" style="box-shadow: none">
                                        <div class="card-header border-0">
                                            <div class="card-title text-center">
                                                <img src="img/logo_1.png" style="height: 90px;" alt="branding logo">
                                            </div>
                                        
                                        </div>
                                        <div class="card-content">
                                            <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1"><span>Ingrese los siguientes datos</span></p>
                                            <div class="card-body">
                                                <form class="form-horizontal"  method="POST" validate>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input type="text" class="form-control" v-model="datosEditar.identificacion" name="identificacion" placeholder="Ingrese su identificación" required>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-id-card"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input type="text" class="form-control" v-model="datosEditar.nombre" name="nombre" placeholder="Ingrese su nombre" required>
                                                                <div class="form-control-position">
                                                                    <i class="feather icon-user"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <select name="sexo" v-model="datosEditar.sexo" class="form-control">
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
                                                                <input v-model="datosEditar.telefono" type="text" class="form-control" name="telefono" placeholder="Ingrese su número  de teléfono" required>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-phone-volume"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input v-model="datosEditar.correo" type="text" class="form-control" name="correo" placeholder="Ingrese un email" required>
                                                                <div class="form-control-position">
                                                                    <i class="feather icon-mail"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input v-model="datosEditar.password" type="password" class="form-control" name="password" placeholder="Ingrese una contraseña" required>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-unlock-alt"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <input v-model="datosEditar.direccion" type="text" class="form-control" name="direccion" placeholder="Ingrese su dirección" required>
                                                                <div class="form-control-position">
                                                                    <i class="fas fa-street-view"></i>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6">
                                                            <fieldset class="form-group position-relative has-icon-left">
                                                                <select class="form-control" name="estado" id="estado" v-model="datosEditar.estado">
                                                                    <option value="Activo">Activo</option>
                                                                    <option value="Inactivo">Inactivo</option>
                                                                </select>
                                                                <div class="form-control-position">
                                                                    <div class="form-control-position">
                                                                    <i v-if="datosEditar.estado == 'Activo'" style="color: green" class="fas fa-toggle-on"></i>
                                                                    <i v-else style="color: red" class="fas fa-toggle-off"></i>
                                                                </div>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                   
                                                </form>
                                            </div>
                                            <div class="card-body" style="display: flex; padding: 0.5rem; justify-content: space-between;">
                                                <button style="width: 48%" @click="editar_docente" class="btn btn-outline-warning btn-block"><i class="feather icon-user"></i> Editar</button>
                                                <button data-dismiss="modal" aria-label="Close" style="width: 48%; margin: 0" class="btn btn-outline-danger btn-block"><i class="feather icon-x"></i> Cancelar</button>
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
                identificacion: "",
                nombre: "",
                sexo: "",
                telefono: "",
                correo: "",
                password: "",
                direccion: "",
            },
           loading: false,
           docentes: [],
           docentesFiltrados: [],
           filtro: "todos",
           datosEditar: {},
        };
    },
    mounted() {
        this.listarDocentes();
        document.title = 'Gestión docentes - BiblioPED';
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
        async registro_docente(){
            this.loading = true;
            try {
                if(this.datosRegistro.identificacion != "" && this.datosRegistro.nombre != "" && this.datosRegistro.correo != "" && this.datosRegistro.direccion != "" && this.datosRegistro.sexo != "" && this.datosRegistro.password != "" && this.datosRegistro.telefono != ""){
                    await adminService.registrar_docente(this.datosRegistro).then(respuesta => {
                        var respuesta_ok = respuesta.data;
                        if(respuesta_ok[1] == 1){
                            toastr.success(respuesta_ok[0]);
                            $('#modalregistroDocente').modal('hide');
                            this.listarDocentes();
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
        async editar_docente(){
            if(this.datosEditar.identificacion != "" && this.datosEditar.nombre != "" && this.datosEditar.correo != "" && this.datosEditar.direccion != "" && this.datosEditar.sexo != "" && this.datosEditar.password != "" && this.datosEditar.telefono != "" && this.datosEditar.estado != ""){
                this.datosEditar._id = this.datosEditar._id.$oid;
                await adminService.editar_docente(this.datosEditar).then(respuesta => {
                    var respuesta_ok = respuesta.data;
                    if(respuesta_ok[1] == 1){
                        toastr.success(respuesta_ok[0]);
                        $('#modalEditarDocente').modal('hide');
                    }else{
                        toastr.error(respuesta_ok[0]);
                    }
                });
            }else{
                toastr.warning("Todos los campos son obligatorios");
            }
        },
        listarDocentes: async function () {
            this.loading = true;
            try {
                await adminService.listarDocentes().then(respuesta => {
                    this.docentesFiltrados = respuesta.data;
                    this.docentes = respuesta.data;
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
                this.docentesFiltrados =  this.docentes;
            } else {
                this.docentesFiltrados = this.docentes.filter(item => item.estado == this.filtro);
            }

            $('#users-list-datatable').DataTable().destroy();
            setTimeout(() => {
                this.dataTables();
            }, 200);
        }
    },
};
</script>
<style lang="">
    
</style>