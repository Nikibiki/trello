<template>
    <div class="container">
        <h1>{{ desk.name }}</h1>
        <div class="alert alert-danger" role="alert" v-if="errored">
            Ошибка загрузки данных!
        </div>
        <div class="text-center" v-if="loading">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="input-group mb-3" v-if="desk">
            <input type="text" v-model="desk.name" class="form-control" :class="[validDeskName ? 'is-valid' : 'is-invalid']" placeholder="Desk name" @blur="saveName">
            <div class="valid-feedback" v-if=!$v.desk.name.$error>
                Looks good!
            </div>
            <div class="invalid-feedback" v-if="!$v.desk.name.required">
                Поле обязательно для заполнения!
            </div>
            <div class="invalid-feedback" v-if=!$v.desk.name.minLength>
                Минимальное количество символов ({{$v.desk.name.$params.minLength.min}})!
            </div>
        </div>
        <form @submit.prevent="addList">
            <div class="mb-3">
                <input type="text" class="form-control" id="newList" placeholder="Введите название нового списка" v-model="newListName">
            </div>
            <button type="submit" class="btn btn-primary">Создать список</button>
        </form>
        <div class="row">
            <div class="text-center" v-if="listsLoading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="col-lg-4" v-for="(list, index) in lists">
                <div class="card mt-3">
                    <div class="card-body">
                        <router-link
                            :to="{name: 'showDesk', params: {deskId: list.id}}"
                            v-bind:deskId="list.id"
                        >
                            <h5 class="card-title">{{list.name}}</h5>
                        </router-link>
                        <button type="button" class="btn btn-danger" @click="removeList(index, list.id)">Удалить список</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { required, minLength } from 'vuelidate/lib/validators'
export default {
    name: "Desk",
    props: ['deskId', 'name'],
    data() {
        return {
            desk: null,
            lists: [],
            errored: false,
            loading: true,
            listsLoading: false,
            newListName: '',
        }
    },
    mounted() {
        axios.get('/api/v1/desks/' + this.deskId)
        .then(res => {
            this.desk = res.data.data
            this.lists = this.desk.lists
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
            if (this.validDeskName) {
                axios.post('/api/v1/desks/' + this.deskId, {
                    _method: 'PUT',
                    name: this.desk.name
                })
                .then(() => {

                })
            }
        },
        getLists() {
            axios.get('api/v1/lists', {
                params: {
                    desk_id: this.desk_id
                }
            })
            .then(res => {
                console.log(res.data)
            })
        },
        removeList(index, listId) {
            axios.post('/api/v1/lists/' + listId, {
                _method: 'delete',
            })
            .then(res => {
                this.lists.splice(index, 1)
            })
        },
        addList() {
            axios.post('/api/v1/lists', {
                desk_id: this.desk.id,
                name: this.newListName,
            })
            .then(res => {
                this.lists.unshift(res.data.data)
            })
        }
    },
    validations: {
        desk: {
            name: {
                required,
                minLength: minLength(4),
            }
        },
    },
    computed: {
        validDeskName() {
            return this.$v.desk.name.required && this.$v.desk.name.minLength;
        },
    }
}
</script>

<style scoped>

</style>
