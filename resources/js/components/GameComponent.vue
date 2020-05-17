<template>
    <div>
        <div class="container">
            <div class="jumbotron">
                <div v-for="player in players" :key="players.id">
                    {{player.name}}
                    <span v-for="domino in player.dominoes">
                        <span @dblclick="addDominoToGameArea(player, domino)">
                            <img class="p-1" :src="`../../images/dominoes/${domino}.png`" width=40 alt="">
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

                    <img @dblclick="rotateLeft(item.i)" class="img-fluid" :id="`rotateDomino${item.i}`" :src="`images/dominoes/${item.i}.png`"  alt="">
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
                layout: [],
                rotateAngle: 90,
                currentRotationPosition: 0
            }
        },
        mounted() {
            this.fetchPlayers();
        },
        methods: {
            addDominoToGameArea(player, domino) {
                this.layout.push({
                    "name":player.name,
                    "x":0,
                    "y":0,
                    "w":1,
                    "h":2,
                    "i":domino
                });

                this.removeUsedDominoFromSelection(domino);
            },
            removeUsedDominoFromSelection(domino) {
                for (let i = 0; i < this.players.length; i++) {
                    let index = this.players[i].dominoes.indexOf(domino);
                    if (index !== -1) this.players[i].dominoes.splice(index, 1);
                }
            },
            rotateLeft(number) {
                if (this.currentRotationPosition > 270) {
                    this.currentRotationPosition = 0;
                }

                document.getElementById("rotateDomino" + number)
                    .style.transform = 'rotate(' + (this.currentRotationPosition += this.rotateAngle) +'deg)';
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

<style>
    #rotateDomino {}
</style>
