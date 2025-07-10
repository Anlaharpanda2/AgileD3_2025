// postcss.config.cjs
const path = require('path');

module.exports = {
  plugins: [
    require('tailwindcss'),
    require('autoprefixer'),
    // PurgeCSS harus berjalan setelah semua plugin CSS lainnya
    // dan hanya dalam mode produksi
    process.env.NODE_ENV === 'production'
      ? require('@fullhuman/postcss-purgecss')({
          content: [
            // Jalur relatif dari root proyek (Frontend)
            path.resolve(__dirname, 'index.html'),
            path.resolve(__dirname, 'src/**/*.vue'),
            path.resolve(__dirname, 'src/**/*.js'),
            path.resolve(__dirname, 'src/**/*.ts'),
          ],
          // Ini sangat penting untuk Element Plus agar tidak menghapus kelas yang dihasilkan secara dinamis
          safelist: {
            standard: [
              // Safe list untuk kelas Element Plus yang sering digunakan atau dinamis
              /^el-/, // Kelas yang dimulai dengan 'el-'
              /-(leave|enter|appear)(|-active|-to)$/, // Vue transitions
              /^(?![DdSs]s).*--/, // Handles various dynamic classes
              /^router-link-active$/,
              /^router-view$/,
              /^v-/, // Vue specific classes (e.g., v-modal)
              /data-v-.*/, // Scoped CSS attributes
            ],
            deep: [
              // Untuk selektor dalam yang mungkin tidak terdeteksi oleh standard
            ],
            greedy: [
              // Untuk pola yang lebih kompleks atau regex, hati-hati menggunakannya
            ]
          },
          // defaultExtractor untuk mengekstrak class names dari content
          defaultExtractor: content => content.match(/[\w-:/]+(?<!:)/g) || [],
          // blocklist: ['dark'], // Contoh: blokir kelas 'dark' jika tidak ingin dihapus
        })
      : false, // Jika bukan produksi, PurgeCSS tidak aktif
  ].filter(Boolean) // Filter `false` dari array jika PurgeCSS tidak aktif
};