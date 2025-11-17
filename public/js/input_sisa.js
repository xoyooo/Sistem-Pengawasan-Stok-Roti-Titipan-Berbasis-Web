document.addEventListener("DOMContentLoaded", function () {
    // === Preview nama file FOTO ROTI (kalau elemennya ada) ===
    const inputRoti = document.getElementById("foto_roti");
    const fileNameRoti = document.getElementById("file-name");

    if (inputRoti && fileNameRoti) {
        inputRoti.addEventListener("change", function (e) {
            const fileName = e.target.files[0]?.name || "";
            fileNameRoti.textContent = fileName ? "📷 " + fileName : "";
        });
    }

    // === Preview nama file FOTO SISA (halaman input sisa) ===
    const inputSisa = document.getElementById("foto_sisa");
    const fileNameSisa = document.getElementById("file-name-sisa");

    if (inputSisa && fileNameSisa) {
        inputSisa.addEventListener("change", function (e) {
            const fileName = e.target.files[0]?.name || "";
            fileNameSisa.textContent = fileName ? "📷 " + fileName : "";
        });
    }

    // === Fungsi drag & drop, aman kalau elemennya ada ===
    function setupDragDrop(areaId, inputId) {
        const area = document.getElementById(areaId);
        const input = document.getElementById(inputId);

        if (!area || !input) return; // <-- penting! kalau tidak ada, jangan lanjut

        area.addEventListener("dragover", (e) => {
            e.preventDefault();
            area.classList.add("bg-yellow-100");
        });

        area.addEventListener("dragleave", () => {
            area.classList.remove("bg-yellow-100");
        });

        area.addEventListener("drop", (e) => {
            e.preventDefault();
            area.classList.remove("bg-yellow-100");
            input.files = e.dataTransfer.files;
            input.dispatchEvent(new Event("change"));
        });
    }

    // Panggil sesuai halaman yang ada
    setupDragDrop("uploadRotiArea", "foto_roti");   // halaman input stok
    setupDragDrop("uploadSisaArea", "foto_sisa");   // halaman input sisa
});
