@extends('layouts.app')

@section('styles')
<style>
    .wobbly-border {
        border: 2px solid currentColor;
        border-radius: 2% 5% 4% 3% / 3% 4% 5% 2%;
    }
    .sticky-note {
        box-shadow: 5px 5px 15px rgba(0,0,0,0.3);
        transform-origin: top left;
        transition: transform 0.2s;
    }
    .sticky-note:hover {
        transform: scale(1.05) rotate(-1deg);
        z-index: 10;
    }
    .tape-mark {
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%) rotate(-2deg);
        width: 60px;
        height: 25px;
        background: rgba(255, 255, 255, 0.4);
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    .pin {
        position: absolute;
        top: 10px;
        left: 50%;
        width: 12px;
        height: 12px;
        background: radial-gradient(circle at 30% 30%, #ff6b6b, #c92a2a);
        border-radius: 50%;
        box-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
</style>
@endsection

@section('content')
<main class="max-w-7xl mx-auto px-margin py-12 relative min-h-screen">
    <header class="mb-16 text-center">
        <h1 class="font-headline-xl text-5xl text-primary drop-shadow-[2px_2px_0px_rgba(0,0,0,1)] uppercase -rotate-1 inline-block">
            MY BOARD
        </h1>
        <p class="font-label-marker text-secondary mt-2 text-xl">The sum of all your scribbles...</p>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        
        <!-- Left Column: Journals (Sticky Notes) -->
        <section class="lg:col-span-8">
            <div class="flex items-center gap-4 mb-8 border-b border-primary/20 pb-4">
                <span class="material-symbols-outlined text-4xl text-primary rotate-12">sticky_note_2</span>
                <h2 class="font-sketch-hand text-3xl text-primary">Journal Snatches</h2>
            </div>

            @if($journals->isEmpty())
                <p class="font-casual-hand text-on-surface-variant text-xl italic bg-surface-container-low p-6 wobbly-border">
                    No thoughts unspooled here yet. <a href="{{ route('journal.index') }}" class="text-secondary underline">Go write one.</a>
                </p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($journals as $index => $journal)
                        @php
                            $colors = ['bg-[#fdfd96]', 'bg-[#ffcccb]', 'bg-[#d4f0f0]', 'bg-[#e9bac7]'];
                            $color = $colors[$index % count($colors)];
                            $rotation = rand(-4, 4);
                        @endphp
                        <div class="{{ $color }} text-[#2e131c] p-6 relative sticky-note" style="transform: rotate({{ $rotation }}deg);">
                            <div class="{{ rand(0,1) ? 'tape-mark' : 'pin' }}"></div>
                            <div class="absolute top-2 right-4 opacity-40 font-label-marker text-sm">{{ $journal->created_at->format('M d') }}</div>
                            <p class="font-casual-hand text-xl mt-4 leading-relaxed whitespace-pre-wrap">{{ Str::limit($journal->content, 150) }}</p>
                            @if(strlen($journal->content) > 150)
                                <div class="mt-4 text-right">
                                    <span class="font-marker-hand text-sm opacity-60">...more</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Right Column: Moods & Appointments -->
        <section class="lg:col-span-4 flex flex-col gap-12">
            
            <!-- Appointments -->
            <div>
                <div class="flex items-center gap-4 mb-6 border-b border-secondary/20 pb-4">
                    <span class="material-symbols-outlined text-4xl text-secondary -rotate-12">calendar_month</span>
                    <h2 class="font-sketch-hand text-3xl text-secondary">Upcoming Talks</h2>
                </div>

                @if($appointments->isEmpty())
                    <p class="font-casual-hand text-on-surface-variant text-lg bg-surface-container p-4 wobbly-border">
                        No sessions booked. <a href="{{ route('booking.index') }}" class="text-primary underline">Find a human.</a>
                    </p>
                @else
                    <div class="space-y-6">
                        @foreach($appointments as $appt)
                            @php
                                $t = $therapists[$appt->therapist_id] ?? ['name' => 'Unknown', 'icon' => 'face', 'color' => 'bg-surface-container-high'];
                            @endphp
                            <div class="bg-surface-container-high p-5 relative wobbly-border shadow-lg flex flex-col gap-4 rotate-1">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 {{ $t['color'] }} flex items-center justify-center rounded-full text-surface">
                                        <span class="material-symbols-outlined">{{ $t['icon'] }}</span>
                                    </div>
                                    <div class="flex-grow">
                                        <p class="font-marker-hand text-primary text-xl">{{ $t['name'] }}</p>
                                        <p class="font-label-marker text-on-surface-variant">
                                            {{ \Carbon\Carbon::parse($appt->date)->format('M d') }} @ {{ $appt->time }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-end gap-3 mt-2 border-t border-white/5 pt-3">
                                    <button onclick="document.getElementById('message-form-{{ $appt->id }}').classList.toggle('hidden')" class="font-body-sm text-sm px-3 py-1 bg-primary text-on-primary rounded hover:bg-secondary transition-colors flex items-center gap-1 shadow-md">
                                        <span class="material-symbols-outlined text-sm">mail</span> Contact
                                    </button>
                                    <form method="POST" action="{{ route('appointments.destroy', $appt->id) }}" class="inline m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-body-sm text-sm px-3 py-1 bg-red-500/20 text-red-400 border border-red-500/50 rounded hover:bg-red-500 hover:text-white transition-colors flex items-center gap-1 shadow-md" onclick="return confirm('Are you sure you want to cancel this session? You will be refunded 1 credit.')">
                                            <span class="material-symbols-outlined text-sm">cancel</span> Cancel
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Hidden Message Form -->
                                <form id="message-form-{{ $appt->id }}" method="POST" action="{{ route('messages.store') }}" class="hidden flex flex-col gap-2 mt-2 bg-surface-container-low p-3 rounded border border-primary/20">
                                    @csrf
                                    <input type="hidden" name="therapist_id" value="{{ $appt->therapist_id }}">
                                    <label class="font-label-marker text-sm text-primary">Message {{ $t['name'] }}</label>
                                    <textarea name="body" required class="w-full bg-surface-container border border-primary/10 rounded p-2 text-sm text-on-surface focus:ring-1 focus:ring-primary h-20 placeholder:opacity-40" placeholder="Type your message here..."></textarea>
                                    <div class="flex justify-end">
                                        <button type="submit" class="font-body-sm text-xs px-3 py-1 bg-secondary text-on-secondary rounded hover:scale-105 transition-transform flex items-center gap-1 shadow-md">
                                            <span class="material-symbols-outlined text-xs">send</span> Send
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Messages Inbox -->
            <div>
                <div class="flex items-center gap-4 mb-6 border-b border-primary/20 pb-4">
                    <span class="material-symbols-outlined text-4xl text-primary rotate-6">inbox</span>
                    <h2 class="font-sketch-hand text-3xl text-primary">Messages</h2>
                </div>

                @if($messages->isEmpty())
                    <p class="font-casual-hand text-on-surface-variant text-lg bg-surface-container p-4 wobbly-border">
                        No messages yet. Contact a therapist from your upcoming talks.
                    </p>
                @else
                    <div class="space-y-4 max-h-96 overflow-y-auto pr-2" style="scrollbar-width: thin;">
                        @foreach($messages as $msg)
                            @php
                                $isUser = $msg->sender_type === 'user';
                                $t = $therapists[$msg->therapist_id] ?? ['name' => 'Unknown Therapist'];
                            @endphp
                            <div class="bg-surface-container-low p-4 rounded-lg border {{ $isUser ? 'border-secondary/20 ml-8' : 'border-primary/40 mr-8 bg-primary/5' }} relative shadow-sm">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="font-label-marker text-sm {{ $isUser ? 'text-secondary' : 'text-primary' }}">
                                        {{ $isUser ? 'You' : $t['name'] }}
                                    </span>
                                    <span class="font-body-sm text-xs opacity-50">{{ $msg->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="font-casual-hand text-on-surface-variant whitespace-pre-wrap">{{ $msg->body }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Mood Tracker Timeline -->
            <div>
                <div class="flex items-center gap-4 mb-6 border-b border-primary/20 pb-4">
                    <span class="material-symbols-outlined text-4xl text-primary rotate-6">timeline</span>
                    <h2 class="font-sketch-hand text-3xl text-primary">Mood Vibe</h2>
                </div>

                @if($moods->isEmpty())
                    <p class="font-casual-hand text-on-surface-variant text-lg bg-surface-container p-4 wobbly-border">
                        No moods logged. <a href="{{ route('mood.index') }}" class="text-primary underline">Log today's vibe.</a>
                    </p>
                @else
                    <div class="bg-surface-container-low p-6 wobbly-border flex flex-col gap-4">
                        @foreach($moods as $mood)
                            <div class="flex items-center gap-4 border-b border-white/5 pb-2 last:border-0">
                                <div class="font-label-marker text-sm text-on-surface-variant w-16">
                                    {{ $mood->created_at->format('M d') }}
                                </div>
                                
                                @if($mood->mood_type === 'good')
                                    <div class="text-[#fdfd96]"><span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">sentiment_very_satisfied</span></div>
                                @elseif($mood->mood_type === 'okay')
                                    <div class="text-[#aacaea]"><span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">sentiment_neutral</span></div>
                                @else
                                    <div class="text-[#f2c2cf]"><span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">sentiment_very_dissatisfied</span></div>
                                @endif
                                
                                <div class="flex-grow">
                                    <div class="h-2 w-full bg-surface-container rounded-full overflow-hidden">
                                        @if($mood->mood_type === 'good')
                                            <div class="h-full bg-[#fdfd96] w-full"></div>
                                        @elseif($mood->mood_type === 'okay')
                                            <div class="h-full bg-[#aacaea] w-2/3"></div>
                                        @else
                                            <div class="h-full bg-[#f2c2cf] w-1/3"></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </section>
    </div>
</main>
@endsection
