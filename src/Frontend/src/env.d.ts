/// <reference types="vite/client" />

interface ImportMetaEnv {
  readonly VITE_API_BASE_URL: string;
  // Tambahkan variabel lain jika perlu
}

interface ImportMeta {
  readonly env: ImportMetaEnv;
}
