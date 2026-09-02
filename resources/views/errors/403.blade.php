<!doctype html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>403 - Forbidden Access | NEXTGEN FOREX</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}" />
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nextgen-theme.css') }}" rel="stylesheet">
</head>

<body id="dashboard" class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden bg-black text-slate-100">

    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black z-10 opacity-90"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-rose-500/10 blur-[150px]"></div>
    </div>

    <div class="w-full max-w-md relative z-20 space-y-6 text-center my-auto px-4">
        <div class="ng-pkg-card p-8 border-2 border-rose-500/60 shadow-[0_0_50px_rgba(255,82,82,0.2)] space-y-6 relative backdrop-blur-xl">
            <div class="w-16 h-16 mx-auto rounded-2xl bg-rose-500/20 border border-rose-500/40 flex items-center justify-center text-rose-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>

            <div class="space-y-2">
                <span class="px-3 py-1 rounded-full bg-rose-500/20 text-rose-300 text-[10px] font-black uppercase tracking-widest border border-rose-500/40">
                    HTTP ERROR 403
                </span>
                <h1 class="text-3xl font-black text-white font-heading">ACCESS FORBIDDEN</h1>
                <p class="text-xs text-neutral-300">You do not have permission or role privileges to view this page.</p>
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
