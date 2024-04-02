<template lang="">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <div v-if="loading == false" class="row" style="margin-right: 0px;">
            <div class="col-5"></div>
            <div style="height: 100px; background-color: white;" class="col-7">
                <div class="row" style="height: 100%; padding: 10px;">
                    <div class="col-3" style="display: flex; flex-direction: column; justify-content: center;">
                        <img style="width: 80%;" :src="info_colegio.logo" alt="">
                    </div>
                    <div class="col-9" style="display: flex; flex-direction: column; justify-content: center; height: 100%;">
                        <h4 style="font-weight: bold; color: #009c9f;">{{info_colegio.nombre}}</h4>
                        <h6><strong>{{info_colegio.municipio}} - {{info_colegio.departamento}}</strong></h6>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</template>
<script>

import * as adminService from "../../services/admin";
export default {
    data() {
        return {
            info_colegio: null,
            loading: true
        }
    },
    mounted() {
        this.infoColegio();
    },
    methods: {
        async infoColegio(){
            this.loading = true;
            await adminService.infoColegio().then(respuesta => {
                this.info_colegio = respuesta.data;
                this.loading = false;
            });
        }
    },
}
</script>
<style lang="">
    
</style>