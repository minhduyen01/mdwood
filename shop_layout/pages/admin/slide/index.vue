<template>
  <div class="content">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <h4 class="m-0" style="float: left">Quản lý slide</h4>
        <Nuxt-link :to="`/admin/slide/create`" style="color: #fff">
          <el-button style="float: right" type="primary">
            Thêm mới
          </el-button>
        </Nuxt-link>
      </div>
      <div>
        <el-table :data="slide" style="width: 100%">
          <el-table-column
            prop="id"
            label="ID"
            width="50">
          </el-table-column>
          <el-table-column
            label="Ảnh">
            <template slot-scope="scope">
              <img :src="`http://127.0.0.1:8000/storage/uploads/${scope.row.image}`" width="250">
            </template>
          </el-table-column>
          <el-table-column
            prop="name"
            label="Tiều đề">
          </el-table-column>
          <el-table-column label="Trạng thái">
            <template slot-scope="scope">
              <el-switch v-model="scope.row.status" @change="updateStatus(scope.row)"></el-switch>
            </template>
          </el-table-column>
          <el-table-column
            fixed="right"
            label="Operations"
            width="120">
            <template slot-scope="scope">
              <Nuxt-link :to="`/admin/slide/${scope.row.id}/update`">
                <el-button type="primary" icon="el-icon-edit" circle></el-button>
              </Nuxt-link>
              <el-button type="danger" icon="el-icon-delete" @click="del(scope.row.id)" circle></el-button>
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
      slide: []
    }
  },
  methods: {
    async getSlide() {
      let res = await this.$axios.get('/admin/slide')
      this.slide = res.data
    },
    updateStatus(slide) {
      this.$axios.post(`/admin/slide/${slide.id}`, {status: slide.status}).then((result) => {
        Swal.fire({
          icon: 'success',
          title: 'Cập nhật trạng thái thành công',
          showConfirmButton: false,
          timer: 1500
        })
        this.$router.push('/admin/slide')
      })
    },
    del(id) {
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
              this.$axios.delete('/admin/slide/' + id).then(res => {
                  this.getSlide()
              })
              Swal.fire(
                  'Deleted!',
                  'Xóa thành công.',
                  'success'
              )
          }
      })
    }
  },
  created() {
    this.getSlide()
  }
}
</script>

<style>
.content {
    padding: calc(2.2rem - 0.4rem) 2.2rem 0;
    margin-top: 9rem;
}
</style>
