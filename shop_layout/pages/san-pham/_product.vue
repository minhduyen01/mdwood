<template>
    <div>
      <section class="main-header">
      <header>
        <div class="container">
          <h1 class="h2 title">{{ detail.name }}</h1>
          <ol class="breadcrumb breadcrumb-inverted">
            <li><Nuxt-link to="/"><span class="icon icon-home"></span></Nuxt-link></li>
            <li><Nuxt-link to="/san-pham">Sản phẩm</Nuxt-link></li>
            <li><Nuxt-link to="" class="active">{{ detail.name }}</Nuxt-link></li>
          </ol>
        </div>
      </header>
    </section>

      <section class="product">
            <div class="main">
                <div class="container">
                    <div class="row product-flex">

                        <!-- product flex is used only for mobile order -->
                        <!-- on mobile 'product-flex-info' goes bellow gallery 'product-flex-gallery' -->

                        <div class="col-md-4 col-sm-12 product-flex-info">
                            <div class="clearfix">

                                <!-- === product-title === -->

                                <h1 class="title">{{ detail.name }}</h1>

                                <div class="clearfix">

                                    <!-- === price wrapper === -->

                                    <div class="price">
                                        <span class="h3">
                                            {{ Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( detail.unit_price * (100 - detail.sale) / 100 ) }} <br/>
                                            <small v-if="detail.sale > 0">{{ Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( detail.unit_price ) }}</small>
                                        </span>
                                    </div>
                                    <hr />

                                    <!-- === info-box === -->

                                    <div class="info-box">
                                        <span><strong>Xuất xứ</strong></span>
                                        <span>{{ detail.origin }}</span>
                                    </div>

                                    <!-- === info-box === -->

                                    <div class="info-box">
                                        <span><strong>Chất liệu</strong></span>
                                        <span>{{ detail.material }}</span>
                                    </div>

                                    <!-- === info-box === -->

                                    <div class="info-box">
                                        <span><strong>Kích thước</strong></span>
                                        <span>{{ detail.size }}</span>
                                    </div>

                                    <div class="info-box">
                                        <span><strong>Bảo hành</strong></span>
                                        <span>2 năm</span>
                                    </div>

                                    <div class="info-box">
                                        <span><strong>Bảo trì</strong></span>
                                        <span>Trọn đời sản phẩm</span>
                                    </div>

                                </div> <!--/clearfix-->
                            </div> <!--/product-info-wrapper-->
                        </div> <!--/col-md-4-->
                        <!-- === product item gallery === -->

                        <div class="col-md-8 col-sm-12 p-0 product-flex-gallery">

                            <!-- === add to cart === -->

                            <button type="submit" class="btn btn-buy" data-text="Buy" @click="handleAddToCart()"></button>


                            <!-- === product gallery === -->

                            <b-carousel
                                controls
                                :interval="3000"
                            >
                                <b-carousel-slide v-for="image in detail.images" :key="image.id"
                                  :img-src="`http://127.0.0.1:8000/storage/uploads/${image.image}`" :img-width="640"></b-carousel-slide>
                            </b-carousel>
                        </div>

                    </div>
                </div>
            </div>

            <!-- === product-info === -->

            <div class="info">
                <div class="container">
                    <div class="row">

                        <!-- === product-designer === -->

                        <div class="col-md-4">
                            <div class="designer">
                                <div class="box">
                                    <div class="name">
                                        <div class="h4 title">{{ supplier.name }} <small>Nhà cung cấp</small></div>
                                        <hr />
                                        <p><a href="mailto:johndoe@mail.com"><i class="icon icon-envelope"></i> {{ supplier.email }}</a></p>
                                        <p><a href="tel:002255858"><i class="icon icon-phone-handset"></i> {{ supplier.phone }}</a></p>
                                        <p>
                                            <a href="#" class="btn btn-main btn-xs"><i class="icon icon-user"></i></a>
                                            <a href="#" class="btn btn-main btn-xs"><i class="icon icon-printer"></i></a>
                                            <a href="#" class="btn btn-main btn-xs"><i class="icon icon-layers"></i></a>
                                        </p>
                                    </div> <!--/name-->
                                </div> <!--/box-->
                                <div class="btn btn-add">
                                    <i class="icon icon-phone-handset"></i>
                                </div>
                            </div> <!--/designer-->
                        </div> <!--/col-md-4-->
                        <!-- === nav-tabs === -->

                        <div class="col-md-8">
                          <b-tabs>
                            <b-tab active>
                              <template #title>
                                <i class="icon icon-sort-alpha-asc"></i>
                                <span>Mô tả sản phẩm</span>
                              </template>
                                <b-card-body>
                                  <div role="tabpanel" class="tab-pane" id="design">
                                    <div class="content">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3>Chi tiết về sản phẩm</h3>
                                                <div v-html="detail.description"></div>
                                            </div>

                                        </div> <!--/row-->
                                    </div> <!--/content-->
                                </div> <!--/tab-pane-->
                                </b-card-body>
                            </b-tab>
                            <b-tab>
                              <template #title>
                                <i class="icon icon-user"></i>
                                <span>Sản phẩm cùng nhà phân phối</span>
                              </template>
                              <b-card-body>
                                <div role="tabpanel" class="tab-pane active" id="designer">
                                    <div class="content">
                                        <h3>Những sản phẩm cùng nhà phân phối</h3>
                                        <div class="products">
                                          <ListProduct :products="products" />
                                        </div>
                                    </div>
                                </div>
                              </b-card-body>
                            </b-tab>
                          </b-tabs>
                        </div>
                    </div> <!--/row-->
                </div> <!--/container-->
            </div> <!--/info-->
        </section>
    </div>
</template>
<script>
import { mapActions } from "vuex";

export default {
    data() {
      return {
        detail: {},
        products: [],
        supplier: {},
      }
    },
    methods: {
      ...mapActions({
        setListCart: "cart/setListCart"
      }),
      handleAddToCart() {
        const cartItem = {
          id: this.detail.id,
          name: this.detail.name,
          image: this.detail.images[0].image,
          price: this.detail.unit_price,
          sale: this.detail.sale,
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
    async created() {
      const slug = this.$route.params.product
      let res = await this.$axios.get(`/product/${slug}`)
      this.detail = res.data
      this.supplier = res.data.supplier
      let a = await this.$axios.get(`/random/product?supplier=${this.detail.supplier_id}`)
      this.products = a.data
    }
}
</script>

<style lang="scss">
.image.image-style-side {
  padding-bottom: 15px;
  figcaption {
    text-align: center;
  }
  img{
    width: 700px;
  }
}
.image{
  img{
    width: 700px;
  }
}
</style>
