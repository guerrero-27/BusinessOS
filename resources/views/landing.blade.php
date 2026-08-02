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
    </head>
    <body class="bg-[#F4F5F7] text-[#111111] antialiased">
        <x-navbar />
        <main>
            <x-hero />
            <x-stats />
            <x-dark-cta />

            <section class="container mx-auto px-4 py-10 sm:px-6 lg:px-8">
                <div class="grid gap-6 md:grid-cols-2">
                    <x-info-card title="Security and access control" description="BusinessOS uses Laravel Breeze authentication, email verification for dashboard access, and profile-level credential management.">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3 4 7v5c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V7l-8-4Z" />
                        </svg>
                    </x-info-card>

                    <x-info-card title="Connected operations" description="Sync customer records, supplier details, product catalogs, inventory adjustments, and reporting in one Laravel workflow.">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5h8m-8 7h8m-8 7h8M5 5h.01M5 12h.01M5 19h.01" />
                        </svg>
                    </x-info-card>
                </div>
            </section>

            <section id="about" class="container mx-auto grid gap-12 px-4 py-10 sm:px-6 md:grid-cols-2 md:items-center lg:px-8">
                <div class="flex justify-center">
                    <div class="relative h-80 w-80">
                        <div class="absolute left-1/2 top-1/2 h-20 w-20 -translate-x-1/2 -translate-y-1/2 rounded-full bg-[#111111] text-white flex items-center justify-center font-bold">BO</div>
                        <div class="absolute left-1/2 top-1/2 h-56 w-56 -translate-x-1/2 -translate-y-1/2 rounded-full border border-black/10"></div>

                        <span class="absolute left-1/2 top-2 h-12 w-12 -translate-x-1/2 rounded-full bg-white ring-1 ring-black/10"></span>
                        <span class="absolute right-6 top-16 h-12 w-12 rounded-full bg-white ring-1 ring-black/10"></span>
                        <span class="absolute right-7 bottom-16 h-12 w-12 rounded-full bg-white ring-1 ring-black/10"></span>
                        <span class="absolute left-1/2 bottom-2 h-12 w-12 -translate-x-1/2 rounded-full bg-white ring-1 ring-black/10"></span>
                        <span class="absolute left-6 top-16 h-12 w-12 rounded-full bg-white ring-1 ring-black/10"></span>

                        <div class="absolute left-1/2 top-1/2 h-px w-24 -translate-y-16 -rotate-90 bg-black/15"></div>
                        <div class="absolute left-1/2 top-1/2 h-px w-24 -translate-x-1 rotate-[-35deg] bg-black/15"></div>
                        <div class="absolute left-1/2 top-1/2 h-px w-24 translate-x-2 rotate-[35deg] bg-black/15"></div>
                        <div class="absolute left-1/2 top-1/2 h-px w-24 translate-y-16 rotate-90 bg-black/15"></div>
                        <div class="absolute left-1/2 top-1/2 h-px w-24 -translate-x-3 rotate-[145deg] bg-black/15"></div>
                    </div>
                </div>

                <div>
                    <h2 class="text-3xl font-bold leading-tight text-[#111111] sm:text-4xl">Keep teams connected across sales, stock, and purchasing</h2>
                    <p class="mt-4 text-sm leading-7 text-[#6B7280]">
                        Customer and supplier teams can work from the same data while inventory and reports stay traceable through movement references and status-based filters.
                    </p>
                    <a href="{{ route('dashboard') }}" class="mt-6 inline-flex items-center rounded-full bg-[#111111] px-5 py-2.5 text-sm font-semibold text-white hover:bg-black">
                        Go to Dashboard
                    </a>
                </div>
            </section>

            <section id="blog" class="container mx-auto px-4 py-10 sm:px-6 lg:px-8">
                <div class="mb-6 flex items-center justify-between gap-3">
                    <h2 class="max-w-lg text-3xl font-bold leading-tight text-[#111111] sm:text-4xl">How teams use BusinessOS every day</h2>
                    <div class="hidden items-center gap-2 sm:flex">
                        <button type="button" id="testimonial-prev" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-black/15 text-[#111111]">&#8592;</button>
                        <button type="button" id="testimonial-next" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#111111] text-white">&#8594;</button>
                    </div>
                </div>

                <div id="testimonial-track" class="grid auto-cols-[minmax(280px,1fr)] grid-flow-col gap-4 overflow-x-auto pb-2 md:grid-cols-3 md:grid-flow-row md:overflow-visible">
                    <x-testimonial-card name="Kevin Santos" role="Operations Lead" quote="From customer status to stock alerts, our team now works in one dashboard instead of separate sheets and chat threads." />
                    <x-testimonial-card name="Maria Cruz" role="Sales Manager" quote="The customer module made onboarding faster because records, activity, and contact details are easy to search and update." />
                    <x-testimonial-card name="John Reyes" role="Inventory Analyst" quote="Inventory movements with reference numbers make every stock-in and stock-out audit-ready and easier to report." />
                </div>
            </section>

            <section id="demo" class="container mx-auto px-4 py-12 sm:px-6 lg:px-8">
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#7ED957] to-[#4CAF50] px-6 py-10 text-white sm:px-8 lg:px-10">
                    <div class="max-w-xl">
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
                if (!track || !prev || !next) return;

                prev.addEventListener('click', function () {
                    track.scrollBy({ left: -320, behavior: 'smooth' });
                });

                next.addEventListener('click', function () {
                    track.scrollBy({ left: 320, behavior: 'smooth' });
                });
            })();
        </script>
    </body>
</html>
