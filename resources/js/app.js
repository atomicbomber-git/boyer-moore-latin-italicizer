require('./bootstrap');
require('alpinejs')

const Swal = require('sweetalert2')
window.Swal = Swal

window.confirmDialog = (attributes) => {
    return Swal.fire({
        title: `Konfirmasi`,
        titleText: `Konfirmasi Tindakan`,
        text: `Apakah Anda yakin ingin melakukan tindakan ini?`,
        icon: `warning`,
        showCancelButton: true,
        confirmButtonText: `Ya`,
        cancelButtonText: `Tidak`,
        ...attributes,
    })
}