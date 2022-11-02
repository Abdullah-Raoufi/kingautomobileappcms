<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { EnvelopeIcon, PhoneIcon } from '@heroicons/vue/20/solid'
import { getFirestore, collection, getDocs,doc,getDoc } from '@firebase/firestore';
import db from '../../firebase.js';


const carList = [];

    const getData = async () => {
      const getdata = getFirestore(db);
      const carDetailsCollectionRef = collection(getdata, 'car_details');
      const data = await getDocs(carDetailsCollectionRef);
      console.log(data)
      console.log(data.docs);
      data.forEach((doc) => {
  // doc.data() is never undefined for query doc snapshots
  carList.push(doc.data())
  console.log(doc.id, " => ", doc.data());
});
console.log(carList[2].make);
    };
    getData();
  




</script>
EnvelopeIcon
<template>
    <AppLayout title="Dashboard">
    <div class="py-12">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              
  <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
    <li v-for="carList in car" :key="carList.email" class="col-span-1 flex flex-col divide-y divide-gray-200 rounded-lg bg-white text-center shadow">
      <div class="flex flex-1 flex-col p-8">
        <img class="mx-auto h-32 w-32 flex-shrink-0 rounded-full" :src="carList.imageUrl" alt="" />
        <h3 class="mt-6 text-sm font-medium text-gray-900">{{ carList.name }}</h3>
        <dl class="mt-1 flex flex-grow flex-col justify-between">
          <dt class="sr-only">Title</dt>
          <dd class="text-sm text-gray-500">{{ carList.title }}</dd>
          <dt class="sr-only">Role</dt>
          <dd class="mt-3">
            <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-800">{{ carList.role }}</span>
          </dd>
        </dl>
      </div>
      <div>
        <div class="-mt-px flex divide-x divide-gray-200">
          <div class="flex w-0 flex-1">
            <a :href="`mailto:${carList.email}`" class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-bl-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500">
              <EnvelopeIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
              <span class="ml-3">Delete</span>
            </a>
          </div>
          <div class="-ml-px flex w-0 flex-1">
            <a :href="`tel:${carList.telephone}`" class="relative inline-flex w-0 flex-1 items-center justify-center rounded-br-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500">
              <PhoneIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
              <span cPhoneIconlass="ml-3">Edit</span>
            </a>
          </div>
        </div>
      </div>
    </li>
  </ul>

          
            </div>
        </div>
    </AppLayout>
</template>