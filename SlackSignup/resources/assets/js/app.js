let Vue = require('vue')
let vueForm = require('vue-form')
let vueResource = require('vue-resource')
let VueRouter = require('vue-router')

Vue.use(vueForm)
Vue.use(vueResource)
Vue.use(VueRouter)

let router = new VueRouter()

Vue.transition('flip', {
    enterClass: 'flipInX',
    leaveClass: 'flipOutX'
})

let Notifications = require('./components/Notifications.vue')
let SignupForm = require('./components/SignupForm.vue')
let Success = require('./components/Success.vue')

let App = Vue.extend({
    // el: 'body',
    components:{
        'notifications': Notifications,
        'signup-form': SignupForm
    },
    // Note: first we're going to do event passing between components
    // once you get that working and committed, refactor to use vuex
    // for shared state. It's not really needed in this simple system, 
    // but it would be cool to work with :P
    events:{
        showNotification: function (...payload){
            this.$broadcast('showNotification', payload)
        },
        resendInvites: function (){
            this.$broadcast('resendInvites')
        },
        showSuccess: function (...payload){
            debugger;
            router.go('/success')
            
        }
    }
})


router.map({
    form: {
        component: SignupForm
    },
    success:{
        component: Success
    }
})

router.start(App, 'body')