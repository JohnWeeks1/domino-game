<template>
    <div class="container">
        <div v-if="dominoes.length > 6">
            <h3>Now submit your selection</h3>
            <button @click="saveSelectedDominoes" v-if="dominoes.length > 6" class="btn btn-primary btn-sm ">Submit selection</button>
        </div>
        <div v-if="dominoes.length < 7">
            <h3>{{ playerInSession.name }}, click the ones you like the most...</h3>
        </div>
        <div v-if="dominoes.length > 0" class="row p-3">
            <div v-for="domino in dominoes" :key="domino">
                <img class="p-1" :src="`images/dominoes/${domino}.png`" width=40 alt="">
            </div>
        </div>

        <hr>

        <div v-if="dominoes.length < 7">
            <div class="col-md-12 text-center">
                <div class="row">
                    <div v-for="dominoNumber in allDominoNumbers" class="col-3 p-1" :key="dominoNumber">
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
        name: 'domino',
        data() {
            return {
                allDominoNumbers: [],
                dominoes: []
            }
        },
        mounted() {
            this.numbers();
        },
        props: {
            playerInSession: {
                type: Object,
                required: true
            },
            usedDominoes: {
                type: Array,
                required: false
            }
        },
        methods: {
            playerPicksDominoes(value) {
                this.dominoes.push(value);

                let index = this.allDominoNumbers.indexOf(value);
                if (index !== -1) this.allDominoNumbers.splice(index, 1);
            },
            numbers() {
                for (let i = 0; i < 7; i++) {
                    for (let j = 0; j < 7; j++) {
                        if (j > i -1) {
                            let numbers = i + '-' + j;
                            this.allDominoNumbers.push(numbers);
                        }
                    }
                }
                this.allDominoNumbers = this.allDominoNumbers.filter(val =>
                    !this.usedDominoes.includes(val)
                );
            },
            saveSelectedDominoes() {
                axios.post('/select-dominoes', {
                    name: this.name,
                    dominoes: this.dominoes
                })
                    .then(() => {
                        window.location.href = '/domino';
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
