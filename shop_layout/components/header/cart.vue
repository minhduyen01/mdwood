<template>
    <div class="cart-wrapper open">
        <div class="checkout">
            <div class="clearfix">

                <!--cart item-->

                <div class="row">
                    <div v-if="listCart.length == 0" style="margin: 0 auto;">
                      <img src="~/assets/image/empty-cart.png" width="400">
                    </div>
                    <div class="cart-block cart-block-item clearfix" v-for="(item, index) in listCart" :key="item.id">
                        <div class="image">
                            <a href="product.html"><img :src="`http://127.0.0.1:8000/storage/uploads/${item.image}`" alt="" height="160" /></a>
                        </div>
                        <div class="title">
                            <div><a href="product.html">{{item.name}}</a></div>
                        </div>
                        <div class="quantity">
                            <input type="number" :value="item.quantity" @input="handleChangeAmount($event, index)" class="form-control form-quantity" />
                        </div>
                        <div class="price">
                            <span class="final">{{ Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( item.price * (100 - item.sale) / 100 ) }}</span>
                            <span class="discount" v-if="item.sale > 0">{{ Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( item.price ) }}</span>
                        </div>
                        <!--delete-this-item-->
                        <span class="icon icon-cross icon-delete" @click="handleDeleteItem(index)"></span>
                    </div>
                </div>

                <hr />


                <!--cart final price -->

                <div class="clearfix" v-if="listCart.length != 0">
                    <div class="cart-block cart-block-footer clearfix">
                        <div>
                            <strong>Total</strong>
                        </div>
                        <div>
                            <div class="h4 title">{{ Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( totalPriceCart ) }}</div>
                        </div>
                    </div>
                </div>


                <!--cart navigation -->

                <div class="cart-block-buttons clearfix">
                    <div class="row">
                        <div class="col-xs-6">
                        </div>
                        <div class="col-xs-6 text-right">
                            <Nuxt-link to="/thanh-toan" class="btn btn-main" v-if="listCart.length != 0"><span class="icon icon-cart"></span> Checkout</Nuxt-link>
                        </div>
                    </div>
                </div>

            </div>
        </div> <!--/checkout-->
    </div> <!--/cart-wrapper-->
</template>

<script>
import { mapState, mapActions } from "vuex";
export default {
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
      console.log(e.target.value, index, '1234');
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
  },
}
</script>
