            <!-- College Schedule View -->
            <!-- College Schedule View -->
            <div id="view-schedule" class="view-content hidden relative">
                <style>
                    /* Custom Scrollbar for Schedule */
                    .schedule-scroll::-webkit-scrollbar { height: 8px; }
                    .schedule-scroll::-webkit-scrollbar-track { background: rgba(255,255,255,0.02); border-radius: 10px; }
                    .schedule-scroll::-webkit-scrollbar-thumb { background: linear-gradient(to right, #3b82f6, #8b5cf6); border-radius: 10px; }
                    
                    /* Animations */
                    @keyframes slideInUp {
                        0% { opacity: 0; transform: translateY(40px) scale(0.95); }
                        100% { opacity: 1; transform: translateY(0) scale(1); }
                    }
                    .day-column {
                        animation: slideInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
                    }

                    @keyframes holo-sweep {
                        0% { transform: translateX(-100%) skewX(-15deg); }
                        100% { transform: translateX(200%) skewX(-15deg); }
                    }
                    .holo-card {
                        position: relative;
                        overflow: hidden;
                        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
                    }
                    .holo-card::after {
                        content: '';
                        position: absolute;
                        top: 0; left: 0; width: 50%; height: 100%;
                        background: linear-gradient(to right, transparent, rgba(255,255,255,0.1), transparent);
                        transform: translateX(-100%) skewX(-15deg);
                    }
                    .holo-card:hover::after {
                        animation: holo-sweep 1.5s infinite;
                    }
                    .holo-card:hover {
                        transform: translateY(-5px) scale(1.02);
                        box-shadow: 0 15px 35px -5px rgba(59, 130, 246, 0.2);
                        border-color: rgba(59, 130, 246, 0.4);
                    }

                    @keyframes fadeInUpBounce {
                        0% { opacity: 0; transform: translateY(30px) scale(0.9); }
                        60% { opacity: 1; transform: translateY(-5px) scale(1.02); }
                        100% { opacity: 1; transform: translateY(0) scale(1); }
                    }
                    .animate-class-item {
                        animation: fadeInUpBounce 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) both;
                    }
                    
                    /* Glass Card */
                    .glass-panel {
                        background: rgba(255, 255, 255, 0.03);
                        backdrop-filter: blur(20px);
                        border: 1px solid rgba(255, 255, 255, 0.1);
                        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.05);
                    }
                    html.dark .glass-panel {
                        background: rgba(15, 23, 42, 0.4);
                        border: 1px solid rgba(255, 255, 255, 0.05);
                    }

                    /* Pulsing line */
                    .pulse-line {
                        position: absolute;
                        left: -1px; top: 20%; bottom: 20%; width: 2px;
                        background: linear-gradient(to bottom, transparent, #3b82f6, #8b5cf6, transparent);
                        opacity: 0;
                        transition: opacity 0.3s;
                    }
                    .day-column:hover .pulse-line { opacity: 1; }
                </style>

                <!-- Floating Orbs Background -->
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-500/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>
                <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-500/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>

                <header class="mb-12 relative z-10">
                    <h2 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 mb-3 tracking-tight drop-shadow-sm">College Schedule</h2>
                    <p class="text-slate-500 dark:text-slate-400 font-medium text-lg">Holographic timeline of your academic journey.</p>
                </header>

                <div class="grid grid-cols-1 xl:grid-cols-12 gap-10 relative z-10">
                    <!-- Left: Control Panel -->
                    <div class="xl:col-span-4 space-y-6">
                        <section class="glass-panel p-8 rounded-[2rem] relative overflow-hidden group">
                            <!-- Animated gradient background for form -->
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                            
                            <div class="relative z-10">
                                <div class="flex items-center gap-3 mb-8">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-purple-500 text-white flex items-center justify-center shadow-lg shadow-purple-500/30">
                                        <span class="material-symbols-outlined">add_circle</span>
                                    </div>
                                    <h3 class="text-xl font-bold dark:text-white">New Class</h3>
                                </div>

                                <div class="space-y-5">
                                    <div class="relative group/input">
                                        <label class="absolute -top-2 left-4 px-1 bg-white dark:bg-slate-900 text-[10px] font-bold text-blue-500 uppercase tracking-wider z-10 transition-all group-focus-within/input:text-purple-500">Subject</label>
                                        <input type="text" id="schedSubject" class="w-full bg-transparent border-2 border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3.5 outline-none focus:border-blue-500 dark:focus:border-blue-500 transition-colors text-sm font-semibold dark:text-white" placeholder="e.g. Data Structures">
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-5">
                                        <div class="relative group/input">
                                            <label class="absolute -top-2 left-4 px-1 bg-white dark:bg-slate-900 text-[10px] font-bold text-blue-500 uppercase tracking-wider z-10 transition-all group-focus-within/input:text-purple-500">Day</label>
                                            <select id="schedDay" class="w-full bg-transparent border-2 border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3.5 outline-none focus:border-blue-500 dark:focus:border-blue-500 transition-colors text-sm font-semibold dark:text-white appearance-none cursor-pointer">
                                                <option value="Monday" class="dark:bg-slate-800">Monday</option>
                                                <option value="Tuesday" class="dark:bg-slate-800">Tuesday</option>
                                                <option value="Wednesday" class="dark:bg-slate-800">Wednesday</option>
                                                <option value="Thursday" class="dark:bg-slate-800">Thursday</option>
                                                <option value="Friday" class="dark:bg-slate-800">Friday</option>
                                                <option value="Saturday" class="dark:bg-slate-800">Saturday</option>
                                            </select>
                                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                                        </div>
                                        <div class="relative group/input">
                                            <label class="absolute -top-2 left-4 px-1 bg-white dark:bg-slate-900 text-[10px] font-bold text-blue-500 uppercase tracking-wider z-10 transition-all group-focus-within/input:text-purple-500">Time</label>
                                            <input type="time" id="schedTime" class="w-full bg-transparent border-2 border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3.5 outline-none focus:border-blue-500 dark:focus:border-blue-500 transition-colors text-sm font-semibold dark:text-white">
                                        </div>
                                    </div>
                                    <button onclick="addClass()" class="w-full relative overflow-hidden group/btn bg-slate-900 dark:bg-white text-white dark:text-slate-900 py-4 rounded-xl font-bold shadow-xl transition-transform hover:scale-[1.02] mt-4">
                                        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-blue-600 to-purple-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                                        <span class="relative z-10 flex items-center justify-center gap-2 group-hover/btn:text-white transition-colors">
                                            <span class="material-symbols-outlined">auto_fix_high</span>
                                            Inject to Timeline
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Right: Holographic Track -->
                    <div class="xl:col-span-8 overflow-hidden rounded-[2rem] p-1">
                        <div class="flex overflow-x-auto schedule-scroll gap-6 pb-6 snap-x snap-mandatory pr-10" id="scheduleGrid">
                            <!-- JS Will Render Columns Here -->
                        </div>
                    </div>
                </div>
            </div>
