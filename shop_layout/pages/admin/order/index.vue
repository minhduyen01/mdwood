<template>
  <div class="content">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <h4 class="m-0" style="float: left">Quản lý đơn hàng</h4>
        <div style="float: right">
          <el-radio-group v-model="radio1" @change="searchStatus()">
            <el-radio-button label="Tất cả"></el-radio-button>
            <el-radio-button label="Đang chờ"></el-radio-button>
            <el-radio-button label="Hoàn thành"></el-radio-button>
            <el-radio-button label="Hủy"></el-radio-button>
          </el-radio-group>
        </div>
      </div>
      <div>
        <el-table :data="bills" style="width: 100%">\
          <el-table-column
            fixed
            prop="order_no"
            label="Mã đơn hàng"
            width="170">
          </el-table-column>
          <el-table-column
            prop="user.name"
            label="Người đặt">
          </el-table-column>
          <el-table-column
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
              <el-button v-if="scope.row.status == 0" @click="update(scope.row.id, 1)" type="success" icon="el-icon-check" circle></el-button>
              <el-button v-if="scope.row.status == 0" @click="update(scope.row.id, 0)" type="danger" icon="el-icon-delete" circle></el-button>
            </template>
          </el-table-column>
          <el-table-column
            fixed="right"
            label="Operations"
            width="120">
            <template slot-scope="scope">
              <Nuxt-Link :to="`/admin/order/${scope.row.id}`">
                <el-button type="primary" icon="el-icon-notebook-2" circle></el-button>
              </Nuxt-Link>
            </template>
          </el-table-column>
        </el-table>
      </div>
      <!-- <CustomPagination :pageCount="pageCount" align="center" class="mt-5" /> -->
      <b-pagination
        v-model="currentPage"
        :total-rows="pagination.total"
        :per-page="pagination.perPage"
        aria-controls="my-table"
      ></b-pagination>
    </el-card>
  </div>
</template>

<script>
import Swal from 'sweetalert2'
import moment from 'moment'

export default {
  layout: 'admin',
  data() {
    return {
      bills: [],
      pageCount: 0,
      radio1: "Tất cả",
      currentPage: null,
            pagination: {
              total: null,
              perPage: null,
              pageCount: null,
            }
    }
  },
  // async beforeRouteUpdate(to, from, next) {
  //   let res = await this.$axios.get(`/admin/bill?page=${to.query.page}`);
  //   this.bills = res.data.data
  //   next();
  // },
  watch: {
    currentPage(newVal) {
          this.$router.push({path: '/admin/order', query: {
            ...this.$route.query,
            page: newVal,
          }})
        },
    async $route(newVal, oldVal) {
        const res = await this.$axios.get('/admin/bill', {params: {...this.$route.query}});
        console.log(res);
        this.bills = res.data.data;
        this.currentPage = res.data.current_page;
        this.pagination.total = res.data.total;
        this.pagination.lastPage = res.data.last_page;
        this.pagination.perPage = res.data.per_page;
        console.log("route change", res);
      },
  },
  methods: {
    async getListOrder() {
        const res = await this.$axios.get('/admin/bill', {params: {...this.$route.query}});
        console.log(res);
        this.bills = res.data.data;
        this.currentPage = res.data.current_page;
        this.pagination.total = res.data.total;
        this.pagination.lastPage = res.data.last_page;
        this.pagination.perPage = res.data.per_page;
        console.log("route change", res);
    },
    update(id, status) {
      this.$axios.post(`/admin/bill/${id}`, {status: status}).then((res) => {
        Swal.fire({
          icon: 'success',
          title: 'Cập nhật trạng thái thành công!',
          showConfirmButton: false,
          timer: 1000
        })
        this.getListOrder()
      })
    },
    searchStatus() {
      switch (this.radio1) {
        case "Tất cả":
          this.$router.push({path:'/admin/order'})
          this.$axios.get('/admin/bill').then((res) => {
            this.bills = res.data.data
            this.pageCount = res.data.last_page
          })
          break;
        case "Đang chờ":
          this.$router.push({path:'/admin/order', query: {
            ...this.$route.query,
            status: 0
          }})
          this.$axios.get(`/admin/bill?status=0`).then((res) => {
            this.bills = res.data.data
            this.pageCount = res.data.last_page
          })
          break;
        case "Hoàn thành":
          this.$router.push({path:'/admin/order', query: {
            ...this.$route.query,
            status: 1
          }})
          this.$axios.get(`/admin/bill?status=1`).then((res) => {
            this.bills = res.data.data
            this.pageCount = res.data.last_page
          })
          break;
        case "Hủy":
          this.$router.push({path:'/admin/order', query: {
            ...this.$route.query,
            status: -1
          }})
          this.$axios.get(`/admin/bill?status=-1`).then((res) => {
            this.bills = res.data.data
            this.pageCount = res.data.last_page
          })
          break;
        default:
          break;
      }
    }
  },
  async created() {
    this.getListOrder()
    console.log(this.bills);
  },
  filters: {
    moment: function (date) {
      return moment(date).lang("vi").format('DD-MM-YYYY');
    }
  }
}
</script>

<style>
.content {
    padding: calc(2.2rem - 0.4rem) 2.2rem 0;
    margin-top: 9rem;
}
nav {
  background-color: #fff;
  position: inherit;
}
</style>
