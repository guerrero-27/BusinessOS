<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Baseline — Tennis Club & Academy</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500&display=swap" rel="stylesheet">
<script type="importmap">{"imports":{"lenis":"https://cdn.jsdelivr.net/npm/lenis@1.1.18/+esm"}}</script>
<style>
/* === CSS VARIABLES === */
:root {
  --background: #ffffff; --foreground: #0a0a0a;
  --brand: #2563c9; --brand-deep: #0f2f63; --brand-light: #5790e6;
  --accent-teal: #0b6e97; --surface: #f4f4f4; --surface-card: #ffffff;
  --ink: #0a0a0a; --ink-soft: #717784; --ghost: #d7dae1; --hairline: #e6e8ec;
  --on-brand: #ffffff;
  --radius-card: 1.5rem; --radius-card-lg: 2rem; --radius-pill: 62.5rem;
}

/* === ADAPTIVE REM GRID === */
html { font-size: 16px; }
@media (max-width: 1920px) { html { font-size: 0.833333vw; } }
@media (max-width: 1440px) { html { font-size: 1.111111vw; } }
@media (max-width: 1024px) { html { font-size: 1.5625vw; } }
@media (max-width: 640px)  { html { font-size: 4.444444vw; } }
html.scroll-locked { position: relative; overflow: hidden; height: 100%; }

/* === RESET & BASE === */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
img, video { display: block; max-width: 100%; }
button { cursor: pointer; border: none; background: none; font: inherit; color: inherit; }
a { text-decoration: none; color: inherit; }
ul, ol { list-style: none; }
:focus-visible { outline: 2px solid var(--brand-light); outline-offset: 2px; }
body { font-family: 'Onest', system-ui, sans-serif; min-height: 100vh; background: var(--background); color: var(--foreground); }
main { padding: 0.5rem; width: 100%; overflow-x: clip; }
@media (min-width: 640px) { main { padding: 0.75rem; } }

/* === LOADER === */
#loader {
  position: fixed; inset: 0; z-index: 200;
  background: var(--brand-deep);
  display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 2rem;
  color: white;
}
.loader-mark { display: flex; flex-direction: column; align-items: center; gap: 0.5rem; opacity: 0; }
.loader-icon { width: 1.75rem; height: 1.75rem; }
.loader-name { font-size: 1.5rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.2em; }
.loader-progress { width: 10rem; height: 1px; background: rgba(255,255,255,0.2); position: relative; overflow: hidden; }
.loader-fill { position: absolute; inset: 0; background: white; transform-origin: left; transform: scaleX(0); }

/* === HEADER === */
.site-header { padding: 1.5rem 1.5rem 0; display: flex; align-items: center; color: white; position: relative; z-index: 10; font-size: 0.75rem; }
@media (min-width: 640px) { .site-header { padding: 2rem 2.5rem 0; } }
.header-nav { flex: 1; display: none; gap: 2rem; }
@media (min-width: 1024px) { .header-nav { display: flex; } }
.header-nav a { color: rgba(255,255,255,0.9); transition: color 0.2s; white-space: nowrap; }
.header-nav a:hover { color: white; }
.header-brand { flex: 1; display: flex; align-items: center; gap: 0.5rem; }
@media (min-width: 1024px) { .header-brand { justify-content: center; } }
.brand-mark { width: 1.5rem; height: 1.5rem; flex-shrink: 0; }
.brand-name { font-size: 1rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.2em; }
.header-right { flex: 1; display: flex; align-items: center; justify-content: flex-end; gap: 1rem; }
@media (min-width: 640px) { .header-right { gap: 1.25rem; } }
.header-book { display: none; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.1em; color: white; text-decoration: underline; text-underline-offset: 2px; cursor: pointer; }
@media (min-width: 640px) { .header-book { display: block; } }
.burger-btn { width: 2.5rem; height: 2.5rem; border-radius: var(--radius-pill); background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 5px; flex-shrink: 0; }
.burger-bar { display: block; width: 1rem; height: 1px; background: white; pointer-events: none; }

/* === HERO === */
#hero { background: var(--brand-deep); color: white; position: relative; isolation: isolate; overflow: hidden; border-radius: var(--radius-card-lg); height: calc(100svh - 1rem); min-height: 36rem; display: flex; flex-direction: column; }
@media (min-width: 640px) { #hero { height: calc(100svh - 1.5rem); } }
.hero-parallax { position: absolute; inset: 0; z-index: -10; pointer-events: none; }
.hero-parallax-inner { position: absolute; left: 0; right: 0; top: -16%; height: 132%; width: 100%; will-change: transform; }
.hero-parallax-inner img { width: 100%; height: 100%; object-fit: cover; display: block; }
.hero-overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(15,47,99,0.65), rgba(15,47,99,0.35), rgba(15,47,99,0.75)); }
#hero-title { font-size: 12.5vw; font-weight: 500; text-transform: uppercase; line-height: 0.85; letter-spacing: -0.02em; white-space: nowrap; padding: 1rem 1.5rem 0; }
@media (min-width: 640px) { #hero-title { padding: 2.5rem; } }
.hero-bottom { margin-top: auto; padding: 0 1.5rem 2rem; display: flex; flex-direction: column; gap: 1.5rem; }
@media (min-width: 640px) { .hero-bottom { padding: 0 2.5rem 2.5rem; flex-direction: row; justify-content: space-between; align-items: flex-end; } }
.hero-tagline { font-size: 2.4rem; font-weight: 500; text-transform: uppercase; line-height: 0.95; color: rgba(255,255,255,0.85); }
.hero-tagline .stacked-line { display: block; }
.hero-right { display: flex; align-items: flex-end; gap: 1rem; flex-shrink: 0; }

/* === COLLECTION SLIDER === */
.collection-slider { display: none; width: 16rem; flex-shrink: 0; }
@media (min-width: 768px) { .collection-slider { display: block; } }
.slider-track { position: relative; }
.slide-card { display: flex; flex-direction: row; gap: 0.75rem; border-radius: var(--radius-card); border: 1px solid rgba(255,255,255,0.15); background: rgba(255,255,255,0.1); padding: 0.75rem; backdrop-filter: blur(10px); box-shadow: 0 4px 20px rgba(0,0,0,0.2); transition: opacity 0.4s ease; position: absolute; inset: 0; opacity: 0; pointer-events: none; }
.slide-card.is-active { opacity: 1; position: relative; pointer-events: auto; }
.slide-img { width: 3.5rem; height: 3.5rem; border-radius: 0.75rem; object-fit: cover; flex-shrink: 0; }
.slide-content { flex: 1; min-width: 0; }
.slide-brand { font-size: 0.7rem; font-weight: 500; text-transform: uppercase; color: var(--brand-light); line-height: 1.3; }
.slide-title { font-size: 0.7rem; text-transform: uppercase; color: rgba(255,255,255,0.8); margin-top: 0.2rem; line-height: 1.3; }
.slide-cta { font-size: 0.65rem; color: white; text-decoration: underline; text-underline-offset: 2px; display: block; margin-top: 0.35rem; }
.slider-dots { display: flex; gap: 0.5rem; margin-top: 0.75rem; justify-content: center; }

/* === MEMBERSHIP CARD === */
.membership-card { width: 100%; max-width: 20rem; display: flex; flex-direction: row; gap: 0.75rem; align-items: stretch; border-radius: var(--radius-card); border: 1px solid rgba(255,255,255,0.15); background: rgba(255,255,255,0.1); padding: 0.75rem; backdrop-filter: blur(10px); box-shadow: 0 4px 20px rgba(0,0,0,0.2); }
@media (min-width: 640px) { .membership-card { max-width: 15rem; } }
.membership-left { display: flex; flex-direction: column; justify-content: space-between; flex: 1; min-width: 0; }
.membership-count { font-size: 1.875rem; font-weight: 500; color: white; line-height: 1; }
.member-avatars { display: flex; margin-top: 0.4rem; }
.member-avatar { width: 1.4rem; height: 1.4rem; border-radius: 50%; border: 1.5px solid rgba(255,255,255,0.4); flex-shrink: 0; display: block; }
.member-avatar + .member-avatar { margin-left: -0.45rem; }
.membership-label { font-size: 0.65rem; color: rgba(255,255,255,0.8); margin-top: 0.35rem; line-height: 1.3; }
.membership-img { width: 4rem; aspect-ratio: 3/4; border-radius: 0.75rem; object-fit: cover; flex-shrink: 0; }

/* === DOT BUTTONS === */
.dot-btn { display: inline-flex; align-items: center; justify-content: center; height: 0.375rem; border-radius: var(--radius-pill); border: none; transition: width 0.3s ease, background-color 0.3s ease; cursor: pointer; padding: 0; flex-shrink: 0; }
.dot-btn.dot-active-dark { background: var(--ink); width: 1.25rem; }
.dot-btn.dot-idle-dark { background: var(--ghost); width: 0.375rem; }
.dot-btn.dot-active-light { background: white; width: 1.25rem; }
.dot-btn.dot-idle-light { background: rgba(255,255,255,0.4); width: 0.375rem; }

/* === EYEBROW === */
.eyebrow { display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.22em; }
.eyebrow-dot { width: 0.375rem; height: 0.375rem; border-radius: var(--radius-pill); flex-shrink: 0; }
.eyebrow-dark { color: var(--ink-soft); }
.eyebrow-dark .eyebrow-dot { background: var(--brand); }
.eyebrow-light { color: rgba(255,255,255,0.7); }
.eyebrow-light .eyebrow-dot { background: var(--brand-light); }

/* === PILL BUTTON === */
.pill-btn { display: inline-flex; align-items: center; gap: 0.5rem; border-radius: var(--radius-pill); padding: 0.875rem 1.75rem; font-size: 0.875rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; font-family: inherit; cursor: pointer; white-space: nowrap; border: 1.5px solid transparent; transition: background-color 0.2s, color 0.2s, border-color 0.2s; }
.pill-btn-light { background: white; color: var(--brand-deep); border-color: white; }
.pill-btn-light:hover { background: var(--brand-light); color: white; border-color: var(--brand-light); }
.pill-btn-solid { background: var(--ink); color: white; border-color: var(--ink); }
.pill-btn-solid:hover { background: var(--brand-deep); border-color: var(--brand-deep); }
.pill-btn-outline { background: transparent; color: var(--ink); border-color: currentColor; }
.pill-btn-outline:hover { background: var(--ink); color: white; }

/* === ARROW BUTTON === */
.arrow-btn { display: inline-flex; align-items: center; justify-content: center; width: 3rem; height: 3rem; border-radius: var(--radius-pill); cursor: pointer; flex-shrink: 0; border: 1.5px solid transparent; background: none; transition: background-color 0.2s, border-color 0.2s; }
@media (min-width: 640px) { .arrow-btn { width: 3.5rem; height: 3.5rem; } }
.arrow-btn-outline { border-color: var(--hairline); color: var(--ink); }
.arrow-btn-outline:hover { border-color: var(--ink); }
.arrow-btn-solid { background: var(--ink); border-color: var(--ink); color: white; }
.arrow-btn-solid:hover { background: var(--brand-deep); border-color: var(--brand-deep); }
.arrow-btn-prev { transform: scaleX(-1); }

/* === TRUST SECTION === */
#trust { background: var(--background); padding: 4rem 1.5rem; position: relative; isolation: isolate; overflow: hidden; }
@media (min-width: 640px) { #trust { padding: 5rem 2.5rem; } }
.trust-badges { display: flex; flex-direction: column; gap: 1.5rem; position: relative; z-index: 20; }
@media (min-width: 640px) { .trust-badges { flex-direction: row; justify-content: space-between; align-items: flex-start; } }
.trust-pct-badge { width: 7rem; height: 7rem; border-radius: 50%; background: var(--surface); display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 0.75rem; flex-shrink: 0; }
@media (min-width: 640px) { .trust-pct-badge { width: 8rem; height: 8rem; } }
.trust-pct-value { font-size: 1.5rem; font-weight: 500; }
.trust-pct-label { font-size: 0.6rem; color: var(--ink-soft); margin-top: 0.25rem; line-height: 1.3; }
.trust-badge-card { max-width: 28rem; border-radius: var(--radius-card); background: var(--surface); padding: 1.25rem; }
@media (min-width: 640px) { .trust-badge-card { padding: 1.5rem; } }
.trust-badge-index { display: inline-block; background: var(--background); border-radius: 0.75rem; padding: 0.5rem 1rem; font-size: 1.25rem; font-weight: 500; }
.trust-badge-title { font-size: 1.125rem; font-weight: 500; margin-top: 0.75rem; }
.trust-badge-body { font-size: 0.75rem; color: var(--ink-soft); margin-top: 0.5rem; line-height: 1.5; }
.trust-ghost { pointer-events: none; max-width: 88rem; margin: 3rem auto 0; position: relative; z-index: 0; }
.trust-ghost-row { display: flex; justify-content: space-between; align-items: baseline; }
.trust-ghost-word { font-size: 8.2vw; font-weight: 500; text-transform: uppercase; line-height: 1.02; display: inline-block; will-change: transform; }
.trust-ghost-word.ink { color: var(--ink); }
.trust-ghost-word.ghost { color: var(--ghost); }
.trust-coach-wrap { width: 13rem; margin: 2rem auto 0; position: relative; z-index: 10; }
@media (min-width: 640px) { .trust-coach-wrap { position: absolute; width: 16rem; left: 50%; margin-left: -8rem; top: 50%; margin-top: -12rem; } }
.trust-coach-fig { aspect-ratio: 3/4; border-radius: var(--radius-card); background: var(--brand); overflow: hidden; position: relative; transform: rotate(6deg); }
.trust-coach-fig img { width: 100%; height: 100%; object-fit: cover; display: block; transition: opacity 0.3s ease; }
.trust-coach-caption { position: absolute; left: 0.75rem; right: 0.75rem; bottom: 0.75rem; border-radius: 0.75rem; background: rgba(15,47,99,0.4); backdrop-filter: blur(10px); padding: 0.5rem 0.75rem; color: white; }
.trust-coach-name { font-size: 0.875rem; font-weight: 500; }
.trust-coach-role { font-size: 0.65rem; color: rgba(255,255,255,0.8); }
.trust-controls { display: flex; align-items: center; justify-content: space-between; margin-top: 3rem; position: relative; z-index: 20; }
@media (min-width: 640px) { .trust-controls { margin-top: 6rem; } }
.trust-dots { display: flex; gap: 0.5rem; }

/* === PROGRAMS SECTION === */
#programs { background: var(--surface); padding: 6rem 1.5rem; }
@media (min-width: 640px) { #programs { padding: 6rem 2.5rem; } }
#programs-title { font-size: 3rem; font-weight: 500; margin-top: 1rem; line-height: 0.95; }
.stacked-line { display: block; }
.programs-list { margin-top: 3.5rem; }
.program-item { display: flex; flex-direction: row; align-items: center; gap: 1.5rem; padding: 1.75rem 0; border-top: 1px solid var(--hairline); color: inherit; width: 100%; }
.program-item:last-child { border-bottom: 1px solid var(--hairline); }
.program-item:hover .program-name { color: var(--brand); }
.program-index { width: 2.5rem; font-size: 0.875rem; font-weight: 500; color: var(--ink-soft); flex-shrink: 0; }
.program-info { flex: 1; min-width: 0; }
.program-name { font-size: 1.5rem; font-weight: 500; line-height: 1.1; transition: color 0.2s; }
@media (min-width: 640px) { .program-name { font-size: 1.875rem; } }
.program-desc { font-size: 0.875rem; color: var(--ink-soft); margin-top: 0.25rem; line-height: 1.4; }
.program-arrow { width: 2.75rem; height: 2.75rem; border-radius: var(--radius-pill); border: 1.5px solid var(--hairline); display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: var(--ink); }

/* === FACILITIES SECTION === */
#facilities { background: var(--background); border-radius: var(--radius-card-lg); margin-top: -2.5rem; padding: 4rem 1.5rem; position: relative; z-index: 1; }
@media (min-width: 640px) { #facilities { padding: 5rem 2.5rem; } }
.facilities-grid { display: grid; grid-template-columns: 1fr; gap: 2.5rem; align-items: end; }
@media (min-width: 768px) { .facilities-grid { grid-template-columns: 1fr 1fr; } }
.facilities-intro { max-width: 24rem; }
.facilities-icon { width: 4rem; height: 4rem; border-radius: var(--radius-card); object-fit: cover; }
#facilities-title { font-size: 3rem; font-weight: 500; margin-top: 1.5rem; line-height: 0.95; }
.facilities-body { font-size: 0.875rem; color: var(--ink-soft); max-width: 20rem; margin-top: 1.5rem; line-height: 1.6; }
.court-cards { display: flex; align-items: flex-end; gap: 1.25rem; }
.court-card { flex: 1; border-radius: var(--radius-card); overflow: hidden; background: var(--surface); position: relative; aspect-ratio: 3/4; cursor: default; will-change: transform; }
.court-card:nth-child(2) { margin-bottom: 2rem; }
.court-card img { width: 100%; height: 100%; object-fit: cover; display: block; }
.court-caption { position: absolute; left: 0.75rem; right: 0.75rem; bottom: 0.75rem; border-radius: 0.75rem; backdrop-filter: blur(10px); padding: 0.75rem 1rem; color: white; }
.court-caption-clay { background: rgba(15,47,99,0.4); }
.court-caption-blue { background: rgba(11,110,151,0.55); }
.court-name { font-size: 0.875rem; font-weight: 500; }
.court-desc { font-size: 0.75rem; color: rgba(255,255,255,0.8); margin-top: 0.25rem; line-height: 1.4; }

/* === STATS SECTION === */
#stats { background: var(--brand-deep); color: white; border-radius: var(--radius-card-lg); margin-top: 0.75rem; padding: 5rem 1.5rem; }
@media (min-width: 640px) { #stats { padding: 5rem 2.5rem; } }
#stats-title { font-size: 3rem; font-weight: 500; margin-top: 1rem; line-height: 0.95; }
.stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 4rem; }
@media (min-width: 1024px) { .stats-grid { grid-template-columns: repeat(4, 1fr); } }
.stat-item { border-top: 1px solid rgba(255,255,255,0.2); padding-top: 1.25rem; }
.stat-value { font-size: 3.75rem; font-weight: 500; line-height: 1; }
@media (min-width: 640px) { .stat-value { font-size: 4.5rem; } }
.stat-label { font-size: 0.875rem; color: rgba(255,255,255,0.65); margin-top: 0.75rem; line-height: 1.4; }

/* === TESTIMONIALS SECTION === */
#testimonials { background: var(--background); padding: 5rem 1.5rem; }
@media (min-width: 640px) { #testimonials { padding: 6rem 2.5rem; } }
#testimonials-title { font-size: 3rem; font-weight: 500; margin-top: 1rem; line-height: 0.95; }
.testimonials-grid { display: grid; grid-template-columns: 1fr; gap: 1.25rem; margin-top: 3.5rem; }
@media (min-width: 768px) { .testimonials-grid { grid-template-columns: repeat(3, 1fr); } }
.testimonial-card { display: flex; flex-direction: column; justify-content: space-between; border-radius: var(--radius-card); background: var(--surface); padding: 1.75rem; will-change: transform; }
.testimonial-quote-mark { font-size: 2.25rem; color: var(--brand); line-height: 1; font-family: Georgia, serif; }
.testimonial-text { font-size: 1.125rem; line-height: 1.6; color: var(--ink); margin-top: 1rem; flex: 1; }
.testimonial-footer { border-top: 1px solid var(--hairline); padding-top: 1rem; margin-top: 1.5rem; }
.testimonial-name { font-weight: 500; font-size: 0.9375rem; }
.testimonial-role { font-size: 0.875rem; color: var(--ink-soft); }

/* === FOOTER === */
footer { background: var(--brand-deep); color: white; border-radius: var(--radius-card-lg); margin-top: 0.75rem; padding: 3.5rem 1.5rem; }
@media (min-width: 640px) { footer { padding: 4rem 2.5rem; } }
.footer-cta { border-bottom: 1px solid rgba(255,255,255,0.15); padding-bottom: 3.5rem; display: flex; flex-direction: column; gap: 2rem; align-items: flex-start; }
@media (min-width: 640px) { .footer-cta { flex-direction: row; justify-content: space-between; align-items: flex-end; } }
.footer-cta-heading { font-size: 3.75rem; font-weight: 500; line-height: 0.92; margin-top: 1rem; }
.footer-cta-heading .stacked-line { display: block; }
.footer-cols { display: grid; grid-template-columns: 1fr; gap: 2.5rem; padding: 3.5rem 0; }
@media (min-width: 768px) { .footer-cols { grid-template-columns: 1.4fr 1fr 1fr 1fr; } }
.footer-brand-col { max-width: 20rem; }
.footer-brand-mark { display: flex; align-items: center; gap: 0.5rem; font-size: 1.125rem; font-weight: 500; }
.footer-blurb { font-size: 0.875rem; color: rgba(255,255,255,0.65); margin-top: 1rem; line-height: 1.6; }
.footer-address { font-style: normal; margin-top: 1.5rem; font-size: 0.875rem; }
.footer-address a { color: rgba(255,255,255,0.8); display: block; margin-bottom: 0.25rem; }
.footer-address a:hover { color: white; }
.footer-address span { color: rgba(255,255,255,0.55); display: block; margin-top: 0.25rem; }
.footer-nav-col h3 { font-size: 0.75rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.5); margin-bottom: 1rem; }
.footer-nav-col ul { display: flex; flex-direction: column; gap: 0.6rem; }
.footer-nav-col a { font-size: 0.875rem; color: rgba(255,255,255,0.7); }
.footer-nav-col a:hover { color: white; }
.footer-bottom { border-top: 1px solid rgba(255,255,255,0.15); padding-top: 2rem; font-size: 0.875rem; color: rgba(255,255,255,0.6); display: flex; flex-direction: column; gap: 1rem; align-items: flex-start; }
@media (min-width: 640px) { .footer-bottom { flex-direction: row; justify-content: space-between; align-items: center; } }
.footer-social { display: flex; gap: 1.25rem; flex-wrap: wrap; }
.footer-social a { color: rgba(255,255,255,0.6); font-size: 0.875rem; }
.footer-social a:hover { color: white; }
.footer-legal { display: flex; gap: 1.25rem; }
.footer-legal a { color: rgba(255,255,255,0.6); font-size: 0.875rem; }
.footer-legal a:hover { color: white; }

/* === CONTACT MODAL === */
#contact-modal { position: fixed; inset: 0; z-index: 90; display: flex; align-items: flex-end; padding: 0.75rem; pointer-events: none; }
@media (min-width: 640px) { #contact-modal { align-items: center; padding: 1.5rem; justify-content: center; } }
#contact-modal.open { pointer-events: auto; }
.modal-backdrop { position: absolute; inset: 0; background: rgba(15,47,99,0.4); backdrop-filter: blur(4px); opacity: 0; }
.modal-panel { position: relative; z-index: 1; background: var(--surface-card); border-radius: var(--radius-card-lg); padding: 1.5rem; max-height: 92svh; overflow-y: auto; width: 100%; box-shadow: 0 20px 60px rgba(0,0,0,0.3); opacity: 0; transform: translateY(28px) scale(0.96); }
@media (min-width: 640px) { .modal-panel { padding: 2rem; max-width: 32rem; } }
.modal-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; }
.modal-header-text { flex: 1; }
.modal-title { font-size: 2.25rem; font-weight: 500; line-height: 1; margin-top: 0.75rem; }
@media (min-width: 640px) { .modal-title { font-size: 3rem; } }
.modal-close { width: 2.5rem; height: 2.5rem; border-radius: 50%; background: var(--surface); display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: background 0.2s; cursor: pointer; color: var(--ink); }
.modal-close:hover { background: var(--hairline); }
.modal-form { margin-top: 1.75rem; display: flex; flex-direction: column; gap: 1rem; }
.form-group { display: flex; flex-direction: column; gap: 0.4rem; }
.form-label { font-size: 0.75rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.18em; color: var(--ink-soft); }
.form-input, .form-textarea { width: 100%; border-radius: 0.75rem; border: 1px solid var(--hairline); background: var(--background); padding: 0.75rem 1rem; font-size: 0.875rem; font-family: inherit; color: var(--ink); outline: none; transition: border-color 0.2s; }
.form-input:focus, .form-textarea:focus { border-color: var(--brand-light); }
.form-textarea { resize: vertical; }
.modal-submit { border-radius: var(--radius-pill); background: var(--ink); color: white; padding: 0.875rem 1.75rem; font-size: 0.875rem; font-weight: 500; font-family: inherit; text-transform: uppercase; letter-spacing: 0.05em; width: 100%; border: none; cursor: pointer; transition: background 0.2s; margin-top: 0.25rem; }
.modal-submit:hover { background: var(--brand-deep); }
.modal-success { margin-top: 2rem; border-radius: var(--radius-card); background: var(--surface); padding: 1.5rem; text-align: center; display: none; }
.success-icon { width: 3rem; height: 3rem; border-radius: 50%; background: var(--brand); display: flex; align-items: center; justify-content: center; margin: 0 auto; color: white; }
.success-title { font-size: 1.125rem; font-weight: 500; margin-top: 1rem; }
.success-body { font-size: 0.875rem; color: var(--ink-soft); margin-top: 0.5rem; line-height: 1.5; }
.success-done { margin-top: 1.25rem; }

/* === MENU OVERLAY === */
#menu-overlay { position: fixed; inset: 0; z-index: 70; display: flex; flex-direction: column; pointer-events: none; }
#menu-overlay.open { pointer-events: auto; }
.menu-backdrop { position: absolute; inset: 0; background: var(--brand-deep); opacity: 0; }
.menu-panel { position: relative; z-index: 1; height: 100%; background: var(--brand-deep); display: flex; flex-direction: column; padding: 1.5rem; color: white; opacity: 0; transform: translateY(-24px); }
@media (min-width: 640px) { .menu-panel { padding: 2.5rem; } }
.menu-top { display: flex; justify-content: space-between; align-items: center; }
.menu-close { width: 2.5rem; height: 2.5rem; border-radius: 50%; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; color: white; transition: background 0.2s; cursor: pointer; border: none; flex-shrink: 0; }
.menu-close:hover { background: rgba(255,255,255,0.25); }
.menu-nav { flex: 1; display: flex; flex-direction: column; justify-content: center; gap: 0.5rem; padding: 2rem 0; }
.menu-nav-link { font-size: 3rem; font-weight: 500; line-height: 1.1; color: white; display: block; opacity: 0; transform: translateY(16px); }
@media (min-width: 640px) { .menu-nav-link { font-size: 4.5rem; } }
.menu-nav-link:hover { color: var(--brand-light); }
.menu-bottom { border-top: 1px solid rgba(255,255,255,0.15); padding-top: 2rem; display: flex; flex-direction: column; gap: 1.5rem; }
@media (min-width: 640px) { .menu-bottom { flex-direction: row; align-items: center; justify-content: space-between; } }
.menu-social { display: flex; gap: 1.25rem; flex-wrap: wrap; }
.menu-social a { color: rgba(255,255,255,0.7); font-size: 0.875rem; }
.menu-social a:hover { color: white; }
</style>
</head><body>
<!-- ===================== LOADER ===================== -->
<div id="loader" aria-live="polite" aria-label="Loading Baseline">
  <div class="loader-mark">
    <svg class="loader-icon" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <circle cx="12" cy="12" r="9"/>
      <path d="M4.8 5.6A9 9 0 0 0 4.8 18.4"/>
      <path d="M19.2 5.6a9 9 0 0 1 0 12.8"/>
    </svg>
    <span class="loader-name">Baseline</span>
  </div>
  <div class="loader-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100">
    <div class="loader-fill"></div>
  </div>
</div>

<!-- ===================== MENU OVERLAY ===================== -->
<div id="menu-overlay" role="dialog" aria-modal="true" aria-label="Navigation menu">
  <div class="menu-backdrop"></div>
  <div class="menu-panel">
    <div class="menu-top">
      <div class="header-brand" style="color:white;">
        <svg class="brand-mark" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="9"/>
          <path d="M4.8 5.6A9 9 0 0 0 4.8 18.4"/>
          <path d="M19.2 5.6a9 9 0 0 1 0 12.8"/>
        </svg>
        <span class="brand-name">Baseline</span>
      </div>
      <button class="menu-close" aria-label="Close menu">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
          <line x1="3" y1="3" x2="13" y2="13"/><line x1="13" y1="3" x2="3" y2="13"/>
        </svg>
      </button>
    </div>
    <nav class="menu-nav" aria-label="Main navigation">
      <a href="#programs" class="menu-nav-link">Programs</a>
      <a href="#facilities" class="menu-nav-link">Facilities</a>
      <a href="#testimonials" class="menu-nav-link">Reviews</a>
      <a href="#contact" class="menu-nav-link">Contact</a>
    </nav>
    <div class="menu-bottom">
      <button class="pill-btn pill-btn-light" data-open-modal="contact" onclick="document.getElementById('menu-overlay').classList.remove('open');" aria-label="Book a visit">
        Book a Visit
        <svg class="pill-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </button>
      <nav class="menu-social" aria-label="Social media">
        <a href="#instagram">Instagram</a>
        <a href="#x">X</a>
        <a href="#youtube">YouTube</a>
        <a href="#linkedin">LinkedIn</a>
      </nav>
    </div>
  </div>
</div>

<!-- ===================== MAIN ===================== -->
<main>

  <!-- ======= HERO ======= -->
  <section id="hero" aria-label="Hero">
    <div class="hero-parallax" aria-hidden="true">
      <div class="hero-parallax-inner">        <img src="https://api.getlayers.ai/storage/v1/object/public/public/assets/baseline-88535e4000/hero/hero-court.webp" alt="Tennis court aerial view" fetchpriority="high">
      </div>
      <div class="hero-overlay"></div>
    </div>

    <header class="site-header">
      <nav class="header-nav" aria-label="Primary navigation">
        <a href="#programs">Programs &amp; Coaches</a>
        <a href="#facilities">Club &amp; Events</a>
      </nav>
      <div class="header-brand">
        <svg class="brand-mark" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="9"/>
          <path d="M4.8 5.6A9 9 0 0 0 4.8 18.4"/>
          <path d="M19.2 5.6a9 9 0 0 1 0 12.8"/>
        </svg>
        <span class="brand-name">Baseline</span>
      </div>
      <div class="header-right">
        <button class="header-book" data-open-modal="contact">Book a Visit</button>
        <button class="burger-btn" aria-label="Open menu" aria-expanded="false" aria-controls="menu-overlay">
          <span class="burger-bar"></span>
          <span class="burger-bar"></span>
        </button>
      </div>
    </header>

    <h1 id="hero-title">Own The Court</h1>

    <div class="hero-bottom">
      <p class="hero-tagline">
        <span class="stacked-line" data-words="Show|Up,">Show Up,</span>
        <span class="stacked-line" data-words="Level|Up">Level Up</span>
      </p>
      <div class="hero-right">
        <!-- Collection Slider -->
        <div class="collection-slider" aria-label="Featured collection">
          <div class="slider-track">            <div class="slide-card is-active" role="group" aria-label="Slide 1 of 3">
              <img class="slide-img" src="https://api.getlayers.ai/storage/v1/object/public/public/assets/baseline-88535e4000/2.webp" alt="Baseline Pro gear" loading="lazy">
              <div class="slide-content">
                <div class="slide-brand">Baseline Pro</div>
                <div class="slide-title">Featured Gear</div>
                <a href="#" class="slide-cta">Shop the kit</a>
              </div>
            </div>            <div class="slide-card" role="group" aria-label="Slide 2 of 3">
              <img class="slide-img" src="https://api.getlayers.ai/storage/v1/object/public/public/assets/baseline-88535e4000/3.webp" alt="Court Series summer drop" loading="lazy">
              <div class="slide-content">
                <div class="slide-brand">Court Series</div>
                <div class="slide-title">Summer Drop</div>
                <a href="#" class="slide-cta">View the line</a>
              </div>
            </div>            <div class="slide-card" role="group" aria-label="Slide 3 of 3">
              <img class="slide-img" src="https://api.getlayers.ai/storage/v1/object/public/public/assets/baseline-88535e4000/5.webp" alt="Academy Kit junior range" loading="lazy">
              <div class="slide-content">
                <div class="slide-brand">Academy Kit</div>
                <div class="slide-title">Junior Range</div>
                <a href="#" class="slide-cta">Browse juniors</a>
              </div>
            </div>
          </div>
          <div class="slider-dots" role="tablist" aria-label="Slider navigation">
            <button class="dot-btn dot-active-light" role="tab" aria-selected="true" aria-label="Slide 1" aria-current="true"></button>
            <button class="dot-btn dot-idle-light" role="tab" aria-selected="false" aria-label="Slide 2" aria-current="false"></button>
            <button class="dot-btn dot-idle-light" role="tab" aria-selected="false" aria-label="Slide 3" aria-current="false"></button>
          </div>
        </div>

        <!-- Membership Card -->
        <div class="membership-card" aria-label="Member count">
          <div class="membership-left">
            <div class="membership-count">9K+</div>
            <div class="member-avatars" aria-hidden="true">
              <span class="member-avatar" style="background:#5790e6;"></span>
              <span class="member-avatar" style="background:#c2e029;"></span>
              <span class="member-avatar" style="background:#0b6e97;"></span>
              <span class="member-avatar" style="background:#ffffff;"></span>
            </div>
            <div class="membership-label">Members on court</div>
          </div>          <img class="membership-img" src="https://api.getlayers.ai/storage/v1/object/public/public/assets/baseline-88535e4000/1.webp" alt="Club member playing tennis" loading="lazy">
        </div>
      </div>
    </div>
  </section>

  <!-- ======= TRUST / COACHES ======= -->
  <section id="trust" aria-label="Coaching team">
    <div class="trust-badges">
      <div class="trust-pct-badge" aria-label="100% coaching built around your game">
        <div class="trust-pct-value">100%</div>
        <div class="trust-pct-label">Coaching built around your game</div>
      </div>
      <article class="trust-badge-card">
        <span class="trust-badge-index">#01</span>
        <h2 class="trust-badge-title">Trusted by serious players</h2>
        <p class="trust-badge-body">From first-timers to competitive club players, our coaches are hand-picked for their ability to accelerate your development at every level.</p>
      </article>
    </div>

    <div class="trust-ghost" aria-hidden="true">
      <div class="trust-ghost-row">
        <span class="trust-ghost-word ghost">Expert</span>
        <span class="trust-ghost-word ghost">Result-</span>
      </div>
      <div class="trust-ghost-row">
        <span class="trust-ghost-word ink">Driven</span>
        <span class="trust-ghost-word ghost">Coaching</span>
      </div>
    </div>

    <div class="trust-coach-wrap">
      <figure class="trust-coach-fig">        <img class="trust-coach-img" src="https://api.getlayers.ai/storage/v1/object/public/public/assets/baseline-88535e4000/5.webp" alt="Marco Vidal - Head Coach" loading="lazy">
        <figcaption class="trust-coach-caption">
          <div class="trust-coach-name">Marco Vidal</div>
          <div class="trust-coach-role">Head Coach</div>
        </figcaption>
      </figure>
    </div>

    <div class="trust-controls">
      <button class="arrow-btn arrow-btn-outline arrow-btn-prev trust-prev" aria-label="Previous coach">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </button>
      <div class="trust-dots" role="tablist" aria-label="Coach slides">
        <button class="dot-btn dot-active-dark" role="tab" aria-selected="true" aria-label="Coach 1" aria-current="true"></button>
        <button class="dot-btn dot-idle-dark" role="tab" aria-selected="false" aria-label="Coach 2" aria-current="false"></button>
        <button class="dot-btn dot-idle-dark" role="tab" aria-selected="false" aria-label="Coach 3" aria-current="false"></button>
      </div>
      <button class="arrow-btn arrow-btn-solid trust-next" aria-label="Next coach">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </button>
    </div>
  </section>

  <!-- ======= PROGRAMS ======= -->
  <section id="programs" aria-label="Training programs">
    <span class="eyebrow eyebrow-dark"><span class="eyebrow-dot"></span>Training programs</span>
    <h2 id="programs-title">
      <span class="stacked-line">Built for</span>
      <span class="stacked-line">every level</span>
    </h2>
    <ul class="programs-list">
      <li>
        <a href="#junior" class="program-item" aria-label="Junior Development program">
          <span class="program-index">01</span>
          <div class="program-info">
            <div class="program-name">Junior Development</div>
            <div class="program-desc">Fundamentals, footwork and match play for young players aged 5–16.</div>
          </div>
          <div class="program-arrow" aria-hidden="true">
            <svg class="program-arrow-svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.55"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </div>
        </a>
      </li>
      <li>
        <a href="#performance" class="program-item" aria-label="Performance Squad program">
          <span class="program-index">02</span>
          <div class="program-info">
            <div class="program-name">Performance Squad</div>
            <div class="program-desc">High-volume training for competitive players targeting tournament results.</div>
          </div>
          <div class="program-arrow" aria-hidden="true">
            <svg class="program-arrow-svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.55"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </div>
        </a>
      </li>
      <li>
        <a href="#adult" class="program-item" aria-label="Adult Clinics program">
          <span class="program-index">03</span>
          <div class="program-info">
            <div class="program-name">Adult Clinics</div>
            <div class="program-desc">Small-group sessions focused on technique, tactics and consistency.</div>
          </div>
          <div class="program-arrow" aria-hidden="true">
            <svg class="program-arrow-svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.55"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </div>
        </a>
      </li>
      <li>
        <a href="#private" class="program-item" aria-label="Private Coaching program">
          <span class="program-index">04</span>
          <div class="program-info">
            <div class="program-name">Private Coaching</div>
            <div class="program-desc">One-to-one sessions tailored to your goals, schedule and playing level.</div>
          </div>
          <div class="program-arrow" aria-hidden="true">
            <svg class="program-arrow-svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.55"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </div>
        </a>
      </li>
    </ul>
  </section>

  <!-- ======= FACILITIES ======= -->
  <section id="facilities" aria-label="Our facilities">
    <div class="facilities-grid">
      <div class="facilities-intro">        <img class="facilities-icon" src="https://api.getlayers.ai/storage/v1/object/public/public/assets/baseline-88535e4000/3.webp" alt="Baseline courts icon" loading="lazy">
        <h2 id="facilities-title">
          <span class="stacked-line">Tour Our</span>
          <span class="stacked-line">World-Class</span>
          <span class="stacked-line">Courts</span>
        </h2>
        <p class="facilities-body" data-text="Reserve a court for focused practice or drop in for a social hit — our facilities are open seven days a week with professional maintenance and dedicated court hosts.">Reserve a court for focused practice or drop in for a social hit — our facilities are open seven days a week with professional maintenance and dedicated court hosts.</p>
      </div>
      <div class="court-cards">
        <figure class="court-card">          <img src="https://api.getlayers.ai/storage/v1/object/public/public/assets/baseline-88535e4000/1.webp" alt="Redline Clay outdoor clay court" loading="lazy">
          <figcaption class="court-caption court-caption-clay">
            <div class="court-name">Redline Clay</div>
            <div class="court-desc">A fast outdoor clay court with full lighting and player amenities.</div>
          </figcaption>
        </figure>
        <figure class="court-card">          <img src="https://api.getlayers.ai/storage/v1/object/public/public/assets/baseline-88535e4000/4.webp" alt="Harbor Court sheltered hard court" loading="lazy">
          <figcaption class="court-caption court-caption-blue">
            <div class="court-name">Harbor Court</div>
            <div class="court-desc">A sheltered hard court ideal for year-round play in any conditions.</div>
          </figcaption>
        </figure>
      </div>
    </div>
  </section>

  <!-- ======= STATS ======= -->
  <section id="stats" aria-label="Club statistics">
    <span class="eyebrow eyebrow-light"><span class="eyebrow-dot"></span>By the numbers</span>
    <h2 id="stats-title">
      <span class="stacked-line">A club that</span>
      <span class="stacked-line">keeps score</span>
    </h2>
    <dl class="stats-grid">
      <div class="stat-item">
        <dt class="stat-value">24</dt>
        <dd class="stat-label">Certified coaches</dd>
      </div>
      <div class="stat-item">
        <dt class="stat-value">12</dt>
        <dd class="stat-label">Championship courts</dd>
      </div>
      <div class="stat-item">
        <dt class="stat-value">9K+</dt>
        <dd class="stat-label">Members training</dd>
      </div>
      <div class="stat-item">
        <dt class="stat-value">15</dt>
        <dd class="stat-label">Years on the baseline</dd>
      </div>
    </dl>
  </section>

  <!-- ======= TESTIMONIALS ======= -->
  <section id="testimonials" aria-label="Player testimonials">
    <span class="eyebrow eyebrow-dark"><span class="eyebrow-dot"></span>What players say</span>
    <h2 id="testimonials-title">
      <span class="stacked-line">Loved by</span>
      <span class="stacked-line">the locker room</span>
    </h2>
    <ul class="testimonials-grid">
      <li>
        <figure class="testimonial-card">
          <div class="testimonial-quote-mark">"</div>
          <blockquote class="testimonial-text">I added a level to my serve in just six weeks. The coaches here genuinely care about your progress, not just filling court time.</blockquote>
          <figcaption class="testimonial-footer">
            <div class="testimonial-name">Priya Anand</div>
            <div class="testimonial-role">Performance Squad</div>
          </figcaption>
        </figure>
      </li>
      <li>
        <figure class="testimonial-card">
          <div class="testimonial-quote-mark">"</div>
          <blockquote class="testimonial-text">Best courts in the city, full stop. The surface is always perfect, the staff are fantastic and the community keeps me coming back.</blockquote>
          <figcaption class="testimonial-footer">
            <div class="testimonial-name">Lukas Brenner</div>
            <div class="testimonial-role">Adult Clinics</div>
          </figcaption>
        </figure>
      </li>
      <li>
        <figure class="testimonial-card">
          <div class="testimonial-quote-mark">"</div>
          <blockquote class="testimonial-text">My daughter went from shy beginner to confident match player in one season. The junior programme is exceptional — structured, fun and full of heart.</blockquote>
          <figcaption class="testimonial-footer">
            <div class="testimonial-name">Dana Okafor</div>
            <div class="testimonial-role">Parent, Junior Development</div>
          </figcaption>
        </figure>
      </li>
    </ul>
  </section>

  <!-- ======= FOOTER ======= -->
  <footer id="contact">
    <div class="footer-cta">
      <div class="footer-cta-left">
        <span class="eyebrow eyebrow-light"><span class="eyebrow-dot"></span>Get started</span>
        <p class="footer-cta-heading">
          <span class="stacked-line">Ready to</span>
          <span class="stacked-line">play?</span>
        </p>
      </div>
      <button class="pill-btn pill-btn-light footer-cta-pill" data-open-modal="contact" aria-label="Book a visit to Baseline Tennis Club">
        Book a Visit
        <svg class="pill-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </button>
    </div>

    <div class="footer-cols">
      <div class="footer-brand-col">
        <div class="footer-brand-mark">
          <svg class="brand-mark" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="12" r="9"/>
            <path d="M4.8 5.6A9 9 0 0 0 4.8 18.4"/>
            <path d="M19.2 5.6a9 9 0 0 1 0 12.8"/>
          </svg>
          <span>Baseline</span>
        </div>
        <p class="footer-blurb">New York's premier tennis club and academy — where every level finds its game.</p>
        <address class="footer-address">
          <a href="mailto:play@baseline.club">play@baseline.club</a>
          <a href="tel:+12125550148">+1 (212) 555-0148</a>
          <span>120 Court Lane, New York</span>
        </address>
      </div>
      <div class="footer-nav-col">
        <h3>Programs</h3>
        <ul>
          <li><a href="#junior">Junior Development</a></li>
          <li><a href="#performance">Performance Squad</a></li>
          <li><a href="#adult">Adult Clinics</a></li>
          <li><a href="#private">Private Coaching</a></li>
        </ul>
      </div>
      <div class="footer-nav-col">
        <h3>Club</h3>
        <ul>
          <li><a href="#membership">Membership</a></li>
          <li><a href="#facilities">Facilities</a></li>
          <li><a href="#events">Events</a></li>
          <li><a href="#shop">Pro Shop</a></li>
        </ul>
      </div>
      <div class="footer-nav-col">
        <h3>Company</h3>
        <ul>
          <li><a href="#about">About</a></li>
          <li><a href="#coaches">Coaches</a></li>
          <li><a href="#careers">Careers</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <span>&copy; 2026 Baseline Tennis Club. All rights reserved.</span>
      <nav class="footer-social" aria-label="Social media">
        <a href="#instagram">Instagram</a>
        <a href="#x">X</a>
        <a href="#youtube">YouTube</a>
        <a href="#linkedin">LinkedIn</a>
      </nav>
      <nav class="footer-legal" aria-label="Legal">
        <a href="#privacy">Privacy</a>
        <a href="#terms">Terms</a>
      </nav>
    </div>
  </footer>

</main>

<!-- ===================== CONTACT MODAL ===================== -->
<div id="contact-modal" role="dialog" aria-modal="true" aria-labelledby="modal-heading">
  <div class="modal-backdrop"></div>
  <div class="modal-panel">
    <div class="modal-header">
      <div class="modal-header-text">
        <span class="eyebrow eyebrow-dark"><span class="eyebrow-dot"></span>Book a visit</span>
        <h2 class="modal-title" id="modal-heading">
          <span class="stacked-line">Come see</span>
          <span class="stacked-line">the courts</span>
        </h2>
      </div>
      <button class="modal-close" aria-label="Close dialog">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
          <line x1="3" y1="3" x2="13" y2="13"/><line x1="13" y1="3" x2="3" y2="13"/>
        </svg>
      </button>
    </div>
    <form class="modal-form" novalidate>
      <div class="form-group">
        <label class="form-label" for="modal-name">Full name</label>
        <input class="form-input" id="modal-name" type="text" placeholder="Alex Rivera" autocomplete="name" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="modal-email">Email</label>
        <input class="form-input" id="modal-email" type="email" placeholder="you@email.com" autocomplete="email" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="modal-message">What would you like to play?</label>
        <textarea class="form-textarea" id="modal-message" rows="3" placeholder="Tell us a bit about your game..."></textarea>
      </div>
      <button type="submit" class="modal-submit">Request a visit</button>
    </form>
    <div class="modal-success" role="alert">
      <div class="success-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <div class="success-title">Request received</div>
      <p class="success-body">Thanks — our team will be in touch shortly.</p>
      <button class="pill-btn pill-btn-solid success-done modal-done" style="margin-top:1.25rem;width:100%;justify-content:center;">Done</button>
    </div>
  </div>
</div>
<script type="module">
import Lenis from 'lenis';

/* ============================================================
   FONT SIZE SCALE-UP (above 1920px)
   ============================================================ */
const FONT_BASE=16,BASE_W=1920,COEF=0.6666;
function updateFontSize(){const r=((BASE_W-innerWidth)/BASE_W)*100*COEF,s=FONT_BASE-(FONT_BASE*r)/100;if(s>FONT_BASE)document.documentElement.style.fontSize=s+'px';else document.documentElement.style.removeProperty('font-size');}
updateFontSize();addEventListener('resize',updateFontSize);

/* ============================================================
   SPRING
   ============================================================ */
class Spring{
  constructor(tension=200,friction=26){this.tension=tension;this.friction=friction;this.value=0;this.target=0;this.velocity=0;}
  step(dt){const f=(-this.tension*(this.value-this.target)-this.friction*this.velocity)*dt;this.velocity+=f;this.value+=this.velocity*dt;return Math.abs(this.value-this.target)<0.001&&Math.abs(this.velocity)<0.001;}
  set(v){this.value=v;this.target=v;this.velocity=0;}
}

/* ============================================================
   EASINGS
   ============================================================ */
const easeOutExpo=t=>t===1?1:1-Math.pow(2,-10*t);
const easeOutQuart=t=>1-Math.pow(1-t,4);
const easeInOutCubic=t=>t<0.5?4*t*t*t:(1-Math.pow(-2*t+2,3)/2);

/* ============================================================
   RAF LOOP
   ============================================================ */
let lenis;
const tasks=new Set();
let lastTs=0;
function raf(ts){
  requestAnimationFrame(raf);
  const dt=Math.min((ts-lastTs)/1000,0.05);
  lastTs=ts;
  lenis?.raf(ts);
  tasks.forEach(fn=>{if(fn(dt))tasks.delete(fn);});
}
requestAnimationFrame(raf);

/* ============================================================
   STATE HELPER
   ============================================================ */
function applyState(el,s){
  const t=[];
  if(s.y!==undefined)t.push('translateY('+s.y+'px)');
  if(s.x!==undefined)t.push('translateX('+s.x+'px)');
  if(s.scale!==undefined)t.push('scale('+s.scale+')');
  if(t.length)el.style.transform=t.join(' ');
  if(s.opacity!==undefined)el.style.opacity=String(s.opacity);
}

/* ============================================================
   CLIP REVEAL
   ============================================================ */
function clipReveal(el,words,cfg){
  const {stagger=60,baseDelay=0,duration=900,easing=easeOutExpo}=cfg||{};
  el.innerHTML='';
  words.forEach((w,i)=>{
    if(i>0)el.appendChild(document.createTextNode('\u00a0'));
    const o=document.createElement('span');
    o.style.cssText='overflow:hidden;display:inline-block;padding-bottom:0.14em;vertical-align:bottom';
    const n=document.createElement('span');
    n.style.cssText='display:inline-block;transform:translateY(115%);opacity:0;will-change:transform,opacity';
    n.textContent=w;
    o.appendChild(n);el.appendChild(o);
  });
  const dur=duration/1000;
  el.querySelectorAll('span>span').forEach((s,i)=>{
    const d=(baseDelay+i*stagger)/1000;let e=-d;
    tasks.add(function(dt){e+=dt;if(e<0)return false;const t=Math.min(e/dur,1),v=easing(t);s.style.transform='translateY('+(1-v)*115+'%)';s.style.opacity=String(v);return t>=1;});
  });
}

/* ============================================================
   INVIEW REVEAL
   ============================================================ */
function inviewReveal(el,from,to,cfg,delayIn){
  delayIn=delayIn||0;
  applyState(el,from);
  const obs=new IntersectionObserver(entries=>{
    if(!entries[0].isIntersecting)return;
    obs.disconnect();
    const springs={};
    Object.keys(from).forEach(k=>{
      springs[k]=new Spring(cfg.tension,cfg.friction);
      springs[k].set(from[k]);
      springs[k].target=to[k]!==undefined?to[k]:from[k];
    });
    let e=-(delayIn/1000);
    tasks.add(function(dt){
      e+=dt;if(e<0)return false;
      let done=true;
      Object.keys(springs).forEach(k=>{if(!springs[k].step(dt))done=false;});
      const st={};Object.keys(springs).forEach(k=>st[k]=springs[k].value);
      applyState(el,st);return done;
    });
  },{threshold:0.1,rootMargin:'0px 0px -50px 0px'});
  obs.observe(el);
}

/* ============================================================
   HOVER SPRING
   ============================================================ */
function hoverSpring(el,springs,to,onUpdate){
  if(window.innerWidth<=768)return;
  const from={};Object.keys(to).forEach(k=>from[k]=springs[k]?springs[k].value:0);
  let cancel=null;
  function anim(targets){
    if(cancel)cancel();
    Object.keys(targets).forEach(k=>{if(springs[k])springs[k].target=targets[k];});
    let active=true;
    cancel=()=>{active=false;};
    tasks.add(function(dt){
      if(!active)return true;
      let done=true;
      Object.keys(springs).forEach(k=>{if(!springs[k].step(dt))done=false;});
      onUpdate(springs);
      if(done)active=false;
      return done;
    });
  }
  el.addEventListener('mouseenter',()=>anim(to));
  el.addEventListener('mouseleave',()=>anim(from));
}

/* ============================================================
   SCROLL LOCK
   ============================================================ */
function lockScroll(){document.documentElement.classList.add('scroll-locked');lenis?.stop();}
function unlockScroll(){document.documentElement.classList.remove('scroll-locked');lenis?.start();}

/* ============================================================
   READY CALLBACKS
   ============================================================ */
let loaderReady=false;const readyCbs=[];
function onReady(fn){if(loaderReady)fn();else readyCbs.push(fn);}
function fireReady(){loaderReady=true;readyCbs.forEach(f=>f());readyCbs.length=0;}

/* ============================================================
   LOADER
   ============================================================ */
const loaderEl=document.getElementById('loader');
const loaderFill=loaderEl.querySelector('.loader-fill');
const loaderMark=loaderEl.querySelector('.loader-mark');
const reduced=window.matchMedia('(prefers-reduced-motion:reduce)').matches;
const MIN_MS=reduced?200:1400,MAX_MS=reduced?200:2600,EXIT_MS=reduced?0:850;

/* Mark spring in */
const ms={op:new Spring(200,22),y:new Spring(200,22)};
ms.op.set(0);ms.op.target=1;ms.y.set(16);ms.y.target=0;
tasks.add(function mAnim(dt){
  const od=ms.op.step(dt),yd=ms.y.step(dt);
  loaderMark.style.opacity=String(ms.op.value);
  loaderMark.style.transform='translateY('+ms.y.value+'px)';
  return od&&yd;
});

/* Progress bar tween */
const pStart=performance.now();
tasks.add(function pAnim(){
  const el=(performance.now()-pStart)/1000-0.12;
  if(el<0)return false;
  const t=Math.min(el/1.28,1);
  loaderFill.style.transform='scaleX('+easeInOutCubic(t)+')';
  return t>=1;
});

/* Exit check */
let pageLoaded=false;const lStart=performance.now();
window.addEventListener('load',()=>{pageLoaded=true;});
function checkDone(){
  const e=performance.now()-lStart;
  if(e>=MIN_MS&&(pageLoaded||e>=MAX_MS))exitLoader();
  else setTimeout(checkDone,50);
}
checkDone();

function exitLoader(){
  if(EXIT_MS===0){loaderEl.remove();fireReady();if(lenis)lenis.start();return;}
  const s=performance.now();
  tasks.add(function exitAnim(){
    const t=Math.min((performance.now()-s)/EXIT_MS,1);
    loaderEl.style.transform='translateY('+-105*easeOutExpo(t)+'%)';
    if(t>=1){loaderEl.remove();fireReady();if(lenis)lenis.start();return true;}
    return false;
  });
}

/* ============================================================
   LENIS
   ============================================================ */
lenis=new Lenis({smoothWheel:true});
lenis.stop();
window.scrollTo(0,0);

/* ============================================================
   HERO PARALLAX
   ============================================================ */
const heroEl=document.getElementById('hero');
const heroPar=heroEl.querySelector('.hero-parallax-inner');
lenis.on('scroll',function(e){
  const r=heroEl.getBoundingClientRect(),h=heroEl.offsetHeight;
  const p=Math.max(0,Math.min(1,-r.top/h));
  heroPar.style.transform='translateY('+p*12+'%)';
});

/* ============================================================
   HERO CLIP REVEALS (gated on loader)
   ============================================================ */
onReady(function(){
  /* Title */
  const titleEl=document.getElementById('hero-title');
  clipReveal(titleEl,['Own','The','Court'],{stagger:140,duration:1100,easing:easeOutExpo});
  /* Tagline stacked lines */
  document.querySelectorAll('.hero-tagline .stacked-line').forEach(function(l,i){
    const words=l.getAttribute('data-words').split('|');
    const numPrev=i===0?0:document.querySelectorAll('.hero-tagline .stacked-line')[0].getAttribute('data-words').split('|').length;
    clipReveal(l,words,{baseDelay:350+(numPrev+i)*110,stagger:110,duration:900,easing:easeOutExpo});
  });
});

/* ============================================================
   COLLECTION SLIDER
   ============================================================ */
(function(){
  const sl=document.querySelector('.collection-slider');if(!sl)return;
  const slides=sl.querySelectorAll('.slide-card');
  const dots=sl.querySelectorAll('.dot-btn');
  let cur=0,timer;
  function show(i){
    slides.forEach(function(s,j){
      s.classList.toggle('is-active',j===i);
    });
    dots.forEach(function(d,j){
      d.className='dot-btn '+(j===i?'dot-active-light':'dot-idle-light');
      d.setAttribute('aria-current',j===i?'true':'false');
      d.setAttribute('aria-selected',j===i?'true':'false');
    });
    cur=i;
  }
  function next(){show((cur+1)%slides.length);}
  dots.forEach(function(d,i){
    d.addEventListener('click',function(){show(i);clearInterval(timer);timer=setInterval(next,3800);});
  });
  show(0);
  timer=setInterval(next,3800);
  inviewReveal(sl,{opacity:0,y:20},{opacity:1,y:0},{tension:200,friction:26},650);
})();

/* ============================================================
   MEMBERSHIP CARD INVIEW
   ============================================================ */
const mcEl=document.querySelector('.membership-card');
if(mcEl)inviewReveal(mcEl,{opacity:0,y:24},{opacity:1,y:0},{tension:200,friction:26},780);

/* ============================================================
   TRUST CAROUSEL
   ============================================================ */
(function(){
  const BASE='https://api.getlayers.ai/storage/v1/object/public/public/assets/baseline-88535e4000';
  const sec=document.getElementById('trust');if(!sec)return;
  const coachImg=sec.querySelector('.trust-coach-img');
  const cName=sec.querySelector('.trust-coach-name');
  const cRole=sec.querySelector('.trust-coach-role');
  const dots=sec.querySelectorAll('.trust-dots .dot-btn');
  const prevBtn=sec.querySelector('.trust-prev');
  const nextBtn=sec.querySelector('.trust-next');
  const slides=[
    {img:'5.webp',name:'Marco Vidal',role:'Head Coach',words:['Expert','Result-','Driven','Coaching']},
    {img:'4.webp',name:'Elena Sokolova',role:'Performance Coach',words:['Sharper','Faster','Stronger','Player']},
    {img:'1.webp',name:'James Okoro',role:'Juniors Lead',words:['Future','Champions','Start','Here']}
  ];
  let cur=0;
  function show(i){
    const s=slides[i];
    coachImg.style.opacity='0';
    setTimeout(function(){coachImg.src=BASE+'/'+s.img;coachImg.style.opacity='1';},200);
    cName.textContent=s.name;cRole.textContent=s.role;
    const rows=sec.querySelectorAll('.trust-ghost-row');
    const wEls=[rows[0]&&rows[0].children[0],rows[0]&&rows[0].children[1],rows[1]&&rows[1].children[0],rows[1]&&rows[1].children[1]];
    wEls.forEach(function(el,j){
      if(!el)return;
      clipReveal(el,[s.words[j]],{duration:700,baseDelay:j*50,easing:easeOutExpo});
      el.className='trust-ghost-word '+(j===2?'ink':'ghost');
    });
    dots.forEach(function(d,j){
      d.className='dot-btn '+(j===i?'dot-active-dark':'dot-idle-dark');
      d.setAttribute('aria-current',j===i?'true':'false');
      d.setAttribute('aria-selected',j===i?'true':'false');
    });
    cur=i;
  }
  show(0);
  if(prevBtn)prevBtn.addEventListener('click',function(){show((cur-1+slides.length)%slides.length);});
  if(nextBtn)nextBtn.addEventListener('click',function(){show((cur+1)%slides.length);});
  dots.forEach(function(d,i){d.addEventListener('click',function(){show(i);});});

  /* Coach fig inview with rotation preserved */
  const fig=sec.querySelector('.trust-coach-fig');
  fig.style.opacity='0';
  fig.style.transform='rotate(6deg) translateY(60px) scale(0.92)';
  const cs={op:new Spring(170,26),y:new Spring(170,26),sc:new Spring(170,26)};
  cs.op.set(0);cs.y.set(60);cs.sc.set(0.92);
  cs.op.target=1;cs.y.target=0;cs.sc.target=1;
  const figObs=new IntersectionObserver(function(entries){
    if(!entries[0].isIntersecting)return;figObs.disconnect();
    tasks.add(function(dt){
      const d=cs.op.step(dt)&&cs.y.step(dt)&&cs.sc.step(dt);
      fig.style.opacity=String(cs.op.value);
      fig.style.transform='rotate(6deg) translateY('+cs.y.value+'px) scale('+cs.sc.value+')';
      return d;
    });
  },{threshold:0.1,rootMargin:'0px 0px -50px 0px'});
  figObs.observe(fig);

  inviewReveal(sec.querySelector('.trust-pct-badge'),{opacity:0,scale:0.9},{opacity:1,scale:1},{tension:220,friction:22});
  inviewReveal(sec.querySelector('.trust-badge-card'),{opacity:0,y:20},{opacity:1,y:0},{tension:200,friction:26},120);

  /* Ghost parallax X */
  lenis.on('scroll',function(){
    const r=sec.getBoundingClientRect(),h=sec.offsetHeight,vh=window.innerHeight;
    const p=Math.max(0,Math.min(1,(vh-r.top)/(h+vh)));
    const rows=sec.querySelectorAll('.trust-ghost-row');
    if(rows[0]){
      if(rows[0].children[0])rows[0].children[0].style.transform='translateX('+(-3+6*p)+'%)';
      if(rows[0].children[1])rows[0].children[1].style.transform='translateX('+(3-6*p)+'%)';
    }
    if(rows[1]){
      if(rows[1].children[0])rows[1].children[0].style.transform='translateX('+(-2+6*p)+'%)';
      if(rows[1].children[1])rows[1].children[1].style.transform='translateX('+(4-7*p)+'%)';
    }
  });
})();

/* ============================================================
   PROGRAMS SECTION
   ============================================================ */
(function(){
  /* Title stacked lines */
  document.querySelectorAll('#programs-title .stacked-line').forEach(function(l,i){
    inviewReveal(l,{opacity:0,y:20},{opacity:1,y:0},{tension:200,friction:26},i*80);
  });
  /* Program rows */
  document.querySelectorAll('.program-item').forEach(function(item,i){
    inviewReveal(item,{opacity:0,y:20},{opacity:1,y:0},{tension:190,friction:26},i*90);
    const arrowSvg=item.querySelector('.program-arrow-svg');
    if(arrowSvg&&window.innerWidth>768){
      const sp={x:new Spring(300,20),op:new Spring(300,20)};
      sp.x.set(0);sp.op.set(0.55);
      hoverSpring(item,sp,{x:8,op:1},function(s){
        arrowSvg.style.transform='translateX('+s.x.value+'px)';
        arrowSvg.style.opacity=String(s.op.value);
      });
    }
  });
})();

/* ============================================================
   FACILITIES SECTION
   ============================================================ */
(function(){
  const icon=document.querySelector('.facilities-icon');
  if(icon)inviewReveal(icon,{opacity:0,scale:0.85},{opacity:1,scale:1},{tension:240,friction:20});

  const titleLines=document.querySelectorAll('#facilities-title .stacked-line');
  const bodyEl=document.querySelector('.facilities-body');
  const bodyText=bodyEl?bodyEl.getAttribute('data-text'):null;

  if(titleLines.length){
    const facObs=new IntersectionObserver(function(entries){
      if(!entries[0].isIntersecting)return;facObs.disconnect();
      titleLines.forEach(function(l,i){
        clipReveal(l,l.textContent.trim().split(/\s+/),{baseDelay:i*120,stagger:50,duration:900,easing:easeOutExpo});
      });
      if(bodyEl&&bodyText){
        clipReveal(bodyEl,bodyText.split(' '),{baseDelay:250,stagger:28,duration:700,easing:easeOutQuart});
      }
    },{threshold:0.1,rootMargin:'0px 0px -50px 0px'});
    facObs.observe(titleLines[0]);
  }

  document.querySelectorAll('.court-card').forEach(function(c,i){
    inviewReveal(c,{opacity:0,y:30},{opacity:1,y:0},{tension:180,friction:26},i*140);
    if(window.innerWidth>768){
      const sp={scale:new Spring(300,22)};sp.scale.set(1);
      hoverSpring(c,sp,{scale:1.03},function(s){c.style.transform='scale('+s.scale.value+')';});
    }
  });
})();

/* ============================================================
   STATS SECTION
   ============================================================ */
(function(){
  document.querySelectorAll('#stats-title .stacked-line').forEach(function(l,i){
    inviewReveal(l,{opacity:0,y:20},{opacity:1,y:0},{tension:200,friction:26},i*80);
  });
  document.querySelectorAll('.stat-item').forEach(function(item,i){
    inviewReveal(item,{opacity:0,y:24},{opacity:1,y:0},{tension:180,friction:24},i*110);
  });
})();

/* ============================================================
   TESTIMONIALS SECTION
   ============================================================ */
(function(){
  document.querySelectorAll('#testimonials-title .stacked-line').forEach(function(l,i){
    inviewReveal(l,{opacity:0,y:20},{opacity:1,y:0},{tension:200,friction:26},i*80);
  });
  document.querySelectorAll('.testimonial-card').forEach(function(card,i){
    inviewReveal(card,{opacity:0,y:30},{opacity:1,y:0},{tension:180,friction:26},i*120);
    if(window.innerWidth>768){
      const sp={y:new Spring(300,22)};sp.y.set(0);
      hoverSpring(card,sp,{y:-8},function(s){card.style.transform='translateY('+s.y.value+'px)';});
    }
  });
})();

/* ============================================================
   FOOTER CTA REVEALS
   ============================================================ */
(function(){
  document.querySelectorAll('.footer-cta-heading .stacked-line').forEach(function(l,i){
    inviewReveal(l,{opacity:0,y:20},{opacity:1,y:0},{tension:200,friction:26},i*100);
  });
  const fp=document.querySelector('.footer-cta-pill');
  if(fp)inviewReveal(fp,{opacity:0,y:20},{opacity:1,y:0},{tension:200,friction:24},150);
})();

/* ============================================================
   CONTACT MODAL
   ============================================================ */
(function(){
  const modal=document.getElementById('contact-modal');
  const backdrop=modal.querySelector('.modal-backdrop');
  const panel=modal.querySelector('.modal-panel');
  const closeBtn=modal.querySelector('.modal-close');
  const form=modal.querySelector('.modal-form');
  const submitBtn=modal.querySelector('.modal-submit');
  const successPanel=modal.querySelector('.modal-success');
  const nameInput=modal.querySelector('#modal-name');
  let open=false;
  const bSp=new Spring(240,30);
  const pOp=new Spring(240,26),pY=new Spring(240,26),pSc=new Spring(240,26);
  bSp.set(0);pOp.set(0);pY.set(28);pSc.set(0.96);
  let animCancel=null;
  function startAnim(){
    if(animCancel)animCancel();
    let alive=true;animCancel=function(){alive=false;};
    tasks.add(function(dt){
      if(!alive)return true;
      const bd=bSp.step(dt);
      backdrop.style.opacity=String(bSp.value);
      const pd=pOp.step(dt)&&pY.step(dt)&&pSc.step(dt);
      panel.style.opacity=String(pOp.value);
      panel.style.transform='translateY('+pY.value+'px) scale('+pSc.value+')';
      if(!open&&bSp.value<0.01)modal.classList.remove('open');
      if(bd&&pd)alive=false;
      return bd&&pd;
    });
  }
  function openModal(){
    open=true;modal.classList.add('open');lockScroll();
    bSp.target=1;pOp.target=1;pY.target=0;pSc.target=1;
    startAnim();
    setTimeout(function(){if(nameInput)nameInput.focus();},120);
  }
  function closeModal(){
    open=false;
    bSp.target=0;pOp.target=0;pY.target=28;pSc.target=0.96;
    startAnim();
    unlockScroll();
    setTimeout(function(){
      if(form){form.reset();form.style.display='';}
      if(successPanel)successPanel.style.display='none';
      if(submitBtn)submitBtn.textContent='Request a visit';
    },350);
  }
  document.querySelectorAll('[data-open-modal="contact"]').forEach(function(b){
    b.addEventListener('click',openModal);
  });
  if(closeBtn)closeBtn.addEventListener('click',closeModal);
  if(backdrop)backdrop.addEventListener('click',closeModal);
  document.addEventListener('keydown',function(e){if(e.key==='Escape'&&open)closeModal();});
  if(form){
    form.addEventListener('submit',function(e){
      e.preventDefault();
      const n=(nameInput&&nameInput.value.trim())||'there';
      submitBtn.textContent='Sending\u2026';
      setTimeout(function(){
        form.style.display='none';
        if(successPanel){
          successPanel.style.display='block';
          const sb=successPanel.querySelector('.success-body');
          if(sb)sb.textContent='Thanks, '+n+' \u2014 our team will be in touch shortly.';
        }
      },800);
    });
  }
  modal.querySelectorAll('.modal-done').forEach(function(b){b.addEventListener('click',closeModal);});

  /* Modal title clip reveal when opened */
  const origOpenModal=openModal;
})();

/* ============================================================
   MENU OVERLAY
   ============================================================ */
(function(){
  const ov=document.getElementById('menu-overlay');
  const backdrop=ov.querySelector('.menu-backdrop');
  const panel=ov.querySelector('.menu-panel');
  const closeBtn=ov.querySelector('.menu-close');
  const navLinks=ov.querySelectorAll('.menu-nav-link');
  const burger=document.querySelector('.burger-btn');
  let open=false;
  const bSp=new Spring(260,30);
  const pOp=new Spring(220,28),pY=new Spring(220,28);
  bSp.set(0);pOp.set(0);pY.set(-24);
  let animCancel=null;
  function startAnim(){
    if(animCancel)animCancel();
    let alive=true;animCancel=function(){alive=false;};
    tasks.add(function(dt){
      if(!alive)return true;
      const bd=bSp.step(dt);
      backdrop.style.opacity=String(bSp.value);
      const pd=pOp.step(dt)&&pY.step(dt);
      panel.style.opacity=String(pOp.value);
      panel.style.transform='translateY('+pY.value+'px)';
      if(!open&&bSp.value<0.01)ov.classList.remove('open');
      if(bd&&pd)alive=false;
      return bd&&pd;
    });
  }
  function openMenu(){
    open=true;ov.classList.add('open');lockScroll();
    if(burger)burger.setAttribute('aria-expanded','true');
    bSp.target=1;pOp.target=1;pY.target=0;
    startAnim();
    navLinks.forEach(function(l,i){
      l.style.transition='';l.style.opacity='0';l.style.transform='translateY(16px)';
      setTimeout(function(){
        l.style.transition='opacity 0.35s ease, transform 0.35s ease';
        l.style.opacity='1';l.style.transform='translateY(0)';
      },120+i*70);
    });
  }
  function closeMenu(){
    open=false;
    if(burger)burger.setAttribute('aria-expanded','false');
    bSp.target=0;pOp.target=0;pY.target=-24;
    startAnim();
    unlockScroll();
    setTimeout(function(){
      navLinks.forEach(function(l){
        l.style.transition='';l.style.opacity='0';l.style.transform='translateY(16px)';
      });
    },200);
  }
  if(burger)burger.addEventListener('click',openMenu);
  if(closeBtn)closeBtn.addEventListener('click',closeMenu);
  if(backdrop)backdrop.addEventListener('click',closeMenu);
  document.addEventListener('keydown',function(e){if(e.key==='Escape'&&open)closeMenu();});
  ov.querySelectorAll('a[href^="#"]').forEach(function(a){
    a.addEventListener('click',function(e){
      e.preventDefault();
      const tgt=document.querySelector(a.getAttribute('href'));
      closeMenu();
      setTimeout(function(){if(lenis&&tgt)lenis.scrollTo(tgt);},350);
    });
  });
})();

/* ============================================================
   SMOOTH SCROLL FOR ANCHOR LINKS
   ============================================================ */
document.querySelectorAll('a[href^="#"]').forEach(function(a){
  if(a.closest('#menu-overlay'))return;
  a.addEventListener('click',function(e){
    const tgt=document.querySelector(a.getAttribute('href'));
    if(tgt){e.preventDefault();if(lenis)lenis.scrollTo(tgt);}
  });
});

/* ============================================================
   PILL BUTTON ARROW SPRINGS
   ============================================================ */
document.querySelectorAll('.pill-btn').forEach(function(btn){
  const arrow=btn.querySelector('.pill-arrow');
  if(!arrow||window.innerWidth<=768)return;
  const sp=new Spring(320,20);sp.set(0);
  let active=false;
  function ensureAnim(){
    if(active)return;active=true;
    tasks.add(function(dt){
      const d=sp.step(dt);
      arrow.style.transform='translateX('+sp.value+'px)';
      if(d)active=false;
      return d;
    });
  }
  btn.addEventListener('mouseenter',function(){sp.target=5;ensureAnim();});
  btn.addEventListener('mouseleave',function(){sp.target=0;ensureAnim();});
});

/* ============================================================
   ARROW BUTTON SVG SCALE SPRINGS
   ============================================================ */
document.querySelectorAll('.arrow-btn').forEach(function(btn){
  if(window.innerWidth<=768)return;
  const svg=btn.querySelector('svg');if(!svg)return;
  const sp=new Spring(320,18);sp.set(1);
  let active=false;
  function ensureAnim(){
    if(active)return;active=true;
    tasks.add(function(dt){
      const d=sp.step(dt);
      svg.style.transform='scale('+sp.value+')';
      if(d)active=false;
      return d;
    });
  }
  btn.addEventListener('mouseenter',function(){sp.target=1.15;ensureAnim();});
  btn.addEventListener('mouseleave',function(){sp.target=1;ensureAnim();});
});

</script>
</body>
</html>