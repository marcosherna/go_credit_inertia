<script setup>
import ModuloCajaLayout from './partials/ModuloCajaLayout.vue';

</script>
<template> 
    <modulo-caja-layout> 
        <div class="w-full h-screen  ">
            <div class="flex">
                <h1 class="text-3xl font-bold mb-4 w-full">Pagar</h1>
            </div>

            <div class="flex">
                <div class="mr-16 w-full">

                    <!-- <div class="mb-4">
                        <label for="location" class="mr-2">Select Location:</label>
                        <select id="location"  class="lign-middle select-none font-sans font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-2 px-4 rounded-lg bg-gray-900 text-white shadow-md shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none">
                            <option value="US" selected>US</option>
                            <option value="EU">EU</option>
                        </select>
                    </div> 
                    <div class="mb-4">
                        <label for="frequency" class="mr-2">Frequency:</label>
                        <select id="frequency"  class="lign-middle select-none font-sans font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-2 px-4 rounded-lg bg-gray-900 text-white shadow-md shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                            <option value="quarterly">Quarterly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                    </div>--> 
                    <div class="mb-4">
                        <label for="duration" class="mr-2">Cuota</label>
                        <select id="duration"  class="lign-middle select-none font-sans font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-2 px-4 rounded-lg bg-green-300 text-white shadow-md shadow-green-300 hover:shadow-lg hover:shadow-green-300 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none">
                            <option value="0.25">Cuota 1</option>
                            <option value="0.5">Cuota 2</option>
                            <option value="0.75">Cuota 3</option> 
                        </select>
                    </div>
                </div>
                <!-- <div class="flex flex-col justify-end space-2 w-full">
                    <h2 class="text-2xl mb-4"> Use Template </h2>
                    <button class="py-2 px-4 bg-red-100 text-red-500 font-medium rounded-md mb-4">Daily Stand-up</button>
                    <button class="py-2 px-4 bg-red-100 text-red-500 font-medium rounded-md mb-4">Weekly Sync</button>
                    <button class="py-2 px-4 bg-red-100 text-red-500 font-medium rounded-md mb-4">Monthly Review</button>
                    <button class="py-2 px-4 bg-red-100 text-red-500 font-medium rounded-md mb-4">Quarterly Planning</button>
                </div> -->
                
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border-y border-gray-100 bg-gray-50/50 p-2">Job Title</th>
                            <th class="border-y border-gray-100 bg-gray-50/50 p-2">Hourly Rate</th>
                            <th class="border-y border-gray-100 bg-gray-50/50 p-2">Attendees</th>
                            <th class="border-y border-gray-100 bg-gray-50/50 p-2">Total Cost</th>
                            <th class="border-y border-gray-100 bg-gray-50/50 p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody id="attendees-list">
                        <!-- Initial attendees -->
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">
                                <select   class="p-2 rounded border bg-white">
                                    <option value="Developer">Developer</option>
                                    <option value="DevOps">DevOps</option>
                                    <option value="QA">QA</option>
                                    <option value="Designer">Designer</option>
                                    <option value="Marketer">Marketer</option>
                                    <option value="Product Manager">Product Manager</option>
                                    <option value="Head of department">Head of department</option>
                                    <option value="VP">VP</option>
                                    <option value="C-Level executive">C-Level executive</option>
                                </select>
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <input type="number"  class="p-2 rounded border hourly-rate" value="75">
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <input type="number"   value="1" class="p-2 rounded border attendees-count">
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <input type="number" readonly disabled class="p-2 rounded border total-cost">
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <button   class="p-2 text-red-600 ">
                                    <svg class="w-6 h-6 " stroke="currentColor" fill="none"  xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 24 24">
                                    <path d="M 10 2 L 9 3 L 4 3 L 4 5 L 5 5 L 5 20 C 5 20.522222 5.1913289 21.05461 5.5683594 21.431641 C 5.9453899 21.808671 6.4777778 22 7 22 L 17 22 C 17.522222 22 18.05461 21.808671 18.431641 21.431641 C 18.808671 21.05461 19 20.522222 19 20 L 19 5 L 20 5 L 20 3 L 15 3 L 14 2 L 10 2 z M 7 5 L 17 5 L 17 20 L 7 20 L 7 5 z M 9 7 L 9 18 L 11 18 L 11 7 L 9 7 z M 13 7 L 13 18 L 15 18 L 15 7 L 13 7 z"></path>
                                    </svg>
                                </button>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex w-2/3 justify-center mx-auto mt-8">
                <div>
                    <button   class="align-middle select-none font-sans font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-2 px-4 rounded-lg bg-gray-900 text-white shadow-md shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none flex items-center gap-3 mt-4" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" stroke-width="2" class="h-4 w-4"><path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"></path></svg> 
                        Add Attendee
                    </button>
                </div>
                <div class="flex w-full justify-end">
                    <div class="col-span-9 sm:col-span-6 md:col-span-3">
                        <div class="flex flex-row bg-white shadow-sm rounded p-4">
                            <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-red-100 text-red-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="flex flex-col flex-grow ml-4">
                                <div class="text-sm text-gray-500">Cost per Meeting</div>
                                <div class="font-bold text-lg">$<span id="meeting-total">0.00</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 md:col-span-3">
                        <div class="flex flex-row bg-white shadow-sm rounded p-4">
                            <div class="flex items-center justify-center flex-shrink-0 h-12 w-12 rounded-xl bg-red-100 text-red-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="flex flex-col flex-grow ml-4">
                                <div class="text-sm text-gray-500">Yearly cost</div>
                                <div class="font-bold text-lg">$<span id="yearly-cost-result">0.00</span></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> 
            <div class="w-full pt-5 px-4 mb-8 mx-auto text-center ">
                <div class="text-sm text-gray-700 py-1">
                    Made with <a href="https://chat.openai.com/g/g-8gGyAPc6i-material-tailwind-gpt" class="text-gray-6 hover:text-gray-800 font-bold" target="_blank">MT GPT</a> based on <a href="https://www.material-tailwind.com" class="text-gray-500 hover:text-gray-800 font-bold" target="_blank"> Material Tailwind Framework</a>.
                </div>
            </div>
        </div>
    </modulo-caja-layout> 
</template>