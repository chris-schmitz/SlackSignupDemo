<script>
    module.exports = {
        data: () => {
            return {
                notification:{
                    show: false,
                    showResendButton: false,
                    type: null,
                    message: null,
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
                this.notification.showResendButton = notificationData.showResendButton || false
            },
            hideNotification: function (){
                this.notification.show = false
            },
            resendInvites: function (){
                this.$dispatch('resendInvites');
            }
        }
    }    
</script>
<template>
     <div v-show="notification.show" class="animated" transition="flip">

        <div class="alert alert-{{notification.type}} alert-dismissible" role="alert">
            <button type="button" class="close" @click="hideNotification" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p>
                <strong>{{notification.type | capitalize}}!</strong> {{notification.message | capitalize}}
            </p>
            <p v-show="notification.showResendButton">
                Would you like to resend your invitation(s)? <button class="btn btn-primary" @click="resendInvites">Resend</button>
            </p>
        </div>
    </div> 
</template>

<style>
</style>