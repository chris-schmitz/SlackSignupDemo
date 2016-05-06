let Vue = require('vue')
let vueForm = require('vue-form')
let vueResource = require('vue-resource')
window.$ = require('jquery')
let bootstrap = require('bootstrap-sass')

Vue.use(vueForm)
Vue.use(vueResource)

// once you've got all of this hammered out. Extract the logic into it's own signupform component.
// you'll need to do this to use the vue router anyway (I believe).
// Also, when you implement the router, put some sweet animate.css transitions in! (guitar squeal)

let Notifications = Vue.extend({
    template: '#notifications',
    props:['notification']
});

new Vue({
    el: 'body',
    components:{
        'notifications': Notifications
    },
    data: {
        token: null,
        invites: {
            meetup: true,
            slack: true
        },
        signupForm: null,
        email: {
            value: null,
            isRequired: false
        },
        name:{
            first: null,
            last: null
        },
        notification:{
            show: false,
            type: 'danger',
            message: 'test!!'
        }
    },
    watch:{
        'invites.slack': 'toggleMeetupInvite',
        'invites.meetup': 'toggleSlackInvite',
    },
    ready: function (){
        let me = this
        // We're adding this watcher once the component is ready 
        // because at the time that the vue instance's watch property 
        // is built up the signupForm has not yet been set by vue-form.
        me.$watch( 
            () => { return me.signupForm.email.$touched },
            (newValue, oldValue) => {
            me.email.isRequired = newValue === true
        })

        this.token = document.getElementById('token').getAttribute('value') || null
    },
    computed:{
        emailHasError: function (){
            return this.signupForm.email.$invalid
        },
        formIsValid: function (){
            let invitesAreValid = this.invites.meetup || this.invites.slack
            let emailIsValid = this.email.value !== null && this.emailHasError === false
            return invitesAreValid && emailIsValid
        }
    },
    methods: {
        // note that with these two toggle methods and their associated
        // watchers, the logic only works if we have two things to invite
        // to. If we ever add more than two we would need to adjust this 
        // logic.
        toggleMeetupInvite: function (slackValue){
            if(slackValue === false && this.invites.meetup === false){
                this.invites.meetup = true
            }
        },
        toggleSlackInvite: function (meetupValue){
            if(meetupValue === false && this.invites.slack === false){
                this.invites.slack = true
            }
        },
        submit: function (){
            if(!this.formIsValid){
                return
            }

            let me = this
            let payload = this.buildPayload()

            this.$http({
                url: 'signup',
                method: 'POST',
                data: payload      
            }).then((response) => {
                debugger
                console.log('submitted successfully')
                // switch to success view
            }, (response) => {
                debugger
                // show an alert error message and let them try again
                console.log('error submitting')
            })
            // ajax post to server
            // show success page (vue router?)
        },
        buildPayload: function (){
            return {
                invites: this.invites,
                name: this.name,
                email: this.email.value,
                "_token": this.token
            }
        }
    }
})
