@extends('layouts.app')

@section('styles')
<style>
    .marker-border-double {
        border: 12px double rgba(255, 255, 255, 0.4);
        border-radius: 4px;
    }
    .wobbly-grid {
        mask-image: radial-gradient(circle, black 70%, transparent 100%);
    }
    .rotate-tilt-min { transform: rotate(-3deg); }
    .rotate-tilt-max { transform: rotate(3deg); }
    .rotate-tilt-slight { transform: rotate(1.5deg); }
    
    /* Messy Rotations */
    .rotate-1deg { transform: rotate(1deg); }
    .rotate-neg-2deg { transform: rotate(-2.4deg); }
    .rotate-3deg { transform: rotate(3.2deg); }
    .rotate-neg-1deg { transform: rotate(-1.5deg); }
    .rotate-4deg { transform: rotate(4deg); }

    .marker-circle {
        border: 6px solid #e9bac7;
        border-radius: 100% 90% 110% 80% / 95% 105% 85% 115%;
    }
    .scribble-underline {
        text-decoration: underline;
        text-underline-offset: 8px;
        text-decoration-thickness: 3px;
    }
    .marker-bleed {
        box-shadow: 4px 4px 0px 0px rgba(0, 0, 0, 0.5);
    }

    /* Ghosting/Smudge Effects */
    .ghost-smudge {
        position: absolute;
        background: rgba(255, 255, 255, 0.03);
        filter: blur(20px);
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
    }
    .erased-text {
        position: absolute;
        opacity: 0.05;
        font-family: 'Permanent Marker', cursive;
        pointer-events: none;
        transform: rotate(-15deg);
    }

    /* Hand-sketched wobbly lines */
    .sketch-line-h {
        height: 3px;
        background: rgba(255, 255, 255, 0.15);
        width: 100%;
        border-radius: 100% 80% 90% 110% / 50%;
        transform: scaleY(0.8) rotate(0.2deg);
    }
    .sketch-line-v {
        width: 3px;
        background: rgba(255, 255, 255, 0.15);
        height: 100%;
        border-radius: 80% 100% 110% 90% / 50%;
        transform: scaleX(0.8) rotate(-0.5deg);
    }
</style>
@endsection

@section('content')
<!-- Board Smudges/Ghosting -->
<div class="ghost-smudge w-64 h-64 top-20 left-10"></div>
<div class="ghost-smudge w-96 h-40 bottom-40 right-20 bg-secondary/5"></div>
<div class="erased-text text-64px top-1/4 left-1/3">DELETE ME</div>
<div class="erased-text text-32px bottom-1/3 right-1/4 rotate-12">NOT GOOD ENOUGH</div>

<main class="max-w-7xl mx-auto px-margin py-gutter relative">
    <!-- Header Section -->
    <header class="mb-gutter text-center py-12">
        <h1 class="font-marker-hand text-6xl text-primary rotate-neg-2deg mb-4 drop-shadow-[2px_2px_0px_rgba(0,0,0,1)]">FIND A HUMAN TO TALK TO</h1>
        <p class="font-body-lg text-on-surface-variant max-w-2xl mx-auto rotate-tilt-slight">No bots. No cold scripts. Just messy, real human conversations to help clear the board in your head.</p>
    </header>

    <!-- Main Workspace Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        
        <!-- Calendar Section (Left Side) -->
        <section class="lg:col-span-7 bg-surface-container border-marker-stroke border-primary/10 p-8 rotate-neg-1deg marker-bleed relative">
            <div class="flex justify-between items-center mb-8 px-4">
                <h2 class="font-sketch-hand text-4xl text-primary rotate-1deg">{{ strtoupper($requestedDate->format('F Y')) }}</h2>
                <div class="flex gap-4">
                    @if($requestedDate->startOfMonth() > $currentDate->startOfMonth())
                        <a href="{{ route('booking.index', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}" class="material-symbols-outlined cursor-pointer hover:scale-125 transition-transform" data-icon="arrow_back_ios">arrow_back_ios</a>
                    @else
                        <span class="material-symbols-outlined opacity-30 cursor-not-allowed" data-icon="arrow_back_ios">arrow_back_ios</span>
                    @endif
                    <a href="{{ route('booking.index', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}" class="material-symbols-outlined cursor-pointer hover:scale-125 transition-transform" data-icon="arrow_forward_ios">arrow_forward_ios</a>
                </div>
            </div>

            <!-- Wobbly Hand-Sketched Calendar Grid -->
            <div class="relative p-2" id="calendar-container">
                <!-- Vertical Sketch Lines -->
                <div class="absolute inset-0 flex justify-between px-2 pointer-events-none opacity-40 z-0">
                    <div class="sketch-line-v h-full -rotate-1"></div>
                    <div class="sketch-line-v h-full rotate-1"></div>
                    <div class="sketch-line-v h-full -rotate-2"></div>
                    <div class="sketch-line-v h-full rotate-2"></div>
                    <div class="sketch-line-v h-full -rotate-1"></div>
                    <div class="sketch-line-v h-full rotate-1"></div>
                </div>

                <div class="grid grid-cols-7 text-center relative z-10">
                    <div class="font-label-marker text-on-surface-variant py-4">MON</div>
                    <div class="font-label-marker text-on-surface-variant py-4">TUE</div>
                    <div class="font-label-marker text-on-surface-variant py-4">WED</div>
                    <div class="font-label-marker text-on-surface-variant py-4">THU</div>
                    <div class="font-label-marker text-on-surface-variant py-4">FRI</div>
                    <div class="font-label-marker text-on-surface-variant py-4">SAT</div>
                    <div class="font-label-marker text-on-surface-variant py-4">SUN</div>

                    <!-- Date Rows -->
                    @php
                        $startOfMonth = $requestedDate->copy()->startOfMonth();
                        $endOfMonth = $requestedDate->copy()->endOfMonth();
                        
                        // Carbon dayOfWeek returns 0 (Sunday) to 6 (Saturday). We want 1 (Monday) to 7 (Sunday).
                        $startDayOfWeek = $startOfMonth->dayOfWeekIso; 
                        
                        // Calculate days from previous month to pad the first row
                        $daysToPad = $startDayOfWeek - 1;
                        $daysInPrevMonth = $prevMonth->daysInMonth;
                    @endphp

                    <div class="col-span-7 sketch-line-h my-2 opacity-30"></div>
                    
                    {{-- Padding previous month days --}}
                    @for($i = $daysToPad - 1; $i >= 0; $i--)
                        <div class="aspect-square flex items-center justify-center font-label-marker opacity-20">
                            {{ $daysInPrevMonth - $i }}
                        </div>
                    @endfor

                    {{-- Current month days --}}
                    @for($day = 1; $day <= $endOfMonth->day; $day++)
                        @php
                            $currentLoopDate = $requestedDate->copy()->setDay($day);
                            $isPast = $currentLoopDate->startOfDay() < now()->startOfDay();
                            $formattedDate = $currentLoopDate->format('Y-m-d');
                        @endphp
                        
                        @if($isPast)
                            <div class="aspect-square flex items-center justify-center font-sketch-hand text-primary/30 text-2xl relative cursor-not-allowed day-cell">
                                <span class="z-10 line-through">{{ $day }}</span>
                            </div>
                        @else
                            <div class="aspect-square flex items-center justify-center font-sketch-hand text-primary text-2xl relative cursor-pointer hover:scale-110 transition-transform day-cell" 
                                 onclick="selectDate('{{ $formattedDate }}', this)">
                                <span class="z-10">{{ $day }}</span>
                            </div>
                        @endif
                        
                        {{-- Add wobbly horizontal dividers every 7 cells (end of week) --}}
                        @if(($day + $daysToPad) % 7 == 0 && $day != $endOfMonth->day)
                            @php $rot = rand(-2, 2); @endphp
                            <div class="col-span-7 sketch-line-h my-2 opacity-30" style="transform: rotate({{ $rot }}deg);"></div>
                        @endif
                    @endfor

                    {{-- Dynamic Selection Circles (hidden initially) --}}
                    <div id="selection-ring" class="absolute pointer-events-none transition-all duration-300 opacity-0 z-0 w-12 h-12 flex items-center justify-center">
                        <div class="absolute inset-0 marker-circle border-secondary/60 border-[4px] rotate-tilt-max marker-bleed opacity-80 scale-110 w-full h-full"></div>
                        <div class="absolute inset-[2px] marker-circle border-secondary/40 border-[2px] -rotate-12 opacity-60 w-full h-full"></div>
                    </div>
                </div>
            </div>

            <div class="mt-12 border-t-2 border-dashed border-primary/10 pt-8">
                <h3 class="font-sketch-hand text-xl uppercase tracking-tighter mb-6 text-on-surface-variant italic">Available Times:</h3>
                
                @if($errors->any())
                    <div class="bg-[#f2c2cf] text-[#1a1c1c] p-4 mb-6 rotate-1 font-label-marker text-sm shadow-md border-2 border-black">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <form action="{{ route('booking.store') }}" method="POST" id="booking-form" class="hidden flex-wrap items-start gap-8">
                    @csrf
                    <input type="hidden" name="therapist_id" id="selected_therapist_id" value="">
                    <input type="hidden" name="date" id="selected_date" value="">
                    
                    <div id="dynamic-time-slots" class="flex flex-wrap items-start gap-4 w-full">
                        <!-- Slots injected via JS -->
                    </div>
                </form>

                <div id="selection-prompt" class="font-casual-hand text-lg text-primary opacity-60">
                    <span class="material-symbols-outlined align-middle mr-2">arrow_upward</span> Pick a Human and a Date above!
                </div>
            </div>
        </section>

        <!-- Therapist Selection (Right Side) -->
        <section class="lg:col-span-5 space-y-16">
            <h2 class="font-casual-hand text-5xl text-primary -rotate-2 ml-4">CHOOSE YOUR HUMAN</h2>

            <!-- Data injected from DB -->
            
            @foreach($therapists as $index => $therapist)
            <div class="relative pl-8 pt-4 rotate-1deg">
                <div class="absolute left-[-10px] top-[-10px] w-16 h-16 bg-surface-container-high marker-border-double rotate-neg-2deg flex items-center justify-center z-10 shadow-xl">
                    <span class="material-symbols-outlined text-4xl {{ $therapist['text_color'] }}">{{ $therapist['icon'] }}</span>
                </div>
                <div class="bg-surface-container-low p-8 border-marker-stroke border-secondary/20 marker-bleed ml-4 shadow-2xl cursor-pointer hover:bg-surface-container-high transition therapist-card" onclick="selectTherapist('{{ $therapist['id'] }}', '{{ $therapist['name'] }}', this)">
                    <div class="relative -mt-14 ml-8 mb-6 inline-block {{ $therapist['color'] }} {{ $therapist['text_color'] }} px-5 py-2 border-2 border-on-primary rotate-neg-1deg">
                        <p class="font-marker-hand text-lg">{{ $therapist['name'] }}</p>
                        <div class="absolute -bottom-2 left-4 w-4 h-4 {{ $therapist['color'] }} rotate-45 border-r-2 border-b-2 border-on-primary"></div>
                    </div>
                    <p class="font-casual-hand text-lg text-on-surface-variant mb-4">{!! $therapist['bio'] !!}</p>
                    <button type="button" class="underline text-secondary font-marker-hand flex items-center gap-2 hover:text-primary transition-colors">
                        SELECT <span class="material-symbols-outlined text-sm">star</span>
                    </button>
                </div>
            </div>
            @endforeach
        </section>
    </div>

    <!-- Featured Doodle Grid Section (Bento Style) -->
    <section class="mt-24 grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
        <div class="md:col-span-2 bg-surface-container-high p-10 rotate-neg-1deg marker-bleed border-marker-stroke border-primary/10 shadow-inner">
            <h4 class="font-marker-hand text-3xl text-primary mb-6 italic">WHY THE BOARD?</h4>
            <p class="text-on-surface-variant font-casual-hand text-lg leading-relaxed">Most therapy feels like a clinical exam. We wanted it to feel like a shared canvas. Grab a digital marker and let's map out the chaos together.</p>
        </div>
        <div class="bg-secondary-container p-8 rotate-3deg marker-bleed border-marker-stroke border-secondary/20 flex flex-col items-center justify-center text-center shadow-lg -translate-y-4">
            <span class="material-symbols-outlined text-5xl mb-4" data-icon="history_edu">history_edu</span>
            <p class="font-marker-hand text-2xl text-on-secondary-container">12,403 Sessions Booked</p>
        </div>
        <div class="bg-surface-container-lowest p-8 rotate-neg-2deg marker-bleed border-marker-stroke border-primary/5 flex flex-col items-center justify-center text-center shadow-lg translate-y-4">
            <span class="material-symbols-outlined text-5xl mb-4" data-icon="group">group</span>
            <p class="font-marker-hand text-2xl text-on-surface">Community Support</p>
        </div>
    </section>
</main>

<script>
    let currentTherapistId = '';
    let currentDate = '';

    function selectTherapist(id, name, element) {
        currentTherapistId = id;
        document.getElementById('selected_therapist_id').value = id;
        
        // Visual selection
        document.querySelectorAll('.therapist-card').forEach(el => {
            el.classList.remove('ring-4', 'ring-primary', 'scale-105');
        });
        element.classList.add('ring-4', 'ring-primary', 'scale-105');

        checkAvailability();
    }

    function selectDate(dateString, element) {
        currentDate = dateString;
        document.getElementById('selected_date').value = dateString;
        
        // Get the selection ring
        const ring = document.getElementById('selection-ring');
        
        // Calculate position relative to the calendar container
        const container = document.getElementById('calendar-container');
        const containerRect = container.getBoundingClientRect();
        const elRect = element.getBoundingClientRect();
        
        // Move the ring to exactly overlay the clicked element
        ring.style.left = (elRect.left - containerRect.left) + 'px';
        ring.style.top = (elRect.top - containerRect.top) + 'px';
        ring.style.width = elRect.width + 'px';
        ring.style.height = elRect.height + 'px';
        
        // Make it visible
        ring.style.opacity = '1';
        
        // Remove text-primary from all, add to selected to ensure contrast
        document.querySelectorAll('.day-cell').forEach(el => {
            el.classList.remove('font-bold', 'scale-110');
        });
        element.classList.add('font-bold', 'scale-110');

        checkAvailability();
    }

    async function checkAvailability() {
        if (!currentTherapistId || !currentDate) return;

        const slotsContainer = document.getElementById('dynamic-time-slots');
        const form = document.getElementById('booking-form');
        const prompt = document.getElementById('selection-prompt');

        slotsContainer.innerHTML = '<p class="font-casual-hand text-on-surface-variant">Checking the board...</p>';
        prompt.classList.add('hidden');
        form.classList.remove('hidden');

        try {
            const response = await fetch(`/api/availability/${currentTherapistId}?date=${currentDate}`);
            const slots = await response.json();

            slotsContainer.innerHTML = '';

            if (slots.length === 0) {
                slotsContainer.innerHTML = '<p class="bg-[#f2c2cf] text-[#1a1c1c] p-4 rotate-1 font-label-marker shadow-md border-2 border-black">Fully booked! Pick another day or human.</p>';
                return;
            }

            const colors = ['bg-[#fdfd96]', 'bg-[#aacaea]', 'bg-[#f2c2cf]', 'bg-[#cde5ff]'];

            slots.forEach((time, index) => {
                const color = colors[index % colors.length];
                const rot = (index % 2 === 0) ? randRot() : -randRot();
                
                // Convert 24hr to 12hr for display
                const [h, m] = time.split(':');
                const hour = parseInt(h);
                const ampm = hour >= 12 ? 'PM' : 'AM';
                const displayHour = hour % 12 || 12;
                const displayTime = `${displayHour}:${m} ${ampm}`;

                const btn = document.createElement('button');
                btn.type = 'submit';
                btn.name = 'time';
                btn.value = time;
                btn.className = `${color} text-surface p-5 marker-bleed cursor-pointer hover:scale-105 transition-transform shadow-lg border-2 border-black/10`;
                btn.style.transform = `rotate(${rot}deg)`;
                btn.innerHTML = `
                    <span class="material-symbols-outlined block text-sm mb-1">schedule</span>
                    <p class="font-marker-hand text-xl">${displayTime}</p>
                `;
                slotsContainer.appendChild(btn);
            });
        } catch (e) {
            slotsContainer.innerHTML = '<p class="text-red-500 font-casual-hand">Error loading times.</p>';
        }
    }

    function randRot() {
        return Math.random() * 4 - 2;
    }
</script>
@endsection
