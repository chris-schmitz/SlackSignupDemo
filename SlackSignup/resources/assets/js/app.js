let Vue = require('vue')
let vueForm = require('vue-form')
let vueResource = require('vue-resource')

Vue.use(vueForm)
Vue.use(vueResource)

Vue.transition('flip', {
    enterClass: 'flipInX',
    leaveClass: 'flipOutX'
})

let SignupComponent = require('./components/Signup/SignupComponent.vue')

new Vue({
    el: 'body',
    components:{
        signupcomponent: SignupComponent
    }
})
