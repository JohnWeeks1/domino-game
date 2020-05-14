<template>
    <div class="container">
        <grid-layout
            class="bg-success"
            width=100
            :prevent-collision="true"
            :layout="layout"
            :col-num="12"
            :row-height="30"
            :is-draggable="true"
            :is-resizable="false"
            :is-mirrored="false"
            :vertical-compact="false"
            :margin="[2, 2]"
            :use-css-transforms="false"
        >
            <grid-item v-for="item in layout"
                       class="bg-dark"
                       :x="item.x"
                       :y="item.y"
                       :w="item.w"
                       :h="item.h"
                       :i="item.i"
                       :key="item.i">

                    <img class="" :src="`images/dominoes/${item.i}.png`"  height='100px' alt="">
<!--                {{item.i}}-->
            </grid-item>
        </grid-layout>
    </div>
</template>

<script>
    import VueGridLayout from 'vue-grid-layout';
    export default {
        name: 'game',
        data() {
            return {
                layout: [
                    {"x":6,"y":10,"w":2,"h":2,"i":"4-4"},
                ]
            }
        },
        components: {
            GridLayout: VueGridLayout.GridLayout,
            GridItem: VueGridLayout.GridItem
        },
    }
</script>
