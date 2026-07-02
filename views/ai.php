<style>
/* AI Page Animations */
@keyframes ai-float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
}
@keyframes ai-pulse-glow {
    0%, 100% { box-shadow: 0 0 20px rgba(139, 92, 246, 0.3); }
    50% { box-shadow: 0 0 50px rgba(139, 92, 246, 0.6); }
}
@keyframes chatSlideUp {
    from { opacity: 0; transform: translateY(20px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.chat-animate {
    animation: chatSlideUp 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}
.ai-orb {
    animation: ai-float 6s ease-in-out infinite, ai-pulse-glow 4s ease-in-out infinite;
}
.glass-chat-container {
    background: rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(255, 255, 255, 0.4);
}
.dark .glass-chat-container {
    background: rgba(15, 23, 42, 0.4);
    border-color: rgba(255, 255, 255, 0.05);
}
</style>

<div id="view-ai" class="view-content hidden relative min-h-[80vh] flex flex-col items-center justify-center py-10">
    
    <!-- Background Animated Orbs -->
    <div class="absolute top-1/4 left-1/4 w-[400px] h-[400px] bg-purple-500/10 rounded-full blur-[100px] pointer-events-none -z-10 ai-orb" style="animation-delay: 0s;"></div>
    <div class="absolute bottom-1/4 right-1/4 w-[300px] h-[300px] bg-blue-500/10 rounded-full blur-[80px] pointer-events-none -z-10 ai-orb" style="animation-delay: 2s; animation-duration: 8s;"></div>

    <header class="mb-6 text-center flex flex-col items-center">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white mb-4 shadow-xl shadow-purple-500/30 ai-orb relative">
            <div class="absolute inset-0 rounded-2xl bg-white/20 blur-md"></div>
            <span class="material-symbols-outlined text-3xl relative z-10 animate-pulse">robot_2</span>
        </div>
        <h1 class="text-3xl lg:text-4xl font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-500 dark:from-purple-400 dark:to-blue-400 mb-2">
            Gemini AI
        </h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 max-w-lg leading-relaxed">
            Asisten personal Anda untuk wawasan kesehatan, produktivitas, dan perencanaan rutinitas.
        </p>
    </header>

    <div class="w-full max-w-5xl flex flex-col h-[65vh] min-h-[550px]">
        <div class="glass-chat-container rounded-[2rem] shadow-2xl flex flex-col flex-1 overflow-hidden transition-all duration-500 hover:shadow-purple-500/10 hover:border-purple-500/30">
            <div id="aiChatBox" class="flex-1 p-6 md:p-8 overflow-y-auto space-y-6 custom-scrollbar scroll-smooth">
                <!-- AI Message -->
                <div class="flex gap-4 chat-animate">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-blue-500 text-white flex items-center justify-center shrink-0 shadow-lg shadow-purple-500/20">
                        <span class="material-symbols-outlined text-lg animate-spin" style="animation-duration: 4s;">auto_awesome</span>
                    </div>
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm p-4 rounded-2xl rounded-tl-none border border-slate-200 dark:border-slate-700/50 shadow-sm max-w-[85%] hover:-translate-y-1 transition-transform">
                        <p class="text-slate-800 dark:text-slate-200 text-sm leading-relaxed font-medium">Halo! Saya Gemini. Ada yang bisa saya bantu terkait kesehatan, olahraga, atau gaya hidup hari ini?</p>
                    </div>
                </div>
            </div>
            
            <div class="p-4 md:p-6 border-t border-slate-200/50 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/50 backdrop-blur-md">
                <div class="relative group">
                    <input type="text" id="aiInput" placeholder="Ketik pesan Anda di sini..." 
                        class="w-full pl-6 pr-16 py-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-purple-500/30 focus:border-purple-500 transition-all text-slate-800 dark:text-white shadow-inner text-sm font-medium"
                        onkeypress="if(event.key === 'Enter') askAI()">
                    <button onclick="askAI()" id="aiSendBtn" class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 bg-gradient-to-br from-purple-500 to-blue-500 text-white rounded-xl flex items-center justify-center hover:scale-105 transition-all shadow-lg shadow-purple-500/25 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed group-focus-within:animate-pulse">
                        <span class="material-symbols-outlined text-xl">send</span>
                    </button>
                </div>
                <p class="text-center text-[10px] text-slate-400 mt-3 uppercase tracking-widest font-bold opacity-50">Gemini can make mistakes. Consider verifying important information.</p>
            </div>
        </div>
    </div>
</div>
