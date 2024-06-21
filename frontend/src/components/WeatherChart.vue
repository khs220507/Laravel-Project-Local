<template>
    <div class="text-center">
      <h2 class="text-2xl font-bold mb-4">Weather Data from API</h2>
      <p v-if="loading">Loading...</p>
      <p v-if="error" class="text-red-500">{{ error }}</p>
      <div v-if="data">
        <p class="text-lg">Temperature: {{ data.temperature }} °C</p>
        <p class="text-lg">Humidity: {{ data.humidity }} %</p>
        <p class="text-lg">Date: {{ data.base_date }}</p>
        <p class="text-lg">Time: {{ data.base_time }}</p>
      </div>
      <div v-if="chartData">
        <bar-chart :chart-data="chartData" />
      </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import BarChart from './BarChart.vue';
  
  export default {
    components: {
      BarChart
    },
    setup() {
      const data = ref(null);
      const chartData = ref(null);
      const loading = ref(true);
      const error = ref(null);
  
      const fetchWeatherData = async () => {
        try {
          const response = await axios.get('/api/weather');
          data.value = response.data[0]; // 첫 번째 데이터를 사용
  
          const uniqueData = response.data.reduce((acc, current) => {
            const x = acc.find(item => item.base_time === current.base_time);
            if (!x) {
              return acc.concat([current]);
            } else {
              return acc;
            }
          }, []);
  
          chartData.value = {
            labels: uniqueData.map(item => item.base_time),
            datasets: [
              {
                label: 'Temperature (°C)',
                backgroundColor: '#FF6384',
                data: uniqueData.map(item => item.temperature),
              },
              {
                label: 'Humidity (%)',
                backgroundColor: '#36A2EB',
                data: uniqueData.map(item => item.humidity),
              },
            ],
          };
  
          loading.value = false;
        } catch (err) {
          error.value = 'Failed to fetch weather data';
          loading.value = false;
        }
      };
  
      onMounted(fetchWeatherData);
  
      return { data, chartData, loading, error };
    }
  };
  </script>
  
  <style scoped>
  </style>
  