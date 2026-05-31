<style>
/* Holographic Dashboard Animations */
@keyframes dash-float {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-15px) scale(1.02); }
}
@keyframes pulse-glow {
    0%, 100% { opacity: 0.5; filter: blur(40px); }
    50% { opacity: 1; filter: blur(60px); }
}
@keyframes sweep-gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
@keyframes hologram-flicker {
    0%, 19%, 21%, 23%, 25%, 54%, 56%, 100% { opacity: 1; }
    20%, 24%, 55% { opacity: 0.8; }
    22% { opacity: 0.4; text-shadow: 0 0 10px rgba(59, 130, 246, 0.8); }
}

.holo-bento {
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(30px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
    transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
    position: relative;
    overflow: hidden;
}
.dark .holo-bento {
    background: rgba(15, 23, 42, 0.4);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    border-left: 1px solid rgba(255, 255, 255, 0.05);
}
.holo-bento:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(59, 130, 246, 0.15);
    border-color: rgba(59, 130, 246, 0.3);
}

.holo-bento::before {
    content: '';
    position: absolute;
    top: -50%; left: -50%;
    width: 200%; height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.5s;
    pointer-events: none;
}
.holo-bento:hover::before { opacity: 1; }

.gradient-text-anim {
    background: linear-gradient(to right, #3b82f6, #8b5cf6, #ec4899, #3b82f6);
    background-size: 300% auto;
    color: transparent;
    -webkit-background-clip: text;
    background-clip: text;
    animation: sweep-gradient 6s linear infinite;
}

.input-holo {
    background: rgba(0,0,0,0.02);
    border: 1px solid rgba(0,0,0,0.1);
    transition: all 0.3s;
}
.dark .input-holo { background: rgba(0,0,0,0.2); border-color: rgba(255,255,255,0.05); }
.input-holo:focus-within {
    background: transparent;
    border-color: #3b82f6;
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.2) inset;
}

/* Background Mesh */
.bg-mesh {
    position: absolute;
    inset: 0;
    background-image: 
        radial-gradient(at 40% 20%, hsla(228,100%,74%,0.15) 0px, transparent 50%),
        radial-gradient(at 80% 0%, hsla(189,100%,56%,0.15) 0px, transparent 50%),
        radial-gradient(at 0% 50%, hsla(355,100%,93%,0.1) 0px, transparent 50%);
    z-index: -10;
    pointer-events: none;
}
</style>

<div id="view-dashboard" class="view-content relative min-h-screen">
    
    <!-- Ultra VFX Background -->
    <div class="bg-mesh"></div>
    <div class="absolute top-10 right-20 w-[500px] h-[500px] bg-blue-500/20 dark:bg-blue-600/20 rounded-full blur-[120px] pointer-events-none -z-10 animate-[pulse-glow_8s_ease-in-out_infinite]"></div>
    <div class="absolute bottom-20 left-10 w-[600px] h-[600px] bg-purple-500/20 dark:bg-purple-600/20 rounded-full blur-[150px] pointer-events-none -z-10 animate-[dash-float_10s_ease-in-out_infinite]"></div>

    <header class="mb-12 max-w-4xl relative z-10">
        <h1 class="text-6xl lg:text-8xl font-black tracking-tighter mb-4 gradient-text-anim" id="greetingText" style="animation: sweep-gradient 6s linear infinite, hologram-flicker 10s infinite;">
            Good Morning.
        </h1>
        <p class="text-xl text-slate-600 dark:text-slate-400 max-w-2xl font-medium tracking-wide">
            Your personal command center. Awaiting directives.
        </p>
    </header>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-10 relative z-10">
        
        <!-- Left Column: User Panel & Habits -->
        <div class="xl:col-span-8 space-y-10">
            
            <!-- Add Habit Form -->
            <section class="holo-bento p-10 rounded-[2.5rem]">
                <div class="flex justify-between items-center mb-8 relative z-10">
                    <div>
                        <h2 class="text-2xl font-black text-slate-800 dark:text-white flex items-center gap-3">
                            <span class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/30">
                                <span class="material-symbols-outlined text-2xl">rocket_launch</span>
                            </span>
                            Initialize Routine
                        </h2>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mt-2">Deploy new behavioral subroutines</p>
                    </div>
                </div>

                <div class="input-holo p-2 rounded-3xl relative z-10">
                    <div class="flex flex-col md:flex-row gap-2 items-stretch w-full bg-white/50 dark:bg-slate-900/50 p-4 rounded-2xl backdrop-blur-md border border-white/20 dark:border-slate-700/50">
                        <div class="flex-1 relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors">terminal</span>
                            <input class="w-full bg-transparent border-0 focus:ring-0 pl-12 pr-4 py-4 text-slate-800 dark:text-white placeholder:text-slate-400 transition-all font-bold text-lg outline-none" id="activityInput" placeholder="Enter activity parameters..." type="text" />
                        </div>
                        <div class="w-full md:w-48 shrink-0 relative group border-l-0 md:border-l border-t md:border-t-0 border-slate-200 dark:border-slate-700">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors">schedule</span>
                            <input class="w-full bg-transparent border-0 focus:ring-0 pl-12 py-4 text-slate-800 dark:text-white transition-all font-bold outline-none cursor-pointer" id="timeInput" type="time" />
                        </div>
                        <div class="w-full md:w-auto shrink-0 pl-0 md:pl-2">
                            <button class="w-full md:w-auto h-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-4 rounded-xl font-black uppercase tracking-widest shadow-xl shadow-blue-500/30 hover:shadow-blue-500/50 hover:scale-105 transition-all flex items-center justify-center gap-2 overflow-hidden group/btn" onclick="addHabit()">
                                <div class="absolute inset-0 bg-white/20 -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700 ease-out skew-x-12"></div>
                                <span class="relative z-10 flex items-center gap-2">Execute <span class="material-symbols-outlined text-sm">send</span></span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Rekomendasi Area -->
                <div class="mt-6 hidden" id="recommendationArea">
                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 backdrop-blur-sm relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -translate-x-full animate-[sweep-gradient_3s_infinite]"></div>
                        <span class="material-symbols-outlined text-indigo-500 animate-pulse text-3xl">smart_toy</span>
                        <div class="relative z-10">
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500 mb-1">AI Recommendation System</p>
                            <p class="text-sm text-slate-700 dark:text-indigo-200 font-bold leading-relaxed" id="recommendationText">Computing optimal routine...</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Habit List -->
            <section class="holo-bento p-10 rounded-[2.5rem]">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-10">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-white flex items-center gap-3">
                            <span class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-600 text-white flex items-center justify-center shadow-lg shadow-purple-500/30">
                                <span class="material-symbols-outlined text-2xl">checklist_rtl</span>
                            </span>
                            Active Subroutines
                        </h3>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mt-2">Monitor daily execution progress</p>
                    </div>
                    
                    <div class="relative w-full sm:w-80 group">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl blur opacity-20 group-focus-within:opacity-50 transition-opacity"></div>
                        <div class="relative flex items-center bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden">
                            <span class="material-symbols-outlined pl-4 text-slate-400 group-focus-within:text-purple-500 transition-colors">radar</span>
                            <input type="text" id="habitSearch" placeholder="Scan subroutines..." class="w-full pl-3 pr-4 py-4 bg-transparent border-none text-sm font-bold focus:ring-0 text-slate-800 dark:text-white placeholder:text-slate-400 outline-none" oninput="renderUserList()">
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="userHabitList">
                    <!-- Populated by JS -->
                </div>
            </section>
        </div>

        <!-- Right Column: Quick Stats & Widgets -->
        <div class="xl:col-span-4 space-y-10">
            
            <!-- Weather Widget (Highly Animated) -->
            <section class="rounded-[2.5rem] shadow-2xl text-white relative overflow-hidden group hover:-translate-y-2 transition-transform duration-500 cursor-default p-1" style="background: linear-gradient(135deg, #0ea5e9, #3b82f6, #8b5cf6); background-size: 200% 200%; animation: gradient-x 10s ease infinite;">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-30 mix-blend-overlay animate-[dash-float_20s_linear_infinite]"></div>
                
                <div class="bg-black/10 backdrop-blur-md rounded-[2.3rem] p-8 h-full relative z-10 border border-white/20">
                    <div class="absolute -right-12 -top-12 opacity-30 group-hover:rotate-12 group-hover:scale-110 transition-all duration-700">
                        <span class="material-symbols-outlined text-[15rem]" id="dashWeatherIconLarge">sunny</span>
                    </div>
                    
                    <div class="flex justify-between items-start mb-12 relative z-10">
                        <div>
                            <h3 class="text-6xl font-black mb-2 tracking-tighter drop-shadow-lg" id="dashTemp">--°</h3>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-white bg-white/20 inline-block px-4 py-1.5 rounded-full backdrop-blur-xl border border-white/30 shadow-lg" id="dashCondition">Loading...</p>
                        </div>
                        <div class="w-20 h-20 bg-white/20 rounded-3xl backdrop-blur-xl flex items-center justify-center border border-white/30 shadow-[0_0_30px_rgba(255,255,255,0.2)] group-hover:scale-110 transition-transform duration-500">
                            <span class="material-symbols-outlined text-5xl animate-pulse drop-shadow-md" id="dashWeatherIcon">cloud</span>
                        </div>
                    </div>
                    <div class="flex gap-4 relative z-10">
                        <div class="flex-1 bg-white/10 backdrop-blur-xl p-5 rounded-3xl border border-white/20 hover:bg-white/20 transition-colors shadow-inner">
                            <p class="text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Humidity</p>
                            <p class="text-2xl font-black flex items-center gap-2"><span class="material-symbols-outlined text-base">water_drop</span> <span id="dashHumidity">--%</span></p>
                        </div>
                        <div class="flex-1 bg-white/10 backdrop-blur-xl p-5 rounded-3xl border border-white/20 hover:bg-white/20 transition-colors shadow-inner">
                            <p class="text-[10px] font-black text-white/70 uppercase tracking-widest mb-2">Wind</p>
                            <p class="text-2xl font-black flex items-center gap-2"><span class="material-symbols-outlined text-base">air</span> <span id="dashWind">--</span></p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Completion Stats -->
            <section class="holo-bento p-10 rounded-[2.5rem]">
                <div class="flex justify-between items-center mb-10 relative z-10">
                    <h2 class="text-sm font-black uppercase tracking-widest text-emerald-500">System Efficiency</h2>
                    <div class="w-10 h-10 rounded-full bg-emerald-500/10 flex items-center justify-center border border-emerald-500/20">
                        <span class="material-symbols-outlined text-emerald-500">analytics</span>
                    </div>
                </div>
                
                <div class="space-y-8 relative z-10">
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-5xl font-black text-slate-800 dark:text-white tracking-tighter" id="totalHabitsCount">0</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold mt-2">Active Nodes</p>
                        </div>
                        <div class="text-right">
                            <p class="text-5xl font-black text-emerald-500 tracking-tighter drop-shadow-[0_0_15px_rgba(16,185,129,0.3)]" id="completionRate">0%</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold mt-2">Completion</p>
                        </div>
                    </div>
                    
                    <div class="h-4 w-full bg-slate-900/5 dark:bg-slate-900/50 rounded-full overflow-hidden shadow-inner p-0.5 border border-slate-200 dark:border-slate-800">
                        <div id="completionBar" class="h-full bg-gradient-to-r from-emerald-400 to-teal-400 rounded-full transition-all duration-1000 ease-out relative overflow-hidden shadow-[0_0_10px_rgba(16,185,129,0.5)]" style="width: 0%">
                            <div class="absolute inset-0 bg-[linear-gradient(45deg,rgba(255,255,255,0.2)_25%,transparent_25%,transparent_50%,rgba(255,255,255,0.2)_50%,rgba(255,255,255,0.2)_75%,transparent_75%,transparent)] bg-[length:20px_20px] animate-[sweep-gradient_1s_linear_infinite]"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Upcoming Event Widget -->
            <section class="holo-bento p-8 rounded-[2.5rem] group overflow-hidden">
                <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-b from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10"></div>
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xs font-black uppercase tracking-widest text-amber-500">Upcoming Directive</h3>
                    <span class="material-symbols-outlined text-amber-500 animate-[dash-float_2s_ease-in-out_infinite]">crisis_alert</span>
                </div>
                
                <div id="nextEventWidget" class="p-6 bg-white/40 dark:bg-slate-800/40 backdrop-blur-md rounded-3xl flex items-center gap-5 border border-white/50 dark:border-slate-700/50 group-hover:border-amber-500/30 transition-all hover:-translate-y-1 hover:shadow-lg">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 text-white flex items-center justify-center shadow-lg shadow-amber-500/30 shrink-0 relative overflow-hidden">
                        <div class="absolute inset-0 bg-white/20 animate-ping opacity-20"></div>
                        <span class="material-symbols-outlined text-3xl relative z-10">flash_on</span>
                    </div>
                    <div class="overflow-hidden">
                        <p class="font-black text-lg text-slate-800 dark:text-white truncate" id="nextEventName">Standby Mode</p>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-amber-600 dark:text-amber-400 mt-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[12px]">schedule</span>
                            <span id="nextEventDate">-</span>
                        </p>
                    </div>
                </div>
            </section>
            
        </div>
    </div>
</div>
