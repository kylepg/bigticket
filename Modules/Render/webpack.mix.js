const dotenvExpand = require(`dotenv-expand`);
dotenvExpand(require(`dotenv`).config({ path: `../../.env`/*, debug: true*/ }));
const tailwindcss = require(`tailwindcss`);

const mix = require(`laravel-mix`);
require(`laravel-mix-merge-manifest`);

mix.setPublicPath(`../../public`).mergeManifest();

mix

/* ---------------------------------- Draft --------------------------------- */
  .sass(`${__dirname}/Resources/views/draft/scss/draft.scss`, `render-assets/draft/draft.css`)
  .js(`${__dirname}/Resources/views/draft/js/draft.js`, `render-assets/draft/draft.js`)
  /* -------------------------- Team | Career Center -------------------------- */
  .sass(`${__dirname}/Resources/views/team/career-center/scss/career-center.scss`, `render-assets/team/career-center/career-center.css`)
  .js(`${__dirname}/Resources/views/team/career-center/js/career-center.js`, `render-assets/team/career-center/career-center.js`)
  .sass(`${__dirname}/Resources/views/team/career-center/scss/blog.scss`, `render-assets/team/career-center/blog.css`)
  .js(`${__dirname}/Resources/views/team/career-center/js/blog.js`, `render-assets/team/career-center/blog.js`)
  /* -------------------------------- Tailwind -------------------------------- */
  .sass(`${__dirname}/Resources/tailwindcss/tailwind.scss`, `render-assets/render/tailwind.css`)
  .options({
    processCssUrls: false,
    postCss: [tailwindcss(`${__dirname}/Resources/tailwindcss/tailwind.config.js`)],
  })
  /* ---------------------------------- Misc ---------------------------------- */
  .js(`${__dirname}/Resources/assets/js/app.js`, `render-assets/render.js`)
  .browserSync(`127.0.0.1:8000`);

if (mix.inProduction()) {
  mix.version();
}
