<template>
<nav class="navbar navbar-default navbar-wrapper" v-if="!hide" v-bind:class="{transparent: transparent}">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-dropdown-menu-small" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <router-link to="/" class="navbar-brand"><img v-bind:src="`${baseUrl}/images/Med_logo.png`"/></router-link>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar-dropdown-menu-small">
      <ul class="nav navbar-nav">
          <li><router-link to="/user">All account</router-link></li>
      </ul>
      <ul class="nav navbar-nav navbar-right" v-if="isLoggedIn">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ getName }}<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><router-link to="/profile">Profile</router-link></li>
            <li><router-link to="/logout">Logout</router-link></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</template>


<script>
  import { mapState, mapGetters } from 'vuex'

  export default {
    data(){
      return {
        transparent: false,
        hide: false,
        baseUrl: this.$store.getters.baseUrl
      }
    },
    computed: {
      ...mapState([
        'isLoggedIn'
      ]),
      ...mapGetters([
        'getName',
        'isTeacher'
      ])
    },
    created(){
      this.$store.dispatch('getPersonal')
      this.setStyle(this.$route)
      this.$watch('$route', this.setStyle)
    },
    methods:{
      setStyle(route){
        this.transparent = false
        this.hide = false
        if(route.meta.navstyle){
          if(route.meta.navstyle.transparent){
            this.transparent = route.meta.navstyle.transparent
          }

          if(route.meta.navstyle.hide){
            this.hide = route.meta.navstyle.hide
          }
        }
      }
    }
  }
</script>