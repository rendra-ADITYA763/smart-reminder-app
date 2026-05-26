        <!-- SideNavBar -->
        <aside
            class="bg-slate-50 dark:bg-slate-950 h-[calc(100vh-5rem)] w-64 border-r border-slate-200 dark:border-slate-800 flex flex-col p-6 space-y-2 text-sm font-medium hidden lg:flex sticky top-20 overflow-y-auto custom-scrollbar">
            <div class="mb-4">
                <div class="font-bold text-lg text-slate-900 dark:text-white mb-1">Concierge</div>
                <div class="text-on-surface-variant text-xs normal-case tracking-normal">Habit Architect v1.2</div>
            </div>
            <nav class="flex-1 space-y-1">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 mt-4">Core</p>
                <a class="sidebar-link active bg-white dark:bg-slate-900 text-blue-700 dark:text-blue-400 shadow-sm rounded-lg flex items-center gap-3 p-3 transition-all duration-300 cursor-pointer active:opacity-80"
                    onclick="switchView('dashboard')">
                    <span class="material-symbols-outlined">dashboard</span>
                    Dashboard
                </a>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 mt-4">Services</p>
                <a class="sidebar-link text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900 flex items-center gap-3 p-3 transition-all duration-300 cursor-pointer active:opacity-80 rounded-lg"
                    onclick="switchView('schedule')">
                    <span class="material-symbols-outlined">school</span>
                    College Schedule
                </a>
                <a class="sidebar-link text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900 flex items-center gap-3 p-3 transition-all duration-300 cursor-pointer active:opacity-80 rounded-lg"
                    onclick="switchView('events')">
                    <span class="material-symbols-outlined">emoji_events</span>
                    Competitions
                </a>
                <a class="sidebar-link text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900 flex items-center gap-3 p-3 transition-all duration-300 cursor-pointer active:opacity-80 rounded-lg"
                    onclick="switchView('weather')">
                    <span class="material-symbols-outlined">partly_cloudy_day</span>
                    Weather Concierge
                </a>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 mt-4">Admin</p>
                <a class="sidebar-link text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900 flex items-center gap-3 p-3 transition-all duration-300 cursor-pointer active:opacity-80 rounded-lg"
                    onclick="switchView('analytics')">
                    <span class="material-symbols-outlined">insights</span>
                    Analytics
                </a>
                <a class="sidebar-link text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900 flex items-center gap-3 p-3 transition-all duration-300 cursor-pointer active:opacity-80 rounded-lg"
                    onclick="switchView('logs')">
                    <span class="material-symbols-outlined">history</span>
                    Logs
                </a>
                <a class="sidebar-link text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900 flex items-center gap-3 p-3 transition-all duration-300 cursor-pointer active:opacity-80 rounded-lg"
                    onclick="switchView('settings')">
                    <span class="material-symbols-outlined">settings</span>
                    Settings
                </a>
            </nav>
            <button
                class="w-full bg-primary/10 text-primary py-3 rounded-xl font-bold mt-6 hover:bg-primary/20 transition-colors flex items-center justify-center gap-2"
                onclick="generatePrediction()">
                <span class="material-symbols-outlined text-sm">auto_awesome</span>
                New Prediction
            </button>
        </aside>
