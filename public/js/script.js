//upload dokumen
document.getElementById('uploadCard').addEventListener('click', function() {
    document.getElementById('fileInput').click();
});

document.getElementById('fileInput').addEventListener('change', function(event) {
    const fileName = event.target.files[0].name;
    document.querySelector('#uploadCard p').textContent = fileName;
});



//team
$(document).ready(function() {
    $('#kasusDropdown').select2({
        placeholder: 'Ketik untuk mencari kasus...',
        allowClear: true,
        width: '100%'
    });
    $('#kasusDropdownTeam').select2({
        placeholder: 'Ketik untuk mencari kasus...',
        allowClear: true,
        width: '100%'
    });
    $('#ketuaTeamDropdown').select2({
        placeholder: 'Masukan nama anggota...',
        allowClear: true,
        width: '100%'
    });
    $('#anggota2Dropdown').select2({
        placeholder: 'Masukan nama anggota...',
        allowClear: true,
        width: '100%'
    });
    $('#anggota3Dropdown').select2({
        placeholder: 'Masukan nama anggota...',
        allowClear: true,
        width: '100%'
    });
    $('#anggota4Dropdown').select2({
        placeholder: 'Masukan nama anggota...',
        allowClear: true,
        width: '100%'
    });
    $('#anggota5Dropdown').select2({
        placeholder: 'Masukan nama anggota...',
        allowClear: true,
        width: '100%'
    });
});


function confirmTutupKasus() {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin menutup kasus ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Tutup Kasus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('tutupKasusForm').submit();
        }
    });
}

function confirmDelete() {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus file ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('hapusFile').submit(); // Ganti id form menjadi 'hapusFile'
        }
    });
}
function confirmDeleteUser() {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus file ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('hapusUser').submit(); // Ganti id form menjadi 'hapusFile'
        }
    });
}
