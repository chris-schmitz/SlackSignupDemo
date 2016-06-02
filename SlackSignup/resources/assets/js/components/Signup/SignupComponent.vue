<script>
    let Notifications = require('./Notifications.vue')
    let SignupForm = require('./SignupForm.vue')
    let Mask = require('./Mask.vue')

    module.exports = {
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
            toggleMask: function (){
                debugger;
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
        <mask></mask>
    </div> 
</template>

<style>
</style>