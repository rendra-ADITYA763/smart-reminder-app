            <div id="view-settings" class="view-content hidden">
                <header class="mb-12">
                    <h2 class="text-4xl font-black text-slate-900 dark:text-white mb-2">Settings</h2>
                    <p class="text-slate-500">Personalize your concierge experience.</p>
                </header>
                <div class="max-w-2xl space-y-8">
                    <section
                        class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800">
                        <h3 class="font-bold mb-6">Profile</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Display
                                    Name</label>
                                <input type="text" id="userNameInput"
                                    class="w-full bg-slate-50 dark:bg-slate-800 border-0 rounded-xl px-4 py-3 text-on-surface dark:text-white"
                                    placeholder="Enter your name" onchange="updateProfile()">
                            </div>
                        </div>
                    </section>
                    <section
                        class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800">
                        <h3 class="font-bold mb-6">Preferences</h3>
                        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800 rounded-2xl">
                            <div class="flex items-center gap-4">
                                <span class="material-symbols-outlined text-primary">dark_mode</span>
                                <div>
                                    <p class="font-bold">Dark Mode</p>
                                    <p class="text-xs text-slate-400">Toggle application theme</p>
                                </div>
                            </div>
                            <button id="settingsThemeToggle" onclick="toggleDarkMode()"
                                class="w-12 h-6 bg-slate-200 dark:bg-primary rounded-full relative transition-colors">
                                <div
                                    class="absolute top-1 left-1 dark:left-7 w-4 h-4 bg-white rounded-full transition-all">
                                </div>
                            </button>
                        </div>
                    </section>
                </div>
            </div>
