/**
 * Instrumented-rail scroll driver.
 *
 * Sets `--rail-progress` (0–1) and per-node / per-readout state on every
 * `[data-scrub]` rail as the reader moves through it. Scroll position is
 * process position — that relationship is the whole reason this motion exists.
 *
 * Why not `animation-timeline: view()`:
 * Chrome 148 reports CSS.supports('animation-timeline','view()') === true, but
 * a CSS-declared view timeline resolves inactive — verified: a JS-constructed
 * `new ViewTimeline({subject})` on the same element scrubs correctly while the
 * CSS one reports `timeline.currentTime === null`. Firefox has no support at
 * all. CSS-only would therefore ship a static rail to most visitors.
 *
 * Why not IntersectionObserver to gate the listener:
 * IO callbacks are delivered on rendering opportunities, so a throttled or
 * backgrounded tab can go indefinitely without one. Gating on IO means the
 * rail silently never activates in exactly those conditions. A rect check
 * inside the rAF handler costs less than the observer and cannot stall.
 *
 * Failure mode by design: this only ever *rewinds* a rail that CSS has already
 * rendered complete. No JS, a thrown error, or reduced motion all leave a
 * finished rail rather than a blank one.
 */

type Mode = 'band' | 'through';

const REDUCED = '(prefers-reduced-motion: reduce)';

export function initRails(root: ParentNode = document): void {
  if (window.matchMedia(REDUCED).matches) return;

  const rails = Array.from(root.querySelectorAll<HTMLElement>('.rail[data-scrub]'));
  if (!rails.length) return;

  let frame = 0;

  const apply = (rail: HTMLElement): void => {
    const rect = rail.getBoundingClientRect();
    const vh = window.innerHeight || document.documentElement.clientHeight;

    // Well outside the viewport: nothing to recompute this frame.
    if (rect.bottom < -vh || rect.top > vh * 2) return;

    const p =
      rail.dataset.scrub === 'through'
        ? // Tall rails (the /process timeline): track the reader's position
          // through the section itself.
          (vh * 0.52 - rect.top) / (rect.height || 1)
        : // Short rails: run the scrub as the rail rises from the lower part
          // of the viewport toward the upper third.
          (vh * 0.86 - rect.top) / (vh * 0.52);

    const clamped = Math.min(1, Math.max(0, p));

    rail.style.setProperty('--rail-progress', clamped.toFixed(4));
    rail.toggleAttribute('data-at-edge', clamped <= 0.001 || clamped >= 0.999);

    const setState = (marker: HTMLElement, from: number, to: number): void => {
      const state = clamped < from ? 'queued' : clamped < to ? 'active' : 'committed';
      if (marker.dataset.state !== state) marker.dataset.state = state;
    };

    // Authored spans: the block knew the weights at build time.
    for (const marker of rail.querySelectorAll<HTMLElement>('[data-from]')) {
      setState(marker, Number(marker.dataset.from), Number(marker.dataset.to));
    }

    // Measured spans: on the tall timeline a stage's extent is set by how much
    // copy it has, so read it off the layout instead of guessing in the data.
    const autos = rail.querySelectorAll<HTMLElement>('[data-auto]');
    if (autos.length) {
      const height = rect.height || 1;
      const starts = Array.from(autos, (el) => (el.getBoundingClientRect().top - rect.top) / height);
      autos.forEach((marker, i) => setState(marker, starts[i], starts[i + 1] ?? 1));
    }
  };

  const paint = (): void => {
    frame = 0;
    rails.forEach(apply);
  };

  const schedule = (): void => {
    if (!frame) frame = requestAnimationFrame(paint);
  };

  // Position first, then hand the rail over — so it never paints a frame of
  // empty track between "rewound by CSS" and "positioned by script".
  rails.forEach((rail) => {
    apply(rail);
    rail.setAttribute('data-rail-live', '');
  });

  window.addEventListener('scroll', schedule, { passive: true });
  window.addEventListener('resize', schedule, { passive: true });
  // Restored tabs and bfcache returns land at a scroll position nobody scrolled to.
  window.addEventListener('pageshow', schedule);
}
