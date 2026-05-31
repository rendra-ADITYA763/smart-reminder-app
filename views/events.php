            <!-- Competition Events View -->
            <div id="view-events" class="view-content hidden relative">
                <style>
                    /* Event Animations */
                    @keyframes slideInRightFade {
                        0% { opacity: 0; transform: translateX(50px) scale(0.9); }
                        100% { opacity: 1; transform: translateX(0) scale(1); }
                    }
                    .event-card {
                        animation: slideInRightFade 0.7s cubic-bezier(0.2, 1, 0.3, 1) both;
                        perspective: 1000px;
                        transform-style: preserve-3d;
                        transition: all 0.4s ease;
                    }
                    
                    .event-card:hover {
                        transform: translateY(-8px) rotateX(5deg) rotateY(-5deg);
                        box-shadow: -15px 20px 30px -10px rgba(236, 72, 153, 0.3), 15px 20px 30px -10px rgba(139, 92, 246, 0.3);
                    }

                    .neon-border {
                        position: relative;
                        background: rgba(255, 255, 255, 0.02);
                        backdrop-filter: blur(15px);
                        border: 1px solid rgba(255,255,255,0.05);
                    }
                    .neon-border::before {
                        content: '';
                        position: absolute;
                        top: 0; left: 0; right: 0; height: 2px;
                        background: linear-gradient(90deg, transparent, #ec4899, #8b5cf6, transparent);
                        opacity: 0;
                        transition: opacity 0.4s;
                    }
                    .event-card:hover .neon-border::before {
                        opacity: 1;
                    }

                    /* Glowing Ring */
                    .glow-ring {
                        position: relative;
                    }
                    .glow-ring::after {
                        content: '';
                        position: absolute;
                        inset: -4px;
                        border-radius: 50%;
                        background: conic-gradient(from 0deg, #ec4899, #8b5cf6, #3b82f6, #ec4899);
                        animation: spin 3s linear infinite;
                        z-index: -1;
                        opacity: 0;
                        transition: opacity 0.3s;
                    }
                    .event-card:hover .glow-ring::after { opacity: 1; }
                    
                    @keyframes spin { 100% { transform: rotate(360deg); } }
                </style>

                <!-- Background VFX -->
                <div class="absolute top-20 left-10 w-96 h-96 bg-pink-500/10 rounded-full blur-[120px] pointer-events-none -z-10"></div>
                <div class="absolute bottom-20 right-10 w-[500px] h-[500px] bg-purple-500/10 rounded-full blur-[150px] pointer-events-none -z-10"></div>

                <header class="mb-12 relative z-10">
                    <h2 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 mb-3 tracking-tight drop-shadow-sm">Competitions Arena</h2>
                    <p class="text-slate-500 dark:text-slate-400 font-medium text-lg">Your glorious battles and upcoming tournaments.</p>
                </header>

                <div class="grid grid-cols-1 xl:grid-cols-12 gap-10 relative z-10">
                    <!-- Left: Control Panel -->
                    <div class="xl:col-span-4 space-y-6">
                        <section class="neon-border p-8 rounded-[2rem] relative overflow-hidden group/form shadow-xl shadow-slate-200/20 dark:shadow-none">
                            <div class="absolute inset-0 bg-gradient-to-br from-pink-500/5 to-purple-500/5 opacity-0 group-hover/form:opacity-100 transition-opacity duration-700"></div>
                            
                            <div class="relative z-10">
                                <div class="flex items-center gap-3 mb-8">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-500 to-purple-500 text-white flex items-center justify-center shadow-lg shadow-pink-500/30">
                                        <span class="material-symbols-outlined">emoji_events</span>
                                    </div>
                                    <h3 class="text-xl font-bold dark:text-white">Register Event</h3>
                                </div>

                                <div class="space-y-5">
                                    <div class="relative group/input">
                                        <label class="absolute -top-2 left-4 px-1 bg-white dark:bg-slate-900 text-[10px] font-bold text-pink-500 uppercase tracking-wider z-10 transition-all group-focus-within/input:text-purple-500">Event/Match Name</label>
                                        <input type="text" id="eventName" class="w-full bg-transparent border-2 border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3.5 outline-none focus:border-pink-500 dark:focus:border-pink-500 transition-colors text-sm font-semibold dark:text-white">
                                    </div>
                                    <div class="relative group/input">
                                        <label class="absolute -top-2 left-4 px-1 bg-white dark:bg-slate-900 text-[10px] font-bold text-pink-500 uppercase tracking-wider z-10 transition-all group-focus-within/input:text-purple-500">Date</label>
                                        <input type="date" id="eventDate" class="w-full bg-transparent border-2 border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3.5 outline-none focus:border-pink-500 dark:focus:border-pink-500 transition-colors text-sm font-semibold dark:text-white">
                                    </div>
                                    <div class="relative group/input">
                                        <label class="absolute -top-2 left-4 px-1 bg-white dark:bg-slate-900 text-[10px] font-bold text-pink-500 uppercase tracking-wider z-10 transition-all group-focus-within/input:text-purple-500">Location/Platform</label>
                                        <input type="text" id="eventLoc" class="w-full bg-transparent border-2 border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3.5 outline-none focus:border-pink-500 dark:focus:border-pink-500 transition-colors text-sm font-semibold dark:text-white">
                                    </div>
                                    
                                    <button onclick="addEvent()" class="w-full relative overflow-hidden group/btn bg-slate-900 dark:bg-white text-white dark:text-slate-900 py-4 rounded-xl font-bold shadow-xl transition-transform hover:scale-[1.02] mt-4">
                                        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-pink-500 to-purple-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                                        <span class="relative z-10 flex items-center justify-center gap-2 group-hover/btn:text-white transition-colors">
                                            <span class="material-symbols-outlined">swords</span>
                                            Enter the Arena
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Right: Tournament Cards -->
                    <div class="xl:col-span-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="eventTableBody">
                            <!-- JS Will Render Cards Here -->
                        </div>
                    </div>
                </div>
            </div>
