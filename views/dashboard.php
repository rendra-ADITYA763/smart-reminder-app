<style>
/* Dashboard Specific Animations */
@keyframes dash-float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
@keyframes gradient-x {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}
@keyframes shimmer {
    100% { transform: translateX(100%); }
}

.bento-card {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(226, 232, 240, 0.8);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}
.dark .bento-card {
    background: rgba(15, 23, 42, 0.6);
    border-color: rgba(255, 255, 255, 0.05);
}
.bento-card:hover {
    transform: translateY(-5px) scale(1.01);
    box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1);
}
.dark .bento-card:hover {
    border-color: rgba(59, 130, 246, 0.5);
    box-shadow: 0 20px 40px -10px rgba(59, 130, 246, 0.2);
}

.gradient-bg-animate {
    background: linear-gradient(270deg, #3b82f6, #8b5cf6, #ec4899);
    background-size: 200% 200%;
    animation: gradient-x 8s ease infinite;
}

.animate-float {
    animation: dash-float 6s ease-in-out infinite;
}
.animate-float-delayed {
    animation: dash-float 6s ease-in-out infinite;
    animation-delay: 3s;
}
</style>

<div id="view-dashboard" class="view-content relative">
    
    <!-- Decorative Background Elements for Dashboard -->
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-500/10 rounded-full blur-[120px] pointer-events-none -z-10 animate-pulse"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-500/10 rounded-full blur-[100px] pointer-events-none -z-10 animate-float"></div>

    <header class="mb-12 max-w-4xl relative z-10">
        <h1 class="text-5xl lg:text-7xl font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-slate-500 dark:from-white dark:to-slate-400 mb-4 animate-float" id="greetingText">
            Good Morning.
        </h1>
        <p class="text-lg text-slate-500 dark:text-slate-400 max-w-2xl leading-relaxed">
            Here is your digital concierge for daily habits. We predict and organize so you can focus on execution.
        </p>
    </header>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 relative z-10">
        
        <!-- Left Column: User Panel & Habits -->
        <div class="xl:col-span-8 space-y-8">
            
            <!-- Add Habit Form (Bento Box) -->
            <section class="bento-card p-8 rounded-[2rem] relative overflow-hidden group">
                <!-- Abstract shape -->
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-gradient-to-br from-blue-400/20 to-purple-400/20 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                
                <div class="flex justify-between items-center mb-8 relative z-10">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 dark:text-white flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                                <span class="material-symbols-outlined">add_task</span>
                            </span>
                            Tambah Kebiasaan Baru
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">Buat rutinitas baru untuk mencapai target Anda.</p>
                    </div>
                </div>

                <div class="bg-slate-50/50 dark:bg-slate-800/50 p-6 rounded-2xl border border-slate-100 dark:border-slate-700/50 relative z-10 backdrop-blur-md">
                    <div class="flex flex-col md:flex-row gap-6 items-end w-full">
                        <div class="flex-1 w-full relative group/input">
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-2 group-focus-within/input:text-blue-500 transition-colors">Aktivitas</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-0 top-1/2 -translate-y-1/2 text-slate-400">edit_square</span>
                                <input class="w-full bg-transparent border-0 border-b-2 border-slate-200 dark:border-slate-700 focus:ring-0 focus:border-blue-500 pl-8 pr-4 py-2 text-slate-800 dark:text-white placeholder:text-slate-400 transition-all font-medium" id="activityInput" placeholder="e.g. Membaca Buku 30 Menit" type="text" />
                            </div>
                        </div>
                        <div class="w-full md:w-48 shrink-0 relative group/input">
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-2 group-focus-within/input:text-blue-500 transition-colors">Waktu</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-0 top-1/2 -translate-y-1/2 text-slate-400">schedule</span>
                                <input class="w-full bg-transparent border-0 border-b-2 border-slate-200 dark:border-slate-700 focus:ring-0 focus:border-blue-500 pl-8 py-2 text-slate-800 dark:text-white transition-all font-medium cursor-pointer" id="timeInput" type="time" />
                            </div>
                        </div>
                        <div class="w-full md:w-auto shrink-0">
                            <button class="w-full md:w-auto gradient-bg-animate text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:scale-105 transition-all flex items-center justify-center gap-2" onclick="addHabit()">
                                <span class="material-symbols-outlined">add_circle</span>
                                Tambah
                            </button>
                        </div>
                    </div>

                    <!-- Rekomendasi Area -->
                    <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700/50 hidden" id="recommendationArea">
                        <div class="flex items-start gap-3 p-4 rounded-xl bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-500/10 dark:to-orange-500/10 border border-amber-200 dark:border-amber-500/20">
                            <span class="material-symbols-outlined text-amber-500 animate-pulse">lightbulb</span>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-widest text-amber-600 dark:text-amber-400 mb-1">Saran AI</p>
                                <p class="text-sm text-amber-800 dark:text-amber-200 font-medium leading-relaxed" id="recommendationText">Rekomendasi: ...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Habit List -->
            <section class="bento-card p-8 rounded-[2rem]">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-white flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-500/20 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                                <span class="material-symbols-outlined">checklist</span>
                            </span>
                            Daftar Kebiasaan
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">Kelola dan pantau progres harian Anda.</p>
                    </div>
                    
                    <div class="relative w-full sm:w-72 group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors">search</span>
                        <input type="text" id="habitSearch" placeholder="Cari kebiasaan..." class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-800 dark:text-white" oninput="renderUserList()">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5" id="userHabitList">
                    <!-- Populated by JS -->
                </div>
            </section>
        </div>

        <!-- Right Column: Quick Stats & Widgets -->
        <div class="xl:col-span-4 space-y-8">
            
            <!-- Weather Widget (Highly Animated) -->
            <section class="gradient-bg-animate p-8 rounded-[2rem] shadow-xl text-white relative overflow-hidden group hover:-translate-y-2 transition-transform duration-500 cursor-default">
                <!-- Decorative elements -->
                <div class="absolute -right-10 -top-10 opacity-20 group-hover:rotate-45 group-hover:scale-125 transition-all duration-1000">
                    <span class="material-symbols-outlined text-[15rem]" id="dashWeatherIconLarge">sunny</span>
                </div>
                <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
                
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-10">
                        <div>
                            <h3 class="text-5xl font-black mb-2 tracking-tighter" id="dashTemp">--°C</h3>
                            <p class="text-sm font-bold uppercase tracking-widest text-white/80 bg-white/10 inline-block px-3 py-1 rounded-full backdrop-blur-md border border-white/20" id="dashCondition">Loading...</p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-2xl backdrop-blur-md flex items-center justify-center border border-white/20 shadow-inner group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-4xl animate-pulse" id="dashWeatherIcon">cloud</span>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-1 bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10 hover:bg-white/20 transition-colors">
                            <p class="text-[10px] font-bold text-white/60 uppercase mb-1">Humidity</p>
                            <p class="text-xl font-bold flex items-center gap-1"><span class="material-symbols-outlined text-sm">water_drop</span> <span id="dashHumidity">--%</span></p>
                        </div>
                        <div class="flex-1 bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10 hover:bg-white/20 transition-colors">
                            <p class="text-[10px] font-bold text-white/60 uppercase mb-1">Wind</p>
                            <p class="text-xl font-bold flex items-center gap-1"><span class="material-symbols-outlined text-sm">air</span> <span id="dashWind">--</span></p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Completion Stats -->
            <section class="bento-card p-8 rounded-[2rem] relative overflow-hidden group">
                <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-green-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                
                <div class="flex justify-between items-center mb-8 relative z-10">
                    <h2 class="text-sm font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Activity Completion</h2>
                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                        <span class="material-symbols-outlined text-green-500 text-sm">trending_up</span>
                    </div>
                </div>
                
                <div class="space-y-6 relative z-10">
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-4xl font-black text-slate-800 dark:text-white" id="totalHabitsCount">0</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold mt-1">Total Habits</p>
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-black text-green-500" id="completionRate">0%</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold mt-1">Completion</p>
                        </div>
                    </div>
                    
                    <div class="h-3 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden shadow-inner relative">
                        <div id="completionBar" class="h-full bg-gradient-to-r from-green-400 to-emerald-500 transition-all duration-1000 ease-out relative overflow-hidden" style="width: 0%">
                            <!-- Shimmer effect inside bar -->
                            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-transparent via-white/40 to-transparent -translate-x-full animate-[shimmer_2s_infinite]"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Upcoming Event Widget -->
            <section class="bento-card p-8 rounded-[2rem] group hover:border-amber-500/30 transition-colors">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Next Event</h3>
                    <span class="material-symbols-outlined text-amber-500 animate-bounce">event_star</span>
                </div>
                
                <div id="nextEventWidget" class="p-5 bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-500/10 dark:to-orange-500/10 rounded-2xl flex items-center gap-4 border border-amber-100 dark:border-amber-500/20 group-hover:scale-[1.02] transition-transform">
                    <div class="w-12 h-12 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-lg shadow-amber-500/30 shrink-0">
                        <span class="material-symbols-outlined text-2xl">emoji_events</span>
                    </div>
                    <div class="overflow-hidden">
                        <p class="font-bold text-slate-800 dark:text-amber-50 truncate" id="nextEventName">No events scheduled</p>
                        <p class="text-xs text-amber-600 dark:text-amber-400/80 font-medium mt-0.5 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                            <span id="nextEventDate">-</span>
                        </p>
                    </div>
                </div>
            </section>
            
        </div>
    </div>
</div>
