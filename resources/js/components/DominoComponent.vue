<template>
    <div class="container">
        <h3>Let's do this!</h3>
        <p>Click on the button and select 7 Dominoes</p>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <ul  class="list-group">
                    <li v-for="(playerName, index) in playerNames" :key="playerName" class="list-group-item">
                        {{ ++index }}. {{ playerName}}
                        <button @click="selectDominoes(playerName)" class="btn btn-primary btn-sm float-right">Select dominoes</button>
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
            playerNames: {
                type: Array,
                required: true
            }
        },
        methods: {
            selectDominoes(name) {
                axios.post('/domino', {
                    name: name
                })
                    .then(response => {
                        if (response.status === 200) {
                            window.location.href = '/select-dominoes'
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        },
    }
</script>
