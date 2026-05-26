            <div id="view-dashboard" class="view-content">
                <header class="mb-16 max-w-4xl">
                    <h1 class="text-5xl lg:text-6xl font-headline font-black tracking-[-0.04em] text-on-surface mb-4 dark:text-white"
                        id="greetingText">
                        Good Morning.
                    </h1>
                    <p class="text-xl text-on-surface-variant max-w-2xl leading-relaxed dark:text-slate-400">
                        Here is your digital concierge for daily habits. We predict and organize so you can focus on
                        execution.
                    </p>
                </header>
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-12">
                    <!-- Left Column: User Panel -->
                    <div class="xl:col-span-7 space-y-12">
                        <!-- Form Section -->
                        <section
                            class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800">
                            <h2
                                class="text-sm font-label font-bold uppercase tracking-[0.1em] text-on-surface-variant mb-6 dark:text-slate-500">
                                User Panel</h2>
                            <div
                                class="bg-slate-50 dark:bg-slate-800/50 p-8 rounded-2xl relative overflow-hidden group border border-slate-100 dark:border-slate-800">
                                <div class="flex flex-col md:flex-row gap-6 items-end w-full">
                                    <div class="flex-1 w-full">
                                        <label
                                            class="block text-xs font-medium text-on-surface-variant mb-2 dark:text-slate-400">Aktivitas</label>
                                        <input
                                            class="w-full bg-transparent border-0 border-b border-slate-200 dark:border-slate-700 focus:ring-0 focus:border-b-2 focus:border-primary px-0 py-2 text-on-surface dark:text-white placeholder:text-slate-400 transition-all"
                                            id="activityInput" placeholder="e.g. Read a book" type="text" />
                                    </div>
                                    <div class="w-full md:w-40 shrink-0">
                                        <label
                                            class="block text-xs font-medium text-on-surface-variant mb-2 dark:text-slate-400 text-center md:text-left">Waktu</label>
                                        <input
                                            class="w-full bg-transparent border-0 border-b border-slate-200 dark:border-slate-700 focus:ring-0 focus:border-b-2 focus:border-primary px-0 py-2 text-on-surface dark:text-white placeholder:text-slate-400 transition-all text-center md:text-left"
                                            id="timeInput" type="time" />
                                    </div>
                                    <div class="w-full md:w-auto shrink-0">
                                        <button
                                            class="w-full md:w-auto bg-gradient-to-br from-primary to-primary-container text-on-primary px-8 py-3 rounded-xl font-medium shadow-lg shadow-primary/20 hover:scale-105 transition-transform whitespace-nowrap"
                                            onclick="addHabit()">
                                            Tambah Kebiasaan
                                        </button>
                                    </div>
                                </div>
                                <!-- Rekomendasi Area -->
                                <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700 hidden"
                                    id="recommendationArea">
                                    <p
                                        class="text-sm text-on-surface-variant dark:text-slate-400 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-sm"
                                            style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                                        <span id="recommendationText">Rekomendasi: ...</span>
                                    </p>
                                </div>
                            </div>
                        </section>
                        <!-- User List Section -->
                        <section>
                            <div
                                class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 ml-4">
                                <h3
                                    class="text-sm font-label font-bold uppercase tracking-[0.1em] text-on-surface-variant dark:text-slate-500">
                                    Daftar Kebiasaan</h3>
                                <div class="relative w-full sm:w-64">
                                    <span
                                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                                    <input type="text" id="habitSearch" placeholder="Search habits..."
                                        class="w-full pl-10 pr-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                        oninput="renderUserList()">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="userHabitList">
                                <!-- Populated by JS -->
                            </div>
                        </section>
                    </div>
                    <!-- Right Column: Quick Stats -->
                    <div class="xl:col-span-5 space-y-8">
                        <!-- Weather Widget -->
                        <section
                            class="bg-gradient-to-br from-blue-600 to-blue-400 p-8 rounded-[2rem] shadow-xl text-white relative overflow-hidden group">
                            <div
                                class="absolute -right-10 -top-10 opacity-20 group-hover:rotate-12 transition-transform duration-700">
                                <span class="material-symbols-outlined text-[12rem]"
                                    id="dashWeatherIconLarge">sunny</span>
                            </div>
                            <div class="relative z-10">
                                <div class="flex justify-between items-start mb-12">
                                    <div>
                                        <h3 class="text-3xl font-black" id="dashTemp">--°C</h3>
                                        <p class="text-xs font-bold uppercase tracking-widest text-blue-100"
                                            id="dashCondition">Loading Weather...</p>
                                    </div>
                                    <span class="material-symbols-outlined text-4xl" id="dashWeatherIcon">cloud</span>
                                </div>
                                <div class="flex gap-6">
                                    <div class="flex-1 bg-white/20 backdrop-blur-md p-4 rounded-2xl">
                                        <p class="text-[10px] font-bold text-blue-100 uppercase mb-1">Humidity</p>
                                        <p class="text-lg font-bold" id="dashHumidity">--%</p>
                                    </div>
                                    <div class="flex-1 bg-white/20 backdrop-blur-md p-4 rounded-2xl">
                                        <p class="text-[10px] font-bold text-blue-100 uppercase mb-1">Wind Speed</p>
                                        <p class="text-lg font-bold" id="dashWind">-- km/h</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section
                            class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800">
                            <div class="flex justify-between items-center mb-8">
                                <h2
                                    class="text-sm font-label font-bold uppercase tracking-[0.1em] text-on-surface-variant dark:text-slate-500">
                                    Activity Completion</h2>
                                <span class="material-symbols-outlined text-primary">analytics</span>
                            </div>
                            <div class="space-y-6">
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-3xl font-black text-slate-900 dark:text-white"
                                            id="totalHabitsCount">0</p>
                                        <p class="text-xs text-slate-400 uppercase tracking-widest font-bold">Total
                                            Habits</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-3xl font-black text-green-500" id="completionRate">0%</p>
                                        <p class="text-xs text-slate-400 uppercase tracking-widest font-bold">Completion
                                        </p>
                                    </div>
                                </div>
                                <div class="h-2 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                    <div id="completionBar" class="h-full bg-primary transition-all duration-1000"
                                        style="width: 0%"></div>
                                </div>
                            </div>
                        </section>

                        <!-- Upcoming Event Widget -->
                        <section
                            class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800">
                            <h3 class="text-xs font-bold uppercase text-slate-400 mb-6 tracking-widest">Next Competition
                            </h3>
                            <div id="nextEventWidget"
                                class="p-4 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center gap-4">
                                <span class="material-symbols-outlined text-3xl text-primary">emoji_events</span>
                                <div>
                                    <p class="font-bold dark:text-white" id="nextEventName">No events scheduled</p>
                                    <p class="text-xs text-slate-400" id="nextEventDate">-</p>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
