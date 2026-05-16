@extends('layouts.app')

@section('styles')
<style>
    .marker-smudge {
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
    }
    .wobbly-border {
        border: 2px solid currentColor;
        border-radius: 2% 5% 4% 3% / 3% 4% 5% 2%;
        position: relative;
    }
    .wobbly-border::after {
        content: '';
        position: absolute;
        top: 4px;
        left: 4px;
        right: -4px;
        bottom: -4px;
        border: 2px solid currentColor;
        border-radius: 3% 4% 2% 5% / 5% 2% 4% 3%;
        pointer-events: none;
        opacity: 0.6;
    }
    .hand-drawn-line {
        border-bottom: 3px solid currentColor;
        border-radius: 100% 10% 90% 0% / 10% 0% 10% 0%;
    }
    .rotate-tilt-3 {
        transform: rotate(3deg);
    }
    .rotate-tilt-neg-2 {
        transform: rotate(-2deg);
    }
    .marker-scribble {
        text-decoration: underline wavy;
    }
</style>
@endsection

@section('content')
<main class="flex-grow flex items-center justify-center p-gutter relative overflow-hidden bg-[url('https://www.transparenttextures.com/patterns/chalkboard.png')] min-h-[80vh]">
    <!-- Background Smudges -->
    <div class="absolute top-20 left-10 w-64 h-64 marker-smudge rounded-full blur-3xl opacity-20"></div>
    <div class="absolute bottom-10 right-20 w-96 h-96 marker-smudge rounded-full blur-3xl opacity-10"></div>
    
    <!-- Login Container -->
    <div class="relative w-full max-w-md p-10 bg-surface/80 backdrop-blur-sm wobbly-border text-primary rotate-tilt-3 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.3)]">
        <!-- Floating Doodles -->
        <div class="absolute -top-12 -right-8 text-secondary-fixed-dim rotate-tilt-max scale-150">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
        </div>
        <div class="absolute -bottom-10 -left-6 text-on-surface-variant opacity-40">
            <span class="material-symbols-outlined text-6xl">edit_square</span>
        </div>
        
        <div class="text-center mb-10">
            <h1 class="font-headline-xl text-headline-xl mb-2 tracking-tighter">Enter the Board</h1>
            <p class="font-label-marker text-label-marker text-on-surface-variant uppercase italic">Thoughts are welcome here</p>
        </div>
        
        <form class="space-y-12" method="POST" action="{{ route('login') }}">
            @csrf
            
            <!-- Email (Replaced Username with Email for Breeze) -->
            <div class="group">
                <label class="block font-headline-md text-headline-md mb-2 italic rotate-tilt-neg-2 group-focus-within:text-secondary-fixed-dim transition-colors">
                    Email
                </label>
                <div class="relative">
                    <input class="w-full bg-transparent border-none focus:ring-0 hand-drawn-line text-headline-md font-headline-md text-primary placeholder:text-on-surface-variant/30 py-2" placeholder="..." type="email" name="email" value="{{ old('email') }}" required autofocus />
                    <div class="absolute -right-4 top-1/2 -translate-y-1/2 opacity-20 group-hover:opacity-100 transition-opacity">
                        <span class="material-symbols-outlined">gesture</span>
                    </div>
                </div>
                @error('email')
                    <span class="text-error font-label-marker mt-2 block">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Password -->
            <div class="group">
                <label class="block font-headline-md text-headline-md mb-2 italic rotate-tilt-3 group-focus-within:text-secondary-fixed-dim transition-colors">
                    Password
                </label>
                <div class="relative">
                    <input class="w-full bg-transparent border-none focus:ring-0 hand-drawn-line text-headline-md font-headline-md text-primary placeholder:text-on-surface-variant/30 py-2" placeholder="********" type="password" name="password" required autocomplete="current-password" />
                    <div class="absolute -right-4 top-1/2 -translate-y-1/2 opacity-20 group-hover:opacity-100 transition-opacity">
                        <span class="material-symbols-outlined">lock_open</span>
                    </div>
                </div>
                @error('password')
                    <span class="text-error font-label-marker mt-2 block">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Login Button Row -->
            <div class="flex flex-col items-center gap-6 pt-4">
                <button type="submit" class="relative group cursor-pointer active:scale-95 transition-all bg-transparent border-none">
                    <div class="w-32 h-32 rounded-full border-4 border-primary flex items-center justify-center rotate-tilt-min group-hover:rotate-tilt-max transition-transform border-double">
                        <span class="font-headline-md text-headline-md font-bold tracking-widest uppercase">Login</span>
                    </div>
                    <div class="absolute -right-6 top-0 text-secondary-fixed-dim animate-pulse">
                        <span class="material-symbols-outlined text-4xl" data-weight="fill">star</span>
                    </div>
                </button>
                
                @if (Route::has('password.request'))
                    <a class="font-label-marker text-label-marker text-on-surface-variant hover:text-secondary marker-scribble transition-colors" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
                <a class="font-label-marker text-label-marker text-on-surface-variant hover:text-secondary marker-scribble transition-colors" href="{{ route('register') }}">
                        Don't have an account? Register
                </a>
            </div>
        </form>
        
        <!-- Decorative Smudge in container -->
        <div class="absolute top-2 right-4 w-12 h-12 marker-smudge opacity-30"></div>
    </div>
    
    <!-- Secondary Visual Element (Doodle/Image Placeholder) -->
    <div class="hidden xl:block absolute left-10 bottom-20 w-72 h-72 rotate-tilt-min">
        <div class="w-full h-full p-4 bg-surface-container wobbly-border shadow-[4px_4px_0px_0px_rgba(255,255,255,0.1)]">
            <img alt="Chalkboard art" class="w-full h-full object-cover grayscale opacity-60 mix-blend-screen" src="https://lh3.googleusercontent.com/aida/ADBb0uiJiqA7roc0sSEEstT0zzFzj4fCts_iVju5S4PEcFoXUzHISuqw8qjPZNlrpk8QQk7eaLyTUf1P9YnHwTA3umpN1h_80JlzJ9rDqDPK1sawCDoGCpl35zESZe_xRz1RihsHg8SATYimzz4oTnYqoRbZ1qfG0470RaYJsQTbO5xmv3oszlJ0VhvAcSukUbwHgLh2dVTUUjllYcZLCLpBxVG5zumqA8K78W4SMctaH_a0mNwenZdacicAI3Q"/>
            <p class="mt-4 font-label-marker text-label-marker text-on-surface-variant uppercase text-center">Board Archives #852</p>
        </div>
    </div>
</main>
@endsection
