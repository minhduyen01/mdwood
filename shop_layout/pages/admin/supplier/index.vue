<template>
  <div class="content">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <h4 class="m-0" style="float: left">Quản lý nhà cung cấp</h4>
        <Nuxt-link :to="`/admin/supplier/create`" style="color: #fff">
          <el-button style="float: right" type="primary">
            Thêm mới
          </el-button>
        </Nuxt-link>
      </div>
      <div>
        <el-table :data="suppliers" style="width: 100%">
          <el-table-column
            prop="id"
            label="ID"
            width="50">
          </el-table-column>
          <el-table-column
            prop="name"
            label="Tên nhà cung cấp">
          </el-table-column>
          <el-table-column
            prop="email"
            label="Địa chỉ email">
          </el-table-column>
          <el-table-column
            prop="phone"
            label="Số điện thoại"
            width="150">
          </el-table-column>
          <el-table-column
            prop="address"
            label="Địa chỉ"
            width="350">
          </el-table-column>
          <el-table-column
            fixed="right"
            label="Operations"
            width="120">
            <template slot-scope="scope">
              <Nuxt-link :to="`/admin/supplier/${scope.row.id}/update`">
                <el-button type="primary" icon="el-icon-edit" circle></el-button>
              </Nuxt-link>
              <el-button type="danger" icon="el-icon-delete" @click="delSupplier(scope.row.id)" circle></el-button>
            </template>
          </el-table-column>
        </el-table>
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
      suppliers: [],
      supplier: {}
    }
  },
  methods: {
    async getSuppliers() {
      let res = await this.$axios.get('/admin/supplier')
      this.suppliers = res.data
    },
    delSupplier(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "Bạn có chắc chắn xóa k?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Có',
        cancelButtonText: "Không"
      }).then((result) => {
        if (result.isConfirmed) {
          this.$axios.delete(`/admin/supplier/${id}`).then(res => {
            this.getSuppliers()
          }).then(res => {
            Swal.fire(
              'Deleted!',
              'Xóa thành công.',
              'success'
            )
          })
        }
      })
    },
  },
  created() {
    this.getSuppliers()
  }
}
</script>
<style lang="scss">
.content {
    padding: calc(2.2rem - 0.4rem) 2.2rem 0;
    margin-top: 9rem;
}
</style>
