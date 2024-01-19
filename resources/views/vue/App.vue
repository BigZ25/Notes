<template>
    <b-container fluid>
        <b-row>
            <b-col class="bg-content text-white p-2">
                <div :class="loading === true ? 'd-none' : ''">
                    <div class="w-100">
                        <b-row class="m-0">
                            <b-col cols="6" class="p-2">
                                <h2 class="m-2">
                                    <router-link to="/" class="a-link">
                                        Notes
                                    </router-link>
                                </h2>
                            </b-col>
                            <b-col cols="6" class="p-2 text-right" v-if="$auth.check()">
                                <span class="text-white m-2">
                                    <b-icon icon="person-circle"/>
                                    {{ $auth.user.email }}
                                </span>
                                <router-link to="/settings" class="a-link m-2">
                                    <b-icon icon="gear"/>
                                    Ustawienia
                                </router-link>
                                <span role="button" class="m-2" @click="logout">
                                    <b-icon icon="power"/>
                                    Wyloguj się
                                </span>
                            </b-col>
                        </b-row>
                    </div>
                    <div class="p-2 m-2">
                        <router-view/>
                    </div>
                </div>
                <loading-spinner v-if="loading"/>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import LoadingSpinner from "./components/LoadingSpinner";
import EventBus from "../../js/app";

export default {
    name: 'App',
    components: {
        LoadingSpinner
    },
    computed: {},
    data() {
        return {
            loading: false,
            state: null,
        };
    },
    methods: {
        logout() {
            this.$http.post('/api/logout').then(() => {
                this.$auth.logout();
                this.$router.push('/login');
            })
                .catch((error) => {
                    console.log(error);
                });
        }
    },
    created() {
        // EventBus.$on('http-request-start', () => {
        //     this.loading = true;
        // });
        //
        // EventBus.$on('http-request-end', () => {
        //     this.loading = false;
        // });
    },
};
</script>
