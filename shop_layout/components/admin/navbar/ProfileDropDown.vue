<template>
    <div class="navbar-user">
        <div class="user-name">
            <p>{{ user.name }}</p>
            <small>Admin</small>
        </div>
        <b-dropdown variant="link" toggle-class="text-decoration-none" no-caret>
            <template #button-content>
                <i class="fal fa-user-circle" style="font-size: 40px;"></i>
            </template>
            <b-dropdown-item-button>Profile</b-dropdown-item-button>
            <b-dropdown-divider></b-dropdown-divider>
            <b-dropdown-item-button @click="logout">Logout</b-dropdown-item-button>
        </b-dropdown>
    </div>
</template>

<script>
export default {
  data () {
    return {
      user: {}
    }
  },
  computed: {
  },
  methods: {
    async logout() {
      await this.$auth.logout()
    }
  },
  async created() {
    this.user = await this.$auth.user
  }
}
</script>
<style lang="scss">
.navbar-user {
    -webkit-box-align: center !important;
    -ms-flex-align: center !important;
    align-items: center !important;
    display: -webkit-box !important;
    display: -ms-flexbox !important;
    display: flex !important;
}
.user-name {
    text-align: right !important;
    display: block !important;
    line-height: 1 !important;
    p {
        font-weight: 600 !important;
    }
}
.vs-dropdown {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.12), 0 2px 4px 0 rgba(0,0,0,0.08) !important;
    border-radius: 9999px !important;
}
</style>
