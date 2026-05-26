            <!-- Competition Events View -->
            <div id="view-events" class="view-content hidden">
                <header class="mb-12">
                    <h2 class="text-4xl font-black text-slate-900 dark:text-white mb-2">Competitions</h2>
                    <p class="text-slate-500">Track your matches, tournaments, and achievements.</p>
                </header>
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-12">
                    <div class="xl:col-span-4 space-y-6">
                        <section
                            class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800">
                            <h3 class="font-bold mb-6">New Event</h3>
                            <div class="space-y-4">
                                <input type="text" id="eventName" placeholder="Event/Match Name"
                                    class="w-full bg-slate-50 dark:bg-slate-800 border-0 rounded-xl px-4 py-3">
                                <input type="date" id="eventDate"
                                    class="w-full bg-slate-50 dark:bg-slate-800 border-0 rounded-xl px-4 py-3">
                                <input type="text" id="eventLoc" placeholder="Location/Platform"
                                    class="w-full bg-slate-50 dark:bg-slate-800 border-0 rounded-xl px-4 py-3">
                                <button onclick="addEvent()"
                                    class="w-full bg-primary text-white py-4 rounded-xl font-bold">Register
                                    Event</button>
                            </div>
                        </section>
                    </div>
                    <div class="xl:col-span-8">
                        <div
                            class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 overflow-hidden">
                            <table class="w-full text-left">
                                <thead
                                    class="bg-slate-50 dark:bg-slate-800 text-[10px] font-bold uppercase text-slate-400">
                                    <tr>
                                        <th class="p-6">Event</th>
                                        <th class="p-6">Date</th>
                                        <th class="p-6">Location</th>
                                        <th class="p-6">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="eventTableBody" class="divide-y divide-slate-100 dark:divide-slate-800">
                                    <!-- Rows here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
