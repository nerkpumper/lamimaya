<template>
    <button class="btn btn-primary" @click.prevent="sumar">You clicked me {{ count}}</button>
</template>

<script>
    export default {
        data: function (){
            return {
                count: 0
            }
        },
        mounted: function(){
            alert("bc.vue mounted");
        },
        methods: {
            sumar (){
                this.count++
            }
        }
    }
</script>

    