            <div id="view-settings" class="view-content hidden relative">
                <style>
                    .glass-settings {
                        background: rgba(255, 255, 255, 0.05);
                        backdrop-filter: blur(25px);
                        border: 1px solid rgba(255, 255, 255, 0.1);
                        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
                        transition: all 0.4s ease;
                    }
                    html.dark .glass-settings {
                        background: rgba(15, 23, 42, 0.5);
                        border-color: rgba(255, 255, 255, 0.05);
                    }
                    .glass-settings:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
                        border-color: rgba(99, 102, 241, 0.3); /* Indigo glow */
                    }

                    .holo-input {
                        background: rgba(0,0,0,0.05);
                        border: 2px solid transparent;
                        transition: all 0.3s ease;
                    }
                    html.dark .holo-input { background: rgba(0,0,0,0.2); }
                    .holo-input:focus {
                        border-color: #6366f1;
                        box-shadow: 0 0 20px rgba(99, 102, 241, 0.2);
                        background: transparent;
                    }

                    /* Cyber Toggle */
                    .cyber-toggle {
                        background: rgba(0,0,0,0.1);
                        border: 1px solid rgba(255,255,255,0.1);
                        transition: 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                    }
                    html.dark .cyber-toggle { background: #6366f1; border-color: #6366f1; box-shadow: 0 0 15px rgba(99, 102, 241, 0.5); }
                    .cyber-toggle-knob {
                        transition: 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                    }
                    html.dark .cyber-toggle-knob { transform: translateX(24px); }
                </style>

                <!-- VFX -->
                <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-indigo-500/10 rounded-[100%] blur-[120px] pointer-events-none -z-10"></div>

                <header class="mb-12 relative z-10 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-xl shadow-indigo-500/30 mb-6">
                        <span class="material-symbols-outlined text-3xl">admin_panel_settings</span>
                    </div>
                    <h2 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-500 mb-3 tracking-tight">Control Nexus</h2>
                    <p class="text-slate-500 dark:text-slate-400 font-medium text-lg">Calibrate your personalization protocols.</p>
                </header>

                <div class="max-w-3xl mx-auto space-y-8 relative z-10">
                    <!-- Profile Card -->
                    <section class="glass-settings p-10 rounded-[2.5rem] relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-bl-[100px] -z-10 transition-transform group-hover:scale-110"></div>
                        
                        <h3 class="text-2xl font-black mb-8 dark:text-white flex items-center gap-3">
                            <span class="material-symbols-outlined text-indigo-500">fingerprint</span>
                            Identity Protocol
                        </h3>
                        
                        <div class="space-y-6">
                            <div class="relative">
                                <label class="absolute -top-3 left-4 px-2 bg-white dark:bg-slate-900 text-xs font-bold text-indigo-500 uppercase tracking-widest z-10 rounded-full">Display Name</label>
                                <div class="relative flex items-center">
                                    <span class="material-symbols-outlined absolute left-4 text-slate-400 z-10">person</span>
                                    <input type="text" id="userNameInput" class="holo-input w-full rounded-2xl pl-12 pr-4 py-4 text-slate-900 dark:text-white font-bold outline-none relative z-0" placeholder="Enter identification alias" onchange="updateProfile()">
                                </div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase mt-3 tracking-widest pl-2">System will recognize you by this alias.</p>
                            </div>
                        </div>
                    </section>

                    <!-- Preferences Card -->
                    <section class="glass-settings p-10 rounded-[2.5rem] relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-bl-[100px] -z-10 transition-transform group-hover:scale-110"></div>
                        
                        <h3 class="text-2xl font-black mb-8 dark:text-white flex items-center gap-3">
                            <span class="material-symbols-outlined text-purple-500">tune</span>
                            Environment Parameters
                        </h3>
                        
                        <div class="flex items-center justify-between p-6 bg-white/50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-700 hover:border-purple-500/30 transition-colors">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-purple-500">contrast</span>
                                </div>
                                <div>
                                    <p class="font-extrabold text-lg dark:text-white">Dark Matter Theme</p>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Toggle optical environment</p>
                                </div>
                            </div>
                            <button id="settingsThemeToggle" onclick="toggleDarkMode()" class="cyber-toggle w-16 h-8 rounded-full relative cursor-pointer flex items-center">
                                <div class="cyber-toggle-knob w-6 h-6 bg-white rounded-full ml-1 shadow-md flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[10px] text-slate-900 font-bold" id="themeIcon">light_mode</span>
                                </div>
                            </button>
                        </div>
                    </section>
                </div>
            </div>
