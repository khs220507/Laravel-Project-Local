<template>
  <div>
    <canvas ref="canvas"></canvas>
  </div>
</template>

<script>
import { ref, watch, onMounted } from 'vue';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

export default {
  props: {
    chartData: {
      type: Object,
      required: true
    }
  },
  setup(props) {
    const canvas = ref(null);
    let chartInstance = null;

    const createChart = () => {
      if (chartInstance) {
        chartInstance.destroy();
      }
      if (canvas.value) {
        chartInstance = new Chart(canvas.value.getContext('2d'), {
          type: 'bar',
          data: props.chartData,
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'top',
