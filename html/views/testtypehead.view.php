<?php 



$_addScript = "
		   <script src=\"http://code.jquery.com/jquery-1.8.0.min.js\"></script>
		   <script src=\"".URL_BASE."/assets/typehead/jquery.mockjax.js\"></script>
           <script src=\"".URL_BASE."/assets/typehead/bootstrap-typeahead.js\"></script>
		
		";






?>


<h3>Demo #3</h3>
                    <div class="well col-md-5">
                        <input id="demo3" type="text" class="col-md-12 form-control" placeholder="Search cities..." autocomplete="off" />
                    </div>
                    <div class="col-md-7">
                        <pre class="prettyprint">

    $('#demo3').typeahead({
        source: [
            { id: 1, full_name: 'Toronto', first_two_letters: 'To' },
            { id: 2, full_name: 'Montreal', first_two_letters: 'Mo' },
            { id: 3, full_name: 'New York', first_two_letters: 'Ne' },
            { id: 4, full_name: 'Buffalo', first_two_letters: 'Bu' },
            { id: 5, full_name: 'Boston', first_two_letters: 'Bo' },
            { id: 6, full_name: 'Columbus', first_two_letters: 'Co' },
            { id: 7, full_name: 'Dallas', first_two_letters: 'Da' },
            { id: 8, full_name: 'Vancouver', first_two_letters: 'Va' },
            { id: 9, full_name: 'Seattle', first_two_letters: 'Se' },
            { id: 10, full_name: 'Los Angeles', first_two_letters: 'Lo' }
        ],
        displayField: 'full_name'
    });
                        </pre>
                    </div>
                    
    