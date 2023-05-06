<template>
    <div class="login-wrapper open">
      <div v-if="$auth.loggedIn">
        <h5>{{ $auth.user.name }}</h5>
        <div class="row">
          <div class="col-6">
            <NuxtLink to="/thong-tin-nguoi-dung" class="option text-center">
              <i class="fad fa-clipboard-user"></i><br>
              Thông tin cá nhân
            </NuxtLink>
          </div>
          <div class="col-6">
            <a href="#" class="option text-center" @click="logout">
              <i class="fad fa-sign-out-alt"></i><br>
              Đăng xuất
            </a>
          </div>
        </div>
      </div>
      <div v-else>
        <form>
            <div class="h4">Đăng nhập</div>
            <div class="form-group">
                <input type="email" v-model="form.email" class="form-control" id="exampleInputEmail1" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" v-model="form.password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-group">
                <NuxtLink to="/register" class="open-popup">Đăng kí</NuxtLink>
            </div>
            <button type="button" class="btn btn-block btn-main" @click="login">Đăng nhập</button>
        </form>
      </div>
    </div>
</template>
<script>
import Swal from 'sweetalert2'

export default {
  data() {
    return {
      form: {}
    }
  },
  methods: {
    async login() {
      try {
        await this.$auth.loginWith('laravelJWT', {
          data: {
            email: this.form.email,
            password: this.form.password
          }
        }).then(res => {
          Swal.fire({
            icon: 'success',
            title: 'Đặng nhập thành công',
            showConfirmButton: false,
            timer: 1500
          })
        }).catch(err => {
          Swal.fire({
            icon: 'error',
            title: 'Tài khoản hoặc mật khẩu không chính xác!',
            showConfirmButton: false,
            timer: 1500
          })
        })
      } catch (err) {

      }
    },
    async logout() {
      await this.$auth.logout()
    }
  }
}
</script>
<style>
.open {
    transition: opacity .5s;
}
.option {
  box-shadow: 0 1px 2px rgb(0 0 0 / 10%);
  background-color: white;
  transition: all 0.5s;
}
.option:hover {
  box-shadow: 2px 1px 2px rgb(0 0 0 / 10%);
}
.option i{
  font-size: 50px;
  margin-bottom: 5px;
  color: #ffb701;
}
</style>
