// src/services/textFormatter.ts

/**
 * Memotong teks hingga panjang maksimum yang ditentukan dan menambahkan elipsis jika dipotong.
 * @param text Teks asli.
 * @param maxLength Panjang maksimum teks sebelum dipotong. Default 120.
 * @returns Teks yang dipotong atau teks asli jika lebih pendek dari maxLength.
 */
export function truncateText(text: string, maxLength: number = 120): string {
  if (!text || text.length <= maxLength) {
    return text;
  }
  return text.substring(0, maxLength) + '...';
}
