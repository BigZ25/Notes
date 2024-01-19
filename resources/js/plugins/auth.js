import Vue from 'vue'
import VueResource from 'vue-resource'

Vue.use(VueResource)

class Auth {
    constructor() {
        this.token = window.localStorage.getItem('token')
        this.authToken = window.localStorage.getItem('auth_token')
        let userData = window.localStorage.getItem('user')
        this.user = userData ? JSON.parse(userData) : null

        if (this.token) {
            Vue.http.interceptors.push((request, next) => {
                request.headers.set('Authorization', 'Bearer ' + this.token)
                next()
            })
        }
    }

    login(token, user, authToken) {
        window.localStorage.setItem('token', token)
        window.localStorage.setItem('auth_token', authToken)
        window.localStorage.setItem('user', JSON.stringify(user))
        Vue.http.interceptors.push((request, next) => {
            request.headers.set('Authorization', 'Bearer ' + this.token)
            next()
        })

        this.token = token
        this.user = user
    }

    check() {
        return !!this.token
    }

    logout() {
        window.localStorage.removeItem('token')
        window.localStorage.removeItem('auth_token')
        window.localStorage.removeItem('user')
        Vue.http.interceptors.push((request, next) => {
            request.headers.set('Authorization', '')
            next()
        })
        this.token = null
        this.user = null
    }
}

export default new Auth()
