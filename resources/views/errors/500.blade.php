<!doctype html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>500 - Server Error | NEXTGEN FOREX</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}" />
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nextgen-theme.css') }}" rel="stylesheet">
</head>

<body id="dashboard" class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden bg-black text-slate-100">

    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black z-10 opacity-90"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-emerald-500/10 blur-[150px]"></div>
    </div>

    <div class="w-full max-w-md relative z-20 space-y-6 text-center my-auto px-4">
        <div class="ng-pkg-card p-8 border-2 border-emerald-500/60 shadow-[0_0_50px_rgba(0,230,118,0.2)] space-y-6 relative backdrop-blur-xl">
            <div class="w-16 h-16 mx-auto rounded-2xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-emerald-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="m9 8 6 4-6 4"/></svg>
            </div>

            <div class="space-y-2">
                <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-black uppercase tracking-widest border border-emerald-500/40">
                    HTTP ERROR 500
                </span>
                <h1 class="text-3xl font-black text-white font-heading">INTERNAL SERVER ERROR</h1>
                <p class="text-xs text-neutral-300">Something went wrong on our servers. Please try again in a moment.</p>
            </div>

            <div class="pt-2 flex flex-col gap-2">
                <a href="{{ url('/') }}" class="w-full py-3 rounded-xl bg-amber-500 text-black font-black text-xs uppercase tracking-wider hover:scale-102 transition shadow-lg flex items-center justify-center gap-2">
                    RETURN TO HOME
                </a>
            </div>
        </div>
    </div>

</body>

</html>
