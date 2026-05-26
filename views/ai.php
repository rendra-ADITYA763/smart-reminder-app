            <div id="view-ai" class="view-content hidden">
                <header class="mb-12">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-2xl">robot_2</span>
                        </div>
                        <h1 class="text-4xl lg:text-5xl font-headline font-black tracking-[-0.04em] text-on-surface dark:text-white">
                            Gemini AI Assistant
                        </h1>
                    </div>
                    <p class="text-xl text-on-surface-variant max-w-2xl leading-relaxed dark:text-slate-400">
                        Ask any questions regarding health, sports, or your daily routines. Powered by Google Gemini.
                    </p>
                </header>

                <div class="w-full max-w-7xl bg-white dark:bg-slate-900 rounded-[2rem] shadow-xl border border-slate-100 dark:border-slate-800 flex flex-col h-[75vh] min-h-[600px] overflow-hidden">
                    <div id="aiChatBox" class="flex-1 p-6 md:p-8 overflow-y-auto space-y-6 custom-scrollbar">
                        <!-- AI Message -->
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-primary-container text-white flex items-center justify-center shrink-0 shadow-lg shadow-primary/20">
                                <span class="material-symbols-outlined text-lg">auto_awesome</span>
                            </div>
                            <div class="bg-slate-50 dark:bg-slate-800/80 p-4 rounded-2xl rounded-tl-none border border-slate-100 dark:border-slate-700 shadow-sm max-w-[85%]">
                                <p class="text-on-surface dark:text-slate-200 text-sm leading-relaxed">Halo! Saya adalah asisten AI Anda yang ditenagai oleh Google Gemini. Ada yang bisa saya bantu terkait kesehatan, olahraga, atau gaya hidup hari ini?</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 md:p-6 border-t border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                        <div class="relative">
                            <input type="text" id="aiInput" placeholder="Tanya seputar olahraga, diet..." 
                                class="w-full pl-6 pr-16 py-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-on-surface dark:text-white shadow-sm text-sm"
                                onkeypress="if(event.key === 'Enter') askAI()">
                            <button onclick="askAI()" id="aiSendBtn" class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center hover:scale-105 transition-all shadow-lg shadow-primary/20 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span class="material-symbols-outlined text-xl">send</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
