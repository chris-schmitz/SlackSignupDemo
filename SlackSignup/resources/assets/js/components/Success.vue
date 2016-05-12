<script>
    module.exports = {
        data: () => {
            return { test: 'Worked'}
        },
        ready: function () {
            debugger;
            this.$dispatch('showNotification', {
                type: 'info', message: 'test'
            })
        }
    }    
</script>
<template>
    <h2>{{test}}</h2>
</template>

<style>
</style>