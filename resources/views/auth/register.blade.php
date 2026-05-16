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
    
    <!-- Register Container -->
    <div class="relative w-full max-w-md p-10 bg-surface/80 backdrop-blur-sm wobbly-border text-primary -rotate-1 shadow-[8px_8px_0px_0px_rgba(0,0,0,0.3)]">
        <!-- Floating Doodles -->
        <div class="absolute -top-12 -right-8 text-secondary-fixed-dim rotate-tilt-max scale-150">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
        </div>
        
        <div class="text-center mb-10">
            <h1 class="font-headline-xl text-headline-xl mb-2 tracking-tighter">Join the Board</h1>
            <p class="font-label-marker text-label-marker text-on-surface-variant uppercase italic">Grab a marker and step up</p>
        </div>
        
        <form class="space-y-8" method="POST" action="{{ route('register') }}">
            @csrf
            
            <!-- Name -->
            <div class="group">
                <label class="block font-headline-md text-lg mb-2 italic rotate-tilt-3 group-focus-within:text-secondary-fixed-dim transition-colors">
                    Name
                </label>
                <div class="relative">
                    <input class="w-full bg-transparent border-none focus:ring-0 hand-drawn-line text-lg font-headline-md text-primary placeholder:text-on-surface-variant/30 py-2" placeholder="Your scribble..." type="text" name="name" value="{{ old('name') }}" required autofocus />
                    <div class="absolute -right-4 top-1/2 -translate-y-1/2 opacity-20 group-hover:opacity-100 transition-opacity">
                        <span class="material-symbols-outlined">face</span>
                    </div>
                </div>
                @error('name')
                    <span class="text-error font-label-marker mt-2 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="group">
                <label class="block font-headline-md text-lg mb-2 italic rotate-tilt-neg-2 group-focus-within:text-secondary-fixed-dim transition-colors">
                    Email
                </label>
                <div class="relative">
                    <input class="w-full bg-transparent border-none focus:ring-0 hand-drawn-line text-lg font-headline-md text-primary placeholder:text-on-surface-variant/30 py-2" placeholder="..." type="email" name="email" value="{{ old('email') }}" required />
                    <div class="absolute -right-4 top-1/2 -translate-y-1/2 opacity-20 group-hover:opacity-100 transition-opacity">
                        <span class="material-symbols-outlined">mail</span>
                    </div>
                </div>
                @error('email')
                    <span class="text-error font-label-marker mt-2 block">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Password -->
            <div class="group">
                <label class="block font-headline-md text-lg mb-2 italic rotate-tilt-3 group-focus-within:text-secondary-fixed-dim transition-colors">
                    Password
                </label>
                <div class="relative">
                    <input class="w-full bg-transparent border-none focus:ring-0 hand-drawn-line text-lg font-headline-md text-primary placeholder:text-on-surface-variant/30 py-2" placeholder="********" type="password" name="password" required autocomplete="new-password" />
                    <div class="absolute -right-4 top-1/2 -translate-y-1/2 opacity-20 group-hover:opacity-100 transition-opacity">
                        <span class="material-symbols-outlined">lock</span>
                    </div>
                </div>
                @error('password')
                    <span class="text-error font-label-marker mt-2 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="group">
                <label class="block font-headline-md text-lg mb-2 italic rotate-tilt-neg-2 group-focus-within:text-secondary-fixed-dim transition-colors">
                    Confirm Password
                </label>
                <div class="relative">
                    <input class="w-full bg-transparent border-none focus:ring-0 hand-drawn-line text-lg font-headline-md text-primary placeholder:text-on-surface-variant/30 py-2" placeholder="********" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <div class="absolute -right-4 top-1/2 -translate-y-1/2 opacity-20 group-hover:opacity-100 transition-opacity">
                        <span class="material-symbols-outlined">lock_clock</span>
                    </div>
                </div>
                @error('password_confirmation')
                    <span class="text-error font-label-marker mt-2 block">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Register Button Row -->
            <div class="flex flex-col items-center gap-6 pt-4">
                <button type="submit" class="relative group cursor-pointer active:scale-95 transition-all bg-transparent border-none">
                    <div class="w-32 h-32 rounded-full border-4 border-primary flex items-center justify-center rotate-tilt-min group-hover:rotate-tilt-max transition-transform border-double">
                        <span class="font-headline-md text-lg font-bold tracking-widest uppercase">Sign Up</span>
                    </div>
                    <div class="absolute -right-6 top-0 text-secondary-fixed-dim animate-pulse">
                        <span class="material-symbols-outlined text-4xl" data-weight="fill">edit</span>
                    </div>
                </button>
                
                <a class="font-label-marker text-label-marker text-on-surface-variant hover:text-secondary marker-scribble transition-colors mt-2" href="{{ route('login') }}">
                    Already scribbling here? Log in
                </a>
            </div>
        </form>
    </div>
</main>
@endsection
