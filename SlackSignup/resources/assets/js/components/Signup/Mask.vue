<script>
    module.exports = {
        data: () => {
            return {
            }
        }
    }    
</script>
<template>
    <div class="app-mask">
        <div class="window">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="aligner">
                        <div class="message-block">
                            <h3>Submitting</h3> <div class="fa fa-spinner fa-pulse fa-3x fa-fw"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="sass">
    .app-mask{
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1;
        background-color: rgba(0,0,0,0.4);
        height:100%;
        width:100%;

    }
    .window {
        margin:20% auto;
        background-color: green;
        width:400px;

        h3 {
            display:inline-block;
        }
    }

    .aligner{
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .message-block{
        
        h3{
            display:inline-block;
        }
    }

</style>