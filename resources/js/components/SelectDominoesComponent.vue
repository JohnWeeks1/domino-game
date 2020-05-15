<template>
    <div class="container">
        <div v-if="dominoes.length > 6">
            <h3>Now submit your selection</h3>
            <button @click="saveSelectedDominoes" v-if="dominoes.length > 6" class="btn btn-primary btn-sm ">Submit selection</button>
        </div>
        <div v-if="dominoes.length < 7">
            <h3>{{ player.name }}, click the ones you like the most...</h3>
        </div>
        <div v-if="dominoes.length > 0" class="row p-3">
            <div v-for="domino in dominoes" :key="domino">
                <img class="p-1" :src="`../../images/dominoes/${domino}.png`" width=40 alt="">
            </div>
        </div>

        <hr>

        <div v-if="dominoes.length < 7">
            <div class="col-md-12 text-center">
                <div class="row">
                    <div v-for="dominoNumber in availableDominoes" class="col-3 p-1" :key="dominoNumber">
                        <div class="cursor-pointer" @click="playerPicksDominoes(dominoNumber)">
                            <div class="py-3 bg-dark text-white-50 px-1 pointer domino-width">{{ dominoNumber }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'select-dominoes',
        data() {
            return {
                availableDominoes: [],
                unavailableDominoes: [],
                dominoes: [],
                player: {}
            }
        },
        mounted() {
            this.numbers();
            this.fetchPlayer();
            this.fetchAllUnavailableDominoes();


        },
        methods: {
            fetchPlayer() {
                axios.post('players/'+this.$route.params.player_id)
                    .then(response => {
                        this.player = response.data.data;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            fetchAllUnavailableDominoes() {
                axios.get('dominoes')
                    .then(response => {
                        this.unavailableDominoes = response.data.data;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            playerPicksDominoes(value) {
                this.dominoes.push(value);

                let index = this.availableDominoes.indexOf(value);
                if (index !== -1) this.availableDominoes.splice(index, 1);
            },
            numbers() {
                for (let i = 0; i < 7; i++) {
                    for (let j = 0; j < 7; j++) {
                        if (j > i -1) {
                            let numbers = i + '-' + j;
                            this.availableDominoes.push(numbers);
                        }
                    }
                }
                this.removeUnavailableDominoes();
            },
            removeUnavailableDominoes() {
                setTimeout(() => {
                    this.availableDominoes = this.availableDominoes.filter(val =>
                        !this.unavailableDominoes.includes(val)
                    );
                }, 200)
            },
            saveSelectedDominoes() {
                axios.post('/select-dominoes', {
                    player_id: this.player.id,
                    dominoes: this.dominoes
                })
                    .then(() => {
                        this.$router.push({ name: 'player-list' });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        },
    }
</script>

<style scoped>
    .cursor-pointer {
        cursor: pointer;
    }

    .domino-width {
        max-width: 70%;
    }
</style>
