// vitest.config.ts
import { defineConfig } from 'vitest/config'
import tsconfigPaths from 'vite-tsconfig-paths'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url'

export default defineConfig({
  plugins: [
    vue(),
    tsconfigPaths()
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
test: {
  globals: true,
  environment: 'jsdom',
  deps: {
    optimizer: {
      web: {
        include: ['element-plus', '@popperjs/core']
      }
    }
  },
  coverage: {
    provider: 'v8',
    reporter: ['text', 'html'],
    all: true,
    include: ['src/**/*.{js,ts,vue}'],
    exclude: ['node_modules', 'test']
  }
}

})
