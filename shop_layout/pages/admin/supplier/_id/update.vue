<template>
  <div class="content">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <h4 class="m-0" style="float: left">Sửa cung cấp</h4>
      </div>
      <div>
        <el-form ref="formItemName" :model="supplier" label-width="140px" :rules="rules" label-position="top">
          <el-col :span="12" class="pr-5">
            <el-form-item label="Tên nhà cung cấp" prop="name">
              <el-input v-model="supplier.name"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12" class="pr-5">
            <el-form-item label="Địa chỉ" prop="address">
              <el-input v-model="supplier.address"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12" class="pr-5">
            <el-form-item label="Email" prop="email">
              <el-input v-model="supplier.email"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12" class="pr-5">
            <el-form-item label="Số điện thoại" prop="phone">
              <el-input v-model="supplier.phone"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="23">
            <el-form-item style="float: right">
              <el-button type="primary" @click="createSupp()">Cập nhật</el-button>
            </el-form-item>
          </el-col>
        </el-form>
      </div>
    </el-card>
  </div>
</template>

<script>
import Swal from 'sweetalert2'

export default {
  layout: 'admin',
  data() {
    return {
      supplier: {},
      rules: {
        name: [
          { required: true, message: 'Vui lòng nhập tên nhà cung cấp', trigger: 'blur' }
        ],
        address: [
          { required: true, message: 'Vui lòng nhập tên nhà cung cấp', trigger: 'blur' }
        ],
        email: [
          { required: true, message: 'Vui lòng nhập tên nhà cung cấp', trigger: 'blur' },
          {
            type: 'email',//The type to be checked (number, email, date, etc.)
            message: 'Vui lòng nhập địa chỉ email chính xác',
            trigger: ['blur', 'change']//change is when the tested character changes)
          }
        ],
        phone: [
          { required: true, message: 'Vui lòng nhập tên nhà cung cấp', trigger: 'blur' },
        ],
      }
    }
  },
  methods: {
    createSupp() {
      this.$refs.formItemName.validate((valid) => {
        if(valid) {
          this.$axios.post(`/admin/supplier/${this.supplier.id}`, this.supplier).then((res) => {
            Swal.fire({
              icon: 'success',
              title: 'Cập nhật thành công',
              showConfirmButton: false,
              timer: 1500
            })
            this.$router.push('/admin/supplier')
          })
        }
      })
    }
  },
  created() {
    const id = this.$route.params.id
    this.$axios.get(`/admin/supplier/${id}`).then((res) => {
      this.supplier = res.data
    })
  }
}
</script>

<style>
.content {
    padding: calc(2.2rem - 0.4rem) 2.2rem 0;
    margin-top: 9rem;
}
</style>
