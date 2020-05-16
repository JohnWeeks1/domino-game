<template>
    <div>
        <div class="container">
            <div class="jumbotron">
                <div v-for="player in players" :key="players.id">
                    {{player.name}}
                    <span v-for="domino in player.dominoes">
                        <span @dblclick="addDominoToGameArea(player.name, domino.current)">
                            <img class="p-1" :src="`../../images/dominoes/${domino.current}.png`" width=40 alt="">
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <grid-layout
            style="margin: 0 auto; max-width: 1000px !important; min-width: 940px !important;"
            :prevent-collision="true"
            :layout="layout"
            :col-num="20"
            :row-height="45"
            :is-draggable="true"
            :is-resizable="false"
            :is-mirrored="false"
            :vertical-compact="false"
            :margin="[2, 2]"
            :use-css-transforms="false"
        >
            <grid-item v-for="item in layout"
                       :x="item.x"
                       :y="item.y"
                       :w="item.w"
                       :h="item.h"
                       :i="item.i"
                       :key="item.i">

                <div @dblclick="">
                    <img class="img-fluid" :src="`images/dominoes/${item.i}.png`"  height='100px' alt="">
                </div>
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
                players: [],
                layout: []
            }
        },
        mounted() {
            this.fetchPlayers();
        },
        methods: {
            addDominoToGameArea(name, domino) {
                this.layout.push({
                    "name":name,
                    "x":0,
                    "y":0,
                    "w":1,
                    "h":2,
                    "i":domino
                });
            },
            rotateLeft() {
                this.rotation += 90
            },
            fetchPlayers() {
                axios.get('players')
                    .then(response => {
                        this.players = response.data.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
        },
        components: {
            GridLayout: VueGridLayout.GridLayout,
            GridItem: VueGridLayout.GridItem
        },
    }
</script>
