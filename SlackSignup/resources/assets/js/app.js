let Vue = require('vue')
let vueForm = require('vue-form')

Vue.use(vueForm)

new Vue({
    el: 'body',
    data: {
        invites: {
            meetup: false,
            slack: false
        },
        signupForm: null,
        email: {
            value: null,
            isRequired: false
        },
        name:{
            first: null,
            last: null
        }
    },
    ready: function (){
        let me = this
        me.$watch( 
            () => { return me.signupForm.email.$touched },
            (newValue, oldValue) => {
            me.email.isRequired = newValue === true
        })
    },
    computed:{
        emailHasError: function (){
            return this.signupForm.email.$invalid
        }
    },
    methods: {
        submit: function (){
            debugger;
        }
    }
})
