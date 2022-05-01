/**
 * Student Number Text box mask
 */
$("input[name='student_number']").on("keyup change", function () {
    $("input[name='student_number_mask']").val(destroyMask(this.value));
    this.value = createMask($("input[name='student_number_mask']").val());
})

function createMask(string) {
    return string.replace(/(\d{2})(\d{2})(\d{4})/, "$1-$2-$3");
}

function destroyMask(string) {
    return string.replace(/\D/g, '').substring(0, 8);
}

/**
 * Confirmation and form submit
 */
function confirmSubmit(action, formId, id) {
    if (confirm('Do you want to ' + action + " this record?")) {
        document.getElementById(formId + id).submit();
    } else {
        return false;
    }
}

/**
 * Password confirmation
 */
function comparePassword(id) {
    var passwordValue = $("#password" + id).val();
    var confirmPasswordValue = $("#password-confirm" + id).val();

    if (confirmPasswordValue !== passwordValue) {
        $("#password-does-not-match-text" + id).removeAttr("hidden");
        $("#submitBtn" + id).attr("disabled", true);
    }
    if (confirmPasswordValue === passwordValue) {
        $("#submitBtn" + id).removeAttr("disabled");
        $("#password-does-not-match-text" + id).attr("hidden", true);
    }
}