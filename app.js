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
            const displayName = (typeof SESSION_USER !== 'undefined' && SESSION_USER.name) ? SESSION_USER.name : userProfile.name;
            greetingText.innerHTML = `${greet}, <span class="text-primary">${displayName}.</span>`;
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
            
            days.forEach((dayName, colIndex) => {
                const dayClasses = schedule.filter(s => s.day === dayName).sort((a, b) => a.time.localeCompare(b.time));
                
                const col = document.createElement('div');
                // day-column animation with staggered delay
                col.className = `day-column min-w-[280px] w-[280px] snap-center relative`;
                col.style.animationDelay = `${colIndex * 0.1}s`;
                
                col.innerHTML = `
                    <div class="pulse-line"></div>
                    <div class="glass-panel p-6 rounded-[2rem] h-full flex flex-col relative group/col transition-all duration-500 hover:shadow-[0_0_40px_rgba(59,130,246,0.15)] hover:border-blue-500/30">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-sm font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-600 to-slate-400 dark:from-white dark:to-slate-400 uppercase tracking-widest">${dayName}</h4>
                            <div class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500 font-bold text-xs">${dayClasses.length}</div>
                        </div>
                        <div class="space-y-4 flex-1 relative">
                            <!-- Connection Line -->
                            <div class="absolute left-4 top-2 bottom-4 w-px bg-gradient-to-b from-blue-500/50 via-purple-500/50 to-transparent -z-10"></div>
                            
                            ${dayClasses.length === 0 ? `
                                <div class="h-full flex flex-col items-center justify-center opacity-50 text-slate-400 py-10">
                                    <span class="material-symbols-outlined text-4xl mb-2">hotel_class</span>
                                    <p class="text-xs font-medium">Free Day</p>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                `;

                const listContainer = col.querySelector('.space-y-4');
                
                dayClasses.forEach((c, itemIndex) => {
                    const item = document.createElement('div');
                    item.className = "holo-card animate-class-item ml-8 p-4 bg-white dark:bg-slate-800 rounded-2xl relative group/item border border-slate-100 dark:border-slate-700/50 cursor-pointer";
                    item.style.animationDelay = `${(colIndex * 0.1) + (itemIndex * 0.15) + 0.2}s`;
                    
                    item.innerHTML = `
                        <!-- Node Point -->
                        <div class="absolute -left-[38px] top-1/2 -translate-y-1/2 w-4 h-4 rounded-full bg-white dark:bg-slate-900 border-4 border-blue-500 group-hover/item:border-purple-500 group-hover/item:scale-125 transition-transform z-10 shadow-[0_0_10px_rgba(59,130,246,0.5)]"></div>
                        
                        <div class="pr-8">
                            <p class="text-[10px] text-blue-500 font-black tracking-widest uppercase mb-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[12px]">schedule</span>
                                ${c.time}
                            </p>
                            <p class="font-extrabold text-sm text-slate-800 dark:text-white leading-tight">${c.subject}</p>
                        </div>
                        
                        <button onclick="deleteClass(${schedule.indexOf(c)})" class="absolute top-1/2 -translate-y-1/2 right-3 w-8 h-8 rounded-full bg-red-500/10 text-red-500 flex items-center justify-center opacity-0 group-hover/item:opacity-100 transition-all hover:bg-red-500 hover:text-white scale-75 group-hover/item:scale-100">
                            <span class="material-symbols-outlined text-sm">delete</span>
                        </button>
                    `;
                    listContainer.appendChild(item);
                });

                grid.appendChild(col);
            });
        }

        function renderEvents() {
            const container = document.getElementById('eventTableBody');
            if (!container) return;
            container.innerHTML = '';
            
            if (events.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full h-64 flex flex-col items-center justify-center opacity-50 text-slate-400">
                        <span class="material-symbols-outlined text-6xl mb-4">sports_esports</span>
                        <p class="text-lg font-medium">No competitions registered</p>
                    </div>
                `;
                return;
            }

            events.sort((a, b) => new Date(a.date) - new Date(b.date)).forEach((e, i) => {
                const card = document.createElement('div');
                card.className = "event-card neon-border bg-white dark:bg-slate-900 p-6 rounded-[2rem] flex flex-col justify-between group/card shadow-sm";
                card.style.animationDelay = `${i * 0.15}s`;
                
                // Format date nice
                const dateObj = new Date(e.date);
                const day = dateObj.toLocaleDateString('en-US', { day: '2-digit' });
                const month = dateObj.toLocaleDateString('en-US', { month: 'short' }).toUpperCase();
                
                card.innerHTML = `
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4">
                            <div class="glow-ring w-14 h-14 rounded-full bg-slate-50 dark:bg-slate-800 flex flex-col items-center justify-center border border-slate-200 dark:border-slate-700 z-10 shadow-inner">
                                <span class="text-lg font-black text-slate-900 dark:text-white leading-none">${day}</span>
                                <span class="text-[9px] font-bold text-pink-500 uppercase tracking-widest">${month}</span>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-lg text-slate-800 dark:text-white group-hover/card:text-transparent group-hover/card:bg-clip-text group-hover/card:bg-gradient-to-r group-hover/card:from-pink-500 group-hover/card:to-purple-500 transition-colors">${e.name}</h4>
                                <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold flex items-center gap-1 mt-1">
                                    <span class="material-symbols-outlined text-[12px] text-purple-500">location_on</span>
                                    ${e.loc}
                                </p>
                            </div>
                        </div>
                        <button onclick="deleteEvent(${events.indexOf(e)})" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center opacity-0 group-hover/card:opacity-100 transition-all hover:bg-red-500 hover:text-white hover:scale-110 hover:-rotate-12 hover:shadow-[0_0_15px_rgba(239,68,68,0.5)]">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </button>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <div class="flex-1 h-1 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full w-full bg-gradient-to-r from-pink-500 to-purple-500 -translate-x-full group-hover/card:translate-x-0 transition-transform duration-700 ease-out"></div>
                        </div>
                        <span class="text-[10px] font-bold text-slate-300 dark:text-slate-600 uppercase tracking-widest">Incoming</span>
                    </div>
                `;
                container.appendChild(card);
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
            if (!forecastContainer) return;
            forecastContainer.innerHTML = '';

            weatherData.daily.time.forEach((time, i) => {
                const item = document.createElement('div');
                
                const weatherCode = weatherData.daily.weather_code[i];
                const date = new Date(time).toLocaleDateString([], { weekday: 'long', month: 'short', day: 'numeric' });
                const icon = getWeatherIcon(weatherCode);
                const desc = getWeatherText(weatherCode);
                
                // Determine dynamic glow class based on weather
                let glowClass = 'glow-cloudy';
                let iconColor = 'text-slate-500';
                if (weatherCode === 0 || weatherCode <= 3 && weatherCode > 0) {
                    glowClass = 'glow-sunny hover:!border-yellow-400/50 hover:shadow-[0_0_30px_rgba(250,204,21,0.2)]';
                    iconColor = 'text-yellow-500';
                } else if (weatherCode >= 51 && weatherCode <= 67) {
                    glowClass = 'glow-rainy hover:!border-blue-400/50 hover:shadow-[0_0_30px_rgba(59,130,246,0.3)]';
                    iconColor = 'text-blue-500';
                } else if (weatherCode >= 71) {
                    glowClass = 'glow-snowy hover:!border-slate-300/50 hover:shadow-[0_0_30px_rgba(226,232,240,0.4)]';
                    iconColor = 'text-slate-300';
                }

                item.className = `weather-card-anim glass-weather flex items-center justify-between p-5 rounded-2xl relative overflow-hidden group cursor-pointer ${glowClass}`;
                item.style.animationDelay = `${i * 0.1}s`;

                item.innerHTML = `
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-in-out"></div>
                    <div class="flex items-center gap-5 relative z-10">
                        <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800/80 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-2xl ${iconColor}">${icon}</span>
                        </div>
                        <div>
                            <p class="font-extrabold text-slate-800 dark:text-white text-base tracking-tight">${date}</p>
                            <p class="text-[10px] ${iconColor} uppercase font-black tracking-widest mt-0.5">${desc}</p>
                        </div>
                    </div>
                    <div class="text-right relative z-10 flex items-center gap-4">
                        <div class="h-8 w-px bg-slate-200 dark:bg-slate-700"></div>
                        <div>
                            <p class="font-black text-xl text-slate-900 dark:text-white tracking-tighter">${Math.round(weatherData.daily.temperature_2m_max[i])}°</p>
                            <p class="text-[11px] text-slate-400 font-bold">${Math.round(weatherData.daily.temperature_2m_min[i])}°</p>
                        </div>
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
                userHabitList.innerHTML = `<div class="col-span-full p-8 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">No active subroutines match.</div>`;
                return;
            }
            filteredHabits.forEach((habit, i) => {
                const index = habits.findIndex(h => h === habit);
                const card = document.createElement('div');
                card.className = "group relative p-4 rounded-2xl transition-all duration-500 overflow-hidden bg-slate-50 dark:bg-slate-800/50 hover:bg-white dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-700/50 hover:border-blue-500/30 hover:shadow-[0_10px_30px_rgba(59,130,246,0.15)] hover:-translate-y-1";
                
                // Add a subtle entrance animation delay
                card.style.animation = `logEntryFade 0.5s ease-out forwards`;
                card.style.animationDelay = `${i * 0.1}s`;
                card.style.opacity = '0'; // For the entrance animation
                
                card.innerHTML = `
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="w-12 h-12 rounded-xl shrink-0 bg-gradient-to-br ${habit.completedToday ? 'from-emerald-400 to-teal-500 shadow-lg shadow-emerald-500/30' : 'from-blue-500/10 to-purple-500/10 dark:from-slate-700 dark:to-slate-600'} flex flex-col items-center justify-center transition-colors">
                                <span class="text-[11px] font-black ${habit.completedToday ? 'text-white' : 'text-blue-600 dark:text-blue-400'}">${formatAMPM(habit.time !== undefined ? habit.time : habit.hour)}</span>
                            </div>
                            <div class="overflow-hidden min-w-0">
                                <h4 class="text-sm font-black text-slate-800 dark:text-white truncate ${habit.completedToday ? 'line-through opacity-50' : ''}">${habit.activity}</h4>
                                <p class="text-[9px] text-slate-400 uppercase tracking-widest font-bold mt-0.5 truncate">Scheduled Task</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <button onclick="deleteHabit(${index})" class="w-8 h-8 rounded-lg text-slate-300 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 translate-x-2 group-hover:translate-x-0">
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                            </button>
                            <button onclick="toggleComplete(${index})" class="w-9 h-9 rounded-xl border-2 transition-all flex items-center justify-center ${habit.completedToday ? 'bg-emerald-500 border-emerald-500 text-white shadow-lg shadow-emerald-500/30' : 'border-slate-200 dark:border-slate-600 text-transparent hover:border-emerald-500/50 hover:bg-emerald-500/10'}">
                                <span class="material-symbols-outlined text-[16px] font-bold">${habit.completedToday ? 'done_all' : 'check'}</span>
                            </button>
                        </div>
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
            if (!container) return;
            container.innerHTML = '';
            
            if (logs.length === 0) {
                container.innerHTML = `
                    <div class="p-10 flex flex-col items-center justify-center opacity-40">
                        <span class="material-symbols-outlined text-5xl mb-3 text-slate-500">history</span>
                        <p class="text-sm font-mono text-slate-400">Memory banks are empty.</p>
                    </div>
                `;
                return;
            }
            
            logs.forEach((log, index) => {
                const item = document.createElement('div');
                item.className = "log-line log-anim px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 dark:border-slate-800/50 hover:bg-red-500/5";
                item.style.animationDelay = `${index * 0.05}s`;
                
                // Color code actions
                let actionColor = 'text-blue-400';
                if (log.type === 'Delete' || log.type === 'Removed' || log.type === 'Clear') actionColor = 'text-red-400';
                else if (log.type === 'Habit' || log.type === 'Action' || log.type === 'Add') actionColor = 'text-emerald-400';
                else if (log.type === 'System' || log.type === 'Update') actionColor = 'text-amber-400';

                const displayTime = new Date(log.time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                item.innerHTML = `
                    <div class="flex items-start gap-4">
                        <span class="text-slate-300 dark:text-slate-600 font-bold opacity-50 mt-1">></span>
                        <div>
                            <p class="font-bold text-sm ${actionColor}">${log.type}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">${log.message}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-slate-600"></div>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold tracking-widest">${displayTime}</p>
                    </div>
                `;
                container.appendChild(item);
            });
        }

        function renderAnalytics() {
            const chart = document.getElementById('hourlyChart');
            if (!chart) return;
            chart.innerHTML = '';
            
            const hours = new Array(24).fill(0);
            habits.forEach(h => {
                const hr = typeof h.time === 'string' ? parseInt(h.time.split(':')[0]) : h.hour;
                if (!isNaN(hr)) hours[hr]++;
            });
            const max = Math.max(...hours, 1);
            
            hours.forEach((count, i) => {
                const height = (count / max) * 100;
                const wrapper = document.createElement('div');
                wrapper.className = "flex-1 flex flex-col justify-end items-center h-full group relative";
                
                // Animated column
                const bar = document.createElement('div');
                const isZero = count === 0;
                
                bar.className = `w-full rounded-t-md chart-bar-anim transition-all duration-300 relative overflow-hidden ${
                    isZero 
                    ? 'bg-slate-200/50 dark:bg-slate-800/50 hover:bg-slate-300 dark:hover:bg-slate-700' 
                    : 'bg-gradient-to-t from-emerald-500 to-teal-400 shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_25px_rgba(16,185,129,0.6)] hover:from-emerald-400 hover:to-teal-300'
                }`;
                bar.style.height = `${Math.max(height, 2)}%`;
                bar.style.animationDelay = `${i * 0.04}s`;

                // Tooltip
                const tooltip = document.createElement('div');
                tooltip.className = "absolute -top-10 bg-slate-900 text-white text-[10px] font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none z-20";
                tooltip.textContent = `${i.toString().padStart(2, '0')}:00 - ${count} actions`;
                
                wrapper.appendChild(tooltip);
                wrapper.appendChild(bar);
                chart.appendChild(wrapper);
            });

            const freqList = document.getElementById('frequencyList');
            freqList.innerHTML = '';
            const activityCounts = {};
            habits.forEach(h => activityCounts[h.activity] = (activityCounts[h.activity] || 0) + 1);
            
            const sortedActivities = Object.entries(activityCounts).sort((a, b) => b[1] - a[1]);
            const maxFreq = sortedActivities.length ? sortedActivities[0][1] : 1;

            if (sortedActivities.length === 0) {
                freqList.innerHTML = `<div class="h-full flex flex-col items-center justify-center opacity-50 text-slate-400 py-10"><span class="material-symbols-outlined text-4xl mb-2">hourglass_empty</span><p class="text-sm font-medium">Awaiting behavioral data...</p></div>`;
            }

            sortedActivities.slice(0, 5).forEach(([name, count], index) => {
                const fillPercent = (count / maxFreq) * 100;
                const item = document.createElement('div');
                item.className = "relative group cursor-default";
                
                item.innerHTML = `
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-sm font-bold text-slate-800 dark:text-white group-hover:text-teal-500 transition-colors">${name}</span>
                        <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">${count} occurrences</span>
                    </div>
                    <div class="h-3 w-full bg-slate-100 dark:bg-slate-800/80 rounded-full overflow-hidden shadow-inner">
                        <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 freq-bar-fill rounded-full relative shadow-[0_0_10px_rgba(16,185,129,0.5)] group-hover:brightness-110" style="--fill-width: ${fillPercent}%; animation-delay: ${index * 0.1}s;">
                            <!-- Highlight streak -->
                            <div class="absolute inset-0 bg-gradient-to-b from-white/30 to-transparent"></div>
                        </div>
                    </div>
                `;
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

        async function handleLogout() {
            if (!confirm('Apakah Anda yakin ingin logout?')) return;
            try {
                await fetch('api/auth.php?action=logout');
            } catch (e) {
                console.error('Logout error:', e);
            }
            window.location.href = 'login.php';
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
            userMsg.className = "flex gap-4 flex-row-reverse chat-animate";
            userMsg.innerHTML = `
                <div class="w-10 h-10 rounded-xl bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 flex items-center justify-center shrink-0 shadow-sm">
                    <span class="material-symbols-outlined text-lg">person</span>
                </div>
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 dark:from-slate-700 dark:to-slate-800 text-white p-4 rounded-2xl rounded-tr-none shadow-md max-w-[85%] hover:-translate-y-1 transition-transform">
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
                aiMsg.className = "flex gap-4 chat-animate";
                aiMsg.innerHTML = `
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-blue-500 text-white flex items-center justify-center shrink-0 shadow-lg shadow-purple-500/20">
                        <span class="material-symbols-outlined text-lg animate-spin" style="animation-duration: 4s;">auto_awesome</span>
                    </div>
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm p-4 rounded-2xl rounded-tl-none border border-slate-200 dark:border-slate-700/50 shadow-sm max-w-[85%] hover:-translate-y-1 transition-transform">
                        <p class="text-slate-800 dark:text-slate-200 text-sm leading-relaxed font-medium">${replyText}</p>
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
