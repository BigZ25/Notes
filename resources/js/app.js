import './bootstrap'
import Vue from 'vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'
import App from '../views/vue/App.vue'
import router from './routes.js'
import {BootstrapVue, IconsPlugin} from 'bootstrap-vue'
import {ValidationProvider, ValidationObserver} from 'vee-validate'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

//plugins
import {enumerate} from './plugins/enum'
import Format from './plugins/format.js'
import Auth from './plugins/auth.js'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueRouter)
Vue.use(VueResource)

Vue.component('ValidationProvider', ValidationProvider)
Vue.component('ValidationObserver', ValidationObserver)

const EventBus = new Vue()

Vue.http.get('/api/state').then(response => {
    Vue.prototype.$state = response.body.data
    Vue.prototype.$enum = enumerate
    Vue.prototype.$format = Format
    Vue.prototype.$auth = Auth
    // Vue.prototype.errors = 123
    new Vue({
        router,
        render: (h) => h(App),
        created() {
            Vue.http.interceptors.push((request, next) => {
                EventBus.$emit('http-request-start')

                const csrfToken = document.querySelector('input[name="_token"]').value
                request.headers.set('X-CSRF-TOKEN', csrfToken)

                next((response) => {
                    if (response.status === 200) {
                        this.$bvToast.toast(response.data.data.message, {
                            title: response.data.data.title ?? 'Powiadomienie',
                            variant: response.data.data.type ?? 'info',
                            autoHideDelay: 5000,
                        })
                    }

                    if (response.status === 422) {
                        for (let key in response.body.errors) {
                            this.$bvToast.toast(response.body.errors[key], {
                                title: 'Błąd',
                                variant: 'danger',
                                autoHideDelay: 5000,
                            })
                        }

                        //this.errors = response.data.errors
                    }

                    if (response.status === 401) {
                        this.$bvToast.toast(response.body.message, {
                            title: 'Błąd',
                            variant: 'danger',
                            autoHideDelay: 5000,
                        })

                        router.push('/login')
                    }

                    EventBus.$emit('http-request-end')
                })
            })
        }
    }).$mount('#app')
})

export default EventBus

