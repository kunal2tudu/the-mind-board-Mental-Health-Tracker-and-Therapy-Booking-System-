@extends('layouts.app')

@section('styles')
<style>
    .marker-border {
        border: 3px solid white;
        box-shadow: 4px 4px 0px 0px rgba(0,0,0,0.5);
    }
    .wobbly-circle {
        border-radius: 48% 52% 50% 50% / 50% 48% 52% 50%;
        border: 4px solid currentColor;
    }
    .wobbly-triangle {
        clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
        border: 4px solid currentColor;
    }
    .squiggle-path {
        border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
    }
    .marker-line {
        background-image: repeating-linear-gradient(90deg, white 0, white 10px, transparent 10px, transparent 20px);
    }
    .tilt-card-cw { transform: rotate(2deg); }
    .tilt-card-ccw { transform: rotate(-2.5deg); }
    .double-stroke-box {
        border: 4px double white;
        padding: 8px;
    }
    .wobbly-border {
        border-radius: 255px 15px 225px 15px/15px 225px 15px 255px;
        border: 3px solid white;
    }
    .wobbly-container {
        border: 5px double rgba(255,255,255,0.3);
        border-radius: 40px 10px 40px 10px / 10px 40px 10px 40px;
    }
    .whiteboard-bg {
        background-color: #141313;
        background-image: 
            radial-gradient(circle at 50% 50%, rgba(255,255,255,0.03) 1px, transparent 1px),
            radial-gradient(circle at 20% 30%, rgba(255,255,255,0.02) 40px, transparent 100px),
            radial-gradient(circle at 80% 70%, rgba(255,255,255,0.02) 60px, transparent 120px);
        background-size: 40px 40px, 800px 800px, 1000px 1000px;
    }
    .ghost-mark {
        position: absolute;
        opacity: 0.05;
        pointer-events: none;
        filter: blur(1px);
    }
</style>
@endsection

@section('content')
<!-- Ghost Marks Background Layer -->
<div class="ghost-mark top-40 left-10 text-8xl rotate-12 select-none">?</div>
<div class="ghost-mark bottom-20 right-10 text-9xl -rotate-6 select-none">☺</div>
<div class="ghost-mark top-1/2 left-1/4 text-6xl -rotate-45 select-none font-bold">X</div>

<main class="max-w-6xl mx-auto px-margin py-12 relative">
    <!-- Title Section -->
    <section class="mb-20 text-center -rotate-1">
        <h1 class="font-headline-xl text-headline-xl text-primary mb-2">HOW ARE WE FEELING?</h1>
        <div class="h-1 w-64 mx-auto bg-primary opacity-30 mt-2 rotate-1"></div>
    </section>

    <!-- Main Layout Cluster -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-start">
        
        <!-- Daily Check-in Section -->
        <div class="md:col-span-12 flex flex-col items-center mb-16">
            <form action="{{ route('mood.store') }}" method="POST" class="flex flex-wrap justify-center gap-12 md:gap-24 items-end">
                @csrf
                <!-- Good Day - Staggered high and tilted CW -->
                <button type="submit" name="mood_type" value="good" class="group flex flex-col items-center gap-4 transition-transform hover:scale-110 active:scale-95 -translate-y-8 rotate-3 bg-transparent border-none cursor-pointer">
                    <div class="w-32 h-32 flex items-center justify-center text-[#fdfd96] wobbly-circle border-[6px] group-hover:rotate-tilt-max transition-transform">
                        <span class="material-symbols-outlined text-5xl" style="font-variation-settings: 'FILL' 1;">sentiment_very_satisfied</span>
                    </div>
                    <span class="font-label-marker text-xl uppercase tracking-wider text-[#fdfd96]">Good day</span>
                </button>

                <!-- Okay Day - Staggered low and tilted CCW -->
                <button type="submit" name="mood_type" value="okay" class="group flex flex-col items-center gap-4 transition-transform hover:scale-110 active:scale-95 translate-y-4 -rotate-2 bg-transparent border-none cursor-pointer">
                    <div class="w-32 h-32 flex items-center justify-center text-[#aacaea] squiggle-path border-[6px] border-solid group-hover:rotate-tilt-min transition-transform">
                        <span class="material-symbols-outlined text-5xl" style="font-variation-settings: 'FILL' 1;">sentiment_neutral</span>
                    </div>
                    <span class="font-label-marker text-xl uppercase tracking-wider text-[#aacaea]">Okay day</span>
                </button>

                <!-- Hard Day - Staggered middle and heavy tilt -->
                <button type="submit" name="mood_type" value="hard" class="group flex flex-col items-center gap-4 transition-transform hover:scale-110 active:scale-95 -translate-y-2 rotate-6 bg-transparent border-none cursor-pointer">
                    <div class="w-32 h-32 flex items-center justify-center text-[#f2c2cf] group-hover:rotate-tilt-max transition-transform" style="border: 6px solid currentColor; border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;">
                        <span class="material-symbols-outlined text-5xl" style="font-variation-settings: 'FILL' 1;">sentiment_very_dissatisfied</span>
                    </div>
                    <span class="font-label-marker text-xl uppercase tracking-wider text-[#f2c2cf]">Hard day</span>
                </button>
            </form>
        </div>

        <!-- Graph Section -->
        <div class="md:col-span-8 rotate-1">
            <div class="wobbly-container bg-surface-container-low min-h-[440px] relative p-10">
                <h3 class="font-headline-md text-primary mb-12 border-b-2 border-dashed border-primary/20 pb-2 -rotate-1 inline-block">MOOD TRENDS</h3>
                
                <div class="relative w-full h-64 mt-8">
                    @if($moods->isEmpty())
                        <div class="flex items-center justify-center h-full opacity-50 font-casual-hand text-xl">
                            No scribbles yet. Log a mood!
                        </div>
                    @else
                        @php
                            $points = [];
                            $n = count($moods);
                            $width = 800;
                            $height = 200;
                            
                            foreach ($moods as $i => $mood) {
                                // Calculate X
                                $x = $n > 1 ? 50 + ($i * (700 / ($n - 1))) : 400;
                                
                                // Calculate Y based on mood
                                if ($mood->mood_type === 'good') {
                                    $y = 50 + rand(-10, 10);
                                    $color = '#fdfd96';
                                    $icon = 'sentiment_very_satisfied';
                                } elseif ($mood->mood_type === 'okay') {
                                    $y = 100 + rand(-10, 10);
                                    $color = '#aacaea';
                                    $icon = 'sentiment_neutral';
                                } else {
                                    $y = 150 + rand(-10, 10);
                                    $color = '#f2c2cf';
                                    $icon = 'sentiment_very_dissatisfied';
                                }
                                
                                $points[] = [
                                    'x' => $x, 
                                    'y' => $y, 
                                    'color' => $color, 
                                    'icon' => $icon, 
                                    'date' => $mood->created_at->format('M d'),
                                    'full_time' => $mood->created_at->format('M d, g:i A')
                                ];
                            }
                            
                            // Generate SVG Path
                            $pathD = "";
                            if ($n == 1) {
                                $pathD = "M{$points[0]['x']},{$points[0]['y']}";
                            } else {
                                $pathD = "M{$points[0]['x']},{$points[0]['y']} ";
                                for ($i = 1; $i < $n; $i++) {
                                    $prevX = $points[$i-1]['x'];
                                    $prevY = $points[$i-1]['y'];
                                    $currX = $points[$i]['x'];
                                    $currY = $points[$i]['y'];
                                    
                                    // Control points for a curved path
                                    $cp1X = $prevX + ($currX - $prevX) * 0.5;
                                    $cp2X = $prevX + ($currX - $prevX) * 0.5;
                                    $pathD .= "C{$cp1X},{$prevY} {$cp2X},{$currY} {$currX},{$currY} ";
                                }
                            }
                        @endphp

                        <!-- Hand-drawn SVG Graph -->
                        <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 800 200">
                            <!-- Uneven path -->
                            <path d="{{ $pathD }}" fill="none" stroke="white" stroke-dasharray="12,8" stroke-linecap="round" stroke-width="4"></path>
                            
                            <!-- Data Points -->
                            @foreach($points as $point)
                                <circle class="opacity-80 cursor-pointer hover:opacity-100 hover:r-12 transition-all" cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" fill="{{ $point['color'] }}" r="10">
                                    <title>{{ $point['full_time'] }}</title>
                                </circle>
                            @endforeach
                        </svg>

                        <!-- Face Overlay labels -->
                        @foreach($points as $point)
                            <div class="absolute cursor-pointer group" style="top: {{ ($point['y'] / 200 * 100) - 20 }}%; left: {{ ($point['x'] / 800 * 100) - 2 }}%; transform: rotate({{ rand(-15, 15) }}deg);">
                                <span class="material-symbols-outlined text-2xl" style="color: {{ $point['color'] }};" title="{{ $point['full_time'] }}">{{ $point['icon'] }}</span>
                                
                                <!-- Custom Tooltip -->
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max px-3 py-1 bg-surface-container-highest text-on-surface font-label-marker text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-50 border border-primary/20 shadow-xl">
                                    {{ $point['full_time'] }}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Graph Axes (Dates) -->
                <div class="flex justify-between mt-8 font-label-marker text-on-surface-variant/60 px-2 italic">
                    @if(!$moods->isEmpty())
                        @foreach($points as $point)
                            <span style="transform: rotate({{ rand(-4, 4) }}deg);">{{ strtoupper($point['date']) }}</span>
                        @endforeach
                    @else
                        <span>MON</span><span>TUE</span><span>WED</span><span>THU</span><span>FRI</span><span>SAT</span><span>SUN</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Side Bento/Note -->
        <div class="md:col-span-4 flex flex-col space-y-12">
            <!-- Sticky Note 1 - Heavy tilt CCW and moved up -->
            <div class="bg-[#fdfd96] text-[#1a1c1c] p-6 -rotate-[4deg] shadow-2xl relative min-h-[200px] -mt-6 ml-4 flex flex-col">
                <div class="absolute top-0 right-0 w-10 h-10 bg-black/10" style="clip-path: polygon(0 0, 100% 100%, 0 100%);"></div>
                <p class="font-headline-md mb-4 uppercase tracking-tighter">Mind Health Tip</p>
                <p class="font-body-sm italic leading-relaxed">"{{ $dailyTip }}"</p>
                <div class="mt-auto border-t border-black/10 pt-3 flex justify-end">
                    <span class="material-symbols-outlined scale-125">health_and_safety</span>
                </div>
            </div>

            <!-- Margin Text - Asymmetric placement -->
            <div class="p-6 border-2 border-dashed border-primary/30 rotate-[3deg] text-center w-3/4 self-end">
                <p class="font-label-marker text-primary tracking-widest text-sm">DON'T FORGET TO BREATHE</p>
                <div class="flex justify-center gap-2 mt-2">
                    <span class="material-symbols-outlined text-primary text-xs">star</span>
                    <span class="material-symbols-outlined text-primary text-xs">star</span>
                </div>
            </div>

            <!-- Quick Action Card - Rotated CW and misaligned -->
            <div class="bg-surface-container-highest border-marker-stroke p-8 rotate-[2.5deg] border-2 border-white/10 shadow-lg -ml-2 flex flex-col h-[300px]">
                <h4 class="font-label-marker text-on-surface-variant uppercase mb-4 tracking-widest border-b border-primary/10 inline-block">Therapy Chat</h4>
                
                <div class="flex-grow space-y-3 overflow-y-auto pr-2 mb-4" id="chat-messages" style="scrollbar-width: none;">
                    <div class="bg-white/5 p-4 rounded-lg border border-primary/10 -rotate-1">
                        <p class="text-sm opacity-80 italic text-primary">Dr. MindBoard: How are you feeling today? I'm here to listen.</p>
                    </div>
                </div>

                <form id="chat-form" class="flex items-center gap-3 bg-black/20 p-2 rounded border border-white/5 mt-auto">
                    @csrf
                    <input id="chat-input" class="bg-transparent border-none w-full focus:ring-0 text-sm placeholder:opacity-40" placeholder="Type a message..." type="text" required/>
                    <button type="submit" class="material-symbols-outlined text-primary/60 hover:text-primary transition-colors bg-transparent border-none">send</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    document.getElementById('chat-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const input = document.getElementById('chat-input');
        const message = input.value.trim();
        if (!message) return;
        
        const chatMessages = document.getElementById('chat-messages');
        
        // Append user message
        const userDiv = document.createElement('div');
        userDiv.className = 'bg-primary/20 p-4 rounded-lg border border-primary/30 rotate-1 text-right ml-4';
        userDiv.innerHTML = `<p class="text-sm italic">${message}</p>`;
        chatMessages.appendChild(userDiv);
        
        input.value = '';
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // Append loading indicator
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'bg-white/5 p-4 rounded-lg border border-primary/10 -rotate-1 mr-4';
        loadingDiv.id = 'loading-indicator';
        loadingDiv.innerHTML = `<p class="text-sm opacity-50 italic text-primary">Dr. MindBoard is typing...</p>`;
        chatMessages.appendChild(loadingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;

        try {
            const response = await fetch('{{ route("chat.ask") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            
            // Remove loading
            document.getElementById('loading-indicator').remove();
            
            // Append AI response
            const aiDiv = document.createElement('div');
            aiDiv.className = 'bg-white/5 p-4 rounded-lg border border-primary/10 -rotate-1 mr-4';
            aiDiv.innerHTML = `<p class="text-sm opacity-80 italic text-primary">Dr. MindBoard: ${data.reply}</p>`;
            chatMessages.appendChild(aiDiv);
            
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
        } catch (error) {
            document.getElementById('loading-indicator').remove();
            console.error('Chat error:', error);
        }
    });
</script>
@endsection
