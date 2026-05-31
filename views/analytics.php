            <div id="view-analytics" class="view-content hidden relative">
                <style>
                    /* Data Flow Animation */
                    @keyframes dataFlow {
                        0% { background-position: 0 0; }
                        100% { background-position: 0 50px; }
                    }
                    .matrix-bg {
                        position: absolute;
                        inset: 0;
                        opacity: 0.05;
                        background-image: linear-gradient(rgba(16, 185, 129, 0.2) 1px, transparent 1px),
                                          linear-gradient(90deg, rgba(16, 185, 129, 0.2) 1px, transparent 1px);
                        background-size: 25px 25px;
                        animation: dataFlow 3s linear infinite;
                        z-index: -1;
                    }
                    
                    /* Chart Bar Animation */
                    @keyframes growUp {
                        0% { transform: scaleY(0); opacity: 0; }
                        100% { transform: scaleY(1); opacity: 1; }
                    }
                    .chart-bar-anim {
                        transform-origin: bottom;
                        animation: growUp 1s cubic-bezier(0.16, 1, 0.3, 1) both;
                    }
                    
                    .glass-chart {
                        background: rgba(255, 255, 255, 0.03);
                        backdrop-filter: blur(20px);
                        border: 1px solid rgba(16, 185, 129, 0.1); /* Emerald tint */
                        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1);
                        position: relative;
                        overflow: hidden;
                    }
                    html.dark .glass-chart {
                        background: rgba(15, 23, 42, 0.4);
                    }

                    /* Holographic Sweep */
                    .holo-sweep::after {
                        content: '';
                        position: absolute;
                        top: 0; left: -100%;
                        width: 50%; height: 100%;
                        background: linear-gradient(to right, transparent, rgba(16, 185, 129, 0.2), transparent);
                        transform: skewX(-20deg);
                        transition: 0.5s;
                    }
                    .glass-chart:hover.holo-sweep::after {
                        left: 200%;
                        transition: 1s ease-in-out;
                    }

                    @keyframes fillBar {
                        0% { width: 0; }
                        100% { width: var(--fill-width); }
                    }
                    .freq-bar-fill {
                        animation: fillBar 1.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                    }
                </style>

                <!-- Data Matrix VFX -->
                <div class="matrix-bg"></div>
                <div class="absolute -top-20 right-20 w-96 h-96 bg-emerald-500/10 rounded-full blur-[150px] pointer-events-none -z-10"></div>
                <div class="absolute bottom-10 left-10 w-[500px] h-[500px] bg-teal-500/10 rounded-full blur-[150px] pointer-events-none -z-10"></div>

                <header class="mb-12 relative z-10">
                    <h2 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-500 mb-3 tracking-tight drop-shadow-sm">Analytics Matrix</h2>
                    <p class="text-slate-500 dark:text-slate-400 font-medium text-lg">Visualizing your behavioral distribution and quantum patterns.</p>
                </header>

                <div class="grid grid-cols-1 xl:grid-cols-2 gap-10 relative z-10">
                    <!-- Left: Hourly Chart -->
                    <div class="glass-chart holo-sweep p-8 rounded-[2.5rem]">
                        <div class="flex justify-between items-center mb-10">
                            <h3 class="font-bold text-xl dark:text-white flex items-center gap-3">
                                <span class="material-symbols-outlined text-emerald-500">bar_chart</span>
                                Temporal Distribution
                            </h3>
                            <div class="px-3 py-1 bg-emerald-500/10 text-emerald-500 text-xs font-bold rounded-full uppercase tracking-widest animate-pulse">Live Feed</div>
                        </div>

                        <div class="relative">
                            <!-- Background Grid Lines -->
                            <div class="absolute inset-0 flex flex-col justify-between opacity-10 pointer-events-none">
                                <div class="border-b border-emerald-500 w-full h-0"></div>
                                <div class="border-b border-emerald-500 w-full h-0"></div>
                                <div class="border-b border-emerald-500 w-full h-0"></div>
                                <div class="border-b border-emerald-500 w-full h-0"></div>
                            </div>

                            <div class="h-64 flex items-end gap-1.5 md:gap-3 px-2 relative z-10" id="hourlyChart">
                                <!-- Bars generated by JS -->
                            </div>
                        </div>
                        
                        <div class="flex justify-between text-[10px] font-bold tracking-widest uppercase text-slate-400 dark:text-slate-500 mt-6 px-2">
                            <span>Midnight</span>
                            <span>Noon</span>
                            <span>Late</span>
                        </div>
                    </div>

                    <!-- Right: Frequency -->
                    <div class="glass-chart holo-sweep p-8 rounded-[2.5rem]">
                        <h3 class="font-bold text-xl dark:text-white mb-10 flex items-center gap-3">
                            <span class="material-symbols-outlined text-teal-500">query_stats</span>
                            Behavioral Frequency
                        </h3>
                        <div class="space-y-6" id="frequencyList">
                            <!-- Top activities -->
                        </div>
                    </div>
                </div>
            </div>
