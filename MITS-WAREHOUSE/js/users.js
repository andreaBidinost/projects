filters = {};
$(document).ready(function () {

    $('#filterButton').click(updateUsersList());

    loadRoles();
    loadUsers({});
});


function updateUsersList() {
    filters = {
        firstName: $('#firstNameFilter').val(),
        lastName: $('#lastNameFilter').val(),
        role: $('#roleFilter').val()
    };
    loadUsers(filters);
}

function loadRoles() {
    showLoadingSpinner();
    $.ajax({
        url: URL_GET_USER_ROLES,
        type: 'GET',
        dataType: 'json',
        success: function (roles) {
            var roleFilter = $('#roleFilter');
            $.each(roles, function (index, role) {
                roleFilter.append($('<option>', {
                    value: role.id,
                    text: role.description
                }));
            });
            hideLoadingSpinner();
        },
        error: function (xhr, status, error) {
            mitsAlert(MITSALERT_ERROR, "Errore durante il caricamento dei ruoli", null)

            hideLoadingSpinner();
        }
    });
}

function loadUsers(filters) {
    showLoadingSpinner();
    $.ajax({
        url: URL_GET_USERS_DETAILS,
        type: 'GET',
        dataType: 'json',
        data: filters,
        success: function (users) {
            var userList = $('#userList');
            userList.empty();
            $.each(users, function (index, user) {
                var listItem = $('<div>').addClass('user-item').html(`
                    <p>${user.firstName} ${user.lastName}</p>
                    <p>Ruolo: ${user.role}</p>
                `);
                userList.append(listItem);
            });
            hideLoadingSpinner();
        },
        error: function (xhr, status, error) {
            mitsAlert(MITSALERT_ERROR, "Errore durante il caricamento degli utenti", null)

            hideLoadingSpinner();
        }
    })
}