<template>
    <div class="relative">
        <div class="navbar-floating">
            <div class="vs-navbar vx-navbar">
                <div class="vs-con-items"></div>
                <div class="vs-spacer"></div>
                <!-- <notification-dropdown/> -->
                <ProfileDropDown/>
            </div>
        </div>
    </div>
</template>


<script>
import Vue from 'vue'
import Vuesax from 'vuesax'

import 'vuesax/dist/vuesax.css' //Vuesax styles
Vue.use(Vuesax)

import ProfileDropDown      from './ProfileDropDown.vue'
import NotificationDropdown from './NotificationDropdown.vue'

export default {
  name: 'the-navbar-vertical',
  props: {
    navbarColor: {
      type: String,
      default: '#fff'
    }
  },
  components: {
    ProfileDropDown,
    NotificationDropdown
  },
  computed: {

  },
  methods: {

  },
}
</script>

<style lang="scss">
.relative {
    position: relative !important;
    .navbar-floating {
        padding: 1.3rem 2.2rem 2.2rem;
        width: calc(100% - 260px);
        position: fixed;
        z-index: 1000;
        top: 0;
        height: 103px;
        .vs-navbar {
            background: rgb(255, 255, 255);
            -webkit-transition: all .5s;
            width: 100%;
            z-index: 10000;
            clear: both;
            display: flex;
            align-items: center;
            -webkit-box-pack: justify;
            justify-content: space-between;
            box-shadow: 0 4px 20px 0 rgb(0 0 0 / 5%);
            position: relative;
        }
        .vx-navbar {
            border-radius: .5rem;
            padding: .8rem 1rem;
            height: 100%;
        }
    }
}
.vs-con-items{
    display: flex !important;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
}
.vs-spacer {
    display: block !important;
    padding: 0;
    margin: 0;
    -webkit-box-flex: 1!important;
    -ms-flex-positive: 1!important;
    flex-grow: 1!important;
    background: transparent;
}
</style>
