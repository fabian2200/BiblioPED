<template>
    <div>
        <div id="search-nav" class="card-body">
            <ul class="nav nav-inline">
                <li class="nav-item">
                    <a :class="tipo == 'normal' ? 'nav-link active' : 'nav-link'" @click.prevent="getAboutLink(1)"><i class="fa fa-link"></i>
                        Contenido</a>
                </li>
                <li class="nav-item">
                    <a :class="tipo == 'imagenes' ? 'nav-link active' : 'nav-link'" @click.prevent="getAboutLink(2)"><i class="fa fa-file-image-o"></i>
                        Imágenes</a>
                </li>
                <li class="nav-item">
                    <a :class="tipo == 'videos' ? 'nav-link active' : 'nav-link'" @click.prevent="getAboutLink(3)"><i class="fa fa-file-video-o"></i>
                        Videos</a>
                </li>
                <li class="nav-item">
                    <a :class="tipo == 'metafactos' ? 'nav-link active' : 'nav-link'" @click.prevent="getAboutLink(4)"><i class="fa fa-file-video-o"></i>
                        Mentefactos</a>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    props: ['tipo'],
    methods: {
        getAboutLink(tipo_enlace){
            var navigate = this.$router;
            var texto = this.$route.params.texto;
            switch  (tipo_enlace) {  
                case 0:
                    navigate.push({ name: 'paginaBusqueda' })
                break  
                case 1: 
                    navigate.push({ name: 'ResultadoBusqueda', params: { texto: texto, tipo: "contenido", pagina: 1 } })
                break;
                case 2: 
                    navigate.push({ name: 'ResultadoImagenes', params: { texto: texto, tipo: "imagenes" } })
                break;
                case 3: 
                    navigate.push({ name: 'ResultadoVideos', params: { texto: texto, tipo: "videos", pagina: 1 } })
                break;
                case 4: 
                    navigate.push({ name: 'ResultadoMetafactos', params: { texto: texto, tipo: "metafactos", pagina: 1 } })
                break
            }
        }
    }
}
</script>