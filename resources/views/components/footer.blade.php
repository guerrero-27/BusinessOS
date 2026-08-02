<footer class="mt-16 bg-[#111111] text-white">
    <div class="container mx-auto px-4 pb-7 pt-12 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
            <div class="lg:col-span-1">
                <div class="flex items-center gap-2">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-[#7ED957] to-[#4CAF50] text-[#111111]">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 2 22 20 12 15 2 20Z" />
                        </svg>
                    </span>
                    <span class="text-lg font-bold">BusinessOS</span>
                </div>
                <p class="mt-3 max-w-xs text-sm leading-6 text-white/70">BusinessOS-powered planning for teams that grow better together.</p>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-[0.12em] text-white/80">About</h4>
                <ul class="mt-4 space-y-2 text-sm text-white/70">
                    <li><a href="#about" class="hover:text-white">Overview</a></li>
                    <li><a href="#services" class="hover:text-white">Services</a></li>
                    <li><a href="#blog" class="hover:text-white">Insights</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-[0.12em] text-white/80">Company</h4>
                <ul class="mt-4 space-y-2 text-sm text-white/70">
                    <li><a href="#" class="hover:text-white">Careers</a></li>
                    <li><a href="#" class="hover:text-white">Partners</a></li>
                    <li><a href="#" class="hover:text-white">Contact</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold uppercase tracking-[0.12em] text-white/80">Legal</h4>
                <ul class="mt-4 space-y-2 text-sm text-white/70">
                    <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-white">Terms of Use</a></li>
                    <li><a href="#" class="hover:text-white">Cookie Policy</a></li>
                </ul>
                <div class="mt-5 flex items-center gap-2">
                    <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-white/20 text-white/80 hover:text-white">F</a>
                    <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-white/20 text-white/80 hover:text-white">X</a>
                    <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-white/20 text-white/80 hover:text-white">I</a>
                </div>
            </div>
        </div>

        <div class="mt-10 border-t border-white/10 pt-5 text-center text-xs text-white/60">
            &copy; {{ now()->year }} BusinessOS. All rights reserved.
        </div>
    </div>
</footer>
