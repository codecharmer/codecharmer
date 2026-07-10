// @ts-check
import { defineConfig } from 'astro/config';

// Static site, architected so each component maps to a future Gutenberg block.
// https://astro.build/config
export default defineConfig({
  site: 'https://codecharmer.io',
  build: {
    // Inline small stylesheets; keep the critical path lean.
    inlineStylesheets: 'auto',
  },
  compressHTML: true,
});
