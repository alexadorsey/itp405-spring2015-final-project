$(function() {
	$(".iframes").fancybox({
		fitToView	: false,
		width		: '450',
		height		: '400',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
    
    $("#sign-up-header").fancybox({
        fitToView	: false,
		width		: '440',
		height		: '450',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
    });
	
	$("#login-header").fancybox({
        fitToView	: false,
		width		: '340',
		height		: '350',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
    });
	
	$.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });
	 
});


$("#sign-up-form").submit(function() {
    $form = $(this);
    $.ajax({
      url: $form.attr("action"),
      type: 'POST',
      dataType: 'html',
      data: $form.serialize(),
      success: function(data, textStatus, xhr) {
        //parent.$.fancybox.close();
        document.write(data);
        document.close();
      },
      error: function(xhr, textStatus, errorThrown) {
        console.log("An error occurred.");
      }
    });
    return false;
});
