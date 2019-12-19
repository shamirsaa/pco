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
              backgroundColor: '#f87979',
              data: responseData.map(item => item.productividad)
            },
            {
              label: 'Cerrados',
              backgroundColor: '#000000',
              data: responseData.map(item => item.cerrados),
              type: 'line'
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
