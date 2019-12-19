<template>
  <div class="graph-container">
    <canvas id="graph" ref="graph"/>
  </div>
</template>

<script>
import Chart from 'chart.js'

export default {
   data () {
    return {
      
       datachart: '',
    }
  },
  props: {
    labels: {
      type: Array,
      require: true,
      default: Array
    },
    values: {
      type: Array,
      require: true,
      default: Array
    }
  },

  mounted () {
for(var i=0; i<=1; i++){
      if(i==0){
        this.getTodos()
      }else{
        setInterval(this.getTodos, 30000)
      }
    }
  },
  methods: {

    async getTodos () {

    let context = this.$refs.graph.getContext('2d')
    let options = {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        display: false
      }
    }

    let response =   await window.axios.get('/api/getDataSMPrueba?username=')
      
        // JSON responses are automatically parsed.
        const responseData = response.data
        let datachart = this.chartData = {
          labels: responseData.map(item => item.username),
          datasets: [
            {
              label: '% Productividad',
              backgroundColor: '#ffde00',
              data: responseData.map(item => item.productividad),
              order:1
            },
            {
              label: '% Meta',
              backgroundColor: '#E9F339',
              data: responseData.map(item => item.goal),
              type: 'line',
              order: 2,
              fill: false,
              lineTension: 0.1,
              backgroundColor: 'rgba(0,125,204,0.4)',
              borderColor: 'rgba(0,125,204,1)',
              borderCapStyle: 'butt',
              borderDash: [],
              borderDashOffset: 0.0,
              borderJoinStyle: 'miter',
              pointBorderColor: 'rgba(75,192,192,1)',
              pointBackgroundColor: '#fff',
              pointBorderWidth: 1,
              pointHoverRadius: 5,
              pointHoverBackgroundColor: 'rgba(75,192,192,1)',
              pointHoverBorderColor: 'rgba(220,220,220,1)',
              pointHoverBorderWidth: 2,
              pointRadius: 1,
              pointHitRadius: 10,
            },
            
          ]
        }
      
    this.myBarChart = new Chart(context, {
      type: 'bar',
      data: datachart,
      options: options
    })
    
    },

    beforeDestroy () {
      this.myBarChart.destroy()
    }
  
  }

  
}
</script>

<style scoped>
.graph-container {
  height: 300px;
}

.home-container{
  margin: 150px 5% 5% 5%;
}
</style>
