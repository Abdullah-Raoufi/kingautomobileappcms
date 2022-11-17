<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { EnvelopeIcon, PhoneIcon } from '@heroicons/vue/20/solid'
import { getFirestore, collection, getDocs, doc, getDoc, setDoc } from '@firebase/firestore';
import db from '../../firebase.js';
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { async } from '@firebase/util';
import { PaperClipIcon } from '@heroicons/vue/20/solid'

const props = defineProps(['doc_id'])
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
    srcImages: [],

});

onMounted(async () => {
    const getdata = getFirestore(db);
    const querySnapshot = await doc(getdata, 'bits', props.doc_id)
    const docSnap = await getDoc(querySnapshot);
    let nice = docSnap.data();
    console.log(nice)
    data.value.badge_variant = nice.badge_variant;
 
});
console.log(data)


</script>
<template>
    <AppLayout title="Dashboard">
        <div class="py-12">
            <div class="shadow-lg max-w-7xl mx-auto sm:px-6 lg:px-8 p-10">
                <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Car Details</h3>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-4">

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Badge Variant</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ data.badge_variant }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Body</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ data.body }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Colour</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ data.colour }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">CYL</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ data.cyl }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">W2/W4</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ data.w2_w4 }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Engine Capacity</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ data.engine_capacity }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Engine Code</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ data.engine_code }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Gearbox</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ data.gearbox }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Issues</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ data.issues }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Make</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ data.make }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Model</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ data.model }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Odometer</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ data.odometer }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">PPSR NO</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ data.ppsr_no }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Rego</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ data.rego }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Stock No</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ data.stock_no }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">VIN NO</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ data.vin_no }}</dd>
                            </div>


                            <div class="sm:col-span-4">
                                <dt class="text-sm font-medium text-gray-500">Description</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ data.description }}</dd>
                            </div>

                        </dl>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Attachments</dt>
                                <div class="bg-white">
                                    <div class="mx-auto max-w-2xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
                                        <h2 class="sr-only">Products</h2>
                                        <div
                                            class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                                            <a v-for="item in data.srcImages"
                                                class="group">
                                                <div
                                                    class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                                                    <img :src="item"
                                                        class="h-full w-full object-cover object-center group-hover:opacity-75" />
                                                </div>
                                                
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>