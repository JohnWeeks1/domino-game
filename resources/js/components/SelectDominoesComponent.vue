<template>
    <div class="container">
        {{dominoes}}
        <div v-if="dominoes.length > 6">
            <h3>Now submit your selection</h3>
            <button @click="saveSelectedDominoes" v-if="dominoes.length > 6" class="btn btn-primary btn-sm ">Submit selection</button>
        </div>
        <div v-if="dominoes.length < 7">
            <h3>{{ name }}, click the ones you like the most...</h3>
        </div>

        <hr>
        <div v-if="dominoes.length < 7" class="row">
            <div class="col-md-12 text-center">
                <div class="row">
                    <div v-for="cardNumber in allCardNumbers" class="col-3 p-4 " :key="cardNumber">
                        <div class="cursor-pointer text-white-50 bg-dark" @click="playerPicksCards(cardNumber)">
                            <h3 class="py-2 pointer">{{ cardNumber }}</h3>
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
                allCardNumbers: [],
                dominoes: []
            }
        },
        mounted() {
            this.numbers();
        },
        props: {
            name: {
                type: String,
                required: true
            }
        },
        methods: {
            playerPicksCards(value) {
                this.dominoes.push(value);

                // Thank god for stackoverflow lol
                let index = this.allCardNumbers.indexOf(value);
                if (index !== -1) this.allCardNumbers.splice(index, 1);
            },
            numbers() {
                for (let i = 1; i < 29; i++) {
                    this.allCardNumbers.push(i);
                }
            },
            saveSelectedDominoes() {
                axios.post('/select-dominoes', {
                    name: this.name,
                    dominoes: this.dominoes
                })
                    .then(response => {
                        console.log(response.status);
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
</style>
