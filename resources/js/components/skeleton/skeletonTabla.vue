<template lang="">
    <div>
        <div class="container" style="width: 94%; height: 100%">
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
                        <h2 style="color: #fc4f00">{{ mensaje }}</h2>
                    </div>
                </template>
            </loading> 
        </div>
        
    </div>
</template>
<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';

export default {
    props: ['mensaje'],
    components: {
        Loading
    },
    data() {
        return {
            isLoading: true,
            fullPage: false,
            color: '#fc4f00',
            bgColor: '#ffffff',
            height: 100,
            width: 100,
            useSlot: true,
            loader: 'dots'
        };
    }
}
</script>
<style lang="">
    
</style>