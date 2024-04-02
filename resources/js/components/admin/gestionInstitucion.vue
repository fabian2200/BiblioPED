<template lang="">
    <div>
        <section class="users-list-wrapper" v-if="loading == false">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class="card profile-card-with-cover">
                        <div class="card-img-top img-fluid bg-cover height-200" >
                            <img  style="position: absolute; width: 100%; height: 200px" :src="infoColegio.portada" alt="">
                            <input @change="handleFileChangePortada" type="file" style="display: none" id="foto_colegio_portada">
                            <label id="label_foto_colegio_portada" for="foto_colegio_portada"><span><i class="fas fa-camera"></i></span></label>
                        </div>
                        <div class="card-profile-image">
                            <img :src="infoColegio.logo" style="background-color: white" class="rounded-circle img-border box-shadow-1" alt="Card image">
                            <input @change="handleFileChangeLogo" type="file" style="display: none" id="foto_colegio_logo">
                            <label id="label_foto_colegio_logo" for="foto_colegio_logo"><span><i class="fas fa-camera"></i></span></label>
                        </div>
                        <div class="profile-card-with-cover-content text-center">
                            <div class="text-left" style="padding: 20px">
                                <div class="form-group">
                                    <label for="my-input">Nombre de la institución</label>
                                    <input v-model="infoColegio.nombre" id="my-input" class="form-control" type="text" name="">
                                </div>
                                <div class="form-group">
                                    <label for="my-input">Sede</label>
                                    <input v-model="infoColegio.sede" id="my-input" class="form-control" type="text" name="">
                                </div>
                                <div class="form-group">
                                    <label for="my-input">Departamento</label>
                                    <input v-model="infoColegio.departamento" id="my-input" class="form-control" type="text" name="">
                                </div>
                                <div class="form-group">
                                    <label for="my-input">Municipio</label>
                                    <input v-model="infoColegio.municipio" id="my-input" class="form-control" type="text" name="">
                                </div>
                            </div>
                            <hr>
                            <div style="padding-left: 20px; padding-right: 20px">
                                <button @click="editarInfoColegio" style="width: 100%" class="btn btn-success">Guardar datos</button>
                            </div>
                            <br>
                        </div>
                    </div>
                </div> 
                <div class="col-lg-2"></div>   
            </div>
        </section>
    </div>
</template>
<script>
import * as adminService from "../../services/admin";

export default {
    data() {
        return {
            infoColegio: null,
            loading: true,
            logoImagen: null,
            portadaImagen: null
        }
    },    
    mounted() {
        this.infoColegioFunction();
    },
    methods: {
        async infoColegioFunction(){
            this.loading = true;
            await adminService.infoColegio().then(respuesta => {
                this.infoColegio = respuesta.data;
                this.loading = false;
            });
        },
        handleFileChangeLogo(event) {
            const file = event.target.files[0];
            if (file) {
                this.infoColegio.logo = URL.createObjectURL(file);
                this.logoImagen = file;
            }
        },
        handleFileChangePortada(event) {
            const file = event.target.files[0];
            if (file) {
                this.infoColegio.portada = URL.createObjectURL(file);
                this.portadaImagen = file;
            }
        },
        async editarInfoColegio(){
            const formData = new FormData();
            formData.append('id_institucion', this.infoColegio._id.$oid);
            formData.append('infoColegio', JSON.stringify(this.infoColegio));
            formData.append('logoImagen', this.logoImagen);
            formData.append('portadaImagen', this.portadaImagen);

            const response = await adminService.editarInfoColegio(formData);
            const respuesta_ok = response.data;
            if (respuesta_ok[1] === 1) {
                toastr.success(respuesta_ok[0]);
                await adminService.infoColegio().then(respuesta => {
                    this.infoColegio = respuesta.data;
                    if(this.logoImagen != null){
                        this.infoColegio.logo = URL.createObjectURL(this.logoImagen);
                    }

                    if(this.portadaImagen != null){
                        this.infoColegio.portada = URL.createObjectURL(this.portadaImagen);
                    }

                    this.logoImagen = null;
                    this.portadaImagen = null;
                });
            } else {
                toastr.error(respuesta_ok[0]);
            }
        }
    },
}
</script>
<style>
    #label_foto_colegio_logo {
        width: 44px;
        height: 43px;
        background-color: #009199;
        color: white;
        font-size: 20px;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        position: absolute;
        left: 53%;
        top: 77px;
        border: 3px solid;
        cursor: pointer;
    }

    #label_foto_colegio_portada {
        width: 44px;
        height: 43px;
        background-color: #009199;
        color: white;
        font-size: 20px;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        position: absolute;
        left: 93%;
        top: 6px;
        border: 3px solid;
        cursor: pointer;
    }
</style>