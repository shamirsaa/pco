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
    <div class="col-12">
<site-home/>
    </div>
    
    <site-ranking/>
    <site-footer/>

  </div>
  
      
</template>
<script type="text/babel">
import SiteRanking from '../front/Ranking.vue'
import SiteHome from '../front/Home.vue'
import SiteFooter from './partials/TheSiteFooter.vue'


export default {
  components: {
    SiteFooter,SiteRanking, SiteHome
  },
  mounted () {
    this.$utils.setLayout('front')
  }
}
</script>