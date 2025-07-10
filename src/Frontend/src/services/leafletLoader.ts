// src/services/leafletLoader.ts

/**
 * Memuat library Leaflet secara dinamis (CSS dan JS) jika belum ada di window.L.
 * Juga mengatur opsi default untuk ikon marker agar dapat ditampilkan dengan benar.
 * @returns Promise yang resolve dengan objek Leaflet (window.L) setelah dimuat.
 */
export const loadLeaflet = (): Promise<typeof import('leaflet')> => {
  return new Promise((resolve, reject) => {
    // Periksa apakah Leaflet sudah dimuat
    if (window.L) {
      resolve(window.L as typeof import('leaflet'));
      return;
    }

    // Fungsi untuk memeriksa apakah Leaflet sudah dimuat setelah script selesai
    const checkLeafletLoaded = () => {
    if (window.L) {
        const DefaultIcon = window.L.Icon.Default;

        // Paksa akses _getIconUrl dengan casting ke any
        const prototypeAny = DefaultIcon.prototype as { _getIconUrl?: unknown };

        if (typeof prototypeAny._getIconUrl !== 'undefined') {
        delete prototypeAny._getIconUrl;
        }

        DefaultIcon.mergeOptions({
        iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
        iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
        });

        resolve(window.L as typeof import('leaflet'));
    } else {
        reject(new Error('Leaflet script loaded but L object not found.'));
    }
    };


    // Muat CSS Leaflet
    const cssLink = document.createElement('link');
    cssLink.rel = 'stylesheet';
    cssLink.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
    cssLink.integrity = 'sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=';
    cssLink.crossOrigin = '';
    document.head.appendChild(cssLink);

    // Muat JS Leaflet
    const script = document.createElement('script');
    script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
    script.integrity = 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=';
    script.crossOrigin = '';
    script.async = true;
    script.defer = true;
    script.onload = checkLeafletLoaded; // Panggil fungsi cek setelah script dimuat
    script.onerror = () => reject(new Error('Gagal memuat Leaflet script.'));
    document.head.appendChild(script);
  });
};
