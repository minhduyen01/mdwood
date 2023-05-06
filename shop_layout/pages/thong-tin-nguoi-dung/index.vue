<template>
  <div>
    <section class="main-header">
      <header>
        <div class="container text-center">
          <h2 class="h2 title">Thông tin người dùng</h2>
          <ol class="breadcrumb breadcrumb-inverted">
            <li><a href="index.html"><span class="icon icon-home"></span></a></li>
            <li><a class="active" href="">Thông tin người dùng</a></li>
          </ol>
        </div>
      </header>
    </section>
    <section class="checkout">
      <b-container>
        <b-card>
          <b-tabs pills card vertical nav-wrapper-class="w-25 px-4"
            active-nav-item-class="bg-warning">
            <b-tab title="Thông tin người dùng" active>
              <el-form ref="form" :model="form" label-width="120px">
                <el-form-item label="Họ tên">
                  <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="Giới tính" prop="resource">
                  <el-radio v-model="form.gender" label="1">Nam</el-radio>
                  <el-radio v-model="form.gender" label="0">Nữ</el-radio>
                </el-form-item>
                <el-form-item label="Ngày sinh">
                  <el-input v-model="form.birth" type="date"></el-input>
                </el-form-item>
                <el-form-item label="Email">
                  <el-input v-model="form.email" disabled></el-input>
                </el-form-item>
                <el-form-item label="Số điện thoại">
                  <el-input v-model="form.phone"></el-input>
                </el-form-item>
                <el-form-item label="Địa chỉ">
                  <el-input v-model="form.address"></el-input>
                </el-form-item>
                <el-form-item class="text-right">
                  <el-button type="warning" @click="update">Cập nhật thông tin</el-button>
                </el-form-item>
              </el-form>
            </b-tab>
            <b-tab title="Đổi mật khẩu">
              <el-form ref="repassword" :model="repassword" label-width="140px">
                <el-form-item label="Mật khẩu cũ">
                  <el-input type="password" v-model="repassword.old_password"></el-input>
                </el-form-item>
                <el-form-item label="Mật khẩu mới">
                  <el-input type="password" v-model="repassword.new_password"></el-input>
                </el-form-item>
                <el-form-item label="Nhập lại mật khẩu">
                  <el-input type="password" v-model="repassword.confirm"></el-input>
                </el-form-item>
                <el-form-item class="text-right">
                  <el-button type="warning" @click="changePassword">Đổi mật khẩu</el-button>
                </el-form-item>
              </el-form>
            </b-tab>
            <b-tab title="Hàng đã mua">
              <el-table :data="order" style="width: 100%">
                <el-table-column
                  fixed
                  prop="order_no"
                  label="Mã đơn hàng"
                  width="170">
                </el-table-column>
                <el-table-column
                  prop="created_at"
                  label="Ngày đặt">
                  <template slot-scope="scope">
                    {{ scope.row.created_at | moment }}
                  </template>
                </el-table-column>
                <el-table-column
                  label="Trạng thái">
                  <template slot-scope="scope">
                    <el-tag v-if="scope.row.status == -1"
                      type="danger"
                      effect="plain">
                      Đã hủy
                    </el-tag>
                    <el-tag v-if="scope.row.status == 1"
                      type="success"
                      effect="plain">
                      Đã giao
                    </el-tag>
                    <el-tag v-if="scope.row.status == 0"
                      type="warning"
                      effect="plain">
                      Đang xử ký
                    </el-tag>
                  </template>
                </el-table-column>
                <el-table-column
                  fixed="right"
                  label="Hành động"
                  width="120">
                  <template slot-scope="scope">
                    <Nuxt-Link :to="`thong-tin-nguoi-dung/don-hang/${scope.row.order_no}`">
                      <el-button type="primary" icon="el-icon-notebook-2" circle></el-button>
                    </Nuxt-Link>
                    <el-button v-if="scope.row.status == 0" @click="updateBill(scope.row.id, -1)" type="danger" icon="el-icon-delete" circle></el-button>
                  </template>
                </el-table-column>
              </el-table>
            </b-tab>
          </b-tabs>
        </b-card>
      </b-container>
    </section>
  </div>
</template>

<script>
import Swal from 'sweetalert2'
import moment from 'moment'

export default {
  middleware: ['auth'],
  data() {
    return {
      form: {},
      repassword: {},
      user: {},
      order: [],
    }
  },
  methods: {
    update() {
      this.$axios.post(`/user/${this.form.id}`, this.form).then(res => {
        Swal.fire({
          icon: 'success',
          title: 'Cập nhật thành công!',
          showConfirmButton: false,
          timer: 1500
        })
        this.$auth.user.then(res => {
          console.log(res);
        })
      }).catch(err => {
        Swal.fire({
          icon: 'success',
          title: 'Cập nhật không thành công!',
          showConfirmButton: false,
          timer: 1500
        })
      })
    },
    changePassword() {
      this.$axios.post(`/change_password`, this.repassword).then(res => {
        Swal.fire({
          icon: 'success',
          title: 'Cập nhật thành công!',
          showConfirmButton: false,
          timer: 1500
        })
        this.repassword = null
      }).catch(err => {
        Swal.fire({
          icon: 'success',
          title: 'Cập nhật không thành công!',
          showConfirmButton: false,
          timer: 1500
        })
      })
    },
    updateBill(id, status) {
      this.$axios.post(`user/bill/${id}`, {status: status}).then((res) => {
        Swal.fire({
          icon: 'success',
          title: 'Cập nhật trạng thái thành công!',
          showConfirmButton: false,
          timer: 1000
        })
        this.$axios.get('/user/order').then(res => {
          this.order = res.data
        })
      })
    },
  },
  async created() {
    let user = await this.$axios.get('/user')
    this.form = user.data
    let res = await this.$axios.get('/user/order')
    this.order = res.data
    console.log(this.order);
  },
  filters: {
    moment: function (date) {
      return moment(date).lang("vi").format('DD-MM-YYYY');
    }
  }
}
</script>

<style>
.breadcrumb {
  display: inline-block !important;
}
b, strong {
    font-weight: bold !important;
}
</style>
