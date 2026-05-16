@extends('layouts.app')

@section('content')
<main class="max-w-4xl mx-auto px-margin py-20 relative">
    <div class="text-center mb-12 -rotate-1">
        <h1 class="font-headline-xl text-5xl text-primary drop-shadow-[2px_2px_0px_rgba(0,0,0,1)] uppercase">
            THERAPY ACCESS
        </h1>
        <p class="font-label-marker text-secondary mt-4 text-xl">Unlock the whiteboard and talk to our experts.</p>
    </div>

    <div class="bg-surface-container-low p-10 rotate-1 border-4 border-dashed border-primary/30 relative">
        <div class="absolute -top-6 -left-6 text-primary wobbly-circle p-4 border-[4px] bg-background rotate-12 shadow-lg">
            <span class="material-symbols-outlined text-4xl">star</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="font-sketch-hand text-4xl text-primary mb-6">Monthly Plan</h2>
                <ul class="space-y-4 font-casual-hand text-xl text-on-surface-variant">
                    <li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span> 4 Live Sessions per month</li>
                    <li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span> Access to all therapists</li>
                    <li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span> Unlimited Mood Logging</li>
                    <li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span> 24/7 Dr. MindBoard Chat</li>
                </ul>
            </div>
            
            <div class="bg-surface-container-high p-8 text-center -rotate-2 shadow-2xl border-2 border-white/10 flex flex-col items-center">
                <p class="font-label-marker text-2xl text-on-surface mb-2">Only</p>
                <p class="font-headline-xl text-6xl text-secondary mb-8">$199<span class="text-2xl">/mo</span></p>
                
                @if($subscription && $subscription->sessions_remaining > 0 && $subscription->expires_at > now())
                    <p class="font-casual-hand text-xl text-primary bg-primary/20 p-4 w-full rotate-1">You currently have an active plan with {{ $subscription->sessions_remaining }} sessions remaining!</p>
                @else
                    <form action="{{ route('subscription.store') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full font-hand-2 text-2xl uppercase tracking-wider bg-primary text-on-primary px-8 py-4 border-4 border-black shadow-[5px_5px_0px_0px_rgba(255,255,255,0.2)] hover:scale-105 transition-all wobbly-path btn-draw-hover">
                            BUY NOW
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
