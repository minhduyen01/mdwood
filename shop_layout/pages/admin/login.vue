<template>
  <div class="auth-wrapper">
    <div class="row auth-inner m-0">
      <a class="brand-logo">
        <h4>Hatech</h4>
      </a>
      <div class="d-none d-lg-flex align-items-center p-5 col-lg-8" style="background-color: #f8f8f8;">
        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
          <img src="~/assets/image/maintenance.png" alt="img" class="img-fluid">
        </div>
      </div>
      <div class="d-flex align-items-center auth-bg px-3 p-lg-5 col-lg-4">
        <div class="px-xl-5 mx-auto col-sm-8 col-md-6 col-lg-12">
          <h2 class="card-title mb-1 font-weight-bold" style="font-size: 1.714rem;"> Trang quản lý Hatech 👋 </h2>
          <p class="card-text mb-2"> Vui lòng đăng nhập </p>
          <span>
            <el-form ref="formLogin" :model="form" label-width="140px" :rules="rules" label-position="top">
              <el-col :span="24">
                <el-form-item label="Email" prop="email">
                  <el-input v-model="form.email" type="email"></el-input>
                </el-form-item>
              </el-col>
              <el-col :span="24">
                <el-form-item label="Password" prop="password">
                  <el-input v-model="form.password" type="password"></el-input>
                </el-form-item>
              </el-col>
              <el-col :span="24">
                <el-form-item>
                  <el-checkbox label="Lưu tài khoản" name="type" v-model="form.remember"></el-checkbox>
                </el-form-item>
              </el-col>
              <el-col :span="24">
                <el-form-item class="text-center">
                  <el-button type="primary" class="w-75" @click="login">Đăng nhập</el-button>
                </el-form-item>
              </el-col>
            </el-form>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Swal from 'sweetalert2'

export default {
  layout: "blank",
  data() {
    return {
      form: {},
      rules: {
        email: [
          { required: true, message: 'Vui lòng nhập địa chỉ email', trigger: 'blur' },
          {
            type: 'email',//The type to be checked (number, email, date, etc.)
            message: 'Vui lòng nhập địa chỉ email chính xác',
            trigger: ['blur', 'change']//change is when the tested character changes)
          }
        ],
        password: [
          { required: true, message: 'Vui lòng nhập mật khẩu', trigger: 'blur' }
        ]
      }
    }
  },
  methods: {
    login() {
      this.$refs.formLogin.validate((valid) => {
        if (valid) {
          this.$auth.loginWith('laravelJWT', {
            data: {
              email: this.form.email,
              password: this.form.password
            }
          }).then((res) => {
            Swal.fire({
              icon: 'success',
              title: 'Đặng nhập thành công',
              showConfirmButton: false,
              timer: 1500
            })
            this.$router.push('/admin')
          }).catch((err) => {
            Swal.fire({
              icon: 'error',
              title: err.message,
              showConfirmButton: false,
              timer: 1500
            })
          })
        } else {
          return false;
        }
      })
    }
  }
}
</script>
<style>
body {
    font-family: Montserrat,Helvetica,Arial,serif;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.45;
    color: #6e6b7b;
}
.auth-wrapper{
  -webkit-box-align: start;
  -ms-flex-align: start;
  align-items: flex-start;
  display: flex;
  flex-basis: 100%;
  min-height: calc(var(--vh, 1vh)*100);
  width: 100%;
}
.auth-wrapper .auth-inner{
  overflow-y: auto;
  height: calc(var(--vh, 1vh)*100);
  width: 100%;
  position: relative;
}
.auth-wrapper .brand-logo{
  position: absolute;
  top: 2rem;
  z-index: 1;
  left: 2rem;
}
.p-5 {
  padding: 4rem!important;
}

.px-5 {
  padding-left: 4rem!important;
  padding-right: 4rem!important;
}

.auth-wrapper .auth-bg {
    background-color: #fff;
}

.el-form-item__label{
  margin: 0 !important;
  padding: 0 !important;
}
</style>
