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
            if (this.validDeskName) {
                axios.post('/api/v1/desks/' + this.deskId, {
                    _method: 'PUT',
                    name: this.desk.name
                })
                .then(() => {

                })
            }
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
