// vite.config.ts
import { defineConfig } from 'vitest/config'
import tsconfigPaths from 'vite-tsconfig-paths'
import vue from '@vitejs/plugin-vue'
import { fileURLToPath, URL } from 'node:url'
import { visualizer } from 'rollup-plugin-visualizer'
// 🔧 Auto-import Element Plus
import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import { ElementPlusResolver } from 'unplugin-vue-components/resolvers'
import path from 'path'
import tailwindcss from 'tailwindcss'
import autoprefixer from 'autoprefixer'

export default defineConfig({
  css: {
    postcss: {
      plugins: [
        tailwindcss,
        autoprefixer,
      ],
    },
  },
  plugins: [
    vue(),
    tsconfigPaths(),
    
    visualizer({
      filename: 'dist/stats.html',
      template: 'treemap', // atau 'sunburst', atau 'raw' untuk file json
      gzipSize: true,
      brotliSize: true,
      open: true
    }),

    AutoImport({
      imports: ['vue', 'vue-router'],
      resolvers: [ElementPlusResolver()],
      dts: './auto-imports.d.ts',
    }),

    Components({
      resolvers: [
        ElementPlusResolver({
          importStyle: 'css',
        }),
      ],
      dts: './components.d.ts',
    }),
  ],

  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },

  build: {
    rollupOptions: {
      output: {
        manualChunks(id) {
          if (id.includes('node_modules')) {
            const segments = id.split(path.sep)
            const nmIndex = segments.lastIndexOf('node_modules') + 1
            let pkgName = segments[nmIndex]
            // handle scoped packages
            if (pkgName.startsWith('@')) {
              pkgName = `${pkgName}/${segments[nmIndex + 1]}`
            }

            // Element Plus: split per component
            if (pkgName === 'element-plus' && id.includes('es/components')) {
              const comp = id.split('es/components/')[1].split(path.sep)[0]
              return `element-plus-${comp}`
            }

            // Vue core libs
            if (['vue', 'vue-router'].includes(pkgName)) return 'vendor_vue'
            // Specific libs
            if (['jspdf', 'docx', 'xlsx', 'leaflet'].includes(pkgName)) return `vendor_${pkgName}`
            if (['lodash-es'].includes(pkgName)) return 'vendor_lodash'

            // Default: each package to its own chunk
            return `vendor_${pkgName}`
          }
        }
      }
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
