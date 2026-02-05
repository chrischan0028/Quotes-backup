import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
  plugins: [vue()],

  define: {
    'process.env': {}
  },

  build: {
    lib: {
      entry: path.resolve(__dirname, 'resources/js/main.ts'),
      name: 'QuotesUI',
      fileName: () => 'quotes-ui.js',
      formats: ['iife']
    },
    outDir: path.resolve(__dirname, 'dist'),
    emptyOutDir: true
  }
})
