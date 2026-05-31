            <div id="view-logs" class="view-content hidden relative">
                <style>
                    /* Audit Log Animations */
                    @keyframes logEntryFade {
                        0% { opacity: 0; transform: translateX(-20px); filter: blur(10px); }
                        100% { opacity: 1; transform: translateX(0); filter: blur(0); }
                    }
                    .log-anim {
                        animation: logEntryFade 0.4s cubic-bezier(0.16, 1, 0.3, 1) both;
                    }
                    
                    @keyframes scanner {
                        0% { top: -10%; }
                        100% { top: 110%; }
                    }
                    .console-screen {
                        position: relative;
                        background: rgba(15, 23, 42, 0.6);
                        backdrop-filter: blur(20px);
                        border: 1px solid rgba(239, 68, 68, 0.2);
                        box-shadow: 0 0 40px rgba(239, 68, 68, 0.05) inset;
                        overflow: hidden;
                    }
                    .console-screen::before {
                        content: '';
                        position: absolute;
                        left: 0; right: 0; height: 10%;
                        background: linear-gradient(to bottom, transparent, rgba(239, 68, 68, 0.1), transparent);
                        animation: scanner 4s linear infinite;
                        pointer-events: none;
                        z-index: 10;
                    }

                    .log-line {
                        position: relative;
                        transition: all 0.3s ease;
                        border-left: 2px solid transparent;
                    }
                    .log-line:hover {
                        background: rgba(239, 68, 68, 0.05);
                        border-left: 2px solid #ef4444;
                        transform: translateX(4px);
                    }
                </style>

                <!-- VFX -->
                <div class="absolute top-0 right-0 w-full h-[500px] bg-red-500/5 dark:bg-red-500/10 rounded-full blur-[200px] pointer-events-none -z-10"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-orange-500/5 dark:bg-orange-500/10 rounded-full blur-[150px] pointer-events-none -z-10"></div>

                <header class="mb-12 flex justify-between items-end relative z-10">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <span class="material-symbols-outlined text-red-500 animate-pulse">terminal</span>
                            <span class="text-xs font-black text-red-500 uppercase tracking-[0.3em]">System Audit</span>
                        </div>
                        <h2 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-orange-400 mb-2 tracking-tight drop-shadow-sm">Activity Logs</h2>
                        <p class="text-slate-500 dark:text-slate-400 font-medium">Chronological history of quantum interactions.</p>
                    </div>
                    <button onclick="clearLogs()" class="group relative overflow-hidden bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white px-6 py-3 rounded-xl font-bold transition-all duration-300 shadow-[0_0_15px_rgba(239,68,68,0.2)] hover:shadow-[0_0_25px_rgba(239,68,68,0.5)] flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm group-hover:rotate-180 transition-transform duration-500">delete_sweep</span>
                        Purge Memory
                    </button>
                </header>

                <div class="console-screen rounded-[2.5rem] p-2 relative z-10">
                    <!-- Console Header -->
                    <div class="flex items-center gap-2 px-6 py-4 border-b border-red-500/20 bg-slate-900/50 rounded-t-[2rem]">
                        <div class="w-3 h-3 rounded-full bg-red-500 shadow-[0_0_10px_rgba(239,68,68,0.8)] animate-pulse"></div>
                        <div class="w-3 h-3 rounded-full bg-orange-500 opacity-50"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-500 opacity-50"></div>
                        <span class="ml-4 text-xs font-mono text-red-400/70">root@smart-reminder:~# tail -f /var/log/activity.log</span>
                    </div>
                    
                    <div id="logContent" class="max-h-[600px] overflow-y-auto p-4 space-y-1 font-mono">
                        <!-- Logs populated by JS -->
                    </div>
                </div>
            </div>
