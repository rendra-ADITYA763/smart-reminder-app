        <!-- SideNavBar -->
        <aside
            class="bg-slate-50 dark:bg-slate-950 h-[calc(100vh-5rem)] w-64 border-r border-slate-200 dark:border-slate-800 flex flex-col p-6 space-y-2 text-sm font-medium hidden lg:flex sticky top-20 overflow-y-auto custom-scrollbar">
            <div class="mb-4">
                <div class="font-bold text-lg text-slate-900 dark:text-white mb-1">Concierge</div>
                <div class="text-on-surface-variant text-xs normal-case tracking-normal">Habit Architect v1.2</div>
            </div>

            <!-- User Role Badge -->
            <?php if (isset($sessionUser)): ?>
            <div class="mb-2 px-3 py-2 rounded-xl <?php echo $sessionUser['role'] === 'admin' ? 'bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/40' : 'bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800/40'; ?>">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm <?php echo $sessionUser['role'] === 'admin' ? 'text-amber-500' : 'text-blue-500'; ?>"><?php echo $sessionUser['role'] === 'admin' ? 'shield_person' : 'person'; ?></span>
                    <span class="text-[10px] font-black uppercase tracking-widest <?php echo $sessionUser['role'] === 'admin' ? 'text-amber-600 dark:text-amber-400' : 'text-blue-600 dark:text-blue-400'; ?>"><?php echo $sessionUser['role']; ?> Access</span>
                </div>
            </div>
            <?php endif; ?>

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
                <a class="sidebar-link text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900 flex items-center gap-3 p-3 transition-all duration-300 cursor-pointer active:opacity-80 rounded-lg"
                    onclick="switchView('ai')">
                    <span class="material-symbols-outlined">robot_2</span>
                    AI Assistant
                </a>

                <?php if (isset($sessionUser) && $sessionUser['role'] === 'admin'): ?>
                <p class="text-[10px] font-black text-amber-500/70 uppercase tracking-widest mb-2 mt-4 flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs">shield_person</span> Admin
                </p>
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
                <?php endif; ?>

                <a class="sidebar-link text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900 flex items-center gap-3 p-3 transition-all duration-300 cursor-pointer active:opacity-80 rounded-lg"
                    onclick="switchView('settings')">
                    <span class="material-symbols-outlined">settings</span>
                    Settings
                </a>
            </nav>
            <button
                class="w-full bg-primary/10 text-primary py-3 rounded-xl font-bold mt-4 hover:bg-primary/20 transition-colors flex items-center justify-center gap-2"
                onclick="generatePrediction()">
                <span class="material-symbols-outlined text-sm">auto_awesome</span>
                New Prediction
            </button>
            <button
                onclick="handleLogout()"
                class="w-full bg-red-50 dark:bg-red-900/20 text-red-500 py-3 rounded-xl font-bold mt-2 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors flex items-center justify-center gap-2 border border-red-100 dark:border-red-900/30">
                <span class="material-symbols-outlined text-sm">logout</span>
                Logout
            </button>
        </aside>

