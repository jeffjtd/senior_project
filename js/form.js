// on document ready
jQuery(function($) {	

	/* if browser doesn't support input type ="date"
     * initialize date picker widget
     * selector[name ^= 'value'] selects elements that
     * have the specified attribute with a value beginning
     * exactly with a given string */
	if( $("input[name^='eventDate']").type != 'date') {
		$("input[name^='eventDate']").datepicker();	
	}
})
	