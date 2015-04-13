$(document).ready(function() {
	//$('#company-input').val("");
    $('#position-input').val("");
    $('#city-input').val("");
    $('#state-input').val("");
});

function getCompanyValue() {
	var x = $('#company-input').val();
    var z = $('#company');
    var val = $(z).find('option[value="' + x + '"]');
    var company_id = val.attr('id');
    $('#company-id').val(company_id);
}

function getPositionValue() {
    var x = $('#position-input').val();
    var z = $('#position');
    var val = $(z).find('option[value="' + x + '"]');
    var position_id = val.attr('id');
    $('#position-id').val(position_id);
}