let Vue = require('vue')
let vueForm = require('vue-form')
let vueResource = require('vue-resource')

Vue.use(vueForm)
Vue.use(vueResource)

Vue.transition('flip', {
    enterClass: 'flipInX',
    leaveClass: 'flipOutX'
})

// once you've got all of this hammered out. Extract the logic into it's own signupform component.
// you'll need to do this to use the vue router anyway (I believe).
// Also, when you implement the router, put some sweet animate.css transitions in! (guitar squeal)

let Notifications = require('./components/Notifications.vue')
let SignupForm = require('./components/SignupForm.vue')

new Vue({
    el: 'body',
    components:{
        'notifications': Notifications,
        'signup-form': SignupForm
    },
    data: {},
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
        }
    }
})
