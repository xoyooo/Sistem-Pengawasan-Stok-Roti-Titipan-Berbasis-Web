// Menampilkan nama file
document.getElementById("foto_roti").addEventListener("change", function (e) {
    const fileName = e.target.files[0]?.name || "";
    document.getElementById("file-name").textContent = fileName
        ? "📷 " + fileName
        : "";
});
document.getElementById("foto_sisa").addEventListener("change", function (e) {
    const fileName = e.target.files[0]?.name || "";
    document.getElementById("file-name-sisa").textContent = fileName
        ? "📷 " + fileName
        : "";
});

// Efek drag & drop upload area
function setupDragDrop(areaId, inputId) {
    const area = document.getElementById(areaId);
    const input = document.getElementById(inputId);
    area.addEventListener("dragover", (e) => {
        e.preventDefault();
        area.classList.add("bg-yellow-100");
    });
    area.addEventListener("dragleave", () =>
        area.classList.remove("bg-yellow-100")
    );
    area.addEventListener("drop", (e) => {
        e.preventDefault();
        area.classList.remove("bg-yellow-100");
        input.files = e.dataTransfer.files;
        input.dispatchEvent(new Event("change"));
    });
}
setupDragDrop("uploadRotiArea", "foto_roti");
setupDragDrop("uploadSisaArea", "foto_sisa");
