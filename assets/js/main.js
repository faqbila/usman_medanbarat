/**
 * Custom JavaScript Logic
 * Aplikasi Web Usia Mandiri Medan Barat
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Hitung Usia Otomatis saat Input Tanggal Lahir
    const inputTglLahir = document.getElementById('input_tanggal_lahir');
    const inputUsia = document.getElementById('input_usia');

    if (inputTglLahir && inputUsia) {
        inputTglLahir.addEventListener('change', function () {
            const birthDate = new Date(this.value);
            if (!isNaN(birthDate.getTime())) {
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                inputUsia.value = age > 0 ? age : 0;
            }
        });
    }

    // 2. Image File Upload Preview
    const fotoInput = document.getElementById('input_foto');
    const fotoPreview = document.getElementById('preview_foto');

    if (fotoInput && fotoPreview) {
        fotoInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    fotoPreview.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // 3. Live Search & Multi-Filter Logic (Table & Grid Card)
    const searchInput = document.getElementById('filter_search');
    const filterKelompok = document.getElementById('filter_kelompok');
    const filterDesa = document.getElementById('filter_desa');
    const filterGender = document.getElementById('filter_gender');
    const btnReset = document.getElementById('btn_reset_filter');

    function applyFilters() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const kelompokVal = filterKelompok ? filterKelompok.value.toLowerCase() : '';
        const desaVal = filterDesa ? filterDesa.value.toLowerCase() : '';
        const genderVal = filterGender ? filterGender.value.toLowerCase() : '';

        // Filter untuk Tampilan Tabel
        const tableRows = document.querySelectorAll('.item-peserta-row');
        let countVisible = 0;

        tableRows.forEach(row => {
            const nama = row.getAttribute('data-nama') ? row.getAttribute('data-nama').toLowerCase() : '';
            const kelompok = row.getAttribute('data-kelompok') ? row.getAttribute('data-kelompok').toLowerCase() : '';
            const desa = row.getAttribute('data-desa') ? row.getAttribute('data-desa').toLowerCase() : '';
            const gender = row.getAttribute('data-gender') ? row.getAttribute('data-gender').toLowerCase() : '';

            const matchNama = nama.includes(query);
            const matchKelompok = kelompokVal === '' || kelompok === kelompokVal;
            const matchDesa = desaVal === '' || desa === desaVal;
            const matchGender = genderVal === '' || gender === genderVal;

            if (matchNama && matchKelompok && matchDesa && matchGender) {
                row.style.display = '';
                countVisible++;
            } else {
                row.style.display = 'none';
            }
        });

        // Filter untuk Tampilan Kartu / Grid
        const cardItems = document.querySelectorAll('.item-peserta-card');
        cardItems.forEach(card => {
            const nama = card.getAttribute('data-nama') ? card.getAttribute('data-nama').toLowerCase() : '';
            const kelompok = card.getAttribute('data-kelompok') ? card.getAttribute('data-kelompok').toLowerCase() : '';
            const desa = card.getAttribute('data-desa') ? card.getAttribute('data-desa').toLowerCase() : '';
            const gender = card.getAttribute('data-gender') ? card.getAttribute('data-gender').toLowerCase() : '';

            const matchNama = nama.includes(query);
            const matchKelompok = kelompokVal === '' || kelompok === kelompokVal;
            const matchDesa = desaVal === '' || desa === desaVal;
            const matchGender = genderVal === '' || gender === genderVal;

            if (matchNama && matchKelompok && matchDesa && matchGender) {
                card.style.display = '';
                countVisible++;
            } else {
                card.style.display = 'none';
            }
        });

        // Toggle pesan "Tidak Ada Data"
        const noDataMsg = document.getElementById('no_data_message');
        if (noDataMsg) {
            if (countVisible === 0) {
                noDataMsg.classList.remove('d-none');
            } else {
                noDataMsg.classList.add('d-none');
            }
        }
    }

    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (filterKelompok) filterKelompok.addEventListener('change', applyFilters);
    if (filterDesa) filterDesa.addEventListener('change', applyFilters);
    if (filterGender) filterGender.addEventListener('change', applyFilters);

    if (btnReset) {
        btnReset.addEventListener('click', function () {
            if (searchInput) searchInput.value = '';
            if (filterKelompok) filterKelompok.value = '';
            if (filterDesa) filterDesa.value = '';
            if (filterGender) filterGender.value = '';
            applyFilters();
        });
    }
});

/**
 * Konfirmasi Hapus Data
 */
function konfirmasiHapus(id, nama) {
    if (confirm('Apakah Anda yakin ingin menghapus data peserta "' + nama + '"?')) {
        window.location.href = 'proses_hapus.php?id=' + id;
    }
}
