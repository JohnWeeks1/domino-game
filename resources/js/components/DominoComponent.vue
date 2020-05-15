<template>
    <div class="container">
        <h3>Let's do this!</h3>
        <p>Click on the button and select 7 Dominoes</p>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <ul  class="list-group">
                    <li v-for="(player, index) in players" :key="index" class="list-group-item">
                        {{ ++index }}. {{ player.name }}
                        <span v-if="player.dominoes.length > 0" class="bg-success float-right p-1 text-light" role="alert">
                            You're ready to play
                        </span>
                        <router-link v-else
                            :to="{ name: 'domino.select', params: { player_id: player.id } }"
                            class="btn btn-primary btn-sm float-right">
                            Select dominoes
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'domino',
        data() {
            return {
                players: []
            }
        },
        mounted() {
            this.fetchPlayers();
        },
        methods: {
            fetchPlayers() {
                axios.get('players')
                    .then(response => {
                        this.players = response.data.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
    }
</script>
