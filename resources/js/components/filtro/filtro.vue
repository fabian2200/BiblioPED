<template lang="">
    <div>
        <div class="app-content-overlay-filtro"></div>
        <div class="todo-new-task-sidebar">
            <div class="card shadow-none p-0 m-0">
                <div class="card-header border-bottom py-75">
                    <div style="height: 32px" class="task-header d-flex justify-content-between align-items-center">
                        <h5 class="new-task-title mb-0">Filtrar resultados</h5>
                    </div>
                    <button type="button" class="close close-icon cerrar-filtros">
                        <i class="feather icon-x align-middle"></i>
                    </button>
                </div>
                <!-- form start -->
                <form>
                    <div class="form" style="padding: 20px">
                        <div class="form-group" style="padding-top: 20px;">
                            <label for="gradoFiltro"><strong>Filtre la información por grado:</strong></label>
                            <select class="form-control" id="gradoFiltro" name="gradoFiltro" v-model="gradoFiltro">
                                <option value="no">Todos los grados</option>
                                <option value="1">Grado 1°</option>
                                <option value="2">Grado 2°</option>
                                <option value="3">Grado 3°</option>
                                <option value="4">Grado 4°</option>
                                <option value="5">Grado 5°</option>
                                <option value="6">Grado 6°</option>
                                <option value="7">Grado 7°</option>
                                <option value="8">Grado 8°</option>
                                <option value="9">Grado 9°</option>
                                <option value="10">Grado 10°</option>
                                <option value="11">Grado 11°</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="asignaturaFiltro"><strong>Filtre la información por asignatura:</strong></label>
                            <select class="form-control" id="asignaturaFiltro" name="asignaturaFiltro" v-model="asignaturaFiltro">
                                <option value="no">Todos las asignaturas</option>
                                <option v-for="(item, index) in asignaturas" :key="index" :value="item.nombre">{{ item.nombre }}</option>
                            </select>
                        </div>
                    </div>
                    <div style="text-align: right; padding: 20px">
                        <button @click="limpiarFiltro" v-if="gradoFiltro != 'no' || asignaturaFiltro != 'no'" style="width: 150x" type="button" class="btn btn-danger limpiar-filtros-ok">Limpiar filtros <i class="fas fa-trash"></i></button> <button  type="button"  class="btn btn-success aplicar-filtros-ok">Aplicar filtros <i class="fas fa-filter"></i></button>
                    </div>
                </form>
                <!-- form start end-->
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
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
                },
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
                },
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
            gradoFiltro: 'no',
            asignaturaFiltro: 'no'
        }
    },
    methods: {
        limpiarFiltro(){
            this.gradoFiltro = 'no';
            this.asignaturaFiltro = 'no';
        }
    }
}
</script>
<style>
.todo-new-task-sidebar {
    height: calc(var(--vh, 1vh) * 100 - 6.5rem);
    width: 400px;
    border-radius: 0.25rem;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    background-color: #fff;
    position: absolute;
    transform: translateX(110%);
    transition: all .6s ease-in-out;
    z-index: 8;
    right: 2.6rem;
    top: 8%;
}

.todo-new-task-sidebar.show {
    transform: translateX(8%) translateY(1px);
}

.todo-new-task-sidebar .close-icon {
    position: absolute;
    top: 13px;
    right: 10px;
    outline: none;
}

.todo-new-task-sidebar .close-icon i {
    font-size: 1.75rem;
    color: red;
}

.app-content-overlay-filtro {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    position: absolute;
    display: block;
    z-index: 4;
    visibility: hidden;
    opacity: 0;
    transition: all .3s ease;
    width: 100%;
    height: 100%;
}

.app-content-overlay-filtro.show {
    visibility: visible;
    transition: all .3s ease;
    opacity: 1;
    background-color: #0000009e;
    border-radius: .25rem;
}
</style>