<template>
    <div class="container">
        <h1>Доски</h1>
        <div class="row">
            <div class="alert alert-danger" role="alert" v-if="errored">
                Ошибка загрузки данных!
            </div>
            <div class="text-center" v-if="loading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="col-lg-4" v-for="(desk, index) in desks">
                <div class="card mt-3">
                    <div class="card-body">
                        <router-link
                            :to="{name: 'showDesk', params: {deskId: desk.id}}"
                            v-bind:deskId="desk.id"
                        >
                            <h5 class="card-title">{{desk.name}}</h5>
                        </router-link>
                        <button type="button" class="btn btn-danger" @click="removeDesk(index, desk.id)">Удалить доску</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Desks",
    data() {
        return {
            desks: [],
            errored: false,
            loading: true
        }
    },
    mounted() {
        axios.get('/api/v1/desks')
        .then(res => {
            this.desks = res.data.data
        })
        .catch(error => {
            this.errored = true
            console.log(error)
        })
        .finally(() => {
            this.loading = false
        })

    },
    methods: {
        removeDesk(index, deskId) {
            if(confirm('Вы действиетльно хотите удалить доску?')) {
                axios.post('/api/v1/desks/' + deskId, {
                    _method: 'DELETE',
                })
                    .then(res => {
                        this.desks.splice(index, 1)
                    })
            }
        },
    }
}
</script>

<style scoped>

</style>
