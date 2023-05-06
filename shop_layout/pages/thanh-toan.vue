<template>
  <div>
    <section class="main-header">
      <header>
        <div class="container text-center">
          <h2 class="h2 title">Checkout</h2>
          <ol class="breadcrumb breadcrumb-inverted">
            <li><a href="index.html"><span class="icon icon-home"></span></a></li>
            <li><a class="active" href="">Giỏ hàng</a></li>
            <li><a href="">Thanh toán</a></li>
            <li><a href="">Hóa đơn</a></li>
          </ol>
        </div>
      </header>
    </section>
    <b-card>
      <b-container>
        <el-steps :active="active" finish-status="success">
          <el-step title="Giỏ hàng" icon="el-icon-shopping-cart-2"></el-step>
          <el-step title="Thanh toán" icon="el-icon-bank-card"></el-step>
          <el-step title="Hóa đơn" icon="el-icon-document-checked"></el-step>
        </el-steps>
      </b-container>
    </b-card>
    <section class="checkout">
      <b-container>

        <!-- ========================  Payment ======================== -->

        <div class="cart-wrapper" v-if="active > 1">

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
                                        <span>{{ order.order_no }}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Ngày đặt hàng</strong> <br />
                                        <span>{{ order.order_date }}</span>
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
                <div class="cart-block cart-block-item clearfix py-2 pl-2" v-for="(item, index) in listCart" :key="item.id">
                    <div class="image">
                        <a href="product.html"><img :src="`http://127.0.0.1:8000/storage/uploads/${item.image}`" alt="" /></a>
                    </div>
                    <div class="title">
                        <div class="h4"><a href="product.html">{{item.name}}</a></div>
                    </div>
                    <div class="quantity">
                        <input v-if="active == 1" type="number" :value="item.quantity" @input="handleChangeAmount($event, index)" class="form-control form-quantity" />
                        <strong v-if="active > 1">{{ item.quantity }}</strong>
                    </div>
                    <div class="price">
                        <span class="final h3">{{ Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( item.price * (100 - item.sale) / 100 ) }}</span>
                        <span class="discount" v-if="item.sale > 0">{{ Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( item.price ) }}</span>
                    </div>
                    <!--delete-this-item-->
                    <span class="icon icon-cross icon-delete" @click="handleDeleteItem(index)"></span>
                </div>
            </div>

            <!--cart final price -->

            <div class="clearfix">
                <div class="cart-block cart-block-footer cart-block-footer-price clearfix">
                    <div>
                      <strong>Tổng tiền</strong>
                    </div>
                    <div>
                        <div class="h2 title">{{ Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( totalPriceCart ) }}</div>
                    </div>
                </div>
            </div>

            <div class="clearfix pt-3">
                <div class="row">
                    <div class="col-xs-6">
                        <a href="#" class="btn btn-clean-dark"><span class="icon icon-chevron-left"></span> Mua thêm</a>
                    </div>
                    <div class="col-xs-6 text-right" v-if="active == 1">
                        <a href="#" class="btn btn-main" @click.prevent="next"><span class="icon icon-cart"></span> Tiếp tục</a>
                    </div>
                    <div class="col-xs-6 text-right" v-if="active == 2">
                        <a href="#" class="btn btn-main" @click.prevent="checkout"><span class="icon icon-cart"></span> Thanh toán</a>
                    </div>
                </div>
            </div>
        </div>
      </b-container>
    </section>

  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";
import moment from 'moment'
import Swal from 'sweetalert2'

export default {
  middleware: ['auth'],
  data() {
    return {
      active: 1,
      order: {
        payment: 1,
        order_no: Math.floor(Math.random() * (999999999999 - 100000000000 + 1) ) + 100000000000,
        order_date: moment(String(Date())).format('DD/MM/YYYY')
      },
      user: {},
    };
  },
  computed: {
    ...mapState({
      listCart: state => state.cart.listCart
    }),
    totalPriceCart() {
      const total = this.listCart.reduce((total, item) => {
        return total + item.price * item.quantity;
      }, 0);
      return total;
    }
  },
  methods: {
    ...mapActions({ setListCart: "cart/setListCart" }),
    handleDeleteItem(index) {
      const newCarts = [...this.listCart];
      newCarts.splice(index, 1);
      this.setListCart(newCarts);
    },
    handleChangeAmount(e, index) {
      const newCarts = this.listCart.map((item, stt) =>
        stt == index
          ? {
              ...item,
              quantity: e.target.value
            }
          : item
      );
      this.setListCart(newCarts);
    },
    next() {
      this.active++
    },
    checkout() {
      const products = JSON.parse(localStorage.getItem("listCart")).map(
        item => {
          return {
            id: parseInt(item.id),
            quantity: item.quantity,
            price: item.price,
            sale: item.sale
          };
        }
      );
      this.order.products = products
      this.$axios.post('/checkout', this.order).then((res) => {
        Swal.fire({
          icon: 'success',
          title: 'Đặt hàng thành công',
          showConfirmButton: false,
          timer: 1500
        })
        this.active++
        localStorage.removeItem("listCart")
      })
    }
  },
  async created() {
    this.user = await this.$auth.user
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
