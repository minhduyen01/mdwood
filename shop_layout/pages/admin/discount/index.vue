<template>
  <div class="content">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <h4 class="m-0" style="float: left">Quản lý Khuyến mãi</h4>
        <NuxtLink :to="`/admin/news/create`" style="color: #fff">
          <el-button style="float: right" type="primary">
            Thêm mới
          </el-button>
        </NuxtLink>
      </div>
    </el-card>
  </div>
</template>

<script>
export default {
  layout: 'admin',
}
</script>

<style>
.content {
    padding: calc(2.2rem - 0.4rem) 2.2rem 0;
    margin-top: 9rem;
}
</style>
