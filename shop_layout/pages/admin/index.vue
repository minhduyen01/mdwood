<template>
    <div class="content">
      <b-row>
        <b-col>
          <el-card class="box-card">
            <div class="avatar bg-rgba-primary p-50 m-0">
              <div class="avatar-content">
                <i class="fal fa-user-friends text-primary font-medium-5"></i>
              </div>
            </div>
            <strong>Số khách đăng kí mới</strong>
            <h3 class="text-center">{{ registerOnDay }} người</h3>
          </el-card>
        </b-col>
        <b-col>
          <el-card class="box-card">
            <div class="avatar bg-rgba-success p-50 m-0">
              <div class="avatar-content">
                <i class="fal fa-shopping-cart text-primary font-medium-5"></i>
              </div>
            </div>
            <b>Số Đơn hàng trong ngày</b><br>
            <h3 class="text-center">{{ orderOnDay }} đơn</h3>
          </el-card>
        </b-col>
        <b-col>
          <el-card class="box-card">
            <div class="avatar bg-rgba-danger p-50 m-0">
              <div class="avatar-content">
                <i class="fal fa-chart-bar text-primary font-medium-5"></i>
              </div>
            </div>
            <strong>Doanh thu trong ngày</strong><br>
            <h3 class="text-center">{{Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( revenueOfDay.sale )}}</h3>
          </el-card>
        </b-col>
        <b-col>
          <el-card class="box-card">
            <div class="avatar bg-rgba-warning p-50 m-0">
              <div class="avatar-content">
                <i class="fal fa-chart-pie text-primary font-medium-5"></i>
              </div>
            </div>
            <strong>Doanh thu hàng quý</strong><br>
            <h3 class="text-center">35%</h3>
          </el-card>
        </b-col>
      </b-row>
      <el-card class="box-card mt-4">
        <!-- <LineChart v-if="line" :revenueOfWeek="revenueOfWeek" /> -->
        <LineChartcpn :dataOptions="revenueOfWeek" />
      </el-card>
      <!-- <el-card class="box-card mt-4">
        <AreaChart v-if="bar" :revenueOfMonth="revenueOfMonth"/>
      </el-card> -->
      <el-card class="box-card mt-4">
        <div slot="header" class="clearfix">
          <h6 class="m-0" style="float: left">Top sản phẩm bán chạy</h6>
        </div>
        <div>
          <el-table :data="topSale" style="width: 100%">
            <el-table-column
              fixed
              prop="product_id"
              label="ID"
              width="50">
            </el-table-column>
            <el-table-column
              prop="product.name"
              label="Tên sản phẩm">
            </el-table-column>
            <el-table-column
              prop="quantity"
              label="Số lượng đã bán">
            </el-table-column>
          </el-table>
        </div>
      </el-card>
    </div>
</template>
<script>
import LineChartcpn from '../../components/admin/chart/LineChartcpn';
import LineChart from "../../components/admin/chart/LineChart"
import AreaChart from "../../components/admin/chart/AreaChart"

export default {
    layout: 'admin',
    components: {
      LineChart,
      AreaChart,
      LineChartcpn
    },
    data() {
      return {
        orderOnDay: 0,
        registerOnDay: 0,
        saleOnDay: 0,
        revenueOfDay: {},
        revenueOfWeek: [0, 0, 0, 0, 0, 0, 0],
        line: false,
        revenueOfMonth: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        bar: false,
        topSale: [],
      }
    },
    methods: {
      dataRevenueOfWeek(data) {
        data?.forEach(element => {
          var date = new Date(element.date);
          let eSale = parseInt(element.sale ?? 0)
          switch (date.getDay()) {
            case 0:
              this.revenueOfWeek[6] = eSale
              break;
            case 1:
              this.revenueOfWeek[0] = eSale
              break;
            case 2:
              this.revenueOfWeek[1] = eSale
              break;
            case 3:
              this.revenueOfWeek[2] = eSale
              break;
            case 4:
              this.revenueOfWeek[3] = eSale
              break;
            case 5:
              this.revenueOfWeek[4] = eSale
              break;
            case 6:
              this.revenueOfWeek[5] = eSale
              break;
            default:
              break;
          }
        });
      },
      dataRevenueOfMonth(data) {
        data.forEach(element => {
          this.revenueOfMonth[element.month - 1] = parseInt(element.sale ?? 0)
        })
      }
    },
    async created() {
      let order = await this.$axios.get('/admin/order_on_day')
      this.orderOnDay = order.data
      let user = await this.$axios.get('/admin/register_on_day')
      this.registerOnDay = user.data
      let revenue = await this.$axios.get('/admin/revenue_of_day')
      if (revenue.data != null) {
        this.revenueOfDay = revenue.data
      } else {
        this.revenueOfDay.sale = 0
      }
      this.$axios.get('/admin/revenue_of_week').then(res => {
        this.dataRevenueOfWeek(res.data)
        this.line = true
      })
      this.$axios.get('/admin/revenue_of_month').then(res => {
        this.dataRevenueOfMonth(res.data)
        this.bar = true
      })
      console.log(this.revenueOfWeek, this.revenueOfMonth);
      this.$axios.get('/admin/top_product_sale').then(res => {
        this.topSale = res.data
      })
    }
}
</script>
<style>
.content {
    padding: calc(2.2rem - 0.4rem) 2.2rem 0;
    margin-top: 9rem;
}
.avatar {
  white-space: nowrap;
  background-color: #C3C3C3;
  border-radius: 50%;
  position: relative;
  cursor: pointer;
  color: #FFFFFF;
  display: -webkit-inline-box;
  display: -webkit-inline-flex;
  display: -ms-inline-flexbox;
  display: inline-flex;
  font-size: 0.75rem;
  text-align: center;
  vertical-align: middle;
  margin: 5px;
}
.avatar .avatar-content {
    width: 46px;
    height: 46px;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -webkit-justify-content: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
}
.font-medium-5 {
    font-size: 2rem !important;
}
.bg-rgba-primary {
    background: rgba(115, 103, 240, 0.15) !important;
}
b, strong {
    font-weight: bold !important;
}
.bg-rgba-success {
    background: rgba(40, 199, 111, 0.15) !important;
}
.bg-rgba-danger {
    background: rgba(234, 84, 85, 0.15) !important;
}
.bg-rgba-warning {
    background: rgba(255, 159, 67, 0.15) !important;
}
</style>
