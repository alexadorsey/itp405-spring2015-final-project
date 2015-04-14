function sortReviews(reviews, order) {
    return $.ajax({
        type: "POST",
        dataType: "json",
        url: 'search/sort',
        data: { reviews: reviews, order: order },
        success: function(data) {
            console.log(data.data.reviews);
            console.log("Success!");
            
            // Remove html from review div
            $("#reviews").html("");
            
            // Show the new ordered reviews
            reorderReviews(data.data.reviews);
        },
        error: function (data) {
            console.log("There was an error");
        }
    });
}


function reorderReviews(reviews) {
    var newRevs = "";
    var monthNames = [
        "January", "February", "March",
        "April", "May", "June", "July",
        "August", "September", "October",
        "November", "December"
    ];

    for (var key in reviews) {
        if (reviews.hasOwnProperty(key)) {
            var review = reviews[key];
            console.log(review);
            newRevs += '<div class="review">';
            if (review.company.icon) {
                newRevs += '<img class="company-logo" src="' + review.company.icon + '"/>';
            }
            newRevs += ' <a href="company/' + review.company.name + '"><span class="company-name">' + review.company.name + '</span></a><br/>';
            newRevs += '<span class="review-title" style="float:left;">' + review.position.name + ' at ' + review.city.name + ', ' + review.state.abbreviation + '</span>';
            newRevs += '<span style="float:right">';
            
            if (review.recommend == 0) {
                newRevs += ' <span class="glyphicon glyphicon-thumbs-up review-icon neg-review-rating"></span>';
            } else {
                newRevs += ' <span class="glyphicon glyphicon-thumbs-up review-icon pos-review-rating"></span>';
            }
            
            if (review.fair_hours == 0) {
                newRevs += ' <span class="glyphicon glyphicon-time review-icon neg-review-rating"></span>';
            } else {
                newRevs += ' <span class="glyphicon glyphicon-time review-icon pos-review-rating"></span>';
            }
            
            if (review.compensation == 0) {
                newRevs += ' <span class="glyphicon glyphicon-usd review-icon neg-review-rating"></span>';
            } else {
                newRevs += ' <span class="glyphicon glyphicon-usd review-icon pos-review-rating"></span>';
            }
            
            if (review.future_work == 0) {
                newRevs += ' <span class="glyphicon glyphicon-briefcase review-icon neg-review-rating"></span>';
            } else {
                newRevs += ' <span class="glyphicon glyphicon-briefcase review-icon pos-review-rating"></span>';
            }

            newRevs += '</span>';
            newRevs += '<div style="clear:both"></div>';
            var start_date = new Date(review.intern_start);
            var end_date = new Date(review.intern_end);
            var post_date = review.created_at;
            var month = dateFormat(post_date.substring(5,7));
            var day = dateFormat(post_date.substring(8,10));
            var year = post_date.substring(2,4)

            newRevs += '<span class="intern-date">' + monthNames[start_date.getMonth()] + ' ' + start_date.getFullYear() + ' - ' + monthNames[end_date.getMonth()] + ' ' + end_date.getFullYear() + '</span>';
            newRevs += '<span class="post-date">Posted ' + month + '/' + day + '/' + year + '</span>';
            newRevs += '<div class="clear"></div>';
            newRevs += '<table>';
                newRevs += '<col width="10%">';
                newRevs += '<col width="95%">';
                newRevs += '<tr>';
                    newRevs += '<td class="pro">Pros:</td>';
                    newRevs += '<td>' + review.pros + '</td>';
                newRevs += '</tr>'
                newRevs += '<tr>'
                    newRevs += '<td class="pro">Cons:</td>'
                    newRevs += '<td>' + review.cons + '</td>'
                newRevs += '</tr>';
            newRevs += '</table>';
        newRevs += '</div>';
        
        }
        
    }
    $('#reviews').html(newRevs);
}


function dateFormat(date) {
    if (date.substring(0,1) == "0") {
        date = date.substring(1, 2);
    }
    return date;
}