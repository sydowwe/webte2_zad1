import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

import * as path from 'path';

export default defineConfig({
  plugins: [vue()],
  // resolve: {
  //   alias: {
  //     jquery: path.resolve(__dirname, './node_modules/jquery/dist/jquery.min.js')
  //   }
  // },
  // optimizeDeps: {
  //   include: ['jquery', 'bootstrap', 'datatables.net', 'datatables.net-bs5', 'select2']
  // },
  // build: {
  //   rollupOptions: {
  //     output: {
  //       globals: {
  //         jquery: 'jQuery',
  //         bootstrap: 'bootstrap',
  //         'datatables.net': 'DataTables',
  //         'datatables.net-bs5': 'DataTables',
  //         select2: 'Select2'
  //       }
  //     }
  //   }
  // }
});