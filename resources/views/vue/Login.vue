<template>
    <div>
        <b-modal id="loginFormModal" title="Logowanie" hide-header-close no-close-on-backdrop no-close-on-esc ok-only ok-title="Zaloguj się" @ok="submit">
            <ValidationObserver ref="loginForm" v-slot="{ passes }" slim>
                <b-form>
                    <b-col class="md-12">
                        <b-row>
                            <validation-provider v-slot="{ invalid, validated, errors }" vid="email">
                                <text-input v-model="form.email" label="Adres e-mail" :custom-class="{ 'border-danger': validated && invalid }"/>
                            </validation-provider>
                        </b-row>
                        <b-row>
                            <validation-provider v-slot="{ invalid, validated, errors }" vid="password">
                                <password-input v-model="form.password" label="Hasło" :custom-class="{ 'border-danger': validated && invalid }"/>
                            </validation-provider>
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
    name: 'Login',
    components: {
        TextInput,
        PasswordInput
    },
    data: function () {
        return {
            form: {
                email: null,
                password: null
            }
        }
    },
    methods: {
        submit: function (bvModalEvent) {
            bvModalEvent.preventDefault()

            this.$http.post('/api/login', this.form).then(response => {
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
        this.$bvModal.show('loginFormModal')
    }
}
</script>
