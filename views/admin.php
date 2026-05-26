            <div id="view-admin" class="view-content hidden">
                <header class="mb-12">
                    <h2 class="text-4xl font-black text-slate-900 dark:text-white mb-2">Management</h2>
                    <p class="text-slate-500">Control and modify your habit data architecture.</p>
                </header>
                <div
                    class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
                    <div class="p-8 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                        <h3 class="font-bold">Habit Database</h3>
                        <button class="text-sm text-primary font-bold hover:underline" onclick="clearAllHabits()">Clear
                            All Data</button>
                    </div>
                    <div class="p-0">
                        <div id="adminHabitTable" class="divide-y divide-slate-100 dark:divide-slate-800">
                            <!-- Populated by JS -->
                        </div>
                        <div id="adminEmptyState" class="p-20 text-center">
                            <span
                                class="material-symbols-outlined text-6xl text-slate-200 dark:text-slate-800 mb-4">database_off</span>
                            <p class="text-slate-400">No data entries found.</p>
                        </div>
                    </div>
                </div>
            </div>
