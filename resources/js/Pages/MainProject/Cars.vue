<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { EnvelopeIcon, PhoneIcon } from '@heroicons/vue/20/solid'
import { getFirestore, collection, getDocs, doc, getDoc, query, orderBy, endBefore, startAfter, limit } from '@firebase/firestore';
import db from '../../firebase.js';
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { getStorage, uploadBytes, getDownloadURL, ref as storREF } from "firebase/storage";
import { ArrowLongLeftIcon, ArrowLongRightIcon } from '@heroicons/vue/20/solid'
const storage = getStorage(db);
const carlistGolabel = ref([]);
const lastVisible = ref([]);
onMounted(async () => {
  const getdata = getFirestore(db);
  const first = query(collection(getdata, "car_details"), orderBy("doc_id"), limit(8));
  const querySnapshot = await getDocs(first);
  let carListNew = [];
  querySnapshot.forEach((doc) => {
    const carlistNewLocal = doc.data()
    carListNew.push(carlistNewLocal);
  });
  lastVisible.value = querySnapshot.docs[querySnapshot.docs.length - 1];
  console.log("last", lastVisible.value);


  carlistGolabel.value = carListNew;

});

async function next() {
  carlistGolabel.value = []
  const getdatanext = getFirestore(db);
  const next2 = query(collection(getdatanext, "car_details"), orderBy("doc_id"), startAfter(lastVisible.value), limit(8));
  const querySnapshotnext = await getDocs(next2);
  let carListNewnext = [];
  querySnapshotnext.forEach((doc) => {
    const carlistNewLocalnext = doc.data()
    carListNewnext.push(carlistNewLocalnext);
  });
  lastVisible.value = querySnapshotnext.docs[querySnapshotnext.docs.length - 1];

  carlistGolabel.value = carListNewnext;
  console.log("last", lastVisible.value);
}

async function previous() {

  carlistGolabel.value = []
  const getdataprevious = getFirestore(db);
  const previous = query(collection(getdataprevious, "car_details"), orderBy("doc_id"), endBefore(lastVisible.value), limit(8));
  const querySnapshotprevious = await getDocs(previous);
  let carListNewprevious = [];
  querySnapshotprevious.forEach((doc) => {
    const carlistNewLocalprevious = doc.data()
    carListNewprevious.push(carlistNewLocalprevious);
  });
  lastVisible.value = querySnapshotprevious.docs[querySnapshotprevious.docs.length - 1];

  carlistGolabel.value = carListNewprevious;
  console.log("last", lastVisible.value);
}


onMounted(next(), previous());

</script>

<template>
  <AppLayout title="Dashboard">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <Link :href="route('addNewCar')"
          class="inline-flex rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        Add New Car</Link>
        <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 my-5">
          <li v-for="(item, index) in carlistGolabel"
            class="col-span-1 flex flex-col divide-y divide-gray-200 rounded-lg bg-white text-center shadow">
            <div class="flex flex-1 flex-col p-8">
              <Link :href="route('CarDetails', item.doc_id)"> <img class="mx-auto h-32 w-32 flex-shrink-0 rounded-full"
                :src="item.srcImages[0]" alt="" />
              </Link>
              <h3 class="mt-6 text-sm font-medium text-gray-900">{{ item.make }}</h3>
              <dl class="mt-1 flex flex-grow flex-col justify-between">
                <dt class="sr-only">Title</dt>
                <dd class="text-sm text-gray-500">{{ item.model }}</dd>
              </dl>
            </div>
            <div>
              <div class="-mt-px flex divide-x divide-gray-200">
                <div class="flex w-0 flex-1">
                  <a href=""
                    class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-bl-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500">
                    <svg style="height: 20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                      strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
                      <path strokeLinecap="round" strokeLinejoin="round"
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    <span class="ml-3">Delete</span>
                  </a>
                </div>
                <div class="flex w-0 flex-1">
                  <Link :href="route('editCar', item.doc_id)" :data="item.srcImages"
                    class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-bl-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500">
                  <svg style="height: 20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg>
                  <span class="ml-3">Edit</span>
                  </Link>
                </div>
              </div>
            </div>
          </li>
        </ul>
        <nav class="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0">
          <div class="-mt-px flex w-0 flex-1">
            <button @click="previous()"
              class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
              <ArrowLongLeftIcon class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true" />
              Previous
            </button>
          </div>
        <!--  <div class="hidden md:-mt-px md:flex">
            <a href="#"
              class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">1</a>
            Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
           <!--  <a href="#"
              class="inline-flex items-center border-t-2 border-indigo-500 px-4 pt-4 text-sm font-medium text-indigo-600"
              aria-current="page">2</a>
            <a href="#"
              class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">3</a>
            <span
              class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500">...</span>
            <a href="#"
              class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">8</a>
            <a href="#"
              class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">9</a>
            <a href="#"
              class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">10</a>
          </div> -->
          <div class="-mt-px flex w-0 flex-1 justify-end">
            <a @click="next()"
              class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
              Next
              <ArrowLongRightIcon class="ml-3 h-5 w-5 text-gray-400" aria-hidden="true" />
            </a>
          </div>
        </nav>
      </div>

    </div>

  </AppLayout>
</template>