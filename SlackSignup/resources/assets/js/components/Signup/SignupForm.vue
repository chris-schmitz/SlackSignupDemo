<script>
    module.exports = {
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
        events:{
            resendInvites: 'resendInvites'
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
            submit: function (config){
                if(!this.formIsValid){
                    return
                }

                let me = this
                let resend = config.resendInvites || false
                let payload = this.buildPayload(resend)

                me.$dispatch('toggleMask', true, "Submitting")

                me.$http({
                    url: 'signup', 
                    method: 'POST',
                    data: payload      
                })
                .then((response) => {
                    this.submitted = true

                    let notificationPayload = {
                        type: 'success',
                        message: response.data.message
                    }

                    me.$dispatch('toggleMask', false)
                    me.$dispatch('showNotification', notificationPayload)

                })
                .catch((response) => {
                    let notificationPayload = null

                    if(response.status === 409){
                        notificationPayload = {
                            type: 'warning',
                            message: response.data.message,
                            showResendButton: true
                        }
                    } else {
                        notificationPayload = {
                            type: 'danger',
                            message: `There was an error with your submission: "${ response.data.message }".`
                        }
                    }

                    me.$dispatch('toggleMask', false)
                    me.$dispatch('showNotification', notificationPayload)
                })
                // ajax post to server
                // show success page (vue router?)
            },
            buildPayload: function (resend){
                return {
                    invites: this.invites,
                    name: this.name,
                    email: this.email.value,
                    "_token": this.token,
                    resend: resend
                }
            },
            resendInvites: function (){
                this.submit({resendInvites: true});
            }
        }
    }    
</script>
<template>
    <p>
        <form v-form v-show="!submitted" name="signupForm">
            Submitting your email on this form will (<i>you must select at least one</i>):
            <ul>
                <li class="checkbox">
                    <label>
                        <input type="checkbox" name="invites[]" value="meetup" v-model="invites.meetup" class="checkbox">Add you to the Meetup group.
                    </label>
                </li>
                <li class="checkbox">
                    <label>
                        <input type="checkbox" name="invites[]" value="slack" v-model="invites.slack" class="checkbox">Add you to the Slack chat
                    </label>
                </li>
            </ul>

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label for="email">First Name</label>
                        <div>
                            <input type="text" name="nameFirst" v-model="name.first" class="form-control" placeholder='optional'>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Last Name</label>
                        <div>
                            <input type="text" name="nameLast" v-model="name.last" class="form-control" placeholder='optional'>
                        </div>
                    </div>
                    <div class="form-group" :class="{'has-error': emailHasError}">
                        <label for="email">Email</label>
                        <div>
                            <input type="email" name="email" v-model="email.value" v-form-ctrl :required="email.isRequired" class="form-control" placeholder='required'>
                            <span v-show="emailHasError" class="help-block">You need to provide an email to sign up.</span>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div type="submit" @click="submit" class="btn btn-success" :class="{'disabled': !formIsValid}">Submit</div>
                </div>
            </div>
        </form>
    </p> 
</template>

<style>
</style>