<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card">
                    <h3 class="card-header">Enter your name</h3>

                    <div class="card-body">
                        <div>
                            <div class="form-group">
                                <div v-if="playerNames.length < 4">
                                    <label for="add_player">Add player</label>
                                    <input v-model="name" type="text" class="form-control" id="add_player">
                                    <div v-if="errorMessage">
                                        <div class="alert alert-danger mt-2 mb-0" role="alert">
                                            {{ errorMessage }}
                                        </div>
                                    </div>
                                    <div v-if="playerNames.length < 4">
                                        <button @click="addPlayer(name)" class="btn btn-primary mt-2">Submit</button>
                                    </div>
                                </div>
                                <div v-else>
                                    <div class="alert alert-success" role="alert">
                                        <strong>You maxed out!</strong> Let's play...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <ul  class="list-group">
                    <li v-for="(playerName, index) in playerNames" class="list-group-item">
                        {{ ++index }}. {{ playerName}}
                    </li>
                </ul>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div v-if="playerNames.length > 1">
                    <button @click="playGame" class="btn btn-success">Play Game</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'players',
        data() {
            return {
                errorMessage: null,
                name: null,
                playerNames: []
            }
        },
        methods: {
            addPlayer(name) {
                if (!name) {
                    return this.errorMessage = 'The name input can\'t be blank.'
                }
                this.playerNames.push(name);
                this.name = null;
                this.errorMessage = null;
            },
            playGame() {
                axios.post('players', {
                    player_names: this.playerNames
                })
                    .then(response => {
                        this.$router.push({ name: 'domino'})
                    })
                    .catch(error => {
                        console.error(error);
                    })
            }
        }
    }
</script>
