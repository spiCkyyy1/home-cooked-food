<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import TextAreaInput from "@/Components/TextAreaInput.vue";
import {onMounted, ref} from "vue";
import axios from "axios";
// Setting the default coordinates to London
const coords = ref({ lat: 51.5072, lng: 0.1276 })
// Marker Details
const markerDetails = ref({
    id: 1,
    position: coords.value
})
// Get users' current location
const getUserLocation = () => {
    // Check if geolocation is supported by the browser
    const isSupported = 'navigator' in window && 'geolocation' in navigator
    if (isSupported) {
        // Retrieve the user's current position
        navigator.geolocation.getCurrentPosition((position) => {
            coords.value.lat = position.coords.latitude
            coords.value.lng = position.coords.longitude
        })
    }
}

// Set the location based on the place selected
const setPlace = (place) => {
    form.address = place.name;
    form.latitude = place.geometry.location.lat()
    form.longitude = place.geometry.location.lng()
}

const form = useForm({
    name: '',
    description: '',
    address: '',
    number: '',
    postCode: '',
    timings: [],
    shopClosed: [],
    longitude: '',
    latitude: '',
});
onMounted(() => {
    getStoreInformation();
    // getUserLocation();
})

function getStoreInformation(){
    axios.get('/store/get')
        .then((response) => {
            if(response.data.success){
                form.name = response.data.success.name;
                form.description = response.data.success.description;
                form.address = response.data.success.address;
                form.number = response.data.success.number;
                form.postCode = response.data.success.post_code;
                form.longitutde = response.data.success.longitude;
                form.latitude = response.data.success.latitude;
                let timings = response.data.success.timings;
                timings.forEach((value, key) => {
                   if(value.status === 'closed'){
                       form.shopClosed[key] = true;
                   }
                   if(value.start_hour != null && value.end_hour != null){
                       const [hrs, mins, secs] = value.start_hour.split(':')
                       const [endHrs, endMins, endSec] = value.end_hour.split(':')
                       form.timings[key] = [{
                           hours: hrs,
                           minutes: mins,
                           seconds: secs
                       },{
                           hours: endHrs,
                           minutes: endMins,
                           seconds: endSec
                       }];
                   }
                });

            }
        })
}
const updateStore = () => {
    form.post(route('store.update'), {
        preserveScroll: true,
        onSuccess: (response) => {
            getStoreInformation();
        },
        onError: () => {
            console.log('onError' + form.errors);
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Update Store Information</h2>
        </header>

        <div v-if="$page.props.flash.success" class="alert alert-success">
            {{ $page.props.flash.success }}
        </div>

        <form @submit.prevent="updateStore" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="storeName"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div>
                <InputLabel for="description" value="Description" />

                <TextAreaInput
                    id="description"
                    type="textarea"
                    class="mt-1 block w-full"
                    v-model="form.description"
                    required
                    autofocus
                    autocomplete="description"
                />

                <InputError :message="form.errors.description" class="mt-2" />
            </div>

            <div>
                <InputLabel for="address" value="Address" />
                <span v-if="form.address !== ''">{{form.address}}</span>
                <GMapAutocomplete
                    placeholder="Search for a location"
                    @place_changed="setPlace"
                    class="form-control" style="width: 100%"
                >
                </GMapAutocomplete>

                <InputError :message="form.errors.address" class="mt-2" />
            </div>

            <div>
                <InputLabel for="timing" value="Timings" />
                <div class="flex flex-row" v-for="(n, i) in 7" :key="i">
                    <div>
                        <span class="font-bold" v-if="i===0">
                            Monday
                        </span>
                        <span class="font-bold" v-if="i===1">
                            Tuesday
                        </span>
                        <span class="font-bold" v-if="i===2">
                            Wednesday
                        </span>
                        <span class="font-bold" v-if="i===3">
                            Thursday
                        </span>
                        <span class="font-bold" v-if="i===4">
                            Friday
                        </span>
                        <span class="font-bold" v-if="i===5">
                            Saturday
                        </span>
                        <span class="font-bold" v-if="i===6">
                            Sunday
                        </span>
                    </div>
                    <div class="w-100 ml-4 mr-4" :key="i">
                        <VueDatePicker  time-picker
                                        v-model="form.timings[i]"
                                       disable-time-range-validation range placeholder="Select Shop timings"
                                       :is-24="false" />
                    </div>
                    <div>
                        <label class="relative inline-flex items-center mb-4 cursor-pointer">
                            <input type="checkbox" v-model="form.shopClosed[i]" value="" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Closed</span>
                        </label>
                    </div>
                </div>
                <InputError :message="form.errors.timing" class="mt-2" />
            </div>


            <div>
                <InputLabel for="contact" value="Contact" />

                <TextInput
                    id="contact"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.number"
                    required
                    autofocus
                    autocomplete="contact"
                />

                <InputError :message="form.errors.number" class="mt-2" />
            </div>

            <div>
                <InputLabel for="postCode" value="Post Code" />

                <TextInput
                    id="postCode"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.postCode"
                    required
                    autofocus
                    autocomplete="postCode"
                />

                <InputError :message="form.errors.postCode" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
            <div v-if="form.latitude && form.longitude">
            <GMapMap
                :center="{ lat: form.latitude, lng: form.longitude }"
                :zoom="10"
                map-type-id="terrain"
                style="width: 100vw; height: 20rem"
                :options="{
                zoomControl: true,
                mapTypeControl: true,
                scaleControl: true,
                streetViewControl: true,
                rotateControl: true,
                fullscreenControl: true
                }"
            >
                <!-- Marker to display the searched location -->
                <GMapMarker
                    :key="markerDetails.id"
                    :position="{ lat: form.latitude, lng: form.longitude }"
                    :draggable="false"

                >
                    <!-- InfoWindow to display the searched location details -->
                    <GMapInfoWindow
                        v-if="form.address !== ''"
                        :opened="openedMarkerID === markerDetails.id"
                        :options="{
              pixelOffset: {
                width: 10,
                height: 0
              },
              maxWidth: 320,
              maxHeight: 320
            }"

                    >
                        <div class="location-details">
                            <p> Added Info </p>
                        </div>
                    </GMapInfoWindow>
                </GMapMarker>
            </GMapMap>
            </div>

        </form>
    </section>
</template>
