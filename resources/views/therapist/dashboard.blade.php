@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-margin py-12 relative min-h-screen">
    <header class="mb-16 text-center">
        <h1 class="font-headline-xl text-5xl text-secondary drop-shadow-[2px_2px_0px_rgba(0,0,0,1)] uppercase -rotate-1 inline-block">
            THERAPIST PORTAL
        </h1>
        <p class="font-label-marker text-primary mt-2 text-xl">Manage your patients and messages.</p>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <!-- Left: Appointments -->
        <section>
            <div class="flex items-center gap-4 mb-6 border-b border-primary/20 pb-4">
                <span class="material-symbols-outlined text-4xl text-primary rotate-12">event</span>
                <h2 class="font-sketch-hand text-3xl text-primary">Your Schedule</h2>
            </div>

            @if($appointments->isEmpty())
                <p class="font-casual-hand text-on-surface-variant text-lg bg-surface-container p-4 border border-primary/20 rounded">
                    No upcoming sessions.
                </p>
            @else
                <div class="space-y-4">
                    @foreach($appointments as $appt)
                        <div class="bg-surface-container-high p-4 border-l-4 border-primary shadow-md flex justify-between items-center">
                            <div>
                                <p class="font-bold text-lg text-primary">{{ \Carbon\Carbon::parse($appt->date)->format('M d, Y') }} at {{ $appt->time }}</p>
                                <p class="text-on-surface-variant text-sm">Patient ID: {{ $appt->user_id }}</p>
                            </div>
                            <span class="px-3 py-1 bg-primary/20 text-primary text-xs rounded-full uppercase tracking-wider">{{ $appt->status }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Right: Messages -->
        <section>
            <div class="flex items-center gap-4 mb-6 border-b border-secondary/20 pb-4">
                <span class="material-symbols-outlined text-4xl text-secondary -rotate-12">forum</span>
                <h2 class="font-sketch-hand text-3xl text-secondary">Patient Messages</h2>
            </div>

            @if($messages->isEmpty())
                <p class="font-casual-hand text-on-surface-variant text-lg bg-surface-container p-4 border border-secondary/20 rounded">
                    Inbox is empty.
                </p>
            @else
                <div class="space-y-6 max-h-[800px] overflow-y-auto pr-2" style="scrollbar-width: thin;">
                    @foreach($messages as $msg)
                        @php
                            $isTherapist = $msg->sender_type === 'therapist';
                            $patient = $patients[$msg->user_id] ?? null;
                            $patientName = $patient ? $patient->name : 'Unknown Patient';
                        @endphp
                        
                        <div class="bg-surface-container-low p-4 rounded border {{ $isTherapist ? 'border-secondary/40 ml-8 bg-secondary/5' : 'border-primary/40 mr-8' }} shadow-sm">
                            <div class="flex justify-between items-start mb-2 border-b border-white/5 pb-2">
                                <span class="font-bold text-sm {{ $isTherapist ? 'text-secondary' : 'text-primary' }}">
                                    {{ $isTherapist ? 'You (Reply)' : $patientName }}
                                </span>
                                <span class="text-xs opacity-50">{{ $msg->created_at->format('M d, g:i A') }}</span>
                            </div>
                            <p class="font-casual-hand text-on-surface-variant whitespace-pre-wrap">{{ $msg->body }}</p>

                            @if(!$isTherapist)
                                <div class="mt-4 border-t border-white/5 pt-2">
                                    <button onclick="document.getElementById('reply-form-{{ $msg->id }}').classList.toggle('hidden')" class="text-xs text-secondary underline hover:text-primary">
                                        Reply to Patient
                                    </button>
                                    
                                    <form id="reply-form-{{ $msg->id }}" method="POST" action="{{ route('therapist.reply') }}" class="hidden mt-2 flex flex-col gap-2">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $msg->user_id }}">
                                        <textarea name="body" required class="w-full bg-surface-container border border-secondary/20 rounded p-2 text-sm text-on-surface focus:ring-1 focus:ring-secondary h-20" placeholder="Type your professional reply..."></textarea>
                                        <div class="flex justify-end">
                                            <button type="submit" class="px-4 py-1 bg-secondary text-on-secondary rounded text-xs hover:bg-primary transition-colors">Send Reply</button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

    </div>
</main>
@endsection
