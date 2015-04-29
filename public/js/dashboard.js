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

function confirmDeletePosition(url) {
    if (confirm('Are sure sure you want to delete ' + $('#position-id option:selected').text() + '?')) {
        window.location.href = url + '/' + $('#position-id').val();
    }
}

function editCompany(url) {
    url += '/' + $('#company-id').val();
    $.fancybox.open({
        href: url,
        type: 'iframe',
        fitToView	: false,
		width		: '440',
		height		: '280',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
    });
}

function editPosition(url) {
    url += '/' + $('#position-id').val();
    $.fancybox.open({
        href: url,
        type: 'iframe',
        fitToView	: false,
		width		: '440',
		height		: '250',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
    });
}

function editCity(url) {
    url += '/' + $('#city-id').val();
    $.fancybox.open({
        href: url,
        type: 'iframe',
        fitToView	: false,
		width		: '440',
		height		: '250',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
    });
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