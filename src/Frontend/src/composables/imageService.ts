/**
 * Mengembalikan URL gambar atau placeholder jika URL gambar kosong/null.
 * @param foto URL gambar.
 * @returns URL gambar yang valid atau path ke gambar placeholder.
 */
export function getImageSrc(foto: string | null): string {
  if (!foto || foto === null || foto.trim() === '') {
    return '/Berita/Placeholder.jpg';
  }
  return foto;
}
