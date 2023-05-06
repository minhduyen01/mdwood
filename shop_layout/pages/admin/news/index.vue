<template>
  <div class="content">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <h4 class="m-0" style="float: left">Quản lý tin tức</h4>
        <NuxtLink :to="`/admin/news/create`" style="color: #fff">
          <el-button style="float: right" type="primary">
            Thêm mới
          </el-button>
        </NuxtLink>
      </div>
      <div>
        <el-table :data="news" style="width: 100%">
          <el-table-column
            fixed
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
            prop="title"
            label="Tiêu đề">
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
              <Nuxt-link :to="`/admin/news/${scope.row.id}/update`">
                <el-button type="primary" icon="el-icon-edit" circle></el-button>
              </Nuxt-link>
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
      news: []
    }
  },
  methods: {
    getNews()
    {
      this.$axios.get('/admin/news').then(res => {
        this.news = res.data
      })
    },
    updateStatus(news) {
      this.$axios.post(`/admin/news/${news.id}`, {status: news.status}).then((result) => {
        Swal.fire({
          icon: 'success',
          title: 'Cập nhật trạng thái thành công',
          showConfirmButton: false,
          timer: 1500
        })
        this.getNews()
      })
    }
  },
  created() {
    this.getNews()
  }
}
</script>

<style>
.content {
    padding: calc(2.2rem - 0.4rem) 2.2rem 0;
    margin-top: 9rem;
}
</style>
