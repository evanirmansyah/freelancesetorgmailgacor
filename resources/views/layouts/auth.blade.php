<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setoran - Platform Tugas Terpercaya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .bg-mesh {
            background-color: #f1f5f9;
            background-image: radial-gradient(at 40% 20%, hsla(228,100%,74%,1) 0px, transparent 50%),
            radial-gradient(at 80% 0%, hsla(189,100%,56%,1) 0px, transparent 50%),
            radial-gradient(at 0% 50%, hsla(355,100%,93%,1) 0px, transparent 50%),
            radial-gradient(at 80% 50%, hsla(340,100%,76%,1) 0px, transparent 50%),
            radial-gradient(at 0% 100%, hsla(22,100%,77%,1) 0px, transparent 50%),
            radial-gradient(at 80% 100%, hsla(242,100%,70%,1) 0px, transparent 50%),
            radial-gradient(at 0% 0%, hsla(343,100%,76%,1) 0px, transparent 50%);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased h-screen overflow-hidden">

    <div class="flex h-full w-full">
        <!-- Sisi Kiri (Brand & Trust Area) -->
        <div class="hidden lg:flex w-[55%] flex-col justify-between p-12 bg-brand-primary text-white relative overflow-hidden bg-mesh">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-16">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h1 class="text-2xl font-bold tracking-tight">Setoran</h1>
                </div>

                <div class="max-w-lg">
                    <h2 class="text-4xl lg:text-5xl font-bold leading-tight mb-6 text-slate-900">Setor email, kerjakan tugas, ajak teman &mdash; <span class="text-brand-primary">saldo tumbuh otomatis.</span></h2>
                    <p class="text-lg text-slate-800/80 mb-8 font-medium">Platform tugas micro-job terpercaya. Reward langsung masuk ke saldo begitu disetujui dan dapat ditarik kapan saja.</p>
                    
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center gap-3 text-slate-800 font-medium bg-white/40 p-3 rounded-xl backdrop-blur-sm border border-white/50 w-max shadow-sm">
                            <svg class="w-5 h-5 text-status-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Reward Instan & Pencairan Cepat
                        </div>
                        <div class="flex items-center gap-3 text-slate-800 font-medium bg-white/40 p-3 rounded-xl backdrop-blur-sm border border-white/50 w-max shadow-sm">
                            <svg class="w-5 h-5 text-status-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            256-bit Encrypted Security
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trust Badge -->
            <div class="relative z-10 bg-white/70 backdrop-blur-md border border-white/20 shadow-sm rounded-2xl p-6 mt-12 max-w-sm">
                <div class="flex items-center gap-4 mb-4">
                    <div class="flex -space-x-3">
                        <img class="w-10 h-10 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=1" alt="User">
                        <img class="w-10 h-10 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=2" alt="User">
                        <img class="w-10 h-10 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=3" alt="User">
                    </div>
                    <div class="text-sm font-semibold text-slate-800">
                        10.000+ Member <br> <span class="text-xs font-normal text-slate-600">telah bergabung</span>
                    </div>
                </div>
                <p class="text-sm text-slate-700 italic">"Sistem otomatisnya sangat cepat. Saldo langsung masuk tanpa nunggu lama."</p>
                <div class="mt-3 flex items-center gap-1 text-yellow-500">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Sisi Kanan (Form Area) -->
        <div class="w-full lg:w-[45%] flex items-center justify-center bg-white p-8 overflow-y-auto">
            <div class="w-full max-w-md">
                @yield('content')
            </div>
        </div>
    </div>

</body>
</html>
