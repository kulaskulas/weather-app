<template>
    <div class="text-white mb-8 mx-2">
        <div class="location-input"> 
            <div class="grid items-center">
                <div class="flex justify-center items-center mb-3">
                    <img src="./../../../../public/images/weather-app-logo-1.png" alt="weather-app-logo-1" width="110">
                </div>
                <form @submit.prevent="">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="search" v-model="search_query" id="simple-search" 
                        class="bg-gray-50 border border-gray-700 text-gray-900 text-sm rounded-lg 
                        focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Location" required
                        @keyup="searchLocation"
                        >
                    </div>
                </form>
                <div v-if="location_search_results.length > 0 && search_query" class="rounded-lg mt-2">
                    <div class="bg-white w-[385px] px-3 py-1 border border-solid border-b-black cursor-pointer" v-for="(result, index) in location_search_results" :key="index">
                        <div class="" @click="selectLocation(result.lat, result.lon, result.formatted)">
                            <span class="text-gray-800">{{ result.formatted }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-2xl mt-5" :class="{'hidden' : current_location}">
            <div class="px-40">
                <img src="./../../../../public/images/loc-alt.png" alt="" height="70" width="70" class="object-center">
            </div>
            <div class="text-center text-gray-800 mt-2">
                Please Select Location!
            </div> 
        </div>
        <!-- bg-[#217eba] -->
        <div class="weather-container font-sans w-96 max-w-lg overphpflow-hidden bg-gray-900  shadow-lg mt-4 rounded-lg" :class="{'hidden' : !current_location}">
            <!-- <Loader :curr_weather="currentWeather.current_date_dt"/> -->

            <div class="p-5" :class="{'hidden' : !currentWeather.current_date_dt}">
                <span>{{ daysF(currentWeather.dt) }}</span><br>
                <span>Current Weather</span>
            </div>
            <!-- <div>{{ convertUnixToDateTime(currentWeather.current_date_dt) }}</div> -->
            <div class="current-weather flex item-center justify-between px-6 pb-8" :class="{'hidden' : !currentWeather.current_date_dt}">
                <div class="flex item-center">
                    <div>
                        <div class="text-6xl font-semibold">{{ roundTemp(currentWeather.temp) }}&#8451;</div>
                        <div>Feels like {{ roundTemp(currentWeather.feels) }} &#8451;</div>
                    </div>
                    <div class="mx-5 mt-3">
                        <div class="font-semibold">{{ currentWeather.dsec_main }}</div>
                        <div>{{ currentWeather.location }}</div>
                    </div>
                </div>
                <div>
                    <i :class="displayIcon(currentWeather.icon)" class="owf-5x"></i>
                </div>
            </div>

            <Loader :curr_weather="currentWeather.current_date_dt"/>
            <Forecast :five_day_forecast="five_day_forecast" 
                      :forecast="forecast"
                      :class="{'hidden' : forecast.length == 0 || !currentWeather.current_date_dt}"/>
            
        </div>
    </div>
</template>
<style scoped>
input[type=search]::-webkit-search-cancel-button {
    -webkit-appearance: searchfield-cancel-button;
}
</style>
<script>

import Loader from './Loader.vue'
import Forecast from './Forecast.vue'
import moment from 'moment'
    var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    var cur_loc = localStorage.getItem('loc') // saved location from localstorage. the last search locatioin

    export default {
        data () {
            return {
                current_location : localStorage.getItem('loc'),
                timer : 0,
                search_query : '',
                currentWeather : {
                    temp :'',
                    location : '',
                    feels : '',
                    icon : '',
                    desc_main : '',
                    dt : '',
                    current_date_dt : ''
                },

                five_day_forecast : [
                    {date : moment().format('YYYY-MM-DD'), days : moment().format('dddd')}
                ],

                curr_loop : 0,
                location_search_results : [],

                forecast : [],
                location : {
                    latitude : '',
                    longitude : '',
                },

                current_date : moment().format('YYYY-MM-DD')
            }
        },

        mounted() {
            
            if (cur_loc) {
                this.location.latitude = JSON.parse(cur_loc).lat
                this.location.longitude = JSON.parse(cur_loc).lon

                this.fetchWeatherForecast()
                this.fetchCurrentWeather()
            }
            this.getThisWeekDates()
        },

        components : {
            Loader, Forecast
        },
        
        methods : {
            selectLocation (lat, lon, location) {
                this.search_query = location
                this.location.latitude = lat
                this.location.longitude = lon
                this.currentWeather = {}

                localStorage.setItem('loc', JSON.stringify({lat : lat, lon : lon}))
                this.current_location = localStorage.getItem('loc')

                this.axios.get(`/api/weather-forecast?latitude=${this.location.latitude}&longitude=${this.location.longitude}`)
                .then((response) => {
                    this.forecast = response.data.list
                    console.log(response.data)
	            })
                .catch(function (error) {
                    // alert("Oops, something went wrong!")
                    console.log(error)
                })

                this.axios.get(`/api/current-weather?latitude=${this.location.latitude}&longitude=${this.location.longitude}`)
                .then((response) => {
                    this.currentWeather.temp = response.data.main.temp
                    this.currentWeather.feels = response.data.main.feels_like
                    this.currentWeather.dt = response.data.dt
                    this.currentWeather.location = response.data.name
                    this.currentWeather.icon = response.data.weather[0].id
                    this.currentWeather.dsec_main = response.data.weather[0].description
                    this.currentWeather.current_date_dt = response.data.dt
	            })
                .catch(function (error) {
                    // alert("Oops, something went wrong!")
                    console.log(error)
                })
              
                this.location_search_results = []
            },

            fetchWeatherForecast () {
                this.axios.get(`/api/weather-forecast?latitude=${this.location.latitude}&longitude=${this.location.longitude}`)
                .then((response) => {
                    this.forecast = response.data.list
                    console.log(response.data)
	            })
                .catch(function (error) {
                    // alert("Oops, something went wrong!")
                    console.log(error)
                })
            },

            fetchCurrentWeather () {
                this.axios.get(`/api/current-weather?latitude=${this.location.latitude}&longitude=${this.location.longitude}`)
                .then((response) => {
                    this.currentWeather.temp = response.data.main.temp
                    this.currentWeather.feels = response.data.main.feels_like
                    this.currentWeather.dt = response.data.dt
                    this.currentWeather.location = response.data.name
                    this.currentWeather.icon = response.data.weather[0].id
                    this.currentWeather.dsec_main = response.data.weather[0].description
                    this.currentWeather.current_date_dt = response.data.dt
	            })
                .catch(function (error) {
                    console.log(error);
                })
            },
            
            searchLocation() {
                let _this = this

                if (_this.search_query.trim().length == 0) {
                    return false;
                }

                clearTimeout(this.timer);
                _this.timer=setTimeout(function validate(){
                    _this.axios.get(`https://api.geoapify.com/v1/geocode/autocomplete?text=${_this.search_query}&format=json&apiKey=b9792a6d850a40b5a05253432d6be2de`)
                    .then((response) => {
                        _this.location_search_results = response.data.results
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
                },200);
                
            },

            roundTemp(temp) {
                return Math.round(temp)
            },  

            displayIcon (icon) {
                return 'owf owf-'+icon
            },

            daysF (dt) {
                var d = new Date(dt * 1000);
                var dayName = days[d.getDay()];
                return dayName
            },

            convertUnixToDateTime(unixDate) {
                return moment.unix(unixDate).format("YYYY-MM-DD hh:mm a");
            },

            getThisWeekDates() {
                for (var i = 1; i <=4; i++) {
                    this.five_day_forecast.push({date : moment().add(i, 'days').format('YYYY-MM-DD'), days : moment().add(i, 'days').format('dddd')}); 
                }
            },

            // showPosition(position) {
            //     this.location.longitude = position.coords.longitude
            //     this.location.latitude = position.coords.latitude 
            // }
            
        }
    }
</script>