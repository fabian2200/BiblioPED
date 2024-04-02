<template lang="">
    <div>
        <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
            <div class="main-menu-content">
                <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                    <li class=" navigation-header"><span>Menu General</span></li>
                    <hr>
                    <li class="nav-item"><a type="buton" @click="cambiar_tipo('Inicio')"><i class="fas fa-home"></i><span class="menu-title" data-i18n="Email Application">Inicio</span></a></li>
                    <li class="nav-item"><a type="buton" @click="cambiar_tipo('GI')"><i class="fas fa-school"></i><span class="menu-title" data-i18n="Todo Application">Gestión Institución</span></a></li>
                    <li class="nav-item"><a type="buton" @click="cambiar_tipo('GD')"><i class="fas fa-chalkboard-teacher"></i><span class="menu-title" data-i18n="Email Application">Gestión Docente</span></a></li>
                    <li class="nav-item"><a type="buton" @click="cambiar_tipo('GE')"><i class="fas fa-user-graduate"></i><span class="menu-title" data-i18n="Chat Application">Gestión Estudiante</span></a></li>
                    <li class="nav-item"><a type="buton" @click="cambiar_tipo('Estadistica')"><i class="fas fa-chart-pie"></i><span class="menu-title" data-i18n="Todo Application">Estadística</span></a></li>
                </ul>
            </div>
        </div>
        <div class="app-content content" style="margin-left: 240px">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <Inicio v-if="tipoMostrado == 'Inicio'"></Inicio>
                    <gestionDocente v-if="tipoMostrado == 'GD'"></gestionDocente>
                    <gestionEstudiante v-if="tipoMostrado == 'GE'"></gestionEstudiante>
                    <estadistica v-if="tipoMostrado == 'Estadistica'"></estadistica>
                    <gestionInstitucion v-if="tipoMostrado == 'GI'"></gestionInstitucion>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Inicio from "./admin/inicio.vue";
import gestionDocente from "./admin/gestionDocente.vue";
import gestionEstudiante from "./admin/gestionEstudiante.vue";
import estadistica from "./admin/estadistica.vue";
import gestionInstitucion from "./admin/gestionInstitucion.vue";

import * as usuarioService from "../services/usuario";

export default {
    components: {
        Inicio,
        gestionDocente,
        gestionEstudiante,
        estadistica,
        gestionInstitucion
    },
    data() {
        return {
            tipoMostrado: 'Inicio',
        };
    },
    mounted() {
       this.misDatos();
    },
    methods: {
        cambiar_tipo(tipo) {
           this.tipoMostrado = tipo;
        },
        misDatos: async function () {
            this.loading = true;
            var navigate = this.$router;
            try {
                await usuarioService.misDatos().then(respuesta => {
                    this.datos = respuesta.data;
                    this.loading = false;
                    if(this.datos.tipo_registro != "administrador" || this.datos.tipo_registro == undefined){
                        navigate.push({ name: 'sitioProhibido' })
                    }
                });
            } catch (error) {
                console.log(error);
            }
        },
    },
};
</script>
<style lang="">
    
</style>