<template>
    <Line :data="data" :options="options" />
</template>
<script setup>

import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  ArcElement
} from 'chart.js'
import { Line } from 'vue-chartjs' 

const data = {
  labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio'],
  datasets: [
    {
      label: 'Creditos',
      backgroundColor: '#58D68D',
      data: [40, 39, 10, 40, 39, 80, 40]
    },
    {
      label: 'Pagos',
      backgroundColor: '#f87979',
      data: [10, 59, 30, 90, 40, 70, 50]
    }
  ]
}


const options = {
  responsive: true,
  maintainAspectRatio: false
}

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
)

</script> 