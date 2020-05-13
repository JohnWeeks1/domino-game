<template>
    <div>
        <div v-if="!show">
            <players-component @play-game="show = $event" @player-names="playerNames = $event"/>
        </div>
        <div v-else>
            <domino-component :player-names="playerNames"></domino-component>
        </div>
    </div>
</template>

<script>
    import DominoComponent from "./DominoComponent";
    import PlayersComponent from "./PlayersComponent";
    export default {
        name: 'main',
        data() {
            return {
                show: false,
                playerNames: null,
            }
        },
        watch: {
            show(value) {
                this.show = value
            },
            playerNames(value) {
                this.show = value
            }
        },
        components: {
            DominoComponent,
            PlayersComponent
        }
    }
</script>
