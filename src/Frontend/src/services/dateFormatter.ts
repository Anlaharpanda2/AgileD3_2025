/**
 * Memformat string tanggal menjadi format yang lebih mudah dibaca (misalnya, "30 Juni 2025").
 * @param dateString String tanggal (misalnya, ISO 8601).
 * @returns String tanggal yang diformat atau "Tanggal tidak valid" jika input tidak valid.
 */
export function formatDate(dateString: string): string {
  const options: Intl.DateTimeFormatOptions = {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  };
  try {
    return new Date(dateString).toLocaleDateString('id-ID', options);
  } catch (e) {
    console.error("Invalid date string for formatDate:", dateString, e);
    return "Tanggal tidak valid";
  }
}
/**
 * Menentukan tipe tag Element Plus (success, warning, info) berdasarkan umur pengumuman.
 * - 'success' jika pengumuman baru (<= 3 hari).
 * - 'warning' jika pengumuman penting (<= 7 hari).
 * - 'info' untuk pengumuman lainnya.
 * @param createdAt String tanggal pembuatan pengumuman.
 * @returns Tipe tag Element Plus.
 */
export function getAnnouncementType(createdAt: string): 'success' | 'warning' | 'info' {
  const now = new Date();
  const created = new Date(createdAt);
  const diffTime = Math.abs(now.getTime() - created.getTime());
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
  if (diffDays <= 3) return 'success'; 
  if (diffDays <= 7) return 'warning'; 
  return 'info'; 
}
/**
 * Menentukan label teks untuk tag pengumuman berdasarkan umurnya.
 * @param createdAt String tanggal pembuatan pengumuman.
 * @returns Label teks ('Baru', 'Penting', 'Info').
 */
export function getAnnouncementLabel(createdAt: string): 'Baru' | 'Penting' | 'Info' {
  const now = new Date();
  const created = new Date(createdAt);
  const diffTime = Math.abs(now.getTime() - created.getTime());
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
  if (diffDays <= 3) return 'Baru';
  if (diffDays <= 7) return 'Penting';
  return 'Info';
}
