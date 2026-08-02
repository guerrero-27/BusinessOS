<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>BusinessOS | {{ config('app.name', 'BusinessOS') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .reveal {
                opacity: 0;
                transform: translateY(28px) scale(0.98);
                transition: opacity 700ms cubic-bezier(0.22, 1, 0.36, 1), transform 700ms cubic-bezier(0.22, 1, 0.36, 1);
                transition-delay: var(--reveal-delay, 0ms);
                will-change: opacity, transform;
            }

            .reveal.is-visible {
                opacity: 1;
                transform: translateY(0) scale(1);
            }

            .reveal-soft {
                opacity: 0;
                transform: translateY(18px);
                transition: opacity 620ms ease, transform 620ms ease;
                transition-delay: var(--reveal-delay, 0ms);
            }

            .reveal-soft.is-visible {
                opacity: 1;
                transform: translateY(0);
            }

            @media (prefers-reduced-motion: reduce) {
                .reveal,
                .reveal-soft {
                    opacity: 1;
                    transform: none;
                    transition: none;
                }
            }
        </style>
    </head>
    <body class="bg-[#F4F5F7] text-[#111111] antialiased">
        <x-navbar />
        <main>
            <div class="reveal" data-reveal>
                <x-hero />
            </div>
            <div class="reveal" data-reveal>
                <x-stats />
            </div>
            <div class="reveal" data-reveal>
                <x-dark-cta />
            </div>

            <section class="container mx-auto px-4 py-10 sm:px-6 lg:px-8 reveal" data-reveal>
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="reveal-soft" data-reveal data-reveal-delay="80">
                        <x-info-card title="Security and access control" description="BusinessOS uses Laravel Breeze authentication, email verification for dashboard access, and profile-level credential management.">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3 4 7v5c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V7l-8-4Z" />
                            </svg>
                        </x-info-card>
                    </div>

                    <div class="reveal-soft" data-reveal data-reveal-delay="180">
                        <x-info-card title="Connected operations" description="Sync customer records, supplier details, product catalogs, inventory adjustments, and reporting in one Laravel workflow.">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5h8m-8 7h8m-8 7h8M5 5h.01M5 12h.01M5 19h.01" />
                            </svg>
                        </x-info-card>
                    </div>
                </div>
            </section>

            <section id="about" class="container mx-auto grid gap-12 px-4 py-10 sm:px-6 md:grid-cols-2 md:items-center lg:px-8 reveal" data-reveal>
                <div class="flex justify-center reveal-soft" data-reveal data-reveal-delay="60">
                    <x-avatar-network size="lg" />
                </div>

                <div class="reveal-soft" data-reveal data-reveal-delay="150">
                    <h2 class="text-3xl font-bold leading-tight text-[#111111] sm:text-4xl">Keep teams connected across sales, stock, and purchasing</h2>
                    <p class="mt-4 text-sm leading-7 text-[#6B7280]">
                        Customer and supplier teams can work from the same data while inventory and reports stay traceable through movement references and status-based filters.
                    </p>
                    <a href="{{ route('dashboard') }}" class="mt-6 inline-flex items-center rounded-full bg-[#111111] px-5 py-2.5 text-sm font-semibold text-white hover:bg-black">
                        Go to Dashboard
                    </a>
                </div>
            </section>

            <section id="blog" class="container mx-auto px-4 py-10 sm:px-6 lg:px-8 reveal" data-reveal>
                <div class="mb-6 flex items-center justify-between gap-3 reveal-soft" data-reveal data-reveal-delay="40">
                    <h2 class="max-w-lg text-3xl font-bold leading-tight text-[#111111] sm:text-4xl">How teams use BusinessOS every day</h2>
                    <div class="hidden items-center gap-2 sm:flex">
                        <button type="button" id="testimonial-prev" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-black/15 text-[#111111]">&#8592;</button>
                        <button type="button" id="testimonial-next" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#111111] text-white">&#8594;</button>
                    </div>
                </div>

                <div id="testimonial-track" class="grid auto-cols-[minmax(280px,1fr)] grid-flow-col gap-4 overflow-x-auto pb-2 md:grid-cols-3 md:grid-flow-row md:overflow-visible">
                    <div class="reveal-soft" data-reveal data-reveal-delay="70">
                        <x-testimonial-card name="Kevin Santos" role="Operations Lead" quote="From customer status to stock alerts, our team now works in one dashboard instead of separate sheets and chat threads." />
                    </div>
                    <div class="reveal-soft" data-reveal data-reveal-delay="140">
                        <x-testimonial-card name="Maria Cruz" role="Sales Manager" quote="The customer module made onboarding faster because records, activity, and contact details are easy to search and update." />
                    </div>
                    <div class="reveal-soft" data-reveal data-reveal-delay="210">
                        <x-testimonial-card name="John Reyes" role="Inventory Analyst" quote="Inventory movements with reference numbers make every stock-in and stock-out audit-ready and easier to report." />
                    </div>
                </div>
            </section>

            <section id="demo" class="container mx-auto px-4 py-12 sm:px-6 lg:px-8 reveal" data-reveal>
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#7ED957] to-[#4CAF50] px-6 py-10 text-white sm:px-8 lg:px-10 reveal-soft" data-reveal data-reveal-delay="40">
                    <div class="max-w-xl reveal-soft" data-reveal data-reveal-delay="130">
                        <h2 class="text-3xl font-bold leading-tight sm:text-4xl">Start running your business with clearer daily decisions</h2>
                        <a href="{{ route('register') }}" class="mt-6 inline-flex items-center rounded-full bg-[#111111] px-5 py-2.5 text-sm font-semibold text-white">
                            Create BusinessOS Account
                        </a>
                    </div>

                    <div class="pointer-events-none absolute inset-y-0 right-0 hidden w-1/3 lg:block">
                        <span class="absolute right-10 top-8 h-8 w-8 rounded-full bg-white/40"></span>
                        <span class="absolute right-24 top-20 h-5 w-5 rounded-full bg-white/45"></span>
                        <span class="absolute right-16 top-32 h-10 w-10 rounded-full bg-white/35"></span>
                        <span class="absolute right-28 bottom-14 h-6 w-6 rounded-full bg-white/45"></span>
                        <span class="absolute right-8 bottom-8 h-12 w-12 rounded-full bg-white/30"></span>
                    </div>
                </div>
            </section>
        </main>

        <x-footer />

        <script>
            (function () {
                const track = document.getElementById('testimonial-track');
                const prev = document.getElementById('testimonial-prev');
                const next = document.getElementById('testimonial-next');
                const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

                document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
                    anchor.addEventListener('click', function (event) {
                        const hash = this.getAttribute('href');
                        if (!hash || hash === '#') return;

                        const target = document.querySelector(hash);
                        if (!target) return;

                        event.preventDefault();

                        target.scrollIntoView({
                            behavior: prefersReducedMotion ? 'auto' : 'smooth',
                            block: 'start'
                        });

                        if (history.pushState) {
                            history.pushState(null, '', hash);
                        } else {
                            window.location.hash = hash;
                        }

                        const openMenu = this.closest('details[open]');
                        if (openMenu) {
                            openMenu.removeAttribute('open');
                        }
                    });
                });

                if (track && prev && next) {
                    prev.addEventListener('click', function () {
                        track.scrollBy({ left: -320, behavior: 'smooth' });
                    });

                    next.addEventListener('click', function () {
                        track.scrollBy({ left: 320, behavior: 'smooth' });
                    });
                }

                const reveals = Array.from(document.querySelectorAll('[data-reveal]'));

                if (!reveals.length) return;

                if (prefersReducedMotion) {
                    reveals.forEach((item) => item.classList.add('is-visible'));
                    return;
                }

                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach((entry) => {
                        if (!entry.isIntersecting) return;

                        const delay = entry.target.dataset.revealDelay;
                        if (delay) {
                            entry.target.style.setProperty('--reveal-delay', delay + 'ms');
                        }

                        entry.target.classList.add('is-visible');
                        obs.unobserve(entry.target);
                    });
                }, {
                    threshold: 0.14,
                    rootMargin: '0px 0px -8% 0px'
                });

                reveals.forEach((item) => observer.observe(item));
            })();
        </script>
    </body>
</html>
