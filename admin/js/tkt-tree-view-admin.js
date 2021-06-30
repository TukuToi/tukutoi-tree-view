(function( $ ) {
	'use strict';

	var tkt_filter, tkt_ul, tkt_li, tkt_a, tkt_i, tkt_txtValue, i, content;
	var plugin_short 	= 'tkt_htv';
	var tkt_coll 		= document.getElementsByClassName( plugin_short + '_parent_item' );
	var tkt_inputs 		= Object.keys( tkt_htv_localised_object.widgets ).map( ( key ) => [ key, tkt_htv_localised_object.widgets[key] ] );
	var tkt_input 		= '';
	var found_class		= '';

	$( window ).on( 'load', function() {

		for ( i = 0; i < tkt_coll.length; i++ ) {

	  		tkt_coll[i].addEventListener( 'click', function() {
	    
	    		this.classList.toggle( 'active' );
	    		content = this.nextElementSibling;
	    
	    		if ( content.style.display === 'none' ) {

	      			content.style.display = 'block';

	    		} 
	    		else {

	      			content.style.display = 'none';

	    		}

	  		});

		}

		tkt_inputs.forEach( tkt_get_src_inputs );
		
	});

	function tkt_get_src_inputs(item, index){

		tkt_input = document.getElementById( plugin_short + '-' + item[0] + '-search-input' );

		tkt_input.onkeyup = function() {

			tkt_search_on_the_fly_function( this );

		};

	}

	function tkt_search_on_the_fly_function( instance ) {


	    tkt_filter 	= instance.value.toUpperCase();
	    tkt_ul 		= instance.closest( 'div.postbox' ).getElementsByClassName( plugin_short + '-searchable-contents' );

	    for ( let tkt_item of tkt_ul ) {

	      	tkt_li = tkt_item.getElementsByTagName( 'li' );
	      	
	      	for ( tkt_i = 0; tkt_i < tkt_li.length; tkt_i++ ) {

	        	tkt_a = tkt_li[tkt_i].getElementsByTagName( 'a' )[0];
	        	tkt_txtValue = tkt_a.textContent || tkt_a.innerText;

	        	if( tkt_filter ){

		        	if ( tkt_txtValue.toUpperCase().indexOf( tkt_filter ) > -1 ) {

		          		tkt_a.classList.add( 'highlight' );

		          		found_class = tkt_a.closest( 'div' ).classList[1];

		          		Array.from( document.getElementsByClassName( tkt_a.closest( 'div' ).classList[1] ) ).forEach( ( el ) => {
						    el.style.display = '';
						});

		        	} 
		        	else {

		          		tkt_a.classList.remove('highlight');

		          		Array.from( document.getElementsByClassName( tkt_a.closest( 'div' ).classList[1] ) ).forEach( ( el ) => {
						    if( ! ( el.classList.contains( found_class ) ) ){
						    	el.style.display = 'none';
						    }
						});

		        	}
	        	}
	        	else{

	        		tkt_a.classList.remove('highlight');

	        		Array.from( document.getElementsByClassName( tkt_a.closest( 'div' ).classList[1] ) ).forEach( ( el ) => {
						el.style.display = '';
					});
					
	        	}

	      	}

	    }

	}

})( jQuery );
