<template>
  <div>
    <section class="main-header">
      <header>
        <div class="container text-center">
          <h2 class="h2 title">Thông tin người dùng</h2>
          <ol class="breadcrumb breadcrumb-inverted">
            <li><a href="index.html"><span class="icon icon-home"></span></a></li>
            <li><NuxtLink to="/thong-tin-nguoi-dung">Thông tin người dùng</NuxtLink></li>
             <li><a class="active" href="">Đơn hàng</a></li>
          </ol>
        </div>
      </header>
    </section>
    <section class="checkout">
      <b-container>
        <div class="cart-wrapper">
          <div class="note-block">
            <div class="row">
              <div class="col-md-6">
                <div class="white-block">
                  <div class="h4">Chi tiết đơn hàng</div>
                  <hr />
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Mã hóa đơn</strong> <br />
                            <span>{{ order.order_no }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Ngày đặt hàng</strong> <br />
                            <span>{{ order.created_at | moment }}</span>
                        </div>
                    </div>
                </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="white-block">
                  <div class="h4">Thông tin người đặt</div>
                  <hr />
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <strong>Họ tên</strong> <br />
                        <span>{{ user.name }}</span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <strong>Email</strong><br />
                        <span>{{ user.email }}</span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <strong>Số điện thoại</strong><br />
                        <span>{{ user.phone }}</span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <strong>Địa chỉ</strong><br />
                        <span>{{ user.address }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="cart-wrapper">
            <!--cart header -->

            <div class="cart-block cart-block-header clearfix">
                <div>
                    <span>Sản phẩm</span>
                </div>
                <div>
                    <span>&nbsp;</span>
                </div>
                <div>
                    <span>Số lượng</span>
                </div>
                <div class="text-right">
                    <span>Giá tiền</span>
                </div>
            </div>

            <!--cart items-->

            <div class="clearfix">
                <div class="cart-block cart-block-item clearfix py-2 pl-2" v-for="(item) in order.bill_detail" :key="item.id">
                    <div class="image">
                        <a href="product.html"><img :src="`http://127.0.0.1:8000/storage/uploads/${item.product.images[0].image}`" alt="" /></a>
                    </div>
                    <div class="title">
                        <div class="h4"><a href="product.html">{{item.product.name}}</a></div>
                    </div>
                    <div class="quantity">
                        <strong>{{ item.quantity }}</strong>
                    </div>
                    <div class="price">
                        <span class="final h3">{{ Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( item.unit_price * (100 - item.sale) / 100 ) }}</span>
                        <span class="discount" v-if="item.sale > 0">{{ Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( item.unit_price ) }}</span>
                    </div>
                </div>
            </div>

            <!--cart final price -->

            <div class="clearfix">
                <div class="cart-block cart-block-footer cart-block-footer-price clearfix">
                    <div>
                      <strong>Tổng tiền</strong>
                    </div>
                    <div>
                        <div class="h2 title">{{ Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( total ) }}</div>
                    </div>
                </div>
            </div>

        </div>
      </b-container>
    </section>
  </div>
</template>

<script>
import moment from 'moment'

export default {
  middleware: ['auth'],
  data() {
    return {
      order: {},
      user: {},
      total: null,
    }
  },
  methods: {

  },
  async created() {
    let order_no = this.$route.params.order
    let res = await this.$axios.get(`/user/order/${order_no}`)
    this.order = res.data
    this.user = await this.$auth.user
    let billDetail = res.data.bill_detail
    let money = 0
    billDetail.forEach(element => {
      console.log(element);
      money += element.quantity * element.unit_price * (100 - element.sale)/100
    });
    this.total = money
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
