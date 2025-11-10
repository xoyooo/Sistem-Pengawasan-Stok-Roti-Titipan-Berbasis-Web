$(document).ready(function () {
    console.log("✅ tambah_toko.js loaded");

    // ==== Upload Foto ====
    let selectedFiles = [];
    const uploadArea = $("#upload-area");
    const fileInput = $("#photo");
    const previewContainer = $("#preview-container");
    const uploadContent = $("#upload-content");

    uploadArea.on("dragover", (e) => {
        e.preventDefault();
        uploadArea.addClass("bg-yellow-100");
    });
    uploadArea.on("dragleave", () => uploadArea.removeClass("bg-yellow-100"));
    uploadArea.on("drop", (e) => {
        e.preventDefault();
        uploadArea.removeClass("bg-yellow-100");
        handleFiles(e.originalEvent.dataTransfer.files);
    });
    fileInput.on("change", () => handleFiles(fileInput[0].files));

    function handleFiles(files) {
        Array.from(files).forEach((file) => {
            if (file.type.startsWith("image/")) selectedFiles.push(file);
        });
        showPreviews();
    }

    function showPreviews() {
        previewContainer.html("");
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const wrapper = $(
                    `<div class="relative inline-block m-2 transition-transform duration-300 hover:scale-105">
                        <img src="${e.target.result}" class="h-32 w-32 object-cover rounded-lg shadow border border-yellow-300" />
                        <button type="button" data-index="${index}" class="btn-hapus absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition">&times;</button>
                    </div>`
                );
                previewContainer.append(wrapper);
            };
            reader.readAsDataURL(file);
        });
        uploadContent.html(
            `<p class="text-yellow-700 font-semibold">${selectedFiles.length} foto dipilih</p>`
        );
    }

    previewContainer.on("click", ".btn-hapus", function () {
        const index = $(this).data("index");
        selectedFiles.splice(index, 1);
        showPreviews();
    });

    // ==== MAP ====
    let map, marker, selectedLatLng, userMarker;

    $("#btnMap").on("click", function () {
        $("#mapModal").removeClass("hidden").addClass("flex");

        setTimeout(() => {
            if (!map) {
                map = L.map("map").setView([3.5952, 98.6722], 13);
                L.tileLayer(
                    "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
                    { attribution: "&copy; OpenStreetMap contributors" }
                ).addTo(map);

                map.on("click", function (e) {
                    selectedLatLng = e.latlng;
                    if (marker) marker.setLatLng(e.latlng);
                    else marker = L.marker(e.latlng).addTo(map);
                });

                // 🧭 Deteksi lokasi pengguna
                if ("geolocation" in navigator) {
                    navigator.geolocation.getCurrentPosition(
                        (pos) => {
                            const lat = pos.coords.latitude;
                            const lng = pos.coords.longitude;

                            const userIcon = L.icon({
                                iconUrl:
                                    "https://cdn-icons-png.flaticon.com/512/64/64113.png",
                                iconSize: [32, 32],
                                iconAnchor: [16, 32],
                                popupAnchor: [0, -30],
                            });

                            if (userMarker) userMarker.setLatLng([lat, lng]);
                            else
                                userMarker = L.marker([lat, lng], {
                                    icon: userIcon,
                                })
                                    .addTo(map)
                                    .bindPopup("<b>Lokasi Anda Saat Ini</b>")
                                    .openPopup();

                            map.setView([lat, lng], 14);
                            console.log(`📍 Lokasi pengguna: ${lat}, ${lng}`);
                        },
                        (err) => {
                            console.warn(
                                "⚠️ Gagal deteksi lokasi:",
                                err.message
                            );
                            Swal.fire({
                                icon: "info",
                                title: "Izin lokasi ditolak",
                                text: "Silakan pilih titik secara manual.",
                                timer: 2500,
                                showConfirmButton: false,
                            });
                        }
                    );
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: "Browser tidak mendukung deteksi lokasi",
                        text: "Silakan pilih titik secara manual.",
                        timer: 2500,
                        showConfirmButton: false,
                    });
                }
            } else {
                map.invalidateSize();
            }
        }, 300);
    });

    $("#closeMap").on("click", function () {
        $("#mapModal").addClass("hidden").removeClass("flex");
    });

    $("#saveMap").on("click", function () {
        if (!selectedLatLng) {
            Swal.fire({
                icon: "warning",
                title: "Pilih lokasi dulu!",
                timer: 1500,
                showConfirmButton: false,
            });
            return;
        }

        const lat = selectedLatLng.lat.toFixed(6);
        const lng = selectedLatLng.lng.toFixed(6);
        $("#latitude").val(lat);
        $("#longitude").val(lng);

        const nominatimUrl = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&addressdetails=1&accept-language=id&email=sultanjb01@gmail.com`;

        fetch(nominatimUrl)
            .then((res) => res.json())
            .then((data) => {
                let alamat = "";
                if (data.display_name && data.display_name.trim() !== "") {
                    alamat = data.display_name;
                } else if (data.address) {
                    const a = data.address;
                    const parts = [
                        a.road,
                        a.neighbourhood,
                        a.suburb,
                        a.village,
                        a.town,
                        a.city,
                        a.state,
                        a.postcode,
                        a.country,
                    ].filter(Boolean);
                    alamat = parts.join(", ");
                } else {
                    alamat = "Alamat tidak ditemukan";
                }

                $("#address").val(alamat);

                Swal.fire({
                    icon: "success",
                    title: "Lokasi berhasil dipilih!",
                    text: "Alamat otomatis diisi.",
                    timer: 1800,
                    showConfirmButton: false,
                });

                setTimeout(() => {
                    $("#mapModal").addClass("hidden").removeClass("flex");
                }, 120);
            })
            .catch((err) => {
                console.error("Reverse geocode error:", err);
                Swal.fire({
                    icon: "warning",
                    title: "Lokasi tersimpan, tapi alamat gagal dimuat",
                    text: "Silakan isi alamat manual.",
                    timer: 2200,
                    showConfirmButton: false,
                });
            });
    });

    // ==== Submit AJAX ====
    $("#formTambahToko").on("submit", function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        selectedFiles.forEach((file) => formData.append("photo[]", file));

        $.ajax({
            url: $("#formTambahToko").attr("action"),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                Swal.fire({
                    title: "Menyimpan data...",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading(),
                });
            },
            success: function () {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: "Data toko berhasil disimpan!",
                    timer: 2000,
                    showConfirmButton: false,
                });
                $("#formTambahToko")[0].reset();
                previewContainer.html("");
                selectedFiles = [];
            },
            error: function (xhr) {
                let msg =
                    xhr.responseJSON?.message ||
                    "Terjadi kesalahan. Coba lagi!";
                Swal.fire({ icon: "error", title: "Gagal!", text: msg });
            },
        });
    });
});
