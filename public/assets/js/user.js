$(document).ready(function() {
    $('body').on('click', '.jel-update-user', function(event) {
        event.preventDefault();
    // Clear existing values
    $('#update_user_id').val('');
    $('#update_emp_id').val('');
    $('#update_firstname').val('');
    $('#update_middlename').val('');
    $('#update_lastname').val('');
    $('#update_gender').val('');
    $('#update_email').val('');
    $('#update_username').val('');
    $('#update_division').val('');
    $('#update_unit').val('');
    $('#update_position').val('');
    $('#update_province').val('');
    $('#update_region').val('');
    $('#update_address').val('');
    $('#update_mobile_no').val('');

    // Find the closest tr to the clicked button
    var trJel = $(this).closest('tr');

    // Get values from the row
    var id = $(trJel).find('#id').val(); // Ensure that this input exists in the row
    var empId = $(trJel).find('.emp_id').text().trim();
    var firstname = $(trJel).find('.firstname').text().trim();
    var middlename = $(trJel).find('.middlename').text().trim();
    var lastname = $(trJel).find('.lastname').text().trim();
    var gender = $(trJel).find('.gender').text().trim();
    var email = $(trJel).find('.email').text().trim();
    var username = $(trJel).find('.username').text().trim();
    var division = $(trJel).find('.division').text().trim();
    var unit = $(trJel).find('.unit').text().trim();
    var position = $(trJel).find('.position').text().trim();
    var province = $(trJel).find('.province').text().trim();
    var region = $(trJel).find('.region').text().trim();
    var address = $(trJel).find('.address').text().trim();
    var mobile_no = $(trJel).find('.mobile_no').text().trim();

    // Set values to modal inputs
    $('#update_user_id').val(id);
    $('#update_emp_id').val(empId);
    $('#update_firstname').val(firstname);
    $('#update_middlename').val(middlename);
    $('#update_lastname').val(lastname);
    $('#update_gender').val(gender);
    $('#update_email').val(email);
    $('#update_username').val(username);
    $('#update_division').val(division);
    $('#update_unit').val(unit);
    $('#update_position').val(position);
    $('#update_province').val(province);
    $('#update_region').val(region);
    $('#update_address').val(address);
    $('#update_mobile_no').val(mobile_no);

    // Show the modal
    $("#update-user-mdl").modal("show");
});
});


