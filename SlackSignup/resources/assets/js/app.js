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

let Notifications = Vue.extend({
    template: '#notifications',
    data: () => {
        return {
            notification:{
                show: false,
                type: null,
                message: null
            },
        }
    },
    events:{
        showNotification: 'showNotification'
    },
    methods: {
        showNotification: function (payload){
            // since we're using the es6 rest parameter in the parent component to pass the payload through
            // it's going to come in as an array. That said, there may be other instances where we just pass
            // an object in. This check will allow us to handle either scenario. 
            let notificationData = Array.isArray(payload) ? payload[0] : payload
            this.notification.type = notificationData.type || 'info'
            this.notification.message = notificationData.message || '??! the dev f-ed something up :/'
            this.notification.show = true
        },
        hideNotification: function (){
            this.notification.show = false
        }
    }
});

let SignupForm = Vue.extend({
    template: '#signupForm',
    components:{
        notifications: Notifications
    },
    data: () => {
        return {
            token: null,
            submitted: false,
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
            }
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

            me.$http({
                url: 'signup',
                method: 'POST',
                data: payload      
            }).then((response) => {
                this.submitted = true
                
                let notificationPayload = {
                    type: 'success',
                    message: "Your invites have been submitted."
                }

                me.$dispatch('showNotification', notificationPayload)

            }, (response) => {
                let notificationPayload = {
                    type: 'danger',
                    message: "There was an error with your submission. Please try again."
                }

                me.$dispatch('showNotification', notificationPayload)
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

new Vue({
    el: 'body',
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
        }
    },
    data: {}
})
