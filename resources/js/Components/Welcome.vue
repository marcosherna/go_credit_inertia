<script setup>
import { Head } from '@inertiajs/vue3';
import LineChart from './LineChart.vue';
import {
  Chart as ChartJS,
  RadialLinearScale,
  ArcElement,
  Tooltip,
  Legend
} from 'chart.js'
import { PolarArea } from 'vue-chartjs' 





ChartJS.register(RadialLinearScale, ArcElement, Tooltip, Legend) 
 
const data = {
  labels: [
    'Ventas',
    'Clientes',
    'Solicitudes',
    'Pagos',
    'Creditos',
    'Sucursales',
    'Bancos'
  ],
  datasets: [
    {
      label: 'My First dataset',
      backgroundColor: 'rgba(179,181,198,0.2)',
      pointBackgroundColor: 'rgba(179,181,198,1)',
      pointBorderColor: '#fff',
      pointHoverBackgroundColor: '#fff',
      pointHoverBorderColor: 'rgba(179,181,198,1)',
      data: [65, 59, 90, 81, 56, 55, 40]
    },
    {
      label: 'My Second dataset',
      backgroundColor: 'rgba(255,99,132,0.2)',
      pointBackgroundColor: 'rgba(255,99,132,1)',
      pointBorderColor: '#fff',
      pointHoverBackgroundColor: '#fff',
      pointHoverBorderColor: 'rgba(255,99,132,1)',
      data: [28, 48, 40, 19, 96, 27, 100]
    }
  ]
}

const options = {
  responsive: true,
  maintainAspectRatio: false
}

 
 
</script>

<template>
   <Head title="Welcome"/>

   <body>
      <div>
         <div class="grid mx-auto  flex-col container grid-cols-1 gap-8 pt-4 pr-4 pb-4 pl-4 lg:grid-cols-12">
            <div class="flex-grow w-full flex flex-col justify-between mt-0 mr-8 mb-0 ml-0 lg:col-span-8">
               <div class="w-full rounded-2xl pr-4 pl-4 border-2">
                  <div class="container mt-0 mr-auto mb-0 ml-auto">
                     <div class="flex flex-wrap justify-evenly">

                        <div class="w-full pt-4 transition hover:scale-105 duration-300 ease-in-out pr-4 pb-4 pl-4 sm:w-1/2 lg:w-1/3">
                           <div class="rounded-lg shadow-lg bg-white pt-6 pr-6 pb-6 pl-6">
                              <div class="w-full flex justify-between mb-2">
                                 <div class="rounded-lg flex items-center bg-green-400 justify-center mr-8 pt-1 pr-3 pb-1 pl-3">
                                    <i href="" class="fa-shopping-cart h-auto fas text-white text-2xl"></i>
                                 </div>
                                 <div class="flex flex-col justify-evenly items-end">
                                    <p class="text-gray-800 text-xl font-bold text-end whitespace-nowrap">5.45k</p>
                                    <p class="text-gray-500 text-sm font-bold">Pagos</p>
                                 </div>
                              </div>
                           </div> 
                        </div>

                           <div class="w-full pt-4 transition hover:scale-105 duration-300 ease-in-out pr-4 pb-4 pl-4 sm:w-1/2 lg:w-1/3">
                              <div class="bg-green-400 shadow-lg w-full rounded-lg pt-6 pr-6 pb-6 pl-6">
                                 <div class="flex justify-between mb-2">
                                    <div class="flex items-center justify-center bg-white mr-8 pt-1 pr-3 pb-1 pl-3 rounded-lg">
                                       <i href="" class="fa-chart-bar h-auto fas text-white text-2xl"></i>
                                    </div>
                                    <div class="flex flex-col justify-evenly items-end text-white">
                                       <p class="text-gray-100 text-xl font-bold text-end whitespace-nowrap">7.9k</p>
                                       <p class="text-gray-100 text-sm font-bold">Transferencias</p>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="w-full pt-4 pr-4 transition hover:scale-105 duration-300 ease-in-out pb-4 pl-4 sm:w-1/2 lg:w-1/3">
                              <div class="rounded-lg shadow-lg bg-white pt-6 pr-6 pb-6 pl-6">
                                 <div class="flex justify-between mb-2">
                                    <div class="rounded-lg flex items-center justify-center bg-green-400 mr-8 pt-1 pr-3 pb-1 pl-3">
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
 
                  
                  <div class="h-1/2 bg-white w-full mr-0 ml-0 my-8 px-4 py-4 shadow-md rounded-lg">
                     <LineChart /> 
                  </div> 
                  
                   <!--Table Starts Here-->
                  <div class="bg-white w-full pt-0 pr-4 pb-0 pl-4 mt-0 mr-auto ml-auto shadow-lg rounded-lg  lg:mb-0">
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
                                 <a href="#">
                                    <div class="flex items-center space-x-4 p-3.5 rounded-full bg-gray-100">
                                        
                                       <span class="flex items-center justify-center w-10 h-10 shrink-0 rounded-full bg-white text-gray-900">
                                          
                                          <svg class="w-6 h-6 text-gray-800 dark:text-white" 
                                             aria-hidden="true" 
                                             xmlns="http://www.w3.org/2000/svg" 
                                             fill="currentColor" 
                                             viewBox="0 0 14 18">
                                             <path d="M7 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Zm2 1H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                                          </svg>

                                          <!--<svg
                                             xmlns="http://www.w3.org/2000/svg"
                                             class="w-6 h-6"
                                             width="24"
                                             height="24"
                                             viewBox="0 0 24 24"
                                             stroke-width="1.5"
                                             stroke="currentColor"
                                             fill="none"
                                             stroke-linecap="round"
                                             stroke-linejoin="round">

                                             <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                             <path
                                                d="M7.502 19.423c2.602 2.105 6.395 2.105 8.996 0c2.602 -2.105 3.262 -5.708 1.566 -8.546l-4.89 -7.26c-.42 -.625 -1.287 -.803 -1.936 -.397a1.376 1.376 0 0 0 -.41 .397l-4.893 7.26c-1.695 2.838 -1.035 6.441 1.567 8.546z"
                                             ></path>
                                          </svg>-->
                                       </span>
                                       <div class="flex flex-col flex-1">
                                          <h3 class="text-sm font-medium">user.name@gmail.com</h3>
                                          <div class="divide-x divide-gray-200 mt-auto">
                                             <span
                                                class="inline-block px-3 text-xs leading-none text-gray-400 font-normal first:pl-0">27 junio de 2023</span>
                                             <span class="inline-block px-3 text-xs leading-none text-gray-400 font-normal first:pl-0">Tel. 7799-8789</span>
                                          </div>
                                       </div>
                                       <svg
                                          xmlns="http://www.w3.org/2000/svg"
                                          class="w-5 h-5 shrink-0"
                                          width="24"
                                          height="24"
                                          viewBox="0 0 24 24"
                                          stroke-width="2"
                                          stroke="currentColor"
                                          fill="none"
                                          stroke-linecap="round"
                                          stroke-linejoin="round">
                                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                          <path d="M9 6l6 6l-6 6"></path>
                                       </svg>
                                    </div>
                                 </a>
                              </tr> 
                           </tbody>
                        </table> 
                     </div>
                  </div> 
                  <!--Table Ends Here-->
                </div>
                  <div class="flex-grow w-full lg:col-span-4">
                     <div class="h-full flex flex-col justify-between container">
                        <h2 class="text-start pl-2 pb-3 font-bold text-lg" >Tendencias</h2> 
                        <div class="bg-white flex flex-col w-full pt-5 pr-6 pb-5 pl-6 shadow-md rounded-lg">                           
                           <PolarArea :data="data" :options="options" />
                        </div>
                        <div class=" bg-white pt-4 pr-4 pb-4 pl-4 mt-8 mr-0 mb-8 ml-0 shadow-md rounded-lg">
                           <div>
                              <p class="text-base font-bold">Clientes Recientes</p>
                              <p class="text-base">Los ultimos clientes agregados...</p>
                           </div>
                           <div class="flex items-center justify-between mt-4 mr-0 mb-0 ml-0">
                              <svg class="w-6 h-6 mr-2 text-gray-800 dark:text-white" 
                                 aria-hidden="true" 
                                 xmlns="http://www.w3.org/2000/svg" 
                                 fill="currentColor" 
                                 viewBox="0 0 14 18">
                                 <path d="M7 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Zm2 1H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                              </svg>

                              <div class="mt-0 mr-auto mb-0 ml-0">
                                 <!--Cambiar-->
                                 <p class="text-base font-bold">Jenny Wilson</p>
                                 <p class="text-base">user.name@example.com</p>
                              </div>
                              <p class="text-sm">$11,234</p>
                           </div>   
                        </div>

                        <div class="">
                           <div class="mt-4 mr-0 mb-0 ml-0 w-full">
                              <div class="pt-4 pr-6 pb-6 pl-6 bg-white shadow-md rounded-lg  relative">
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
