<template>
    <div class="row">

            <!-- === product-item === -->
            <div v-if="products.length == 0" style="margin: 0 auto;">
              <img src="~/assets/image/empty-cart.png" width="400">
            </div>
            <div class="col-xs-6" :class="{
                'col-md-4': path == '/'
            }" v-for="(product, index) in products" :key="index">
                <article>
                    <div class="info" v-if="path == '/'">
                        <!-- <span class="add-favorite added">
                            <a href="javascript:void(0);" data-title="Add to favorites" data-title-added="Added to favorites list"><i class="icon icon-heart"></i></a>
                        </span> -->
                        <span>
                            <NuxtLink class="mfp-open" :to="`/san-pham/${product.slug}`"><i class="icon icon-eye"></i></NuxtLink>
                        </span>
                    </div>
                    <div class="btn btn-add" @click="handleAddToCart(index)">
                        <i class="icon icon-cart"></i>
                    </div>
                    <div class="figure-grid">
                        <span class="label label-info" v-if="product.sale > 0">-{{product.sale}}%</span>
                        <div class="image">
                          <NuxtLink class="mfp-open" :to="`/san-pham/${product.slug}`">
                            <img :src="`http://127.0.0.1:8000/storage/uploads/${product.images[0].image}`" alt="" width="360" height="300"/>
                          </NuxtLink>
                        </div>
                        <div class="text">
                            <h2 class="title h4"><NuxtLink :to="`/san-pham/${product.slug}`"> {{ product.name }}</NuxtLink></h2>
                            <sup>{{ Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( product.unit_price * (100 - product.sale) / 100 ) }}</sup>
                            <sub v-if="product.sale > 0">{{ Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( product.unit_price ) }}</sub>
                            <span class="description clearfix">Gubergren amet dolor ea diam takimata consetetur facilisis blandit et aliquyam lorem ea duo labore diam sit et consetetur nulla</span>
                        </div>
                    </div>
                </article>
            </div>

        </div> <!--/row-->
</template>
<script>
import Vue from 'vue'
import VModal from 'vue-js-modal/dist/ssr.nocss'

import 'vue-js-modal/dist/styles.css'
import { mapActions } from "vuex";
import Product from '/components/product'

Vue.use(VModal, {
  dynamicDefaults: {
    height: 'auto'
  }}
)

export default {
    props:["products"],
    data() {
        return {
            path: null,
        }
    },
    methods: {
      ...mapActions({
        setListCart: "cart/setListCart"
      }),
        showProduct (index) {
            this.$router.push(`/san-pham/${index}`)
        },
        handleAddToCart(index) {
          const cartItem = {
            id: this.products[index].id,
            name: this.products[index].name,
            image: this.products[index].images[0].image,
            price: this.products[index].unit_price,
            sale: this.products[index].sale,
            quantity: 1,
          }
          const listCart = JSON.parse(localStorage.getItem("listCart")) || [];
          const indexProductExist = listCart.findIndex(element => {
          return element.id === cartItem.id; });
          if (indexProductExist >= 0) {
            listCart[indexProductExist].quantity =
              listCart[indexProductExist].quantity + cartItem.quantity;
          } else {
            listCart.push(cartItem);
          }
          localStorage.setItem("listCart", JSON.stringify(listCart));
          this.setListCart(listCart);
        }
    },
    mounted() {
        this.path = this.$route.path
    },
    created() {
      console.log(this.products);
    }
}
</script>
