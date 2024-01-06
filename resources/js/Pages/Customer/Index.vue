<template>
    <div class="container mx-auto px-4 mt-4">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <GMapAutocomplete
                placeholder="Search for a location"
                @place_changed="setPlace"
                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            >
            </GMapAutocomplete>
        </div>
    </div>
    <div class="bg-white" v-show="menus.data">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Shop by Vendors</h2>

            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                <div v-for="menu in menus.data" v-show="showStore(menu)">
                    <div class="group relative">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80" v-if="menu.vendor.store">
                        <img :src="getImage(menu.background_image)" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <h3 class="text-sm text-gray-700">
                                <a :href="$route('show.menu', {id: menu.id})">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ menu.name}}
                                </a>
                            </h3>
                        </div>
                        <p class="text-sm font-medium text-gray-900" v-if="menu.description">{{menu.description}}</p>
                    </div>
                        <!-- Rating -->
                        <div class="flex flex-row-reverse justify-end items-center">
                            <input id="hs-ratings-readonly-1" v-model="menu.rating" type="radio" class="peer -ms-5 w-5 h-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="hs-ratings-readonly" value="1">
                            <label for="hs-ratings-readonly-1" class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-gray-600">
                                <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                </svg>
                            </label>
                            <input id="hs-ratings-readonly-2" v-model="menu.rating" type="radio" class="peer -ms-5 w-5 h-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="hs-ratings-readonly" value="2">
                            <label for="hs-ratings-readonly-2" class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-gray-600">
                                <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                </svg>
                            </label>
                            <input id="hs-ratings-readonly-3" v-model=menu.rating type="radio" class="peer -ms-5 w-5 h-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="hs-ratings-readonly" value="3">
                            <label for="hs-ratings-readonly-3" class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-gray-600">
                                <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                </svg>
                            </label>
                            <input id="hs-ratings-readonly-4" v-model="menu.rating" type="radio" class="peer -ms-5 w-5 h-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="hs-ratings-readonly" value="4">
                            <label for="hs-ratings-readonly-4" class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-gray-600">
                                <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                </svg>
                            </label>
                            <input id="hs-ratings-readonly-5" v-model="menu.rating" type="radio" class="peer -ms-5 w-5 h-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="hs-ratings-readonly" value="5">
                            <label for="hs-ratings-readonly-5" class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none dark:peer-checked:text-yellow-600 dark:text-gray-600">
                                <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                </svg>
                            </label>
                        </div>
                        <!-- End Rating -->
                    <div class="mt-4 justify-between">
                        <p class="text-sm font-medium text-gray-900" v-if="menu.vendor.name">Store By: {{menu.vendor.name}}</p>
                    </div>
                    <div class="mt-4 justify-between">
                          <p class="text-sm font-medium text-gray-900" v-if="menu.vendor.store">Store Address: {{menu.vendor.store.address}}</p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import axios from "axios";
import {ref} from "vue";

export default {
    data(){
        return {
            menus: {},
            baseURL: this.$page.props.baseUrl,
            lat: '',
            long: '',
            rating: {}
        }
    },
    mounted() {
        this.getmenus();
        this.getUserLocation();
    },
    methods: {
        getmenus(){
            // this.lat !== '' &&
            if(this.long !== ''){
                // latitude: this.lat,
                axios.get(this.baseURL+'/get-menus', {params: { longitude: this.long}})
                    .then(response => {
                        if(response.data.success){
                            this.menus = response.data.success;
                        }
                    })
            }else{
                axios.get(this.baseURL+'/get-menus')
                    .then(response => {
                        if(response.data.success){
                            this.menus = response.data.success;
                        }
                    })
            }


        },
        getImage(imagePath){
            return this.$page.props.storageLink+'/'+imagePath.replace("public", "");
        },
        setPlace(place){
            console.log(place);
            this.lat = place.geometry.location.lat();
            this.long = place.name;
            this.getmenus();
        },
        showStore(menu){
            console.log(menu);
            if(menu.vendor.store){
                return true;
            }
            return false;
        },
        getUserLocation(){
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
    }
};
</script>
