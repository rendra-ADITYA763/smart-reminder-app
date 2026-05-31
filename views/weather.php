            <!-- Weather Concierge View -->
            <div id="view-weather" class="view-content hidden relative">
                <style>
                    /* Weather Animations */
                    @keyframes levitate {
                        0%, 100% { transform: translateY(0); }
                        50% { transform: translateY(-10px); }
                    }
                    .weather-float {
                        animation: levitate 6s ease-in-out infinite;
                    }

                    @keyframes pulse-ring {
                        0% { transform: scale(0.8); opacity: 0.5; }
                        100% { transform: scale(2.5); opacity: 0; }
                    }
                    .radar-ping::before, .radar-ping::after {
                        content: '';
                        position: absolute;
                        inset: 0;
                        border-radius: 50%;
                        border: 2px solid #3b82f6;
                        animation: pulse-ring 3s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
                    }
                    .radar-ping::after { animation-delay: 1.5s; }

                    /* Weather Card Stagger */
                    @keyframes slideUpFade {
                        0% { opacity: 0; transform: translateY(30px); }
                        100% { opacity: 1; transform: translateY(0); }
                    }
                    .weather-card-anim {
                        animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
                    }

                    .glass-weather {
                        background: rgba(255, 255, 255, 0.05);
                        backdrop-filter: blur(20px);
                        border: 1px solid rgba(255, 255, 255, 0.1);
                        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.05);
                        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                    }
                    html.dark .glass-weather {
                        background: rgba(15, 23, 42, 0.5);
                        border: 1px solid rgba(255, 255, 255, 0.05);
                    }
                    .glass-weather:hover {
                        transform: translateY(-5px) scale(1.02);
                        background: rgba(255, 255, 255, 0.1);
                    }
                    html.dark .glass-weather:hover { background: rgba(30, 41, 59, 0.6); }

                    /* Weather specific glows */
                    .glow-sunny { box-shadow: 0 0 20px rgba(250, 204, 21, 0.1); }
                    .glow-rainy { box-shadow: 0 0 20px rgba(59, 130, 246, 0.1); }
                    .glow-cloudy { box-shadow: 0 0 20px rgba(148, 163, 184, 0.1); }
                    .glow-snowy { box-shadow: 0 0 20px rgba(226, 232, 240, 0.1); }
                </style>

                <!-- Atmospheric Background VFX -->
                <div class="absolute -top-10 -left-10 w-[600px] h-[600px] bg-blue-400/10 dark:bg-blue-600/10 rounded-full blur-[150px] pointer-events-none -z-10 weather-float"></div>
                <div class="absolute top-1/2 right-0 w-[400px] h-[400px] bg-cyan-400/10 dark:bg-cyan-600/10 rounded-full blur-[120px] pointer-events-none -z-10 weather-float" style="animation-delay: -3s;"></div>

                <header class="mb-12 relative z-10">
                    <h2 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-500 mb-3 tracking-tight drop-shadow-sm">Weather Concierge</h2>
                    <p class="text-slate-500 dark:text-slate-400 font-medium text-lg">Atmospheric intelligence for your daily missions.</p>
                </header>

                <div class="grid grid-cols-1 xl:grid-cols-12 gap-10 relative z-10">
                    <!-- Left: Sensors & Context -->
                    <div class="xl:col-span-5 space-y-8">
                        <section class="glass-weather p-8 rounded-[2.5rem] relative overflow-hidden group">
                            <!-- Radar Background Map effect -->
                            <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05] pointer-events-none" style="background-image: radial-gradient(#3b82f6 1px, transparent 1px); background-size: 20px 20px;"></div>
                            
                            <h3 class="font-bold mb-8 text-xl dark:text-white flex items-center gap-3 relative z-10">
                                <span class="material-symbols-outlined text-blue-500">satellite_alt</span>
                                Atmospheric Sensors
                            </h3>
                            
                            <div class="flex items-center gap-6 p-6 bg-white/50 dark:bg-slate-800/50 rounded-3xl mb-8 relative z-10 border border-white/20 dark:border-slate-700/50 backdrop-blur-sm">
                                <div class="relative w-16 h-16 flex items-center justify-center shrink-0">
                                    <div class="radar-ping absolute inset-2"></div>
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center shadow-[0_0_20px_rgba(59,130,246,0.5)] z-10">
                                        <span class="material-symbols-outlined text-white text-xl">my_location</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-black text-2xl text-slate-800 dark:text-white tracking-tight" id="weatherCity">Jakarta, ID</p>
                                    <p class="text-xs font-bold text-blue-500 uppercase tracking-widest mt-1">Satellite Linked</p>
                                </div>
                            </div>

                            <button onclick="updateWeather()" class="w-full relative overflow-hidden group/btn bg-slate-900 dark:bg-white text-white dark:text-slate-900 py-4 rounded-2xl font-bold shadow-xl transition-transform hover:scale-[1.02] z-10">
                                <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-blue-500 to-cyan-500 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                                <span class="relative z-10 flex items-center justify-center gap-2 group-hover/btn:text-white transition-colors">
                                    <span class="material-symbols-outlined group-hover/btn:animate-spin">radar</span>
                                    Scan Atmosphere
                                </span>
                            </button>
                        </section>

                        <section class="glass-weather !bg-blue-500/5 dark:!bg-blue-500/10 p-8 rounded-[2.5rem] border !border-blue-500/20">
                            <h3 class="font-bold text-blue-600 dark:text-blue-400 mb-5 flex items-center gap-3">
                                <span class="material-symbols-outlined">psychology</span>
                                AI Concierge Context
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                                I'm monitoring the atmospheric conditions. If you plan outdoor activities like <span class="font-bold text-blue-500 bg-blue-500/10 px-2 py-0.5 rounded-md">lari</span> or <span class="font-bold text-blue-500 bg-blue-500/10 px-2 py-0.5 rounded-md">sepeda</span>, I'll alert you if the conditions become hostile.
                            </p>
                        </section>
                    </div>

                    <!-- Right: Forecast Data -->
                    <div class="xl:col-span-7">
                        <div class="glass-weather p-8 rounded-[2.5rem] h-full flex flex-col">
                            <div class="flex items-center justify-between mb-8">
                                <h3 class="font-bold text-xl dark:text-white flex items-center gap-2">
                                    <span class="material-symbols-outlined text-blue-500">calendar_month</span>
                                    7-Day Projection
                                </h3>
                                <div class="px-3 py-1 bg-blue-500/10 text-blue-500 text-xs font-bold rounded-full uppercase tracking-widest">Live</div>
                            </div>
                            
                            <div class="space-y-4 flex-1" id="weatherForecast">
                                <!-- Forecast items here -->
                                <div class="animate-pulse flex items-center justify-between p-5 bg-white/30 dark:bg-slate-800/50 rounded-2xl">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-slate-200 dark:bg-slate-700 rounded-full"></div>
                                        <div class="space-y-2">
                                            <div class="h-4 bg-slate-200 dark:bg-slate-700 rounded w-24"></div>
                                            <div class="h-2 bg-slate-200 dark:bg-slate-700 rounded w-16"></div>
                                        </div>
                                    </div>
                                    <div class="space-y-2 text-right">
                                        <div class="h-5 bg-slate-200 dark:bg-slate-700 rounded w-10 ml-auto"></div>
                                        <div class="h-2 bg-slate-200 dark:bg-slate-700 rounded w-6 ml-auto"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
