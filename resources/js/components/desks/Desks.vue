<template>
    <div class="container">
        <h1>Доски</h1>
        <div class="row">
            <form @submit.prevent="createDesk(name)">
                <div class="row">
                    <div class="input-group mb-3 col-sm">
                        <input type="text" class="form-control" placeholder="Имя новой доски" v-model="name" @change="callValid" :class="[$v.name.$error ? 'is-invalid' : 'is-valid']">
                        <button class="btn btn-primary" type="submit" id="button-addon2" v-if="!$v.name.$error && name">Create desk</button>
                        <div class="invalid-feedback" v-if="!$v.name.required && name">
                            Поле обязательно для заполнения!
                        </div>
                        <div class="invalid-feedback" v-if="!$v.name.minLength && name">
                            Минимальное количество символов ({{$v.name.$params.minLength.min}})!
                        </div>
                        <div class="invalid-feedback" v-if="!$v.name.isUnique && name">
                            Имя доски уже занято!
                        </div>
                    </div>
                    <div class="alert alert-danger" role="alert" v-if="errored">
                        Ошибка загрузки данных! <br>
                        {{errors[0]}}
                    </div>
                    <div class="alert alert-success" role="alert" v-if="created">
                        Доска {{ name }} успешно создана!
                    </div>
                </div>
            </form>
        </div>
        <div class="row">

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
import {required, minLength} from 'vuelidate/lib/validators'
export default {
    name: "Desks",
    data() {
        return {
            desks: [],
            errored: false,
            loading: true,
            name: '',
            errors: [],
            created: false
        }
    },
    mounted() {
        setTimeout(() => {
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
        }, 500)
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
        createDesk(name) {
            this.errored = this.created = false
            axios.post('/api/v1/desks/', {
                name: this.name
            })
            .then(res => {
                this.desks.unshift(res.data.data)
                this.created = true
            })
            .catch(error => {
                this.errors.push(error.response.data.errors.name[0])
                this.errored = true
            })
        },
        callValid() {

        },
        isUnique() {
            return false;
        }
    },
    watch: {
        name: function(newName, oldName) {
            this.$v.$touch()
        },
    },
    validations: {
        name: {
            required,
            minLength: minLength(4),
            isUnique: (name, v = this) => {
                return (v.desks.find(el => el.name === name)) ? false : true
            },
        }
    }
}
</script>

<style scoped>
    a {
        text-decoration: none;
    }
</style>
