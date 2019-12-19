<template>
  <div class="template-container">
    <header class="site-header">
      <a href="#" class="brand-main">
        <!-- <img
          id="logo-desk"
          src="/assets/img/logo-desk.png"
          alt="PCO Logo"
          class="d-none d-md-inline"
        > -->
        <p
          id="logo-desk"
          class="d-none d-md-inline"
        >Portal de Cifras Operativas</p>
        <p
          id="logo-mobile"
          c class="d-md-none"
        >PCO</p>
        <!-- <img
          id="logo-mobile"
          src="/assets/img/logo-mobile.png"
          alt="PCO Logo"
          class="d-md-none"
        > -->
      </a>
      <ul class="action-list">
        <li class="action-item">
          <router-link to="/admin/dashboard/basic">Iniciar Sesión</router-link>
        </li>
      </ul>
    </header>
    <transition name="fade" mode="out-in">
      <router-view/>
    </transition>
    <div class="row">
      <div class="col-sm-6">
        <site-home/>
      </div>
      <div class="col-sm-6">
        <div class="main-content home-container">
          <div class="card">
            <div class="card-header">
              <h5 class="todo-title">Productividad</h5>
              <p class="text-sm-center">Total de casos cerrados y cumplimiento de los mismos </p>
            </div>
            <div class="card-body">
              <div class="mb-4">
                    <bar-chart
                      :labels="['January', 'February', 'March', 'April', 'May', 'June', 'July']"
                      :values="[65, 59, 80, 81, 56, 55, 40, 20]"
                    />
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    
    <site-footer/>

  </div>
  
      
</template>
<script type="text/babel">
//import SiteRanking from '../front/Ranking.vue'
import SiteHome from '../front/Home.vue'
import SiteFooter from './partials/TheSiteFooter.vue'
import BarChart from '../../components/chartjs/BarChart.vue'


export default {
  components: {
    SiteFooter, SiteHome, BarChart   
  },
  mounted () {
    this.$utils.setLayout('front')
  }
}
</script>

<style scoped>

.home-container{
  margin: 100px 5% 5% 5%;
}
</style>
