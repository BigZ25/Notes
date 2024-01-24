import VueRouter from 'vue-router'
import Notes from "../views/vue/Notes.vue"
import Settings from "../views/vue/Settings.vue"
import Login from "../views/vue/Login.vue"
import Register from "../views/vue/Register.vue"
import Auth from './plugins/auth.js'

const routes = [
    {
        path: "/",
        name: "Notes",
        component: Notes,
        meta: {
            requiresAuth: true,
            label: 'Notatki'
        }
    },
    {
        path: "/settings",
        name: "Settings",
        component: Settings,
        meta: {
            requiresAuth: true,
            label: 'Ustawienia'
        }
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
        meta: {
            label: 'Logowanie'
        }
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
        meta: {
            label: 'Rejestracja'
        }
    },
]

const router = new VueRouter({
    mode: 'history',
    routes: routes
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.label ? to.meta.label + ' - notes' : 'Notes'
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (Auth.check()) {
            return next()
        } else {
            router.push('/login')
        }
    } else {
        if (Auth.check() && to.name === 'Login') {
            router.push('/')
        } else {
            next()
        }
    }
})

export default router
