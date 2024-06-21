import { createApp } from 'vue';
import WeatherComponent from './components/WeatherComponent.vue';

const app = createApp({});
app.component('weather-component', WeatherComponent);
app.mount('#app');
