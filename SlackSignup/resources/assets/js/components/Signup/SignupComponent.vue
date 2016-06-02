<script>
    let Notifications = require('./Notifications.vue')
    let SignupForm = require('./SignupForm.vue')
    let Mask = require('./Mask.vue')

    module.exports = {
        data: () => {
            return { 
                // should we keep this and the business logic below stay here?
                // should we move this down to the mask?
                // I kind of think so
                mask: {
                    show: false,
                    message: ''
                }
            }
        },
        components:{
            'notifications': Notifications,
            'signup-form': SignupForm,
            'mask': Mask
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
            toggleMask: function (state, message){
                if(state === true){
                    this.mask.message = message
                    this.mask.show = true
                } else {
                    this.mask.show = false
                }
            }
        }
    }    
</script>
<template>
    <div class="signup-component">
        <notifications></notifications>
        <p>
            STL Full Stack Web Development is a meetup group in Saint Louis, Missouri that meets monthly to review topics that make up the web development world.
        </p>
        <signup-form></signup-form>
        <mask v-show="mask.show" :message="mask.message"></mask>
    </div> 
</template>

<style>
</style>