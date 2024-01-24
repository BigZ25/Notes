<template>
    <div>
        <b-modal id="registerFormModal" title="Rejestracja" hide-header-close no-close-on-backdrop no-close-on-esc
                 ok-only
                 ok-title="Załóż konto" @ok="submit">
            <ValidationObserver ref="registerForm" v-slot="{ passes }" slim>
                <b-form>
                    <b-col class="md-12">
                        <b-row>
                            <validation-provider v-slot="{ invalid, validated, errors }" vid="name">
                                <text-input v-model="form.name" label="Imię"
                                            :custom-class="{ 'border-danger': validated && invalid }"/>
                            </validation-provider>
                        </b-row>
                        <b-row>
                            <validation-provider v-slot="{ invalid, validated, errors }" vid="surname">
                                <text-input v-model="form.surname" label="Nazwisko"
                                            :custom-class="{ 'border-danger': validated && invalid }"/>
                            </validation-provider>
                        </b-row>
                        <b-row>
                            <validation-provider v-slot="{ invalid, validated, errors }" vid="email">
                                <text-input v-model="form.email" label="Adres e-mail"
                                            :custom-class="{ 'border-danger': validated && invalid }"/>
                            </validation-provider>
                        </b-row>
                        <b-row>
                            <validation-provider v-slot="{ invalid, validated, errors }" vid="password">
                                <password-input v-model="form.password" label="Hasło"
                                                :custom-class="{ 'border-danger': validated && invalid }"/>
                            </validation-provider>
                        </b-row>
                        <b-row>
                            <router-link to="/login" class="form-group text-dark m-2 mb-0">
                                Przejdź do logowania
                            </router-link>
                        </b-row>
                    </b-col>
                </b-form>
            </ValidationObserver>
        </b-modal>
    </div>
</template>

<script>

import TextInput from './components/form/TextInput'
import PasswordInput from './components/form/PasswordInput'

export default {
    name: 'Register',
    components: {
        TextInput,
        PasswordInput
    },
    data: function () {
        return {
            form: {
                name: null,
                surname: null,
                email: null,
                password: null
            }
        }
    },
    methods: {
        submit: function (bvModalEvent) {
            bvModalEvent.preventDefault()

            this.$http.post('/api/register', this.form).then(response => {
                let data = response.data.data.session
                this.$auth.login(data.access_token, data.user, data.auth_token)

                this.$router.push({name: 'Notes'});
            }).catch(error => {
                // if (error && error.data.errors) {
                //     this.$refs.loginForm.setErrors(error.data.errors)
                //     console.log(errors)
                // }
            })
        }
    },
    mounted() {
        this.$bvModal.show('registerFormModal')
    }
}
</script>
