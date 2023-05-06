<template>
  <div>
    <section class="main-header">
      <header>
          <div class="container text-center">
              <h2 class="h2 title">Customer page</h2>
              <ol class="breadcrumb breadcrumb-inverted">
                  <li><a href="/"><span class="icon icon-home"></span></a></li>
                  <li><a class="active" href="login">Đăng nhập & Đăng kí</a></li>
              </ol>
          </div>
      </header>
    </section>

    <!-- ========================  Login & register ======================== -->

    <section class="login-wrapper login-wrapper-page">
        <div class="container">

            <header class="hidden">
                <h3 class="h3 title">Sign in</h3>
            </header>

            <div class="row">

                <!-- === left content === -->

                <div class="col-md-6 col-md-offset-3">

                    <!-- === login-wrapper === -->

                    <div class="login-wrapper">

                        <div class="white-block">

                            <div class="login-block login-block-signup">

                                <div class="h4">Đăng kí <NuxtLink to="/login" class="btn btn-main btn-xs btn-login pull-right">Đăng nhập</NuxtLink></div>

                                <hr />

                                <div class="row">

                                    <el-form ref="formRegister" :model="formRegister" :rules="validate">
                                    <el-col :span="24">
                                      <el-form-item prop="name">
                                        <el-input v-model="formRegister.name" type="text" placeholder="Họ tên"></el-input>
                                      </el-form-item>
                                    </el-col>
                                    <el-col :span="24">
                                      <el-form-item prop="email">
                                        <el-input v-model="formRegister.email" type="email" placeholder="Email"></el-input>
                                      </el-form-item>
                                    </el-col>
                                    <el-col :span="24">
                                      <el-form-item prop="password">
                                        <el-input v-model="formRegister.password" type="password" placeholder="Mật khẩu"></el-input>
                                      </el-form-item>
                                    </el-col>
                                    <el-col :span="24">
                                      <el-form-item prop="confirm">
                                        <el-input v-model="formRegister.password_confirmation" type="password" placeholder="Xác nhận mật khẩu"></el-input>
                                      </el-form-item>
                                    </el-col>
                                    <el-col :span="12" class="pr-2">
                                      <el-form-item prop="birth">
                                        <el-input v-model="formRegister.birth" type="date" placeholder="Ngày sinh"></el-input>
                                      </el-form-item>
                                    </el-col>
                                    <el-col :span="12">
                                      <el-form-item prop="phone">
                                        <el-input v-model="formRegister.phone" type="number" placeholder="Số điện thoại"></el-input>
                                      </el-form-item>
                                    </el-col>
                                    <el-col :span="24">
                                      <el-form-item>
                                        <el-radio-group v-model="formRegister.gender">
                                          <el-radio :label="1">Nam</el-radio>
                                          <el-radio :label="0">Nữ</el-radio>
                                        </el-radio-group>
                                      </el-form-item>
                                    </el-col>
                                    <el-col :span="24">
                                      <el-form-item prop="address">
                                        <el-input v-model="formRegister.address" type="text" placeholder="Địa chỉ"></el-input>
                                      </el-form-item>
                                    </el-col>
                                    <el-col :span="24">
                                      <el-form-item class="text-center">
                                        <el-button type="warning" class="w-100" @click="register">Đăng kí</el-button>
                                      </el-form-item>
                                    </el-col>
                                  </el-form>

                                </div>
                            </div> <!--/signup-->
                        </div>
                    </div> <!--/login-wrapper-->
                </div> <!--/col-md-6-->

            </div>

        </div>
    </section>
  </div>
</template>

<script>
import Swal from 'sweetalert2'

export default {
  data() {
    var validatePass = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('Vui lòng nhập lại mật khẩu'));
      } else if (value !== this.formRegister.password) {
        callback(new Error('Không khớp với mật khẩu'));
      } else {
        callback();
      }
    };
    return {
      islogin: true,
      formLogin: {},
      formRegister: {
        gender: 1,
      },
      validate: {
        password: [
          { required: true, message: 'Vui lòng nhập mật khẩu', trigger: 'blur' }
        ],
        name: [
          {required: true, message: 'Vui lòng nhập họ tên', trigger: 'blur'}
        ],
        email: [
          { required: true, message: 'Vui lòng nhập địa chỉ email', trigger: 'blur' },
          {
            type: 'email',//The type to be checked (number, email, date, etc.)
            message: 'Vui lòng nhập địa chỉ email chính xác',
            trigger: ['blur', 'change']//change is when the tested character changes)
          }
        ],
        confirm: [
          { validator: validatePass, trigger: 'blur' }
        ],
        birth: [
          { required: true, message: 'Vui lòng nhập ngày sinh', trigger: 'blur' },
        ],
        phone: [
          { required: true, message: 'Vui lòng nhập số điện thoại', trigger: 'blur' },
          { required: 'number', message: 'Vui lòng nhập số điện thoại', trigger: 'blur' }
        ],
        address: [
          { required: true, message: 'Vui lòng nhập ngày sinh', trigger: 'blur' },
        ],
      },
    }
  },
  methods: {
    register() {
      this.$refs.formRegister.validate((valid) => {
        if (valid) {
          this.$axios.post('/register', this.formRegister).then((res) => {
            this.$auth.loginWith('laravelJWT', {
              data: {
                email: this.formRegister.email,
                password: this.formRegister.password
              }
            }).then((res) => {
              Swal.fire({
                icon: 'success',
                title: 'Đặng kí thành công',
                showConfirmButton: false,
                timer: 1500
              })
              this.$router.push('/')
            })
          }).catch((err) => {
            Swal.fire({
              icon: 'error',
              title: 'Đăng kí tài khoản không thành công!',
              showConfirmButton: false,
              timer: 1500
            })
          })
        }
      })
    }
  }
}
</script>

<style>
.breadcrumb {
  display: inline-block !important;
}
.login-wrapper .login-block.login-block-signin{
  display: inline-block;
}
</style>
