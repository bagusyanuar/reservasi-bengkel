$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

function ErrorAlert(title, msg) {
    Swal.fire(title, msg, 'error');
}

function AlertConfirm(title = 'Apakah Anda Yakin?', text = 'Apa anda yakin melanjutkan proses', fn) {
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.value) {
            fn();
        }
    });
}

async function AjaxPost(url, param = {}, onSuccess = function () {
}) {
    try {
        let response = await $.post(url, param);
        if (response['status'] === 200) {
            onSuccess();
        }
    } catch (e) {
        ErrorAlert('Error', e.responseText.toString());
    }
}


function createLoader(text = 'sedang mengunduh data...', height = 600) {
    return '<div class="d-flex flex-column align-items-center justify-content-center" style="height: ' + height + 'px">' +
        '<div class="spinner-border text-primary" role="status">\n' +
        '  <span class="sr-only">Loading...</span>\n' +
        '</div>' +
        '<div>' + text + '</div>' +
        '</div>';
}
