<template>
    <div class="container">
        <h3>Let's do this!</h3>
        <p>Click on the button and select 7 Dominoes</p>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <ul  class="list-group">
                    <li v-for="(player, index) in players" :key="player.name" class="list-group-item">
                        {{ ++index }}. {{ player.name}}
<!--                        <span v-if="player.dominoes !== null" class="bg-success float-right p-1 text-light" role="alert">-->
<!--                            You're ready to play-->
<!--                        </span>-->
                        <button @click="selectDominoes(player)" class="btn btn-primary btn-sm float-right">Select dominoes</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'domino',
        props: {
            players: {
                type: Array,
                required: true
            }
        },
        methods: {
            selectDominoes(player) {
                axios.post('/domino', {
                    id: player.id
                })
                    .then(() => {
                        window.location.href = '/select-dominoes'
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        },
    }
</script>
