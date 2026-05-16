@extends('layouts.app')

@section('styles')
<style>
    .wobbly-border {
      border: 4px solid white;
      border-radius: 255px 15px 225px 15px/15px 225px 15px 255px;
    }
    .double-wobbly-border {
      box-shadow: 0 0 0 4px #141313, 0 0 0 8px white;
      border: 4px solid white;
      border-radius: 2% 98% 3% 97% / 97% 5% 95% 3%;
    }
    .marker-underline-journal {
      background-image: linear-gradient(to right, white 0%, white 100%);
      background-repeat: repeat-x;
      background-size: 100% 4px;
      background-position: 0 100%;
    }
    .lined-paper {
      background-image: linear-gradient(#486784 1px, transparent 1px);
      background-size: 100% 2rem;
    }
    .marker-bleed::after {
      content: '';
      position: absolute;
      width: 12px;
      height: 12px;
      background: white;
      border-radius: 50%;
      filter: blur(2px);
      bottom: -6px;
      right: -6px;
    }
    .rotate-tilt-min { transform: rotate(-3deg); }
    .rotate-tilt-max { transform: rotate(4deg); }
    .rotate-slight { transform: rotate(1.5deg); }
</style>
@endsection

@section('content')
<main class="flex-grow flex flex-col items-center justify-center p-margin relative">
    <!-- Header Area -->
    <header class="text-center mb-12 rotate-slight relative z-10">
        <h1 class="font-headline-xl text-headline-xl text-primary drop-shadow-[4px_4px_0px_rgba(0,0,0,1)] uppercase">
            SCRIVENER'S CORNER
        </h1>
        <div class="relative inline-block mt-2">
            <p class="font-label-marker text-secondary text-lg">
                <span class="line-through decoration-primary decoration-2 opacity-50">Thouts</span> <span class="absolute -top-4 left-0 text-primary rotate-tilt-min">Thoughts</span> 
                unfurl here...
            </p>
        </div>
    </header>

    <!-- Main Journal Canvas -->
    <section class="w-full max-w-4xl relative">
        <!-- Paper Shadow/Stacking Effect -->
        <div class="absolute inset-0 bg-surface-container-highest -rotate-2 rounded-xl translate-x-4 translate-y-4 opacity-50"></div>
        
        <!-- The Journal Entry Area -->
        <form method="POST" action="{{ route('journal.store') }}">
            @csrf
            <div class="relative bg-tertiary-fixed text-on-tertiary p-12 min-h-[70vh] shadow-2xl rotate-tilt-max double-wobbly-border marker-bleed overflow-hidden">
                <!-- Instruction Label -->
                <div class="flex items-center gap-4 mb-8 font-label-marker text-2xl text-on-tertiary-fixed-variant">
                    <span class="rotate-tilt-min">Write here &rarr;</span>
                    <div class="flex-grow h-[3px] bg-on-tertiary-fixed-variant/30 rotate-slight"></div>
                </div>

                <!-- Lined Journal Body -->
                <div class="lined-paper relative z-10">
                    <textarea name="content" class="w-full bg-transparent border-none focus:ring-0 font-body-lg text-on-tertiary-fixed leading-[2rem] resize-none h-[50vh] p-0 overflow-hidden placeholder-on-tertiary-container/30" placeholder="Today I feel like..." required>{{ old('content') }}</textarea>
                    
                    @error('content')
                        <span class="text-error font-label-marker block mt-2">{{ $message }}</span>
                    @enderror

                    <!-- Underlined Effect Layer -->
                    <div class="absolute inset-0 pointer-events-none flex flex-col pt-[2rem]">
                        @for($i=0; $i<12; $i++)
                            <div class="h-[2rem] border-b-2 border-on-tertiary-fixed-variant/20 mx-1"></div>
                        @endfor
                    </div>
                </div>

                <!-- Sleepy Cloud Doodle -->
                <div class="absolute bottom-6 right-8 opacity-70 group cursor-pointer hover:scale-110 transition-transform">
                    <div class="relative">
                        <span class="material-symbols-outlined text-6xl text-on-tertiary-container/60" data-icon="cloudy_snowing" style="font-variation-settings: 'FILL' 0;">cloudy_snowing</span>
                        <div class="absolute -top-4 -right-2 font-label-marker text-xl text-on-tertiary-container/40">Zzz</div>
                    </div>
                </div>

                <!-- Marker Bleed Accent -->
                <div class="absolute top-0 left-0 w-8 h-8 bg-on-tertiary-fixed-variant/10 blur-xl"></div>
            </div>

            <!-- Controls -->
            <div class="mt-12 flex justify-center gap-6 relative z-20">
                <button type="reset" class="px-8 py-3 bg-secondary text-on-secondary-fixed font-label-marker uppercase tracking-widest -rotate-2 wobbly-border hover:rotate-tilt-max active:scale-95 transition-all">
                    Discard Mess
                </button>
                <button type="submit" class="px-10 py-4 bg-primary text-on-primary font-headline-md uppercase tracking-tighter rotate-2 double-wobbly-border hover:-rotate-tilt-max active:scale-95 transition-all">
                    Seal Entry
                </button>
            </div>
        </form>
    </section>

    <!-- Past Entries Display -->
    @if(isset($entries) && $entries->count() > 0)
    <section class="w-full max-w-4xl mt-20">
        <h2 class="font-headline-md text-3xl text-primary mb-8 border-b-2 border-dashed border-primary/20 pb-4 inline-block -rotate-1">PAST SNATCHES</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($entries as $entry)
            <div class="bg-[#fdfd96] text-[#2e131c] p-6 shadow-xl relative wobbly-border rotate-slight hover:rotate-0 transition-transform">
                <div class="absolute top-2 right-2 opacity-30 text-sm font-label-marker">{{ $entry->created_at->format('M d, Y') }}</div>
                <p class="font-casual-hand text-lg mt-4 whitespace-pre-wrap">{{ $entry->content }}</p>
                <!-- Marker Bleed Accent -->
                <div class="absolute bottom-2 left-2 w-4 h-4 bg-black/10 blur-sm rounded-full"></div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Decorative Board Elements -->
    <div class="fixed top-1/4 left-10 opacity-20 rotate-tilt-min hidden lg:block">
        <span class="material-symbols-outlined text-9xl text-primary" data-icon="edit">edit</span>
    </div>
    <div class="fixed bottom-20 right-10 opacity-20 rotate-tilt-max hidden lg:block">
        <span class="material-symbols-outlined text-9xl text-primary" data-icon="auto_awesome">auto_awesome</span>
    </div>
</main>
@endsection
