            <!-- Weather Concierge View -->
            <div id="view-weather" class="view-content hidden">
                <header class="mb-12">
                    <h2 class="text-4xl font-black text-slate-900 dark:text-white mb-2">Weather Concierge</h2>
                    <p class="text-slate-500">Smart weather-aware activity recommendations.</p>
                </header>
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-12">
                    <div class="xl:col-span-5 space-y-8">
                        <section
                            class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800">
                            <h3 class="font-bold mb-6">Current Location</h3>
                            <div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-800 rounded-2xl mb-6">
                                <span class="material-symbols-outlined text-primary">location_on</span>
                                <div>
                                    <p class="font-bold dark:text-white" id="weatherCity">Jakarta, ID</p>
                                    <p class="text-xs text-slate-400">Automatic Geolocation</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <button onclick="updateWeather()"
                                    class="w-full bg-primary text-white py-4 rounded-xl font-bold flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-sm">refresh</span>
                                    Update Weather
                                </button>
                            </div>
                        </section>
                        <section
                            class="bg-blue-50 dark:bg-blue-900/20 p-8 rounded-[2rem] border border-blue-100 dark:border-blue-800/30">
                            <h3 class="font-bold text-blue-800 dark:text-blue-300 mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">info</span>
                                Smart Context
                            </h3>
                            <p class="text-sm text-blue-700/80 dark:text-blue-400/80 leading-relaxed">
                                I'm monitoring the skies. If you plan outdoor activities like <span
                                    class="font-bold">"lari"</span> or <span class="font-bold">"sepeda"</span>, I'll
                                alert you if conditions aren't optimal.
                            </p>
                        </section>
                    </div>
                    <div class="xl:col-span-7">
                        <div
                            class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 h-full">
                            <h3 class="font-bold mb-8">7-Day Forecast</h3>
                            <div class="space-y-4" id="weatherForecast">
                                <!-- Forecast items here -->
                                <div class="animate-pulse flex gap-4 p-4">
                                    <div class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-xl"></div>
                                    <div class="flex-1 space-y-2">
                                        <div class="h-4 bg-slate-100 dark:bg-slate-800 rounded w-1/2"></div>
                                        <div class="h-2 bg-slate-100 dark:bg-slate-800 rounded w-1/4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
