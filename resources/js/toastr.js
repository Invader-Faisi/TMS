import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

// Toastr configuration
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

// Make toastr available globally
window.toastr = toastr;

// Display toastr messages from session
if (window.sessionToastr) {
    toastr[window.sessionToastr.type](window.sessionToastr.message, window.sessionToastr.title);
}

// Display other session messages
if (window.sessionSuccess) {
    toastr.success(window.sessionSuccess, 'Success');
}

if (window.sessionError) {
    toastr.error(window.sessionError, 'Error');
}

if (window.sessionWarning) {
    toastr.warning(window.sessionWarning, 'Warning');
}

if (window.sessionInfo) {
    toastr.info(window.sessionInfo, 'Info');
}

// Display validation errors
if (window.validationErrors && window.validationErrors.length > 0) {
    window.validationErrors.forEach(error => {
        toastr.error(error, 'Validation Error');
    });
}
