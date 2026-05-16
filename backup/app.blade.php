<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'THE MIND BOARD') }}</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Indie+Flower&family=Architects+Daughter&family=Gloria+Hallelujah&family=Permanent+Marker&family=Handlee&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-container": "#e2e2e2",
                        "surface-container-lowest": "#0e0e0e",
                        "on-secondary-fixed-variant": "#5f3d48",
                        "on-primary": "#2f3131",
                        "error-container": "#93000a",
                        "on-tertiary-container": "#486784",
                        "inverse-primary": "#5d5f5f",
                        "tertiary": "#ffffff",
                        "primary-fixed": "#e2e2e2",
                        "secondary": "#e9bac7",
                        "secondary-fixed-dim": "#e9bac7",
                        "surface-container-high": "#2a2a2a",
                        "surface-container-highest": "#353434",
                        "on-secondary-container": "#daacb9",
                        "tertiary-fixed-dim": "#aacaea",
                        "on-error-container": "#ffdad6",
                        "inverse-surface": "#e5e2e1",
                        "primary": "#ffffff",
                        "tertiary-fixed": "#cde5ff",
                        "on-surface": "#e5e2e1",
                        "surface-container": "#201f1f",
                        "outline": "#8e9192",
                        "on-background": "#e5e2e1",
                        "surface-bright": "#3a3939",
                        "surface": "#141313",
                        "error": "#ffb4ab",
                        "on-primary-fixed-variant": "#454747",
                        "outline-variant": "#444748",
                        "on-primary-container": "#636565",
                        "tertiary-container": "#cde5ff",
                        "on-secondary-fixed": "#2e131c",
                        "primary-fixed-dim": "#c6c6c7",
                        "surface-container-low": "#1c1b1b",
                        "surface-dim": "#141313",
                        "on-tertiary-fixed": "#001d32",
                        "on-tertiary-fixed-variant": "#294964",
                        "on-tertiary": "#0f334d",
                        "on-error": "#690005",
                        "on-primary-fixed": "#1a1c1c",
                        "secondary-container": "#623f4a",
                        "surface-tint": "#c6c6c7",
                        "background": "#141313",
                        "on-secondary": "#462731",
                        "inverse-on-surface": "#313030",
                        "surface-variant": "#353434",
                        "secondary-fixed": "#ffd9e2",
                        "on-surface-variant": "#c4c7c8"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "margin": "1.5rem",
                        "marker-stroke": "4px",
                        "double-stroke": "12px",
                        "tilt-min": "-5deg",
                        "gutter": "2rem",
                        "tilt-max": "5deg"
                    },
                    "fontFamily": {
                        "body-sm": ["Plus Jakarta Sans"],
                        "label-marker": ["Epilogue"],
                        "body-lg": ["Plus Jakarta Sans"],
                        "headline-xl": ["Epilogue"],
                        "headline-md": ["Epilogue"],
                        "hand-1": ["Indie Flower"],
                        "hand-2": ["Architects Daughter"],
                        "hand-3": ["Gloria Hallelujah"],
                        "hand-4": ["Permanent Marker"],
                        "marker-hand": ["Permanent Marker"],
                        "sketch-hand": ["Gloria Hallelujah"],
                        "casual-hand": ["Handlee"]
                    },
                    "fontSize": {
                        "body-sm": ["14px", {"lineHeight": "1.4", "fontWeight": "400"}],
                        "label-marker": ["12px", {"lineHeight": "1", "fontWeight": "600"}],
                        "body-lg": ["18px", {"lineHeight": "1.5", "fontWeight": "500"}],
                        "headline-xl": ["48px", {"lineHeight": "1.1", "letterSpacing": "0.05em", "fontWeight": "800"}],
                        "headline-md": ["24px", {"lineHeight": "1.2", "letterSpacing": "0.02em", "fontWeight": "700"}]
                    }
                },
            },
        }
    </script>
    <style>
        /* Hand-drawn Animation Core */
        @keyframes draw-stroke {
            to { stroke-dashoffset: 0; }
        }
        @keyframes draw-path {
            from { clip-path: inset(0 100% 0 0); }
            to { clip-path: inset(0 0 0 0); }
        }
        @keyframes scribble-wobble {
            0% { transform: rotate(-1deg) translate(0,0); }
            25% { transform: rotate(1deg) translate(1px,-1px); }
            50% { transform: rotate(-1.5deg) translate(-1px,1px); }
            75% { transform: rotate(1.2deg) translate(2px,0); }
            100% { transform: rotate(-1deg) translate(0,0); }
        }
        @keyframes marching-ants {
            to { stroke-dashoffset: -20; }
        }
        @keyframes flicker {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 1; }
        }
        @keyframes sway {
            0%, 100% { transform: rotate(-2deg); }
            50% { transform: rotate(2deg); }
        }
        @keyframes erase-redraw {
            0% { opacity: 0.4; }
            45% { opacity: 0; }
            55% { opacity: 0; }
            100% { opacity: 0.4; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) scale(1.1); }
        }
        @keyframes letter-reveal { to { opacity: 1; } }

        /* Utility Classes */
        .animate-draw { animation: draw-path 0.8s cubic-bezier(0.5, 1.2, 0.5, 0.8) forwards; }
        .animate-wobble-slow { animation: scribble-wobble 2s steps(4) infinite; }
        .animate-sway { animation: sway 4s steps(6) infinite; }
        .animate-ants { stroke-dasharray: 5, 5; animation: marching-ants 0.5s linear infinite; }
        .animate-flicker { animation: flicker 0.2s steps(2) infinite; }
        .animate-erase { animation: erase-redraw 10s steps(1) infinite; }
        
        .marker-underline { position: relative; }
        .marker-underline::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: -5%;
            width: 110%;
            height: 6px;
            background: currentColor;
            clip-path: polygon(0 40%, 10% 20%, 20% 50%, 30% 30%, 40% 60%, 50% 20%, 60% 70%, 70% 30%, 80% 50%, 90% 10%, 100% 40%, 100% 60%, 90% 80%, 80% 60%, 70% 90%, 60% 50%, 50% 80%, 40% 40%, 30% 70%, 20% 30%, 10% 80%, 0% 60%);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s cubic-bezier(0.5, 1.2, 0.5, 0.8);
        }
        .reveal-underline.in-view .marker-underline::after { transform: scaleX(1); }

        .svg-draw path {
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000;
        }
        .in-view .svg-draw path {
            animation: draw-stroke 2s cubic-bezier(0.5, 1.2, 0.5, 0.8) forwards;
        }

        .marker-double-border {
            border: 4px solid currentColor;
            box-shadow: 0 0 0 4px #141313, 0 0 0 8px currentColor;
        }
        .wobbly-path {
            clip-path: polygon(
                2% 3%, 5% 1%, 10% 2%, 15% 4%, 20% 1%, 25% 3%, 30% 1%, 35% 2%, 40% 4%, 45% 1%, 50% 3%, 55% 1%, 60% 2%, 65% 4%, 70% 1%, 75% 3%, 80% 1%, 85% 2%, 90% 4%, 95% 1%, 98% 3%,
                99% 10%, 97% 20%, 99% 30%, 98% 40%, 99% 50%, 97% 60%, 99% 70%, 98% 80%, 99% 90%, 97% 97%,
                95% 99%, 90% 98%, 85% 99%, 80% 97%, 75% 99%, 70% 98%, 65% 99%, 60% 97%, 55% 99%, 50% 98%, 45% 99%, 40% 97%, 35% 99%, 30% 98%, 25% 99%, 20% 97%, 15% 99%, 10% 98%, 5% 99%, 2% 97%,
                1% 90%, 3% 80%, 1% 70%, 2% 60%, 1% 50%, 3% 40%, 1% 30%, 2% 20%, 1% 10%
            );
        }
        .bg-board {
            background-color: #1a3a2a;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(255,255,255,0.03) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(255,255,255,0.02) 0%, transparent 30%),
                url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M10,10 C30,12 40,5 60,10 C80,15 100,5 120,10' stroke='rgba(255,255,255,0.05)' fill='none' stroke-width='2'/%3E%3C/svg%3E");
        }
        .smudge {
            background: radial-gradient(ellipse at center, rgba(255,255,255,0.06) 0%, transparent 70%);
            filter: blur(18px);
        }
        .smudge-gray {
            background: radial-gradient(ellipse at center, rgba(200,200,200,0.05) 0%, transparent 80%);
            filter: blur(12px);
        }

        .char-draw span {
            opacity: 0;
            display: inline-block;
        }
        .in-view .char-draw span {
            animation: letter-reveal 0.05s forwards;
        }

        .btn-draw-hover { position: relative; }
        .btn-draw-hover::before {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 4px;
            background: black;
            transition: width 0.3s steps(5);
        }
        .btn-draw-hover:hover::before { width: 100%; }

        /* Shared extra styles */
        @yield('styles')
    </style>
</head>
<body class="bg-board text-on-background font-body-lg selection:bg-secondary selection:text-on-secondary overflow-x-hidden">
    
    <!-- Navbar -->
    <nav class="flex justify-between items-center w-[98%] mx-auto px-margin py-8 bg-surface shadow-[6px_8px_0px_0px_rgba(0,0,0,0.4)] organic-rotate-1 border-b-4 border-primary/40 sticky z-50 mt-4 wobbly-path scroll-reveal">
        <a href="{{ route('home') }}" class="flex items-center gap-4">
            <img src="{{ asset('images/logo.png') }}" alt="The Mind Board Logo" class="h-20 w-20 object-contain -rotate-3" />
        </a>
        <div class="hidden md:flex items-center gap-10">
            <a class="font-hand-1 text-xl uppercase tracking-widest text-on-surface-variant hover:text-primary transition-all cursor-pointer marker-underline" href="{{ route('mood.index') }}">Log Mood</a>
            <a class="font-hand-1 text-xl uppercase tracking-widest text-on-surface-variant hover:text-primary transition-all cursor-pointer marker-underline" href="{{ route('therapists.index') }}">Therapists</a>
            <a class="font-hand-1 text-xl uppercase tracking-widest text-on-surface-variant hover:text-primary transition-all cursor-pointer marker-underline" href="{{ route('journal.index') }}">Journal</a>
            <a class="font-hand-1 text-xl uppercase tracking-widest text-on-surface-variant hover:text-primary transition-all cursor-pointer marker-underline" href="{{ route('community.index') }}">Community</a>
            
            @guest
                <a class="font-hand-1 text-xl uppercase tracking-widest text-on-surface-variant hover:text-primary transition-all cursor-pointer marker-underline" href="{{ route('login') }}">Login</a>
            @endguest
            @auth
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="font-hand-1 text-xl uppercase tracking-widest text-on-surface-variant hover:text-primary transition-all cursor-pointer marker-underline">Logout</button>
                </form>
            @endauth
        </div>
        <a href="{{ route('booking.index') }}" class="font-hand-2 text-lg uppercase tracking-wider bg-primary text-on-primary px-8 py-3 border-4 border-black shadow-[5px_5px_0px_0px_rgba(255,255,255,0.2)] hover:scale-105 transition-all wobbly-path btn-draw-hover">
            BOOK SESSION
        </a>
    </nav>

    <!-- Page Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="flex flex-col md:flex-row justify-between items-center px-margin py-12 gap-8 w-[96%] mx-auto bg-surface-container text-primary mt-20 border-t-8 border-primary/30 wobbly-path relative z-10 mb-8 shadow-2xl scroll-reveal opacity-0">
        <div class="font-hand-4 text-3xl text-primary header-shadow char-draw">
            @foreach(str_split(config('app.name', 'THE MIND BOARD')) as $char)
                <span>{!! $char === ' ' ? '&nbsp;' : $char !!}</span>
            @endforeach
        </div>
        <div class="font-hand-1 text-xl opacity-70">&copy; {{ date('Y') }} {{ config('app.name', 'THE MIND BOARD') }} - JUST KEEP SCRIBBLING</div>
        <div class="flex gap-8">
            <a class="font-hand-2 text-lg text-on-surface-variant hover:text-secondary transition-colors underline decoration-wavy" href="#">Privacy</a>
            <a class="font-hand-2 text-lg text-on-surface-variant hover:text-secondary transition-colors underline decoration-dotted" href="#">Terms</a>
            <a class="font-hand-2 text-lg text-on-surface-variant hover:text-secondary transition-colors italic marker-underline" href="#">Doodle Support</a>
        </div>
        <div class="absolute -top-10 right-10 smudge-gray w-32 h-20 rotate-12 animate-erase"></div>
    </footer>

    <!-- Global Scripts -->
    <script>
        const observerOptions = { threshold: 0.1 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    if (entry.target.classList.contains('scroll-reveal')) {
                        entry.target.style.opacity = '1';
                        entry.target.classList.add('animate-draw');
                    }
                    const chars = entry.target.querySelectorAll('.char-draw span');
                    chars.forEach((char, index) => {
                        char.style.animationDelay = `${index * 0.05}s`;
                    });
                }
            });
        }, observerOptions);

        document.querySelectorAll('.scroll-reveal, .char-draw, .reveal-underline, .svg-draw').forEach(el => {
            observer.observe(el);
        });

        setInterval(() => {
            document.querySelectorAll('.animate-erase').forEach(smudge => {
                if (getComputedStyle(smudge).opacity === "0") {
                    const x = (Math.random() - 0.5) * 40;
                    const y = (Math.random() - 0.5) * 40;
                    smudge.style.setProperty('--tw-translate-x', `${x}px`);
                    smudge.style.setProperty('--tw-translate-y', `${y}px`);
                }
            });
        }, 1000);
    </script>
    @yield('scripts')
</body>
</html>
