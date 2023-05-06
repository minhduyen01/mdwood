<template>
  <div class="content">
    <section class="checkout m-0 p-0">

        <!-- ========================  Payment ======================== -->

        <div class="cart-wrapper">

            <div class="note-block">

                <div class="row">
                    <!-- === left content === -->

                    <div class="col-md-6">

                        <div class="white-block">

                            <div class="h4">Chi tiết đơn hàng</div>

                            <hr />

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Mã hóa đơn</strong> <br />
                                        <span>{{ billDetail.order_no }}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Ngày đặt hàng</strong> <br />
                                        <span>{{ billDetail.order_date }}</span>
                                    </div>
                                </div>

                            </div>



                        </div> <!--/col-md-6-->

                    </div>

                    <!-- === right content === -->

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

        <!-- ========================  Cart wrapper ======================== -->

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
                <div class="cart-block cart-block-item clearfix py-2 pl-2" v-for="item in billDetail.bill_detail" :key="item.id">
                    <div class="image">
                        <a href="product.html"><img :src="item.product.images[0].image" alt="" /></a>
                    </div>
                    <div class="title">
                        <div class="h4"><a href="product.html">{{item.product.name}}</a></div>
                    </div>
                    <div class="quantity">
                        <strong>{{ item.quantity }}</strong>
                    </div>
                    <div class="price">
                        <span class="final h3">{{ Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( item.unit_price * (100 - Number(item.sale || 0)) / 100 ) }}</span>
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
    </section>
  </div>
</template>

<script>
import moment from 'moment'

export default {
  layout: 'admin',
  data() {
    return {
      billDetail: {},
      user: {},
      total: 0
    }
  },
  created() {
    const id = this.$route.params.id
    this.$axios.get(`/admin/bill/${id}`).then((res) => {
      this.billDetail = res.data
      this.user = res.data.user
      this.billDetail.order_date = moment(String(this.billDetail.created_at)).format('DD/MM/YYYY')
      var product = res.data.bill_detail
      console.log(product);
      product.forEach(element => {
        this.total += ( element.unit_price * ( 100 - (element.sale ?? 0) ) / 100 ) * element.quantity
      })
    })
  }
}
</script>

<style>
.content {
    padding: calc(2.2rem - 0.4rem) 2.2rem 0;
    margin-top: 9rem;
}
b, strong {
    font-weight: bold !important;
}
</style>
