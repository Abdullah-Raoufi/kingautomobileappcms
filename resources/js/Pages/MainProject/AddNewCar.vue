<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { EnvelopeIcon, PhoneIcon } from '@heroicons/vue/20/solid'
import { getFirestore, collection, getDocs, doc, getDoc, setDoc } from '@firebase/firestore';
import { getStorage, uploadBytesResumable, uploadBytes, getDownloadURL, ref as storREF } from "firebase/storage";
import db from '../../firebase.js';
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import NProgress from 'nprogress'
const storage = getStorage(db);
const carImages = ref([]);

const srcImages = ref([]);
const progressStatus = ref([]);
const saveButtonStatus = ref(true);

function onInputChange(e) {

    carImages.value = e.target.files;


    const imageName = Math.random().toString(36).substring(2, 15) +
        Math.random().toString(36).substring(2, 15);

    for (var i = 0; i < carImages.value.length; i++) {

        const file = carImages.value[i];
        const metadata = {
            contentType: "image/jpeg",
        };
        try {
            const storageRef = storREF(storage, imageName + i);
            const uploadTask = uploadBytesResumable(storageRef, file);
            uploadTask.on('state_changed',
                (snapshot) => {
                    let progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                    switch (snapshot.state) {
                        case 'paused':
                            break;
                        case 'running':
                            progressStatus.value = []
                            break;
                    }
                    progressStatus.value.push(progress)
                },
                (error) => {
                    console.log(error)
                },
                () => {
                    getDownloadURL(uploadTask.snapshot.ref).then((downloadURL) => {
                        srcImages.value.push(downloadURL)
                        if (carImages.value.length == srcImages.value.length) {
                            saveButtonStatus.value = false;
                            
                        }
                    });
                }
            );
        } catch (error) {
            console.log(error)
        }
    }



}

const data = ref({
    badge_variant: '',
    body: '',
    colour: '',
    cyl: '',
    w2_w4: '',
    engine_capacity: '',
    engine_code: '',
    gearbox: '',
    issues: '',
    make: '',
    model: '',
    odometer: '',
    ppsr_no: '',
    rego: '',
    stock_no: '',
    vin_no: '',
    description: '',
});


const successShow = ref(false);
const errorShow = ref(false);
const validation = function () {

    if (data.value.badge_variant != '', data.value.body != '', data.value.colour != '', data.value.cyl != '', data.value.w2_w4 != '', data.value.engine_capacity != '', data.value.engine_code != '', data.value.gearbox != '', data.value.issues != '', data.value.make != '', data.value.model != '', data.value.odometer != '', data.value.ppsr_no != '', data.value.rego != '', data.value.stock_no != '', data.value.vin_no != '', data.value.description != '') {
        return true
    } else {
        return false;
    }

}



const sumbitForm = () => {
    NProgress.start()
    if (validation()) {
        const documentName = Math.random().toString(36).substring(2, 15) +
            Math.random().toString(36).substring(2, 15);
        const getdata = getFirestore(db);
        const myDoc = doc(getdata, "car_details", documentName)
        const badge_variant = data.value.badge_variant;
        const body = data.value.body;
        const colour = data.value.colour;
        const cyl = data.value.cyl;
        const w2_w4 = data.value.w2_w4;
        const engine_capacity = data.value.engine_capacity;
        const engine_code = data.value.engine_code;
        const gearbox = data.value.gearbox;
        const issues = data.value.issues;
        const make = data.value.make;
        const model = data.value.model;
        const odometer = data.value.odometer;
        const ppsr_no = data.value.ppsr_no;
        const rego = data.value.rego;
        const stock_no = data.value.stock_no;
        const vin_no = data.value.vin_no;
        const description = data.value.description;
        const docData = {
            doc_id: documentName,
            badge_variant: badge_variant,
            body: body,
            colour: colour,
            cyl: cyl,
            w2_w4: w2_w4,
            engine_capacity: engine_capacity,
            engine_code: engine_code,
            gearbox: gearbox,
            issues: issues,
            make: make,
            model: model,
            odometer: odometer,
            ppsr_no: ppsr_no,
            rego: rego,
            stock_no: stock_no,
            vin_no: vin_no,
            description: description,
            srcImages: srcImages.value

        }
        setDoc(myDoc, docData)
            .then(() => {
                window.scrollTo(0, 0);
                successShow.value = true;
                setInterval(function () { successShow.value = false; }, 2000);

                data.value = {};
                srcImages.value = [];
                progressStatus.value = [];
                saveButtonStatus.value = true;

            })
            .catch((error) => {
                alert(error.message)
            })
    } else {
        window.scrollTo(0, 0);
        errorShow.value = true;
        setInterval(function () { errorShow.value = false; }, 4000);

    }
    NProgress.done()
}



</script>
<template>
    <AppLayout title="Dashboard">
        <div class="py-12">
            <div class="shadow-lg max-w-7xl mx-auto sm:px-6 lg:px-8 p-10">
                <div class="rounded-md bg-green-50 p-4 mb-5" v-show="successShow">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <CheckCircleIcon class="h-5 w-5 text-green-400" aria-hidden="true" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">Successfully Created</p>
                        </div>
                        <div class="ml-auto pl-3">

                            <div class="-mx-1.5 -my-1.5">
                                <button type="button"
                                    class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50">


                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-md bg-red-50 p-4 mb-5" v-show="errorShow">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <CheckCircleIcon class="h-5 w-5 text-red-400" aria-hidden="true" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">The Record is not created. Please fill in all
                                inputs
                                inputs</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button type="button"
                                    class="inline-flex rounded-md bg-red-50 p-1.5 text-green-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50">


                                </button>
                            </div>
                        </div>
                    </div>
                </div>
               
                <form class="" @submit.prevent="onSubmit">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Car Info</h3>
                    <div class="pt-2">
                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label for="badge_variant" class="block text-sm font-medium text-gray-700">Badge
                                    Variant</label>
                                <div class="mt-1">
                                    <input v-model="data.badge_variant" type="text" name="badge_variant"
                                        id="badge_variant" autocomplete="badge_variant"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>

                            </div>

                            <div class="sm:col-span-2">
                                <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                                <div class="mt-1">
                                    <input v-model="data.body" type="text" name="body" id="body" autocomplete="body"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="colour" class="block text-sm font-medium text-gray-700">Colour
                                </label>
                                <div class="mt-1">
                                    <input v-model="data.colour" type="text" name="colour" id="colour"
                                        autocomplete="colour"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label for="cyl" class="block text-sm font-medium text-gray-700">CYL
                                </label>
                                <div class="mt-1">
                                    <input v-model="data.cyl" type="text" name="cyl" id="cyl" autocomplete="cyl"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="w2_w4" class="block text-sm font-medium text-gray-700">W2 W4
                                </label>
                                <div class="mt-1">
                                    <input v-model="data.w2_w4" type="text" name="w2_w4" id="w2_w4" autocomplete="w2_w4"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="engine_capacity" class="block text-sm font-medium text-gray-700">Engine
                                    Capacity
                                </label>
                                <div class="mt-1">
                                    <input v-model="data.engine_capacity" type="text" name="engine_capacity"
                                        id="engine_capacity" autocomplete="engine_capacity"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label for="engine_code" class="block text-sm font-medium text-gray-700">Engine Code
                                </label>
                                <div class="mt-1">
                                    <input v-model="data.engine_code" type="text" name="engine_code" id="engine_code"
                                        autocomplete="engine_code"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="stock_no" class="block text-sm font-medium text-gray-700">
                                    Stock No</label>
                                <div class="mt-1">
                                    <input v-model="data.stock_no" type="text" name="stock_no" id="stock_no"
                                        autocomplete="stock_no"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="issues" class="block text-sm font-medium text-gray-700">
                                    Issues</label>
                                <div class="mt-1">
                                    <input v-model="data.issues" type="text" name="issues" id="issues"
                                        autocomplete="issues"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label for="make" class="block text-sm font-medium text-gray-700">
                                    Make</label>
                                <div class="mt-1">
                                    <input v-model="data.make" type="text" name="make" id="make" autocomplete="make"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="model" class="block text-sm font-medium text-gray-700">
                                    Model</label>
                                <div class="mt-1">
                                    <input v-model="data.model" type="text" name="model" id="model" autocomplete="model"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="odometer" class="block text-sm font-medium text-gray-700">Odometer
                                </label>
                                <div class="mt-1">
                                    <input v-model="data.odometer" type="text" name="odometer" id="odometer"
                                        autocomplete="odometer"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label for="ppsr_no" class="block text-sm font-medium text-gray-700">PPSR NO
                                </label>
                                <div class="mt-1">
                                    <input v-model="data.ppsr_no" type="text" name="ppsr_no" id="ppsr_no"
                                        autocomplete="ppsr_no"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="rego" class="block text-sm font-medium text-gray-700">Rego
                                </label>
                                <div class="mt-1">
                                    <input v-model="data.rego" type="text" name="rego" id="rego" autocomplete="rego"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>


                            <div class="sm:col-span-2">

                                <label for="gearbox" class="block text-sm font-medium text-gray-700">Gearbox</label>
                                <select v-model="data.gearbox" id="gearbox" name="gearbox"
                                    class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">

                                    <option value="Manual">Manual</option>
                                    <option value="Auto">Auto</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-6">
                                <label for="vin_no" class="block text-sm font-medium text-gray-700">Vin No
                                </label>
                                <div class="mt-1">
                                    <input v-model="data.vin_no" type="text" name="vin_no" id="vin_no"
                                        autocomplete="vin_no"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>


                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-6">
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700">Description</label>
                                <div class="mt-1">
                                    <textarea v-model="data.description" id="description" name="description" rows="3"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>

                            </div>
                        </div>


                        <div class="sm:col-span-6">
                            <label for="car_images" class="block text-sm font-medium text-gray-700">Select Car
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
                                            <input @change="onInputChange" id="file-upload" name="car_images"
                                                type="file" multiple class="sr-only" />
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                            <br />
                            <div v-for="itemss in progressStatus">

                                <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                                    <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                        :style="{ width: itemss + '%' }"> {{ Math.ceil(itemss) }}%</div>
                                </div>
                            </div>



                        </div>


                    </div>


                    <div class="pt-5">
                        <div class="flex justify-end">
                            <button v-on:click="sumbitForm" type="submit" :disabled="saveButtonStatus"
                                class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <p v-if="saveButtonStatus">
                                    Wait  
                                </p>
                                <p v-else>
                                    Save
                                </p>
                                
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>