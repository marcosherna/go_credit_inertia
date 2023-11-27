<script setup>
import { Head } from '@inertiajs/vue3';

 
</script>

<template>
   <Head title="Welcome"/>

   <body>
      <div>
         <div class="grid mx-auto bg-white flex-col container grid-cols-1 gap-8 pt-4 pr-4 pb-4 pl-4 lg:grid-cols-12">
            <div class="flex-grow w-full flex flex-col justify-between mt-0 mr-8 mb-0 ml-0 lg:col-span-8">
               <div class="w-full rounded-2xl pr-4 pl-4 border-2">
                  <div class="container mt-0 mr-auto mb-0 ml-auto">
                     <div class="flex flex-wrap justify-evenly">
                        <div class="w-full pt-4 pr-4 pb-4 pl-4 sm:w-1/2 lg:w-1/3">
                              <div class="rounded-lg shadow bg-white pt-6 pr-6 pb-6 pl-6">
                                 <div class="w-full flex justify-between mb-2">
                                    <div class="rounded-lg flex items-center bg-gray-700 justify-center mr-8 pt-1 pr-3 pb-1 pl-3">
                                       <i href="" class="fa-shopping-cart h-auto fas text-white text-2xl"></i>
                                    </div>
                                    <div class="flex flex-col justify-evenly items-end">
                                       <p class="text-gray-800 text-xl font-bold text-end whitespace-nowrap">5.45k</p>
                                       <p class="text-gray-500 text-sm font-bold">Pagos</p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="w-full pt-4 pr-4 pb-4 pl-4 sm:w-1/2 lg:w-1/3">
                              <div class="bg-gray-800 shadow w-full rounded-lg pt-6 pr-6 pb-6 pl-6">
                                 <div class="flex justify-between mb-2">
                                    <div class="flex items-center justify-center bg-gray-700 mr-8 pt-1 pr-3 pb-1 pl-3 rounded-lg">
                                       <i href="" class="fa-chart-bar h-auto fas text-white text-2xl"></i>
                                    </div>
                                    <div class="flex flex-col justify-evenly items-end text-white">
                                       <p class="text-gray-200 text-xl font-bold text-end whitespace-nowrap">7.9k</p>
                                       <p class="text-gray-200 text-sm font-bold">Transferencias</p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="w-full pt-4 pr-4 pb-4 pl-4 sm:w-1/2 lg:w-1/3">
                              <div class="rounded-lg shadow bg-white pt-6 pr-6 pb-6 pl-6">
                                 <div class="flex justify-between mb-2">
                                    <div class="rounded-lg flex items-center justify-center bg-gray-700 mr-8 pt-1 pr-3 pb-1 pl-3">
                                       <i href="" class="fa-chart-pie h-auto fas text-white text-2xl"></i>
                                    </div>
                                    <div class="flex items-end flex-col justify-evenly">
                                       <p class="text-gray-800 text-xl font-bold text-end whitespace-nowrap">3k</p>
                                       <p class="text-gray-500 text-sm font-bold">Clientes</p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="rounded-2xl text-center bg-white w-full mt-8 mr-0 mb-8 ml-0 pt-2 pr-4 pb-0 pl-4 border-2">
                     <div data_type="columns" class="pt-0 pr-2 pb-0 pl-2 chart w-full"></div>
                  </div>
                   <!--Table Starts Here-->
                  <div class="w-full pt-0 pr-4 pb-0 pl-4 mt-0 mr-auto mb-8 ml-auto border-2 rounded-2xl lg:mb-0">
                     <div class="mt-0 mr-auto mb-0 ml-auto max-w-5xl overflow-x-auto overflow-y-hidde">
                        <div class="flex items-center justify-between">
                           <p class="text-3xl text-left font-bold mt-4 mr-0 mb-2 ml-0">Historial</p>
                           <p class="pt-1 pr-1 pb-1 pl-1 border-2 rounded-md">
                              <svg width="18px" height="18px" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg"><path fill="#494c4e" d="M17 10a8 8 0 0 1-16 0 1 1 0 0 1 2 0 6 6 0 1 0 6.5-5.98V5.5a.477.477 0 0
                                 1-.27.44A.466.466 0 0 1 9 6a.52.52 0 0 1-.29-.09l-3.5-2.5a.505.505 0 0 1 0-.82l3.5-2.5a.488.488 0 0 1
                                 .52-.03.477.477 0 0 1 .27.44v1.52A7.987 7.987 0 0 1 17 10z"></path><path fill="#494c4e" d="M11.71 8.71L10
                                 10.42V13a1 1 0 0 1-2 0v-3a.69.69 0 0 1 .04-.25.37.37 0 0 1 .04-.14.988.988 0 0 1 .21-.32l2-2a1.004
                                 1.004 0 0 1 1.42 1.42z"></path></svg>
                           </p>
                        </div>
                        <p class="text-base font-normal mt-0 mr-0 mb-4 ml-0 text-left">Ultimas transferencias</p>
                        <table class="w-full table-auto mt-0 mr-0 mb-8 ml-0">
                           <tbody>
                              <tr class="text-base rounded-3xl shadow-xl">
                                 <td>
                                    <div class="w-20 h-full flex items-center justify-center px-4">
                                       <img src="https://media.glamour.com/photos/5a425fd3b6bcee68da9f86f8/master/pass/best-face-oil.png" class="object-cover w-9 h-9 rounded-full">
                                    </div>
                                 </td>
                                 <td class="pt-5 pr-0 pb-5 pl-10 text-base hidden lg:block">7770-1122</td>
                                 <td class="text-base">user.name@gmail.com</td>
                                 <td class="text-base">creditos: 90</td>
                                 <td class="text-base">+</td>
                              </tr> 
                           </tbody>
                        </table>
                     </div>
                  </div>

                  <!--Table Ends Here-->
                </div>
                  <div class="flex-grow w-full lg:col-span-4">
                     <div class="h-full flex flex-col justify-between container">
                        <div class="bg-white rounded-2xl flex flex-col w-full pt-5 pr-6 pb-5 pl-6 border-2">
                           <div class="flex items-center justify-between mb-4">
                              <p class="text-xl font-bold">Data Transfer Speed</p>
                              <p class="pt-1 pr-1 pb-1 pl-1 border-2 rounded-md">
                                 <svg width="1.25rem" height="1.25rem" viewBox="0 0 512 512" data-name="Layer 1" id="Layer_1" xmlns="http://www.w3.org/2000/svg">
                                    <title></title>
                                    <path d="M256,62.24c-106.82,0-193.72,86.56-193.72,192.94s86.9,193,193.72,193,193.72-86.56,193.72-192.95S362.82,62.24,256,62.24Zm0,369.89c-98,0-177.72-79.38-177.72-176.95S158,78.24,256,78.24s177.72,79.38,177.72,176.94S354,432.13,256,432.13Zm127.58-103.6h0v0h0a8,8,0,0,1-10.9,2.91l-20-11.51a8,8,0,0,1,8-13.87l12.91,7.41A130.31,130.31,0,0,0,387,263.19H372.18a8,8,0,0,1,0-16H387a129.36,129.36,0,0,0-13.56-50.32l-12.87,7.4a7.91,7.91,0,0,1-4,1.07,8,8,0,0,1-4-14.94l12.8-7.35a131.91,131.91,0,0,0-37-36.83L321,159a8,8,0,0,1-13.84-8l7.39-12.75A130.71,130.71,0,0,0,264,124.73v14.76a8,8,0,0,1-16,0V124.73a130.71,130.71,0,0,0-50.56,13.5L204.83,151A8,8,0,1,1,191,159l-7.41-12.78a132,132,0,0,0-37,36.82l12.8,7.36a8,8,0,1,1-8,13.87l-12.88-7.4A129.36,129.36,0,0,0,125,247.18h14.86a8,8,0,0,1,0,16H125a130.31,130.31,0,0,0,13.53,50.33l12.9-7.41a8,8,0,1,1,8,13.87l-20,11.51a8,8,0,0,1-10.89-2.91h0l0,0h0a146.26,146.26,0,0,1-19.71-72.94c0-.14,0-.27,0-.41s0-.24,0-.36A145.42,145.42,0,0,1,128,182.59a7.54,7.54,0,0,1,.38-.75,7.25,7.25,0,0,1,.53-.79,148.09,148.09,0,0,1,52.63-52.42,7.52,7.52,0,0,1,.75-.5,8.52,8.52,0,0,1,.8-.4,146.86,146.86,0,0,1,72.51-19.25h.72a146.86,146.86,0,0,1,72.51,19.25,8.52,8.52,0,0,1,.8.4,7.52,7.52,0,0,1,.75.5,148,148,0,0,1,52.63,52.42,7.25,7.25,0,0,1,.53.79c.14.25.27.5.38.75a145.42,145.42,0,0,1,19.33,72.23c0,.12,0,.24,0,.37s0,.26,0,.4a146.26,146.26,0,0,1-19.7,72.92Zm-96.33-73.37a31.24,31.24,0,0,0-39.42-30l-27.56-47.54a8,8,0,1,0-13.84,8L234,233.15a31.09,31.09,0,0,0,22,53.14,31.5,31.5,0,0,0,8.15-1.08l5.28,9.12a8,8,0,0,0,13.84-8L278,277.22A31.13,31.13,0,0,0,287.25,255.16Zm-46.43,0a15.16,15.16,0,0,1,7.59-13.08h0a15.1,15.1,0,1,1-7.6,13.08Zm61.61,84.5H209.57a8,8,0,0,0-8,8v46.23a8,8,0,0,0,8,8h92.86a8,8,0,0,0,8-8V347.66A8,8,0,0,0,302.43,339.66Zm-8,46.23H217.57V355.66h76.86Z"></path>
                                 </svg>
                              </p>
                           </div>
                           <div data_type="radial" class="pt-0 pr-2 pb-0 pl-2 chart w-full"></div>
                           <p class="inline-flex items-center bg-gray-50 justify-center rounded-full h-12 text-xl -mt-16 mr-auto mb-8
                              ml-auto">🚀</p>
                           <div class="text-center">
                              <div class="flex items-end justify-center mb-2">
                                 <p class="text-4xl font-bold text-gray-800">74</p>
                                 <p class="text-sm text-gray-800 font-bold mt-0 mr-0 mb-0.5 ml-0">GB/MIN</p>
                              </div>
                              <div class="text-center flex items-center justify-Center">
                                 <p class="text-sm font-medium text-gray-500 mr-2">Network Stability</p>
                                 <p class="rounded-full text-xs text-green-500 bg-green-50 pt-1 pr-2 pb-1 pl-2">Good</p>
                              </div>
                           </div>
                        </div>
                        <div class="rounded-2xl pt-4 pr-4 pb-4 pl-4 mt-8 mr-0 mb-8 ml-0 border-2">
                           <div>
                              <p class="text-base font-bold">Clientes Recientes</p>
                              <p class="text-base">Los ultimos clientes agregados...</p>
                           </div>
                           <div class="flex items-center justify-between mt-4 mr-0 mb-0 ml-0">
                              <img src="https://media.glamour.com/photos/5a425fd3b6bcee68da9f86f8/master/pass/best-face-oil.png" class="object-cover rounded-full w-9 h-9 mr-2">
                              <div class="mt-0 mr-auto mb-0 ml-0">
                                 <p class="text-base font-bold">Jenny Wilson</p>
                                 <p class="text-base">user.name@example.com</p>
                              </div>
                              <p class="text-sm">$11,234</p>
                           </div>   
                        </div>
                        <div class="rounded-2xl border-2">
                           <div class="mt-4 mr-0 mb-0 ml-0 w-full">
                                 <div class="pt-4 pr-6 pb-6 pl-6 bg-white rounded relative">
                                 <div class="mt-0 mr-0 mb-6 ml-0">
                                    <p class="text-lg font-bold">Estadisticas</p>
                                 </div>
                                 <div class="relative">
                                    <div class="flex items-center flex-col mt-0 mr-0 mb-8 ml-0">
                                    <div class="flex items-center justify-between w-full mb-2">
                                       <p class="text-base font-medium">Pagos</p>
                                       <div class="flex items-center">
                                       <p class="text-sm">90%</p>
                                       </div>
                                    </div>
                                    <div class="w-full">
                                       <div class="mt-0 mr-0 mb-1 ml-0 h-1 w-full bg-gray-300 rounded">
                                          <div class="overflow-hidden bg-green-50 h-1.5 rounded-full w-full">
                                             <span
                                                class="h-full bg-green-500 w-full block rounded-full"
                                                style="width: 90%"
                                             ></span>
                                          </div>
                                       </div>
                                    </div>
                                    </div>
                                    <div class="flex items-center flex-col mt-0 mr-0 mb-8 ml-0">
                                       <div class="flex items-center justify-between w-full mb-2">
                                          <p class="text-base font-medium">Creditos</p>
                                          <div class="flex items-center">
                                             <p class="text-sm">50%</p>
                                          </div>
                                       </div>
                                       <div class="w-full">
                                          <div class="mt-0 mr-0 mb-1 ml-0 h-1 w-full bg-gray-300 rounded">
                                             <div class="overflow-hidden bg-green-50 h-1.5 rounded-full w-full">
                                                <span
                                                   class="h-full bg-green-500 w-full block rounded-full"
                                                   style="width: 50%"
                                                ></span>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="flex items-center flex-col mt-0 mr-0 mb-8 ml-0">
                                       <div class="flex items-center justify-between w-full mb-2">
                                          <p class="text-base font-medium">Clientes</p>
                                          <div class="flex items-center">
                                             <p class="text-sm">30%</p>
                                          </div>
                                       </div>
                                       <div class="w-full">
                                          <div class="mt-0 mr-0 mb-1 ml-0 h-1 w-full bg-gray-300 rounded">
                                             <div class="overflow-hidden bg-green-50 h-1.5 rounded-full w-full">
                                                <span
                                                   class="h-full bg-green-500 w-full block rounded-full"
                                                   style="width: 30%"
                                                ></span>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
            </div>
        </div>
    </body>
</template>
