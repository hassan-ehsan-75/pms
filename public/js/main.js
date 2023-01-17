
$( "#comment_form" ).submit(function( event ) {
	// Stop form from submitting normally
	event.preventDefault();
	
	// Get some values from elements on the page:
	var $form = $( this );
	// Send the data using post (url, {data})
	var data=$('#comment_form').serialize();
	// remove comment
	$('#comment_content').val('');
	$('#loading_icon').html('<i class="fa fa-refresh fa-spin"></i>');
	
	var posting = $.post($form.attr( "action" ),
					data,function(){
						 //success
						 
						 jQuery('#box-comments').load(window.location.href+' #box-comments > *');
$('#loading_icon').html();
					 } );
});




window.setTimeout(function(){
	$("#flash-message").fadeTo(500,0).slideUp(500,function(){ $(this).remove;})
},3000);


function getExtension(){
		var fileName=$('#file_url').val();
	    var fileExtension = fileName.substr((fileName.lastIndexOf('.') + 1));
        $('#extension').val(fileExtension);
}


CKEDITOR.config.uiColor='#222e32';
CKEDITOR.plugins.addExternal( 'notification', '/plugins/notification/', 'plugin.js' );
CKEDITOR.plugins.addExternal( 'clipboard', '/plugins/clipboard/', 'plugin.js' );
CKEDITOR.plugins.addExternal( 'widgetselection', '/plugins/widgetselection/', 'plugin.js' );
CKEDITOR.plugins.addExternal( 'lineutils', '/plugins/lineutils/', 'plugin.js' );
CKEDITOR.plugins.addExternal( 'dialogui', '/plugins/dialogui/', 'plugin.js' );
CKEDITOR.plugins.addExternal( 'widget', '/plugins/widget/', 'plugin.js' );
CKEDITOR.plugins.addExternal( 'dialog', '/plugins/dialog/', 'plugin.js' );
CKEDITOR.plugins.addExternal( 'codesnippet', '/plugins/codesnippet/', 'plugin.js' );
CKEDITOR.config.extraPlugins = 'codesnippet';
CKEDITOR.config.codeSnippet_theme='monokai_sublime';


$('span#cke_1_top').css('background-image','none');


function copyText(input_id){
 
  // When the copy button is clicked, select the value of the text box, attempt
  // to execute the copy command, and trigger event to update tooltip message
  // to indicate whether the text was successfully copied.
  $(input_id).attr('disabled', false);
    var input = document.querySelector(input_id);
	input.select();
    //input.setSelectionRange(0, input.value.length + 1);
    try {
      var success = document.execCommand('copy');
      if (success) {
        alert('Copied!');
      } else {
        alert('Couldn\'t copy ..Copy with Ctrl-c');
      }
    } catch (err) {
     alert('Couldn\'t copy ..Copy with Ctrl-c');
    }

	  $(input_id).attr('disabled', true);

 
}

