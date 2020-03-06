(function($) {

	/**
	 * INSERT FORM
	 */
	var form  = $('#add-form'),
	    list  = $('#item-list'),
	    input = form.find('#text');

	input.val('').focus();


	/**
	 * EDIT FORM
	 */
	$('#edit-form').find('#text').select();


	/**
	 * DELETE FORM
	 */
	$('#delete-form').on('submit', function() {
		return confirm('for sure?');
	});

	$('select[multiple]').select2();


}(jQuery));