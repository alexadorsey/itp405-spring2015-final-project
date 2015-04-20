function confirmDelete(url) {
    if (confirm('Are sure sure you want to delete this review?')) {
        window.location.href = url;
    }
}

function confirmDeleteCompany(url) {
    if (confirm('Are sure sure you want to delete ' + $('#company-id option:selected').text() + '?')) {
        window.location.href = url + '/' + $('#company-id').val();
    }
}

function editCompany(url) {
    window.location.href = url + '/' + $('#company-id').val();
}


function reviewReview(url, review_id) {
    return $.ajax({
        type: "POST",
        dataType: "json",
        url: url + "/" + review_id,
        success: function(data) {          
            $("#review-" + review_id).remove();
        },
        error: function (data) {
            console.log("There was an error");
        }
    });
}

$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });
});