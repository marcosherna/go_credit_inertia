<script setup>
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Welcome" />

    <div class="intro-y flex items-center mt-6">
        <h2 class="text-lg font-medium mr-auto">Catalogos</h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Menu -->
        <div
            class="col-span-12 max-h-md lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse rounded-md bg-white shadow-lg">
            <div class="intro-y box mt-5">
                <div class="relative flex items-center p-5">
                    <div class="ml-4 mr-auto">
                        <div class="font-medium text-base">Modulo de Banco</div>
                        <div class="text-slate-500">go credit</div>
                    </div>
                </div>
                <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                    <a class="flex items-center text-primary font-medium">
                        <i class="w-4 h-4 mr-2"></i> Bancos
                    </a>
                    <a class="flex items-center mt-5">
                        <i class="w-4 h-4 mr-2"></i> Cuentas Banco
                    </a>
                    <a class="flex items-center mt-5">
                        <i class="w-4 h-4 mr-2"></i> Chequera
                    </a>
                    <a class="flex items-center mt-5">
                        <i class="w-4 h-4 mr-2"></i> Control Chequera
                    </a>
                </div>
            </div>
        </div>


        <!-- END: Menu--> 
        <!-- BEGIN: Contenido-->
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <div class="relative overflow-x-auto">
                <div class="flex flex-colum sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
                    <div>
                        <!--ADD BUTTON -->
                        <button type="button"
                            class="text-white shadow-md bg-green-700 hover:bg-green-800  font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">


                            <svg class="w-3.5 h-3.5 me-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 1v16M1 9h16" />
                            </svg> 
                            Nuevo Banco
                        </button>
                    </div>
                    <label for="table-search" class="sr-only">Buscar</label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input type="text" id="table-search"
                            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search for items">
                    </div>
                </div>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="p-4">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Product name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Color
                            </th> 
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-4 text-center">
                                000000001 
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Apple MacBook Pro 17"
                            </th>
                            <td class="px-6 py-4">
                                Silver
                            </td> 
                            <td class="px-6 py-4">
                                <a href="#" class="font-medium text-green-600 dark:text-green-500 hover:underline">Edit</a>
                            </td>
                        </tr> 
                    </tbody>
                </table>
            </div> 
        </div>
    </div>
<!-- END: Contenido--></template>
