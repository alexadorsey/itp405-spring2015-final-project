$("#create-company-form").submit(function() {

    $form = $(this);
    console.log($form.attr("action"));

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