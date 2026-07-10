# Code Charmer

Marketing site for [codecharmer.io](https://codecharmer.io), built with [Astro](https://astro.build). Ships as a static HTML/CSS/JS site, with components structured so each maps cleanly to a future block-based WordPress theme.

## Requirements

- **Node.js** `>=18.20.8` (the repo is pinned to **22** via [`.nvmrc`](.nvmrc))
- **npm** (bundled with Node)

If you use [nvm](https://github.com/nvm-sh/nvm), run `nvm use` in the project root to switch to the expected version:

```bash
nvm use
```

## Getting started

Clone the repo and install dependencies:

```bash
git clone git@github.com:codecharmer/codecharmer.git
cd codecharmer
npm install
```

Start the development server:

```bash
npm run dev
```

The site will be available at [http://localhost:4321](http://localhost:4321) with hot-module reloading.

## Scripts

| Command           | Description                                        |
| ----------------- | -------------------------------------------------- |
| `npm run dev`     | Start the local dev server at `localhost:4321`     |
| `npm run build`   | Build the production site to `./dist/`             |
| `npm run preview` | Serve the built site locally to preview the output |
| `npm run astro`   | Run Astro CLI commands (e.g. `npm run astro check`)|

## Building for production

```bash
npm run build
```

Static output is written to `./dist/`. Preview the exact build before deploying:

```bash
npm run preview
```

## Project structure

```
src/
├── pages/          # Routes — each file maps to a URL
├── layouts/        # Shared page shells (Base.astro)
├── components/
│   ├── blocks/     # Page sections (Hero, Faq, CtaBand…) — future Gutenberg blocks
│   ├── layout/     # Header, Footer
│   ├── ui/         # Primitives (Button, Icon, Logo)
│   └── graphics/   # SVG / diagram components
├── data/           # Site content and configuration (site.ts)
├── styles/         # Global CSS and design tokens (global.css)
└── env.d.ts        # Astro type definitions

docs/               # Internal planning notes
```

### Path aliases

Import aliases are configured in [`tsconfig.json`](tsconfig.json):

| Alias           | Resolves to        |
| --------------- | ------------------ |
| `@components/*` | `src/components/*` |
| `@layouts/*`    | `src/layouts/*`    |
| `@data/*`       | `src/data/*`       |
| `@styles/*`     | `src/styles/*`     |

```astro
---
import Base from '@layouts/Base.astro';
import Hero from '@components/blocks/Hero.astro';
---
```

## Adding a page

Create a `.astro` file under `src/pages/`. The file path becomes the route — for example, `src/pages/about.astro` serves `/about`. Nested routes live in subdirectories (`src/pages/services/index.astro` → `/services`).

## Fonts

Web fonts are self-hosted via [Fontsource](https://fontsource.org) and imported in the layout, so there are no external font requests at runtime:

- Bricolage Grotesque (variable)
- Hanken Grotesk (variable)
- Geist Mono (variable)
