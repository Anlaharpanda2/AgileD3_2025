// src/composables/useBeritaCarousel.ts
import { ref, computed, watch, onUnmounted, type Ref } from 'vue';
import type { BeritaItem } from './useBeritaData'; // Import BeritaItem interface

/**
 * Interface untuk item berita yang akan ditampilkan di carousel.
 * Menambahkan properti 'position' dan 'key' untuk kebutuhan rendering dan animasi.
 */
interface CarouselBeritaItem extends BeritaItem {
  position: 'left' | 'center' | 'right';
  index: number; // Menambahkan kembali index untuk clarity
  key: string;
}

/**
 * Interface untuk item pagination bertipe 'page'.
 */
interface PageItem {
  type: 'page';
  value: number;
  active: boolean;
}

/**
 * Interface untuk item pagination bertipe 'ellipsis'.
 */
interface EllipsisItem {
  type: 'ellipsis';
  value: string; // Biasanya "..."
}

/**
 * Tipe gabungan untuk semua jenis item pagination.
 */
type PaginationItem = PageItem | EllipsisItem;

/**
 * Composable untuk mengelola semua logika carousel berita.
 * @param beritaItems Ref ke array BeritaItem yang akan ditampilkan di carousel.
 * @param carouselContainer Ref ke elemen container DOM untuk animasi slide.
 * @param initialIndex Indeks awal carousel. Default 0.
 * @param slideDuration Durasi animasi slide dalam ms. Default 600.
 * @returns Objek dengan state dan fungsi untuk mengontrol carousel.
 */
export function useBeritaCarousel(
  beritaItems: Ref<BeritaItem[]>,
  carouselContainer: Ref<HTMLElement | null>,
  initialIndex: number = 0,
  slideDuration: number = 600
) {
  // --- State Reaktif ---
  const currentIndex = ref(initialIndex);
  const isAnimating = ref(false); // Flag untuk mencegah klik berulang selama animasi
  
  // --- Konfigurasi Animasi & Auto-slide ---
  const animationDuration = slideDuration; // Durasi total animasi slide (ms)
  const autoSlideIntervalTime = 5000; // Interval auto-slide (ms)
  
  // Variabel untuk menyimpan ID interval auto-slide
  let slideInterval: NodeJS.Timeout | null = null;

  // --- Computed Properties ---
  const maxIndex = computed(() => Math.max(0, beritaItems.value.length - 1));
  const canGoPrev = computed(() => currentIndex.value > 0);
  const canGoNext = computed(() => currentIndex.value < maxIndex.value);

  /**
   * Computed: Mengembalikan 3 item berita yang terlihat di carousel saat ini.
   * Menambahkan properti 'position' ('left', 'center', 'right') untuk styling berbasis posisi
   * dan 'key' unik untuk manajemen v-for yang efisien dengan transisi.
   */
  const visibleNews = computed<CarouselBeritaItem[]>(() => {
    const items: CarouselBeritaItem[] = [];
    const total = beritaItems.value.length;
    
    if (total === 0) return [];
    
    // Iterasi untuk mendapatkan 3 item yang akan ditampilkan
    for (let i = 0; i < Math.min(3, total); i++) {
      const index = currentIndex.value + i;
      if (index < total) {
        let position: 'left' | 'center' | 'right';
        if (i === 0) position = 'left';
        else if (i === 1) position = 'center';
        else position = 'right';

        items.push({ 
          ...beritaItems.value[index], 
          position, 
          index: index, // Menyertakan index untuk referensi
          key: `${index}-${position}` // Key unik untuk transisi
        });
      }
    }
    return items;
  });

  /**
   * Computed: Logika smart pagination untuk menampilkan angka halaman dan elipsis.
   * Menyesuaikan tampilan pagination berdasarkan jumlah total berita.
   */
  const paginationItems = computed<PaginationItem[]>(() => { // <-- PERUBAHAN DI SINI: Tipe eksplisit
    const total = beritaItems.value.length;
    const current = currentIndex.value;
    const items: PaginationItem[] = []; // <-- PERUBAHAN DI SINI: Tipe eksplisit
    
    // Jika jumlah berita sedikit, tampilkan semua halaman
    if (total <= 7) {
      for (let i = 0; i < total; i++) {
        items.push({ type: 'page', value: i, active: i === current });
      }
    } else {
      // Selalu tampilkan halaman pertama
      items.push({ type: 'page', value: 0, active: current === 0 });
      
      // Tambahkan elipsis jika current index jauh dari awal
      if (current > 3) {
        items.push({ type: 'ellipsis', value: '...' });
      }
      
      // Tampilkan 3 halaman di sekitar current index
      const start = Math.max(1, current - 1);
      const end = Math.min(total - 2, current + 1);
      
      for (let i = start; i <= end; i++) {
        // Hindari duplikasi halaman pertama dan terakhir jika sudah ada
        if (i !== 0 && i !== total - 1) { 
          items.push({ type: 'page', value: i, active: i === current });
        }
      }
      
      // Tambahkan elipsis jika current index jauh dari akhir
      if (current < total - 4) {
        items.push({ type: 'ellipsis', value: '...' });
      }
      
      // Selalu tampilkan halaman terakhir jika ada lebih dari 1 berita
      if (total > 1) { 
        items.push({ type: 'page', value: total - 1, active: current === total - 1 });
      }
    }
    return items;
  });

  // --- Fungsi Animasi Internal ---
  /**
   * Fungsi bantu untuk mengelola animasi slide pada container carousel.
   * Menggunakan transform dan opacity untuk transisi.
   * @param direction Arah slide untuk animasi (-1 untuk next, 1 untuk prev, 0 untuk reset).
   * @param targetIndex Indeks baru yang akan diatur setelah animasi keluar.
   */
  const _animateSlide = (direction: number, targetIndex: number) => {
    isAnimating.value = true;
    const container = carouselContainer.value;

    if (container) {
      // Fase 1: Animasi keluar (geser dan pudar)
      container.style.transform = `translateX(${direction * 50}px)`; // Misal: 50px atau -50px
      container.style.opacity = '0.7';
    }

    setTimeout(() => {
      currentIndex.value = targetIndex; // Update data setelah animasi keluar
      
      if (container) {
        // Fase 2: Reset posisi dan animasi masuk
        // Geser ke arah berlawanan untuk "menyembunyikan" konten baru sebelum muncul
        container.style.transform = `translateX(${-direction * 50}px)`;
        
        // Timeout kecil untuk memastikan browser meregister perubahan transform sebelum transisi masuk
        setTimeout(() => {
          container.style.transform = 'translateX(0)'; // Geser kembali ke posisi normal
          container.style.opacity = '1'; // Munculkan kembali
          isAnimating.value = false; // Akhiri status animasi
        }, 50); // Delay kecil ini penting untuk efek transisi
      }
    }, animationDuration / 2); // Separuh durasi animasi untuk transisi keluar
  };

  // --- Metode Navigasi Carousel ---
  /**
   * Fungsi navigasi ke slide sebelumnya dengan animasi.
   */
  const goToPrev = () => {
    if (!canGoPrev.value || isAnimating.value) return;
    _animateSlide(1, currentIndex.value - 1); // Arah 1 (kanan) untuk prev
  };

  /**
   * Fungsi navigasi ke slide berikutnya dengan animasi.
   */
  const goToNext = () => {
    if (!canGoNext.value || isAnimating.value) return;
    _animateSlide(-1, currentIndex.value + 1); // Arah -1 (kiri) untuk next
  };

  /**
   * Fungsi navigasi langsung ke indeks tertentu dengan animasi.
   * @param index Indeks tujuan.
   */
  const goToIndex = (index: number) => {
    if (index < 0 || index >= beritaItems.value.length || isAnimating.value || index === currentIndex.value) {
      return;
    }
    const direction = index > currentIndex.value ? -1 : 1; // Tentukan arah slide
    _animateSlide(direction, index);
  };

  // --- Watchers ---
  // Watch untuk menerapkan CSS transition pada container saat currentIndex berubah.
  // Ini memastikan transisi CSS global pada container untuk efek slide.
  watch(currentIndex, () => {
    const container = carouselContainer.value;
    if (container) {
      container.style.transition = `all ${animationDuration}ms cubic-bezier(0.4, 0, 0.2, 1)`;
    }
  });

  // Watch untuk mereset currentIndex jika data berita berkurang atau berubah secara signifikan.
  // Juga untuk refresh auto-slide.
  watch(beritaItems, (newItems) => {
    // Jika currentIndex melebihi panjang array baru, reset ke 0
    if (currentIndex.value >= newItems.length && newItems.length > 0) {
      currentIndex.value = 0;
    } else if (newItems.length === 0) { // Jika tidak ada berita
      currentIndex.value = 0;
    }
    // Hentikan dan mulai kembali auto-slide jika daftar berita berubah
    stopAutoSlide();
    startAutoSlide();
  }, { deep: true }); // Gunakan deep watch jika array beritaItems bisa berubah secara mutabel

  // --- Fungsi Auto-slide ---
  /**
   * Memulai fitur auto-slide.
   */
  const startAutoSlide = () => {
    // Hanya memulai auto-slide jika ada lebih dari 3 berita (untuk carousel yang aktif)
    // dan jika interval belum berjalan
    if (beritaItems.value.length > 3 && slideInterval === null) { 
      slideInterval = setInterval(() => {
        // Jika bisa maju ke slide berikutnya dan tidak sedang dalam animasi
        if (canGoNext.value && !isAnimating.value) {
          goToNext();
        } else if (!isAnimating.value) {
          // Jika sudah di akhir atau tidak bisa maju, kembali ke slide pertama
          goToIndex(0); 
        }
      }, autoSlideIntervalTime);
    }
  };

  /**
   * Menghentikan fitur auto-slide.
   */
  const stopAutoSlide = () => {
    if (slideInterval) {
      clearInterval(slideInterval);
      slideInterval = null;
    }
  };

  // --- Lifecycle Hook ---
  // Cleanup interval saat komponen tidak lagi dimount untuk mencegah memory leak.
  onUnmounted(() => {
    stopAutoSlide();
  });

  // --- Mengembalikan State dan Fungsi ---
  return {
    currentIndex,
    visibleNews,
    canGoPrev,
    canGoNext,
    paginationItems,
    goToPrev,
    goToNext,
    goToIndex,
    isAnimating,
    startAutoSlide,
    stopAutoSlide
  };
}
