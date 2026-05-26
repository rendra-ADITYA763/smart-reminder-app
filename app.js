        // Data Structure
        let habits = [];
        let logs = [];
        let schedule = [];
        let events = [];
        let weatherData = JSON.parse(localStorage.getItem('weatherData')) || null;
        let userProfile = { name: 'Stranger' };
        let currentTheme = localStorage.getItem('theme') || 'light';

        // Apply theme immediately to prevent flashing
        if (currentTheme === 'dark') document.documentElement.classList.add('dark');
        else document.documentElement.classList.remove('dark');

        // DOM Elements
        const activityInput = document.getElementById('activityInput');
        const timeInput = document.getElementById('timeInput');
        const recommendationArea = document.getElementById('recommendationArea');
        const recommendationText = document.getElementById('recommendationText');
        const userHabitList = document.getElementById('userHabitList');
        const adminEmptyState = document.getElementById('adminEmptyState');
        const adminHabitTable = document.getElementById('adminHabitTable');
        const greetingText = document.getElementById('greetingText');
        const userNameInput = document.getElementById('userNameInput');
        const darkModeToggle = document.getElementById('darkModeToggle');
        const settingsThemeToggle = document.getElementById('settingsThemeToggle');

        // Initialize
        async function init() {
            applyTheme();
            
            try {
                const res = await fetch('api/get_all.php');
                const data = await res.json();
                habits = data.habits || [];
                schedule = data.schedule || [];
                events = data.events || [];
                logs = data.logs || [];
                if (data.profile) userProfile = data.profile;
            } catch (e) {
                console.error("Failed to load data from DB", e);
            }

            updateGreeting();
            updateWeather();
            renderUI();
            setInterval(checkReminder, 5000);
            setInterval(updateWeather, 600000); // Update every 10 mins

            if (activityInput) activityInput.addEventListener('input', simulatePrediction);
            if (userNameInput) userNameInput.value = userProfile.name;
        }

        // Core Functions
        function toggleDarkMode() {
            currentTheme = currentTheme === 'light' ? 'dark' : 'light';
            localStorage.setItem('theme', currentTheme);
            applyTheme();
        }

        function applyTheme() {
            if (currentTheme === 'dark') {
                document.documentElement.classList.add('dark');
                if (darkModeToggle) darkModeToggle.innerHTML = '<span class="material-symbols-outlined">light_mode</span>';
            } else {
                document.documentElement.classList.remove('dark');
                if (darkModeToggle) darkModeToggle.innerHTML = '<span class="material-symbols-outlined">dark_mode</span>';
            }
            addLog('System', `Theme applied: ${currentTheme}`);
        }

        function updateGreeting() {
            const hour = new Date().getHours();
            let greet = "Good Morning";
            if (hour >= 12 && hour < 17) greet = "Good Afternoon";
            else if (hour >= 17) greet = "Good Evening";
            greetingText.innerHTML = `${greet}, <span class="text-primary">${userProfile.name}.</span>`;
        }

        function updateProfile() {
            userProfile.name = userNameInput.value || 'Stranger';
            fetch('api/sync.php?type=profile', { method: 'POST', body: JSON.stringify(userProfile) });
            updateGreeting();
            addLog('System', `Updated profile name to ${userProfile.name}`);
        }

        function clearLogs() {
            if (confirm('Clear all activity logs?')) {
                logs = [];
                fetch('api/sync.php?type=logs', { method: 'POST', body: JSON.stringify(logs) });
                renderLogs();
            }
        }

        function saveHabits() { fetch('api/sync.php?type=habits', { method: 'POST', body: JSON.stringify(habits) }); }
        function saveSchedule() { fetch('api/sync.php?type=schedule', { method: 'POST', body: JSON.stringify(schedule) }); }
        function saveEvents() { fetch('api/sync.php?type=events', { method: 'POST', body: JSON.stringify(events) }); }

        function addLog(type, message) {
            logs.unshift({ type, message, time: new Date().toISOString() });
            if (logs.length > 50) logs.pop();
            fetch('api/sync.php?type=logs', { method: 'POST', body: JSON.stringify(logs) });
            renderLogs();
        }

        // Habit Functions
        function formatAMPM(time) {
            if (!time && time !== 0) return '--.--';
            let h, m;
            if (typeof time === 'number') { h = time; m = 0; }
            else { [h, m] = time.split(':').map(Number); }
            const ampm = h >= 12 ? 'pm' : 'am';
            h = h % 12; h = h ? h : 12;
            return `${h.toString().padStart(2, '0')}.${m.toString().padStart(2, '0')} ${ampm}`;
        }

        function addHabit() {
            const activity = activityInput.value.trim();
            const time = timeInput.value;
            if (!activity || !time) return;
            habits.push({ activity, time, lastNotified: '', completedToday: false });
            saveHabits();
            addLog('Habit', `Added habit: ${activity}`);
            activityInput.value = ''; timeInput.value = '';
            renderUI();
        }

        function deleteHabit(index) {
            habits.splice(index, 1);
            saveHabits();
            renderUI();
        }

        function toggleComplete(index) {
            habits[index].completedToday = !habits[index].completedToday;
            saveHabits();
            renderUI();
        }

        // Schedule Functions
        function addClass() {
            const subject = document.getElementById('schedSubject').value;
            const day = document.getElementById('schedDay').value;
            const time = document.getElementById('schedTime').value;
            if (!subject || !time) return;
            schedule.push({ subject, day, time });
            saveSchedule();
            addLog('Schedule', `Added class: ${subject} on ${day}`);
            document.getElementById('schedSubject').value = '';
            renderUI();
        }

        function deleteClass(index) {
            schedule.splice(index, 1);
            saveSchedule();
            renderUI();
        }

        // Event Functions
        function addEvent() {
            const name = document.getElementById('eventName').value;
            const date = document.getElementById('eventDate').value;
            const loc = document.getElementById('eventLoc').value;
            if (!name || !date) return;
            events.push({ name, date, loc });
            saveEvents();
            addLog('Event', `Registered event: ${name}`);
            document.getElementById('eventName').value = '';
            renderUI();
        }

        function deleteEvent(index) {
            events.splice(index, 1);
            saveEvents();
            renderUI();
        }

        function renderSchedule() {
            const grid = document.getElementById('scheduleGrid');
            if (!grid) return;
            grid.innerHTML = '';
            const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            days.forEach(dayName => {
                const dayClasses = schedule.filter(s => s.day === dayName).sort((a, b) => a.time.localeCompare(b.time));
                const col = document.createElement('div');
                col.className = "bg-white dark:bg-slate-900 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm";
                col.innerHTML = `<h4 class="text-xs font-black uppercase text-slate-400 mb-4 tracking-widest">${dayName}</h4>`;
                const list = document.createElement('div');
                list.className = "space-y-3";
                dayClasses.forEach((c) => {
                    const item = document.createElement('div');
                    item.className = "p-4 bg-slate-50 dark:bg-slate-800 rounded-xl relative group border border-transparent hover:border-primary/20 transition-all";
                    item.innerHTML = `
                        <div class="pr-8">
                            <p class="font-bold text-sm dark:text-white">${c.subject}</p>
                            <p class="text-[10px] text-primary font-bold uppercase">${c.time}</p>
                        </div>
                        <button onclick="deleteClass(${schedule.indexOf(c)})" class="absolute top-3 right-3 text-slate-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-all">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </button>
                    `;
                    list.appendChild(item);
                });
                if (dayClasses.length === 0) col.innerHTML += `<p class="text-[10px] text-slate-300 italic px-1">No classes scheduled</p>`;
                col.appendChild(list);
                grid.appendChild(col);
            });
        }

        function renderEvents() {
            const tbody = document.getElementById('eventTableBody');
            if (!tbody) return;
            tbody.innerHTML = '';
            events.sort((a, b) => new Date(a.date) - new Date(b.date)).forEach((e) => {
                const row = document.createElement('tr');
                row.className = "hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group";
                row.innerHTML = `
                    <td class="p-6 font-bold dark:text-white">${e.name}</td>
                    <td class="p-6 text-sm text-slate-500">${e.date}</td>
                    <td class="p-6 text-sm text-slate-500">${e.loc}</td>
                    <td class="p-6">
                        <button onclick="deleteEvent(${events.indexOf(e)})" class="text-slate-300 hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 p-2 rounded-lg transition-all">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        // Weather Integration Functions
        async function updateWeather() {
            try {
                // Fetch using our new PHP backend API
                const res = await fetch('api/weather.php');
                const data = await res.json();
                
                if (data.error) throw new Error(data.error);

                weatherData = data;
                localStorage.setItem('weatherData', JSON.stringify(data));
                renderUI();
                addLog('Weather', 'Updated real-time weather data via Backend API');
            } catch (e) {
                console.error("Weather fetch failed", e);
            }
        }

        function getWeatherIcon(code) {
            if (code === 0) return 'sunny';
            if (code <= 3) return 'partly_cloudy_day';
            if (code <= 48) return 'foggy';
            if (code <= 67) return 'rainy';
            if (code <= 77) return 'snowing';
            return 'thunderstorm';
        }

        function getWeatherText(code) {
            if (code === 0) return 'Clear Sky';
            if (code <= 3) return 'Partly Cloudy';
            if (code <= 48) return 'Foggy';
            if (code <= 67) return 'Rainy';
            if (code <= 77) return 'Snowy';
            return 'Thunderstorm';
        }

        function checkWeatherForActivity(activity) {
            if (!weatherData) return null;
            const code = weatherData.current.weather_code;
            const isRainy = code >= 51;
            const act = activity.toLowerCase();

            if ((act.includes('lari') || act.includes('run') || act.includes('sepeda') || act.includes('outdoor')) && isRainy) {
                return {
                    status: 'Warning',
                    message: 'Waspada: Cuaca sedang hujan/buruk untuk aktivitas luar ruangan.'
                };
            }
            return null;
        }

        // View Logic
        function switchView(viewId) {
            document.querySelectorAll('.view-content').forEach(v => v.classList.add('hidden'));
            document.getElementById(`view-${viewId}`).classList.remove('hidden');
            document.querySelectorAll('.nav-link, .sidebar-link').forEach(l => {
                l.classList.remove('active', 'text-blue-700', 'dark:text-blue-400', 'font-semibold', 'border-b-2', 'border-blue-700', 'bg-white', 'dark:bg-slate-900', 'shadow-sm');
                l.classList.add('text-slate-500', 'dark:text-slate-400');
            });
            const activeLinks = document.querySelectorAll(`[onclick="switchView('${viewId}')"]`);
            activeLinks.forEach(l => {
                l.classList.add('active', 'text-blue-700', 'dark:text-blue-400', 'font-semibold');
                if (l.classList.contains('sidebar-link')) l.classList.add('bg-white', 'dark:bg-slate-900', 'shadow-sm');
                else l.classList.add('border-b-2', 'border-blue-700');
                l.classList.remove('text-slate-500', 'dark:text-slate-400');
            });
            renderUI();
        }

        // Rendering Logic
        function renderUI() {
            renderUserList();
            renderAdminList();
            renderLogs();
            renderAnalytics();
            updateStats();
            renderSchedule();
            renderEvents();
            renderWeather();
        }

        function updateStats() {
            document.getElementById('totalHabitsCount').textContent = habits.length;
            const completed = habits.filter(h => h.completedToday).length;
            const rate = habits.length ? Math.round((completed / habits.length) * 100) : 0;
            document.getElementById('completionRate').textContent = `${rate}%`;
            document.getElementById('completionBar').style.width = `${rate}%`;

            // Dashboard Weather Update
            if (weatherData) {
                const cur = weatherData.current;
                document.getElementById('dashTemp').textContent = `${Math.round(cur.temperature_2m)}°C`;
                document.getElementById('dashCondition').textContent = getWeatherText(cur.weather_code);
                document.getElementById('dashHumidity').textContent = `${cur.relative_humidity_2m}%`;
                document.getElementById('dashWind').textContent = `${cur.wind_speed_10m} km/h`;

                const icon = getWeatherIcon(cur.weather_code);
                document.getElementById('dashWeatherIcon').textContent = icon;
                document.getElementById('dashWeatherIconLarge').textContent = icon;
            }

            const upcoming = events.sort((a, b) => new Date(a.date) - new Date(b.date))[0];
            if (upcoming) {
                document.getElementById('nextEventName').textContent = upcoming.name;
                document.getElementById('nextEventDate').textContent = upcoming.date;
            }
        }

        function renderWeather() {
            if (!weatherData) return;
            const forecastContainer = document.getElementById('weatherForecast');
            forecastContainer.innerHTML = '';

            weatherData.daily.time.forEach((time, i) => {
                const item = document.createElement('div');
                item.className = "flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800 rounded-2xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors";
                const date = new Date(time).toLocaleDateString([], { weekday: 'long', month: 'short', day: 'numeric' });
                const icon = getWeatherIcon(weatherData.daily.weather_code[i]);

                item.innerHTML = `
                    <div class="flex items-center gap-4">
                        <span class="material-symbols-outlined text-primary text-2xl">${icon}</span>
                        <div>
                            <p class="font-bold dark:text-white">${date}</p>
                            <p class="text-[10px] text-slate-400 uppercase font-black">${getWeatherText(weatherData.daily.weather_code[i])}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-black text-slate-900 dark:text-white">${Math.round(weatherData.daily.temperature_2m_max[i])}°</p>
                        <p class="text-[10px] text-slate-400">${Math.round(weatherData.daily.temperature_2m_min[i])}°</p>
                    </div>
                `;
                forecastContainer.appendChild(item);
            });
        }

        function renderUserList() {
            const searchQuery = document.getElementById('habitSearch').value.toLowerCase();
            userHabitList.innerHTML = '';
            const filteredHabits = habits.filter(h => h.activity.toLowerCase().includes(searchQuery));
            if (filteredHabits.length === 0) {
                userHabitList.innerHTML = `<div class="col-span-full p-8 text-center text-slate-400">No habits match your search.</div>`;
                return;
            }
            filteredHabits.forEach((habit) => {
                const index = habits.findIndex(h => h === habit);
                const card = document.createElement('div');
                card.className = "bg-white dark:bg-slate-900 p-6 rounded-2xl relative group hover:shadow-xl transition-all flex items-center justify-between border border-slate-100 dark:border-slate-800";
                card.innerHTML = `
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-12 rounded-xl bg-primary/10 flex flex-col items-center justify-center text-primary">
                            <span class="text-sm font-black">${formatAMPM(habit.time !== undefined ? habit.time : habit.hour)}</span>
                            <span class="text-[8px] font-bold uppercase">Time</span>
                        </div>
                        <div>
                            <h4 class="text-on-surface dark:text-white font-bold ${habit.completedToday ? 'line-through opacity-50' : ''}">${habit.activity}</h4>
                            <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Scheduled</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button onclick="deleteHabit(${index})" class="w-8 h-8 rounded-lg text-slate-300 hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center justify-center transition-all opacity-0 group-hover:opacity-100">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                        <button onclick="toggleComplete(${index})" class="w-10 h-10 rounded-xl border-2 transition-all flex items-center justify-center ${habit.completedToday ? 'bg-green-500 border-green-500 text-white shadow-lg shadow-green-500/20' : 'border-slate-200 dark:border-slate-700 text-transparent hover:border-primary/50'}">
                            <span class="material-symbols-outlined text-lg font-bold">${habit.completedToday ? 'done_all' : 'check'}</span>
                        </button>
                    </div>
                `;
                userHabitList.appendChild(card);
            });
        }

        function renderAdminList() {
            adminHabitTable.innerHTML = '';
            if (habits.length === 0) {
                adminEmptyState.classList.remove('hidden');
                return;
            }
            adminEmptyState.classList.add('hidden');
            habits.forEach((habit, index) => {
                const row = document.createElement('div');
                row.className = "flex items-center justify-between p-6 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors";
                row.innerHTML = `
                    <div class="flex items-center gap-4">
                        <div class="text-xs font-bold text-slate-400 w-8">${index + 1}</div>
                        <div>
                            <p class="font-bold text-on-surface dark:text-white">${habit.activity}</p>
                            <p class="text-[10px] text-slate-400 uppercase font-black">${formatAMPM(habit.time !== undefined ? habit.time : habit.hour)}</p>
                        </div>
                    </div>
                    <button onclick="deleteHabit(${index})" class="p-2 text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                `;
                adminHabitTable.appendChild(row);
            });
        }

        function renderLogs() {
            const container = document.getElementById('logContent');
            container.innerHTML = logs.length ? '' : '<p class="p-12 text-center text-slate-400">No activity logs yet.</p>';
            logs.forEach(log => {
                const item = document.createElement('div');
                item.className = "p-4 flex items-start gap-4";
                const time = new Date(log.time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                item.innerHTML = `
                    <div class="w-2 h-2 rounded-full mt-1.5 ${log.type === 'Habit' ? 'bg-primary' : log.type === 'Action' ? 'bg-green-500' : 'bg-slate-400'}"></div>
                    <div class="flex-1">
                        <p class="text-sm dark:text-slate-300"><span class="font-bold">${log.type}:</span> ${log.message}</p>
                        <p class="text-[10px] text-slate-400">${time}</p>
                    </div>
                `;
                container.appendChild(item);
            });
        }

        function renderAnalytics() {
            const chart = document.getElementById('hourlyChart');
            chart.innerHTML = '';
            const hours = new Array(24).fill(0);
            habits.forEach(h => {
                const hr = typeof h.time === 'string' ? parseInt(h.time.split(':')[0]) : h.hour;
                if (!isNaN(hr)) hours[hr]++;
            });
            const max = Math.max(...hours, 1);
            hours.forEach((count, i) => {
                const height = (count / max) * 100;
                const bar = document.createElement('div');
                bar.className = `flex-1 rounded-t-sm transition-all duration-500 ${count > 0 ? 'bg-primary' : 'bg-slate-100 dark:bg-slate-800'}`;
                bar.style.height = `${Math.max(height, 2)}%`;
                bar.title = `${i}:00 - ${count} habits`;
                chart.appendChild(bar);
            });
            const freqList = document.getElementById('frequencyList');
            freqList.innerHTML = '';
            const activityCounts = {};
            habits.forEach(h => activityCounts[h.activity] = (activityCounts[h.activity] || 0) + 1);
            Object.entries(activityCounts).sort((a, b) => b[1] - a[1]).slice(0, 5).forEach(([name, count]) => {
                const item = document.createElement('div');
                item.className = "flex justify-between items-center p-3 bg-slate-50 dark:bg-slate-800 rounded-xl";
                item.innerHTML = `<span class="text-sm font-medium dark:text-slate-300">${name}</span><span class="bg-primary/10 text-primary text-[10px] font-bold px-2 py-1 rounded-full">${count}x</span>`;
                freqList.appendChild(item);
            });
        }

        function checkReminder() {
            const now = new Date();
            const hr = now.getHours().toString().padStart(2, '0');
            const mn = now.getMinutes().toString().padStart(2, '0');
            const currentStr = `${hr}:${mn}`;
            
            habits.forEach((habit, index) => {
                const hTime = typeof habit.time === 'string' ? habit.time : `${habit.hour.toString().padStart(2, '0')}:00`;
                if (hTime === currentStr && habit.lastNotified !== currentStr) {
                    showNotification(habit.activity);
                    habits[index].lastNotified = currentStr;
                    saveHabits();
                }
            });
        }

        function showNotification(activity) {
            const list = document.getElementById('notificationList');
            if (list.innerHTML.includes('No new notifications')) list.innerHTML = '';
            const item = document.createElement('div');
            item.className = "p-2 bg-primary/5 rounded-lg border-l-2 border-primary mb-2";
            item.innerHTML = `<p class="font-bold">It's time!</p><p>${activity}</p>`;
            list.prepend(item);
            alert(`Waktunya: ${activity}`);
        }

        function simulatePrediction(e) {
            const val = e.target.value.toLowerCase();
            if (val.length > 2) {
                const weatherCheck = checkWeatherForActivity(val);
                if (weatherCheck) {
                    showRecommendation(weatherCheck.message, 'warning');
                    return;
                }

                if (val.includes('makan')) showRecommendation('Sering dilakukan pada jam 12:00 atau 19:00');
                else if (val.includes('tidur')) showRecommendation('Sering dilakukan pada jam 22:00');
                else if (val.includes('olahraga')) showRecommendation('Sering dilakukan pada jam 06:00 atau 16:00');
                else recommendationArea.classList.add('hidden');
            } else recommendationArea.classList.add('hidden');
        }

        function showRecommendation(text, type = 'info') {
            recommendationText.textContent = `Rekomendasi: ${text}`;
            if (type === 'warning') {
                recommendationArea.classList.remove('hidden');
                recommendationArea.className = "mt-6 pt-6 border-t border-red-200 dark:border-red-900 animate-pulse";
                recommendationText.className = "text-sm text-red-600 dark:text-red-400 flex items-center gap-2";
            } else {
                recommendationArea.classList.remove('hidden');
                recommendationArea.className = "mt-6 pt-6 border-t border-slate-200 dark:border-slate-700";
                recommendationText.className = "text-sm text-on-surface-variant dark:text-slate-400 flex items-center gap-2";
            }
        }

        function generatePrediction() {
            const suggestions = ["Meditation at 06:00", "Deep Work at 09:00", "Hydration at 14:00", "Review at 17:00", "Detox at 21:00"];
            const random = suggestions[Math.floor(Math.random() * suggestions.length)];
            const [act, time] = random.split(' at ');
            activityInput.value = act; timeInput.value = time;
            switchView('dashboard');
            addLog('AI', `Generated: ${random}`);
        }

        function clearAllHabits() {
            if (confirm('Clear all data?')) {
                habits = []; schedule = []; events = [];
                saveHabits(); saveSchedule(); saveEvents();
                renderUI();
            }
        }

        function showAddModal() { switchView('dashboard'); activityInput.focus(); }

        async function askAI() {
            const input = document.getElementById('aiInput');
            const btn = document.getElementById('aiSendBtn');
            const chatBox = document.getElementById('aiChatBox');
            const prompt = input.value.trim();
            if (!prompt) return;

            // Add User Message
            const userMsg = document.createElement('div');
            userMsg.className = "flex gap-4 flex-row-reverse";
            userMsg.innerHTML = `
                <div class="w-10 h-10 rounded-xl bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-lg">person</span>
                </div>
                <div class="bg-primary text-white p-4 rounded-2xl rounded-tr-none shadow-sm max-w-[85%]">
                    <p class="text-sm leading-relaxed">${prompt}</p>
                </div>
            `;
            chatBox.appendChild(userMsg);
            input.value = '';
            chatBox.scrollTop = chatBox.scrollHeight;

            // Loading state
            btn.disabled = true;
            btn.innerHTML = `<span class="material-symbols-outlined text-xl animate-spin">refresh</span>`;

            try {
                const res = await fetch('api/gemini.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ prompt })
                });
                const data = await res.json();
                
                let replyText = data.reply || data.error || "Maaf, terjadi kesalahan.";

                // Format simple markdown (e.g., **bold**, *italic*)
                replyText = replyText.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                                     .replace(/\*(.*?)\*/g, '<em>$1</em>')
                                     .replace(/\n/g, '<br>');

                const aiMsg = document.createElement('div');
                aiMsg.className = "flex gap-4";
                aiMsg.innerHTML = `
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-primary-container text-white flex items-center justify-center shrink-0 shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined text-lg">auto_awesome</span>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-800/80 p-4 rounded-2xl rounded-tl-none border border-slate-100 dark:border-slate-700 shadow-sm max-w-[85%]">
                        <p class="text-on-surface dark:text-slate-200 text-sm leading-relaxed">${replyText}</p>
                    </div>
                `;
                chatBox.appendChild(aiMsg);

                addLog('AI Chat', `Tanya seputar: ${prompt.substring(0, 20)}...`);
            } catch (err) {
                console.error(err);
            }

            btn.disabled = false;
            btn.innerHTML = `<span class="material-symbols-outlined text-xl">send</span>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        init();
