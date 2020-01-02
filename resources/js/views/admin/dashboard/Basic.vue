<template>
  <div id="dashboardPage" class="main-content">
    <div class="row">
      <div class="col-md-12 col-lg-6 col-xl-3">
        <a class="dashbox" href="#">
          <i class="icon-fa icon-fa-envelope text-primary"/>
          <span class="title">
            35
          </span>
          <span class="desc">
            Mails
          </span>
        </a>
      </div>
      <div class="col-md-12 col-lg-6 col-xl-3">
        <a class="dashbox" href="#">
          <i class="icon-fa icon-fa-ticket text-success"/>
          <span class="title">
            200
          </span>
          <span class="desc">
            Pending Tickets
          </span>
        </a>
      </div>
      <div class="col-md-12 col-lg-6 col-xl-3">
        <a class="dashbox" href="#">
          <i class="icon-fa icon-fa-shopping-cart text-danger"/>
          <span class="title">
            100
          </span>
          <span class="desc">
            New Orders
          </span>
        </a>
      </div>
      <div class="col-md-12 col-lg-6 col-xl-3">
        <a class="dashbox" href="#">
          <i class="icon-fa icon-fa-comments text-info"/>
          <span class="title">
            59
          </span>
          <span class="desc">
            Comments
          </span>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-xl-6 mt-2">
        <site-ranking />
      </div>
      <div class="col-lg-12 col-xl-6 mt-2">
       <div class="card">
            <div class="card-header">
              <h5 class="todo-title">% Productividad</h5>
              <p class="text-sm-center"> </p>
            </div>
            <div class="card-body">
              <div class="mb-4">
                   <bar-graph/>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
import LineGraph from '../../../components/chartjs/LineChart.vue'
import BarGraph from '../../../components/chartjs/BarChart.vue'
import PieGraph from '../../../components/chartjs/PieChart.vue'
import SiteRanking from '../../front/Home.vue'
export default {
  components: {
    LineGraph,
    BarGraph,
    PieGraph,
    SiteRanking
  },
  data () {
    return {
      'header': 'header'
    }
  }
}
</script>
