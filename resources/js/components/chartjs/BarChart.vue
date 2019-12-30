<template>
  <div class="main-content vue-tabs-demo">
    <tabs class="tabs-simple">
      <tab id="simple-today" name="Hoy">
        <div class="graph-container">
          <canvas id="graph" ref="graph"/>
        </div>
      </tab>
      <tab id="simple-week" name="Esta Semana">
        <div class="graph-container">
          <canvas id="graphWeek" ref="graphWeek"/>
        </div>
      </tab>
      <tab id="simple-month" name="Este Mes">
       <div class="graph-container">
          <canvas id="graphMonth" ref="graphMonth"/>
        </div>
      </tab>
      <tab id="simple-trimester" name="Este Trimestre">
        A prefix and a suffix can be added
        <p>
          Lorem ipsum dolor, sit amet consectetur adipisicing elit.
        </p>
      </tab>
    </tabs>
  </div>
</template>

<script>
import { Tabs, Tab } from 'vue-tabs-component'
import Chart from 'chart.js'

export default {
  components: {
    'tabs': Tabs,
    'tab': Tab
  },
   data () {
    return {
      
       dataTodayChart: '',
       dataMonthChart: '',
       dataWeekChart: '',
       dateSearch: '',
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
        this.getMonth()
        this.getWeek()
      }else{
        setInterval(this.getTodos, 30000)
        setInterval(this.getWeek, 30000)
        setInterval(this.getMonth, 30000)
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
          display: true
        }
      }

      let response =   await window.axios.get('/api/getDataSMChart?date='+this.dateSearch)

        // JSON responses are automatically parsed.
        const responseData = response.data
        let dataTodayChart = this.chartData = {
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
          data: dataTodayChart,
          options: options,
        }),
          this.myBarChart.update({
            duration: 1000,
            easing: 'easeOutBounce'
          })
    },

    async getMonth () {

        let context = this.$refs.graphMonth.getContext('2d')
        let options = {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: true
          }
        }

        let response =   await window.axios.get('/api/getDataSMChart?date=month')

          // JSON responses are automatically parsed.
          const responseData = response.data
          let dataMonthChart = this.chartData = {
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
        
          this.myBarChartMonth = new Chart(context, {
            type: 'bar',
            data: dataMonthChart,
            options: options
          }),
          this.myBarChartMonth.update({
            duration: 1000,
            easing: 'easeOutBounce'
          })
      
    },

    async getWeek () {

        let context = this.$refs.graphWeek.getContext('2d')
        let options = {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: true
          }
        }

        let response =   await window.axios.get('/api/getDataSMChart?date=week')

          // JSON responses are automatically parsed.
          const responseData = response.data
          let dataWeekChart = this.chartData = {
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
        
          this.myBarChartMonth = new Chart(context, {
            type: 'bar',
            data: dataWeekChart,
            options: options
          }),
          this.myBarChartMonth.update({
            duration: 1000,
            easing: 'easeOutBounce'
          })
      
    },

    async beforeDestroy () {
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
