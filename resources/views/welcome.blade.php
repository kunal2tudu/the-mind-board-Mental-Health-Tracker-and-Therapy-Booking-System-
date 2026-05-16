@extends('layouts.app')

@section('content')
<div class="fixed inset-0 pointer-events-none z-0">
    <div class="absolute top-10 left-[15%] w-96 h-64 smudge-gray rotate-12 animate-erase"></div>
    <div class="absolute top-1/2 right-[5%] w-72 h-80 smudge -rotate-6 animate-erase" style="animation-delay: 2s;"></div>
    <div class="absolute bottom-20 left-[5%] w-80 h-48 smudge rotate-45 opacity-40 animate-erase" style="animation-delay: 5s;"></div>
    <div class="absolute top-20 right-1/4 w-40 h-40 bg-white/5 blur-3xl rounded-full"></div>
</div>

<main class="relative min-h-screen z-10">
    <section class="container mx-auto px-margin pt-24 pb-40 flex flex-col items-center text-center scroll-reveal">
        <div class="relative mb-16 svg-draw">
            <div class="absolute -inset-4 bg-white/5 blur-xl rounded-full wobbly-path opacity-0 animate-draw"></div>
            <!-- Hand-drawn SVG Logo Placeholder/Simulation -->
            <svg class="w-72 h-72 mx-auto organic-rotate-4 relative z-10" fill="none" stroke="white" stroke-width="2" viewbox="0 0 100 100">
                <!-- Circle -->
                <path class="logo-circle" d="M50,10 A40,40 0 1,1 49.9,10" stroke-linecap="round"></path>
                <!-- Eyes -->
                <path d="M35,40 Q37,35 39,40" stroke-linecap="round"></path>
                <path d="M61,40 Q63,35 65,40" stroke-linecap="round"></path>
                <!-- Smile -->
                <path d="M30,60 Q50,75 70,60" stroke-linecap="round"></path>
            </svg>
            <div class="absolute -right-20 -bottom-4 w-32 h-32 text-primary opacity-30 pointer-events-none animate-sway">
                <span class="material-symbols-outlined text-[100px]" data-icon="potted_plant">potted_plant</span>
            </div>
            <div class="absolute -left-12 top-0 w-24 h-24 smudge-gray opacity-60 animate-erase"></div>
        </div>
        
        <h1 class="font-hand-4 text-6xl md:text-8xl text-primary uppercase mb-8 header-shadow tracking-tighter reveal-underline">
            <span class="block">WELCOME TO</span>
            <span class="text-secondary inline-block marker-underline">YOUR BOARD</span>
        </h1>
        
        <p class="font-hand-3 text-3xl text-secondary max-w-2xl mx-auto opacity-90 char-draw">
            <span>A</span> <span>safe</span> <span>space</span> <span>to</span> <span>scribble</span> <span>your</span> <span>thoughts...</span>
        </p>
        
        <div class="mt-20 animate-bounce">
            <span class="material-symbols-outlined text-primary text-[80px] opacity-60" data-icon="arrow_downward">arrow_downward</span>
        </div>
    </section>

    <section class="container mx-auto px-margin pb-48 flex flex-wrap justify-center gap-16 relative">
        <div class="absolute -top-20 left-1/3 text-primary/40 font-hand-1 text-2xl uppercase pointer-events-none flex items-center gap-2">
            Start here 
            <svg class="text-primary/40" height="20" viewbox="0 0 60 20" width="60">
                <path class="animate-ants" d="M0,10 L50,10 M40,0 L55,10 L40,20" fill="none" stroke="currentColor" stroke-width="2"></path>
            </svg>
        </div>
        
        <!-- Card 1 -->
        <a href="{{ route('mood.index') }}" class="block bg-surface-container-low text-primary p-10 marker-double-border wobbly-path transition-all duration-500 flex flex-col gap-6 w-full md:w-[380px] relative animate-wobble-slow scroll-reveal opacity-0" style="transition-delay: 0.1s">
            <div class="absolute -top-2 -left-2 w-full h-full bg-black/20 -z-10 wobbly-path"></div>
            <div class="flex justify-between items-start">
                <span class="material-symbols-outlined text-5xl text-secondary animate-sway" data-icon="sentiment_satisfied">sentiment_satisfied</span>
                <div class="bg-secondary text-on-secondary px-4 py-1 font-hand-4 text-lg wobbly-path shadow-lg animate-flicker">NEW!!</div>
            </div>
            <h3 class="font-hand-4 text-4xl uppercase tracking-tight marker-underline">Track your mood</h3>
            <p class="font-hand-1 text-xl text-on-surface-variant">Messy feelings belong here. Mark your vibe with a quick scribble each day.</p>
            <div class="mt-4 flex gap-4">
                <span class="material-symbols-outlined cursor-pointer hover:scale-125 text-3xl hover:text-secondary" data-icon="mood">mood</span>
                <span class="material-symbols-outlined cursor-pointer hover:scale-125 text-3xl" data-icon="mood_bad">mood_bad</span>
                <span class="material-symbols-outlined cursor-pointer hover:scale-125 text-3xl" data-icon="sentiment_neutral">sentiment_neutral</span>
            </div>
        </a>

        <!-- Card 2 -->
        <a href="{{ route('journal.index') }}" class="block bg-[#fdfd96] text-[#2e131c] p-10 marker-double-border wobbly-path transition-all duration-500 flex flex-col gap-6 w-full md:w-[420px] mt-12 animate-wobble-slow scroll-reveal opacity-0" style="transition-delay: 0.3s">
            <div class="absolute top-4 left-4 w-full h-full border-2 border-black/10 -z-10 wobbly-path"></div>
            <div class="flex justify-between items-start">
                <span class="material-symbols-outlined text-5xl" data-icon="edit_note">edit_note</span>
                <span class="material-symbols-outlined text-3xl animate-sway" data-icon="bookmark">bookmark</span>
            </div>
            <h3 class="font-hand-4 text-4xl uppercase tracking-tighter">Daily Journal</h3>
            <p class="font-hand-2 text-xl opacity-90 leading-relaxed">
                Sticky notes for your brain. <span class="line-through decoration-2 decoration-red-500 opacity-60">No formatting</span> Just flow. Doodle if you want. 
            </p>
            <div class="mt-auto pt-8 border-t-4 border-[#2e131c]/30 border-dashed animate-ants">
                <span class="font-hand-4 text-lg uppercase">12 Snatches today &gt;&gt;</span>
            </div>
        </a>

        <!-- Card 3 -->
        <div class="bg-surface-container text-secondary p-10 marker-double-border wobbly-path transition-all duration-500 flex flex-col gap-6 w-full md:w-[360px] animate-wobble-slow scroll-reveal opacity-0" style="transition-delay: 0.5s">
            <div class="flex justify-between items-start">
                <span class="material-symbols-outlined text-6xl opacity-80 animate-sway" data-icon="psychology">psychology</span>
            </div>
            <h3 class="font-hand-4 text-4xl uppercase tracking-tight text-white marker-underline">Book Therapy</h3>
            <p class="font-hand-1 text-xl text-on-surface-variant">Need a real human? Connect with experts who understand the mess in your head.</p>
            <a href="{{ route('booking.index') }}" class="block text-center mt-6 w-full marker-double-border border-secondary bg-transparent py-4 font-hand-4 text-xl uppercase hover:bg-secondary hover:text-on-secondary transition-all wobbly-path btn-draw-hover">
                Find help now &rarr;
            </a>
        </div>
    </section>

    <div class="absolute bottom-10 left-20 pointer-events-none opacity-10 animate-sway">
        <span class="material-symbols-outlined text-[180px] text-primary" data-icon="drawing">draw</span>
    </div>
</main>
@endsection
