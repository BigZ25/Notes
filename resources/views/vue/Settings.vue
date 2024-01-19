<template>
    <div>
        <ValidationObserver ref="settingsForm" v-slot="{ passes }" slim>
            <b-form>
                <b-card header="Ustawienia" header-text-variant="dark">
                    <b-col class="md-12">
                        <b-row>
                            <validation-provider v-slot="{ invalid, validated, errors }" vid="name">
                                <text-input v-model="form.name" label="Imię"
                                            :custom-class="{ 'border-danger': validated && invalid }"/>
                            </validation-provider>
                            <validation-provider v-slot="{ invalid, validated, errors }" vid="surname">
                                <text-input v-model="form.surname" label="Nazwisko"
                                            :custom-class="{ 'border-danger': validated && invalid }"/>
                            </validation-provider>
                            <validation-provider v-slot="{ invalid, validated, errors }" vid="email">
                                <text-input v-model="form.email" label="Adres e-mail"
                                            :custom-class="{ 'border-danger': validated && invalid }"/>
                            </validation-provider>
                        </b-row>
                        <b-row>
                            <validation-provider v-slot="{ invalid, validated, errors }" vid="new_password">
                                <password-input v-model="form.new_password" label="Nowe hasło"
                                                :custom-class="{ 'border-danger': validated && invalid }"/>
                            </validation-provider>
                            <validation-provider v-slot="{ invalid, validated, errors }"
                                                 vid="new_password_confirmation">
                                <password-input v-model="form.new_password_confirmation" label="Potwierdź nowe hasło"
                                                :custom-class="{ 'border-danger': validated && invalid }"/>
                            </validation-provider>
                        </b-row>
                    </b-col>
                </b-card>
                <div class="bg-white p-2 mt-3">
                    <b-button variant="primary" size="sm" class="p-0 m-0" @click="submit">
                        <div class="nav-link text-white">
                            <b-icon icon="save" class="mr-1"/>
                            Zapisz
                        </div>
                    </b-button>
                </div>
            </b-form>
        </ValidationObserver>
    </div>
</template>

<script>

import TextInput from "./components/form/TextInput"
import PasswordInput from "./components/form/PasswordInput"

export default {
    name: 'Settings',
    components: {
        TextInput,
        PasswordInput,
    },
    data: function () {
        return {
            form: {}
        }
    },
    methods: {
        copyToken: function () {
            navigator.clipboard.writeText(this.$auth.authToken).then(
                () => {
                    this.$bvToast.toast('Skopiowano', {
                        title: 'Powiadomienie',
                        variant: 'info',
                        autoHideDelay: 5000,
                    })
                })
        },
        getSettings: function () {
            this.form.name = this.$auth.user.name
            this.form.surname = this.$auth.user.surname
            this.form.email = this.$auth.user.email
            this.form.new_password = null
            this.form.new_password_confirmation = null
        },
        submit: function () {
            this.$http.put('/api/settings', this.form).then(response => {
                //TODO: update form after update - this.$auth.updateData(this.form.name, this.form.surname, this.form.email)
            }).catch(error => {
                if (error && error.data.errors) {
                    this.$refs.settingsForm.setErrors(error.data.errors)
                    console.log(errors)
                }
            })

            //     .catch(response => {
            //     this.errors = response.data.errors
            // })
        }
    },
    created() {
        this.getSettings()
    }
};
</script>
