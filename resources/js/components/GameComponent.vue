<template>
    <div>
        {{currentPlayerDomino}}
        {{layout}}
        <div class="container">
            <div class="jumbotron">
                <div v-if="error !== null" class="alert alert-danger">
                    {{error}}
                </div>
                <div v-for="player in players" :key="players.id">
                    {{player.name}}
                    <span v-for="domino in player.dominoes">
                        <span @dblclick="addDominoToGameArea(player, domino)">
                            <img class="p-1" :src="`../../images/dominoes/${domino}.png`" width=40 alt="">
                        </span>
                    </span>
                    <span v-if="currentPlayerDomino.name">
                        <button class="btn btn-sm btn-success" @click="addDominoToLayout">Apply</button>
                        <button class="btn btn-sm btn-danger" @click="removeCurrentSelectedDominoFromGameArea">Re-pick</button>
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
            :margin="[0, 3]"
            :use-css-transforms="false"
        >
            <grid-item v-for="item in layout"
                       :x="item.x"
                       :y="item.y"
                       :w="item.w"
                       :h="item.h"
                       :i="item.i"
                       :key="item.i">
                    <img height="95px" @dblclick="rotateRight(item.i)" :id="`rotateDomino${item.i}`" :src="`images/dominoes/${item.i}.png`"  alt="">
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
                playersRow: 0,
                layout: [],
                error: null,
                currentPlayerDomino: {},
                rotateAngle: 90,
                rotation: 0,
                currentRotationPosition: 0
            }
        },
        mounted() {
            this.fetchPlayers();
        },
        methods: {
            /**
             * Fetch all players in game.
             */
            fetchPlayers() {
                axios.get('players')
                    .then(response => {
                        this.players = response.data.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            /**
             * Get the info for the selected domino and add it
             * to the currentPlayerDomino object and the layout array.
             *
             * @param player
             * @param domino
             */
            addDominoToGameArea(player, domino) {
                if (this.currentPlayerDomino.name) {
                    return this.error = 'You can\t select more than 1 domino at a time.';
                }
                this.currentPlayerDomino = {
                    name: player.name,
                    i: domino
                };

                this.layout.push({
                    "name":player.name,
                    "x":0,
                    "y":0,
                    "w":1,
                    "h":2,
                    "r":0,
                    "i":domino,
                    "static":false
                });

                this.firstDominoStartingPosition();

                this.removeSelectedDominoFromSelectionArea(domino);
            },
            /**
             * Get the last object in the layout array and make it static.
             * Then clear currentPlayerDomino.
             */
            addDominoToLayout() {
                this.calculateCurrentDominoPositionOnBoard();
                this.getLastInLayout.static = true;
                this.currentPlayerDomino = {};
                this.error = null;
            },

            /**
             * Remove current domino from game area and put back in the players selection
             */
            removeCurrentSelectedDominoFromGameArea() {
                for (let i = 0; i < this.players.length; i++) {
                    if (this.players[i].name === this.currentPlayerDomino.name) {
                        this.players[i].dominoes.push(
                            this.currentPlayerDomino.i
                        )
                    }
                }

                this.layout.pop();
                this.currentPlayerDomino = {};
                this.error = null;
            },

            /**
             * First selected domino is forced to this area of the grid.
             */
            firstDominoStartingPosition() {
                if (this.layout.length === 1) {
                    this.getLastInLayout.x = 8;
                    this.getLastInLayout.y = 4;
                    this.getLastInLayout.r = 0;
                    this.getLastInLayout.static = true;
                }
            },
            /**
             * When selected domino is double clicked remove from the selection area.
             *
             * @param domino
             */
            removeSelectedDominoFromSelectionArea(domino) {
                for (let i = 0; i < this.players.length; i++) {
                    let index = this.players[i].dominoes.indexOf(domino);
                    if (index !== -1) this.players[i].dominoes.splice(index, 1);
                }
            },
            /**
             * Rotate domino right by 90 degrees.
             *
             * @param number
             */
            rotateRight(number) {
                if (this.layout.length === 1) {
                    return null;
                }

                if (this.currentRotationPosition > 270) {
                    this.currentRotationPosition = 0;
                }

                let dominoBeingClicked = document.getElementById("rotateDomino" + number)

                dominoBeingClicked.style.transform = 'rotate(' + (this.currentRotationPosition += this.rotateAngle) +'deg)';

                for (let i = 0; i < this.layout.length; i++) {
                    let layout = this.layout[i];

                    if (
                        layout.name === this.currentPlayerDomino.name &&
                        layout.i === this.currentPlayerDomino.i
                    ) {
                        if (this.currentRotationPosition === 90) {
                            dominoBeingClicked.classList.add('moveDominoToCorrectArea');
                            layout.h = 1;
                            layout.w = 2;
                        }

                        if (this.currentRotationPosition === 180) {
                            dominoBeingClicked.classList.remove('moveDominoToCorrectArea');
                            layout.h = 2;
                            layout.w = 1;
                        }

                        if (this.currentRotationPosition === 270) {
                            dominoBeingClicked.classList.add('moveDominoToCorrectArea');
                            layout.h = 1;
                            layout.w = 2;
                        }

                        if (this.currentRotationPosition === 360) {
                            dominoBeingClicked.classList.remove('moveDominoToCorrectArea');
                            layout.h = 2;
                            layout.w = 1;
                        }
                    }
                }
            },
            calculateRotationAndGridForCurrentDomino(currentRotation) {

                let xAxis = this.getLastInLayout.x;
                let yAxis = this.getLastInLayout.y;
                let width = this.getLastInLayout.w;
                let dominoNumbers = this.getLastInLayout.i;

                if (currentRotation === 0) {
                    return {
                        "x":xAxis,
                        "y":yAxis,
                        "x+1":(xAxis + 1),
                        "x-1":(xAxis - 1),
                        "y-1":(yAxis - 1),
                        "y-2":(yAxis - 2),
                        "y+2":(yAxis + 2),
                        "y+1":(yAxis + 1),
                        "i":dominoNumbers,
                        "r":currentRotation
                    };
                }
            },
            calculateRestOfLayout(currentRotation, layout) {

                let xAxis = layout.x;
                let yAxis = layout.y;

                if (currentRotation === 0) {
                    return {
                        "x":xAxis,
                        "y":yAxis
                    };
                }
            },
            /**
             * First function to calculate domino positions on board.
             *
             * @returns {null}
             */
            calculateCurrentDominoPositionOnBoard() {
                if (this.layout.length < 2) {
                    return null;
                }
                let info = this.calculateRotationAndGridForCurrentDomino(0);

                this.calculateMatchingDomino(info);
            },
            calculateMatchingDomino(info) {
                for (let i = 0; i < this.layout.length - 1; i++) {

                    let layout = this.calculateRestOfLayout(info['r'], this.layout[i]);

                    console.log((layout['x'] && layout['y']));
                    console.log((info['x-1'] && info['y-1']));

                    if ((info['x+1'] && info['y']) === (layout['x'] && layout['y'])) {
                        console.log('1')
                    }

                    if ((info['x-1'] && info['y']) === (layout['x'] && layout['y'])) {
                        console.log('2')
                    }

                    if ((info['y+2'] === layout['y']) === (layout['x'] && layout['y'])) {
                        console.log('3')
                    }

                    if ((info['y-2'] === layout['y']) === (layout['x'] && layout['y'])) {
                        console.log('4')
                    }

                    if ((info['x+1'] && info['y+1']) === (layout['x'] && layout['y'])) {
                        console.log('5')
                    }

                    if ((info['x-1'] && info['y+1']) === (layout['x'] && layout['y'])) {
                        console.log('6')
                    }

                    if ((info['x+1'] && info['y-1']) === (layout['x'] && layout['y'])) {
                        console.log('7')
                    }

                    if ((info['x-1'] && info['y-1']) === (layout['x'] && layout['y'])) {
                        console.log('8')
                    }
                    stop();
                }
            }
        },
        computed: {
            getLastInLayout() {
                return this.layout.slice(-1)[0];
            }
        },
        components: {
            GridLayout: VueGridLayout.GridLayout,
            GridItem: VueGridLayout.GridItem
        },
    }
</script>

<style>
    #rotateDomino {}

    .moveDominoToCorrectArea {
        margin-left: 24px;
        margin-top: -24px;
    }
</style>
