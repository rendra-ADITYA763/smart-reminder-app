            <div id="view-logs" class="view-content hidden">
                <header class="mb-12 flex justify-between items-end">
                    <div>
                        <h2 class="text-4xl font-black text-slate-900 dark:text-white mb-2">Activity Logs</h2>
                        <p class="text-slate-500">Chronological history of your interactions.</p>
                    </div>
                    <button onclick="clearLogs()"
                        class="text-xs font-bold text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 px-4 py-2 rounded-lg transition-colors">Clear
                        Logs</button>
                </header>
                <div
                    class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
                    <div id="logContent"
                        class="divide-y divide-slate-100 dark:divide-slate-800 max-h-[600px] overflow-y-auto">
                        <!-- Logs populated by JS -->
                    </div>
                </div>
            </div>
