            <!-- College Schedule View -->
            <div id="view-schedule" class="view-content hidden">
                <header class="mb-12">
                    <h2 class="text-4xl font-black text-slate-900 dark:text-white mb-2">College Schedule</h2>
                    <p class="text-slate-500">Organize your academic journey with precision.</p>
                </header>
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-12">
                    <div class="xl:col-span-4 space-y-6">
                        <section
                            class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800">
                            <h3 class="font-bold mb-6">Add Class</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase">Subject</label>
                                    <input type="text" id="schedSubject"
                                        class="w-full bg-slate-50 dark:bg-slate-800 border-0 rounded-xl px-4 py-3"
                                        placeholder="e.g. Data Structures">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">Day</label>
                                        <select id="schedDay"
                                            class="w-full bg-slate-50 dark:bg-slate-800 border-0 rounded-xl px-4 py-3">
                                            <option>Monday</option>
                                            <option>Tuesday</option>
                                            <option>Wednesday</option>
                                            <option>Thursday</option>
                                            <option>Friday</option>
                                            <option>Saturday</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">Time</label>
                                        <input type="time" id="schedTime"
                                            class="w-full bg-slate-50 dark:bg-slate-800 border-0 rounded-xl px-4 py-3">
                                    </div>
                                </div>
                                <button onclick="addClass()"
                                    class="w-full bg-primary text-white py-4 rounded-xl font-bold shadow-lg shadow-primary/20">Add
                                    to Schedule</button>
                            </div>
                        </section>
                    </div>
                    <div class="xl:col-span-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="scheduleGrid">
                            <!-- Day columns will be here -->
                        </div>
                    </div>
                </div>
            </div>
