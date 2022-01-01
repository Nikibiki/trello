<template>
    <div class="container">
        <div class="alert alert-danger" role="alert" v-if="errored">
            Ошибка загрузки данных!
        </div>
        <div class="text-center" v-if="loading">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="input-group mb-3" v-if="desk">
            <input type="text" v-model="desk.name" class="form-control" placeholder="Desk name" @blur="saveName">
        </div>
    </div>
</template>

<script>
export default {
    name: "Desk",
    props: ['deskId'],
    data() {
        return {
            desk: null,
            errored: false,
            loading: true
        }
    },
    mounted() {
        axios.get('/api/v1/desks/' + this.deskId)
        .then(res => {
            this.desk = res.data.data
        })
        .catch(error => {
            this.errored = true
        })
        .finally(() => {
            this.loading = false
        })
    },
    methods: {
        saveName() {
            console.log(this.deskId)
            axios.post('/api/v1/desks/' + this.deskId, {
                _method: 'PUT',
                name: this.desk.name
            })
            .then(() => {

            })
        }
    }
}
</script>

<style scoped>

</style>
