document.addEventListener("DOMContentLoaded", function () {
    if (typeof window.storeData === "undefined") {
        console.error("❌ storeData tidak ditemukan.");
        return;
    }

    const stores = window.storeData;

    // Inisialisasi peta (default: Medan)
    const defaultLatLng = [3.5952, 98.6722];
    const map = L.map("map").setView(defaultLatLng, 12);

    // Tambahkan tile layer OpenStreetMap
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 18,
        attribution: "&copy; OpenStreetMap contributors",
    }).addTo(map);

    // Tambahkan marker untuk setiap toko
    stores.forEach((store) => {
        if (store.latitude && store.longitude) {
            const marker = L.marker([store.latitude, store.longitude]).addTo(
                map
            );
            marker.bindPopup(
                `<div style='font-size:14px'>
                    <b>${store.name}</b><br>
                    ${store.address ?? "Alamat tidak tersedia"}
                </div>`
            );
        }
    });

    // Auto zoom agar semua marker toko terlihat
    const markers = stores
        .filter((s) => s.latitude && s.longitude)
        .map((s) => L.marker([s.latitude, s.longitude]));
    const group = L.featureGroup(markers);

    if (group.getLayers().length > 0) {
        map.fitBounds(group.getBounds().pad(0.2));
    }

    // === 🧭 Deteksi Lokasi Pengguna ===
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;

                // Tambahkan marker lokasi pengguna
                const userMarker = L.marker([userLat, userLng], {
                    icon: L.icon({
                        iconUrl:
                            "https://cdn-icons-png.flaticon.com/512/64/64113.png",
                        iconSize: [32, 32],
                        iconAnchor: [16, 32],
                        popupAnchor: [0, -30],
                    }),
                }).addTo(map);

                userMarker.bindPopup("<b>Lokasi Anda Saat Ini</b>").openPopup();

                // Fokuskan peta ke lokasi pengguna
                map.setView([userLat, userLng], 14);

                console.log(`📍 Lokasi pengguna: ${userLat}, ${userLng}`);
            },
            (error) => {
                console.warn("⚠️ Gagal mendapatkan lokasi:", error.message);
                Swal.fire({
                    icon: "info",
                    title: "Izin lokasi ditolak",
                    text: "Peta akan menampilkan wilayah default (Medan).",
                    timer: 2500,
                    showConfirmButton: false,
                });
            }
        );
    } else {
        console.warn("❌ Browser tidak mendukung geolokasi.");
        Swal.fire({
            icon: "warning",
            title: "Perangkat tidak mendukung geolokasi",
            text: "Peta akan menampilkan wilayah default (Medan).",
            timer: 2500,
            showConfirmButton: false,
        });
    }

    console.log("✅ Peta lokasi toko berhasil dimuat.");
});
