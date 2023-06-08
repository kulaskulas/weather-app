<template>
    <div class="future-weather text-sm bg-gray-800 px-6 py-8 overflow-hidden rounded-b-lg">
        <div class="mb-3">
            <span class="text-xl">5 Day / 3 Hour Weather Forecast</span>
        </div>
        <div v-for="(forec,index) in five_day_forecast" :key="index">
            <div id="accordion-open" :data-accordion="{'open' : index == 0}">
                <h2 id="accordion-open-heading-1">
                    <button type="button" class="flex items-center justify-between w-full p-5 font-medium 
                    text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 
                    focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400
                    hover:bg-gray-100 dark:hover:bg-gray-800" :class="{'bg-gray-100' : index == 0}" 
                    :data-accordion-target="'#accordion-open-body-1'+forec.date" 
                    :aria-expanded="{'true' : index == 0}" 
                    aria-controls="accordion-open-body-1">
                    
                    <span class="flex items-center">
                        <span>{{ forec.date }} {{ forec.days }} </span>
                    </span>
                    <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" 
                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </h2>
                <div :id="'accordion-open-body-1'+forec.date" :class="{'hidden' : index > 0}" class="px-2 mb-5 rounded-b-lg" 
                    aria-labelledby="accordion-open-heading-1" style="border: solid 1px #E4E6EA ;">
                    <div v-for="(fc ,index) in forecast" :key="index">
                        <div v-if="forec.date == convertDate(fc.dt_txt)">
                            <div class="flex item-center py-5">
                                <div class="w-2/6 mt-5 text-gray-200">
                                    <div>
                                        <span class="text-xl">
                                            {{ this.$parent.roundTemp(fc.main.temp) }} &#8451;
                                        </span>   
                                    </div>
                                    <div>
                                        <span class="text-xs">wind : {{ Math.round(metricToKmph(fc.wind.speed)) }} km/h</span>
                                    </div>
                                </div>
                                <div class="w-4/6 flex items-center">
                                    <div class="ml-3">
                                        {{ fc.weather[0].description }}
                                    </div>
                                </div>
                                <div class="w-2/6 text-right">
                                    <div>
                                        <i :class="this.$parent.displayIcon(fc.weather[0].id)" class="owf-3x"></i>   
                                    </div>
                                    <div>
                                        {{ convertTime(fc.dt_txt) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment'
    export default {
        props : ['five_day_forecast', 'forecast'],
        methods : {
            convertDate (date) {
                return moment(date).format('YYYY-MM-DD')
            },

            metricToKmph (metric) {
                return metric * 3.6
            },

            convertTime (date) {
                return moment(date).format('hh:mm a')
            },
        }
    }
</script>