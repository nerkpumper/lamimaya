
    Vue.component('bc2', {
        data: function () {
            return {
            count: 0
            }
        },
        template: '<button v-on:click="count++">You clicked me {{ count }} times.</button>'
        })



$(document).ready(function(){
    setTimeout(function(){ 

        // window.location = 'http://www.google.com';


    }, 2);
});