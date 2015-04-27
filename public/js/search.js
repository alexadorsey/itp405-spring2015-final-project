/*
$(function() {
    var sort_order = $('#order').val();
   $("#sort-by-options option").each(function() {
        $(this).removeAttr('selected');
        if (sort_order == $(this).val()) {
            $(this).attr('selected', true).change();
        }
	});
    return false;
});
*/

function setSortBy(sort_order) {
    var options = ""
    options += sortByOptions('date_posted_newest', 'Date Posted: Newest to Oldest', sort_order);
    options += sortByOptions('date_posted_oldest', 'Date Posted: Oldest to Newest', sort_order);
    options += sortByOptions('company_rating_high', 'Company Rating: High to Low', sort_order);
    options += sortByOptions('company_rating_low', 'Company Rating: Low to High', sort_order);
    document.getElementById('sort-by-options').innerHTML = options;
}

function sortByOptions(order, text, sort_order) {
    var option = "";
    option += '<option ';
    if (sort_order == order) {
        option += 'selected=true ';
    }
    option += 'class="sort-by" name="sort_by" value="' + order;
    option += '" onclick="sortReviews(\'' + order + '\')">' + text + '</option>';
    console.log(option);
    return option;
}

function sortReviews(order) {
    var form = $('#sort-reviews');
    var sort_order = $('#order');
    sort_order.val(order);
    form.submit();
    return false;
}