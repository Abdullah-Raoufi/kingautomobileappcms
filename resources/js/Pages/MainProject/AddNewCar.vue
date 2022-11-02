<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { EnvelopeIcon, PhoneIcon } from '@heroicons/vue/20/solid'
import { getFirestore, collection, getDocs, doc, getDoc } from '@firebase/firestore';
import db from '../../firebase.js';
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>
<template>
    <AppLayout title="Dashboard">
        <div class="py-12">
            <div class="shadow-lg max-w-7xl mx-auto sm:px-6 lg:px-8 p-10">
                <form class="">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Car Info</h3>
                    <div class="pt-2">
                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label for="badge_variant" class="block text-sm font-medium text-gray-700">Badge
                                    Variant</label>
                                <div class="mt-1">
                                    <input type="text" name="badge_variant" id="badge_variant"
                                        autocomplete="badge_variant"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                                <div class="mt-1">
                                    <input type="text" name="body" id="body" autocomplete="body"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="colour" class="block text-sm font-medium text-gray-700">Colour
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="colour" id="colour" autocomplete="colour"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label for="cyl" class="block text-sm font-medium text-gray-700">CYL
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="cyl" id="cyl" autocomplete="cyl"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="w2_w4" class="block text-sm font-medium text-gray-700">W2 W4
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="w2_w4" id="w2_w4" autocomplete="w2_w4"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="engine_capacity" class="block text-sm font-medium text-gray-700">Engine
                                    Capacity
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="engine_capacity" id="engine_capacity"
                                        autocomplete="engine_capacity"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label for="engine_code" class="block text-sm font-medium text-gray-700">Engine Code
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="engine_code" id="engine_code" autocomplete="engine_code"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="gearbox" class="block text-sm font-medium text-gray-700">
                                    Gearbox</label>
                                <div class="mt-1">
                                    <input type="text" name="gearbox" id="gearbox" autocomplete="gearbox"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="issues" class="block text-sm font-medium text-gray-700">
                                    Issues</label>
                                <div class="mt-1">
                                    <input type="text" name="issues" id="issues" autocomplete="issues"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label for="make" class="block text-sm font-medium text-gray-700">
                                    Make</label>
                                <div class="mt-1">
                                    <input type="text" name="make" id="make" autocomplete="make"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="model" class="block text-sm font-medium text-gray-700">
                                    Model</label>
                                <div class="mt-1">
                                    <input type="text" name="model" id="model" autocomplete="model"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="odometer" class="block text-sm font-medium text-gray-700">Odometer
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="odometer" id="odometer" autocomplete="odometer"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label for="ppsr_no" class="block text-sm font-medium text-gray-700">PPSR NO
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="ppsr_no" id="ppsr_no" autocomplete="ppsr_no"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="rego" class="block text-sm font-medium text-gray-700">Rego
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="rego" id="rego" autocomplete="rego"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="stock_no" class="block text-sm font-medium text-gray-700">
                                    Stock No</label>
                                <div class="mt-1">
                                    <input type="text" name="stock_no" id="stock_no" autocomplete="stock_no"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                        </div>
                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-6">
                                <label for="vin_no" class="block text-sm font-medium text-gray-700">Vin No
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="vin_no" id="vin_no" autocomplete="vin_no"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>


                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">About</label>
                                <div class="mt-1">
                                    <textarea id="description" name="description" rows="3"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>

                            </div>
                        </div>


                        <div class="sm:col-span-6">
                            <label for="cover-photo" class="block text-sm font-medium text-gray-700">Select Car
                                Images</label>
                            <div
                                class="mt-1 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file-upload"
                                            class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="file-upload" name="file-upload" type="file" class="sr-only" />
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                        </div>


                    </div>


                    <div class="pt-5">
                        <div class="flex justify-end">
                            <button type="submit"
                                class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>