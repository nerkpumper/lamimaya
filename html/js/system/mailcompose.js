var app = new Vue({
	
	el: '#app',
	data: {
		
		cadenita: ''		
	}
	
});


$(document).ready(function(){
	
//	alert("comenzamos");
	
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });


            $('.summernote').summernote();

        });
        var edit = function() {
            $('.click2edit').summernote({focus: true});
        };
        var save = function() {
            var aHTML = $('.click2edit').code(); //save HTML If you need(aHTML: array).
            $('.click2edit').destroy();
        };