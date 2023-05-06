<template>
<nav class="navbar-fixed" :class="{classA: scrollPosition < 100, 'navbar-sticked': scrollPosition > 100}">

            <div class="container">

                <!-- ==========  Top navigation ========== -->

                <div class="navigation navigation-top clearfix">
                    <ul>
                        <!--add active class for current page-->

                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>

                        <li><a href="javascript:void(0);" class="open-login"><i class="icon icon-user" @click="isShowLogin = !isShowLogin"></i></a></li>
                        <li><a href="javascript:void(0);" class="open-search"><i class="icon icon-magnifier" @click="isShowSearch = !isShowSearch"></i></a></li>
                        <li><a href="javascript:void(0);" class="open-cart">
                            <i class="icon icon-cart" @click="isShowCart = !isShowCart"></i> <span>{{ listCart.length || 0 }}</span>
                        </a></li>
                    </ul>
                </div> <!--/navigation-top-->

                <!-- ==========  Main navigation ========== -->

                <div class="navigation navigation-main">

                    <!-- Setup your logo here-->

                    <Nuxt-link to="/" class="logo"><img src="~/assets/image/logo.png" alt="" /></Nuxt-link>

                    <!-- Mobile toggle menu -->

                    <a href="#" class="open-menu"><i class="icon icon-menu"></i></a>

                    <!-- Convertible menu (mobile/desktop)-->

                    <div class="floating-menu">

                        <!-- Mobile toggle menu trigger-->

                        <div class="close-menu-wrapper">
                            <span class="close-menu"><i class="icon icon-cross"></i></span>
                        </div>

                        <ul class="menu-top">
                            <li><Nuxt-link to="/">Trang chủ</Nuxt-link></li>

                            <!-- Multi-content dropdown -->

                            <li>
                                <a href="index.html">Danh mục <span class="open-dropdown"><i class="fa fa-angle-down"></i></span></a>
                                <div class="navbar-dropdown">
                                    <div class="navbar-box">

                                        <!-- box-1 (left-side)-->

                                        <div class="box-1">
                                            <div class="box">
                                                <div class="h2">Tìm nguồn cảm hứng của bạn</div>
                                                <div class="clearfix">
                                                    <p>Những ngôi nhà khác biệt về phong cách, ý tưởng và giải pháp kiến ​​trúc đã được Xưởng nội thất trang bị. Những không gian này nói lên một phong cách sống quốc tế thể hiện sự hiện đại, nghiên cứu và tinh thần sáng tạo.</p>
                                                    <Nuxt-link to="/san-pham" class="btn btn-clean btn-big">Mua ngay</Nuxt-link>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- box-2 (right-side)-->

                                        <div class="box-2">
                                            <div class="box clearfix">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <ul>
                                                            <li><a href="index.html">Sofa bộ</a></li>
                                                            <li><a href="index-2.html">Sofa góc</a></li>
                                                            <li><a href="index-3.html">Sofa giường</a></li>
                                                            <li><a href="index-4.html">Sofa giường</a></li>
                                                            <li><a href="index-xmas.html">Sofa giường</a></li>
                                                            <li><a href="index-rtl.html">Sofa giường<span class="label label-warning">New</span></a></li>
                                                            <li><a href="index-5.html">Ghế bành</a></li>
                                                            <li><a href="index-6.html">Bàn trà<span class="label label-warning">Isotope</span></a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <ul>
                                                            <li><a href="blog-grid.html">Bàn trà</a></li>
                                                            <li><a href="blog-list.html">Kệ tivi</a></li>
                                                            <li><a href="blog-grid-fullpage.html">Vách ốp phòng khách</a></li>
                                                            <li><a href="ideas.html">Vách ốp phòng khách</a></li>
                                                            <li><a href="article.html">Giường ngủ</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <ul>
                                                            <li><a href="about.html">Táp đầu giường</a></li>
                                                            <li><a href="contact.html">Bàn trang điểm</a></li>
                                                            <li><a href="login.html">Tủ quần áo<span class="label label-warning">New</span></a></li>
                                                        </ul>
                                                        <ul>
                                                            <li><a href="shortcodes.html">Bàn làm việc</a></li>
                                                            <li><a href="email-receipt.html">Vách ốp phòng ngủ<span class="label label-warning">New</span></a></li>
                                                            <li><NuxtLink to="/san-pham?category=19">Bàn ăn<span class="label label-warning">New</span></NuxtLink></li>
                                                        </ul>
                                                    </div>
                                                </div> <!--/row-->
                                            </div> <!--/box-->
                                        </div> <!--/box-2-->
                                    </div> <!--/navbar-box-->
                                </div> <!--/navbar-dropdown-->
                            </li>

                            <!-- Single dropdown-->

                            <li>
                                <a href="#">Loại sản phẩm <span class="open-dropdown"><i class="fa fa-angle-down"></i></span></a>
                                <div class="navbar-dropdown navbar-dropdown-single">
                                    <div class="navbar-box">

                                        <!-- box-2 (without 'box-1', box-2 will be displayed as full width)-->

                                        <div class="box-2">
                                            <div class="box clearfix">
                                                <ul>
                                                    <li><a href="products-grid.html">Nội thất phòng khách</a></li>
                                                    <li><a href="products-list.html">Nội thất phòng ngủ</a></li>
                                                    <li><a href="category.html">Nội thất phòng ăn</a></li>
                                                    <li><a href="products-topbar.html">Đồ trang trí</a></li>
                                                    <li><a href="product.html">Nội thất phòng làm việc</a></li>
                                                </ul>
                                            </div> <!--/box-->
                                        </div> <!--/box-2-->
                                    </div> <!--/navbar-box-->
                                </div> <!--/navbar-dropdown-->
                            </li>

                            <!-- Simple menu link-->

                            <li><a href="">Về chúng tôi</a></li>

                            <li><a href="">Liên hệ</a></li>
                        </ul>
                    </div> <!--/floating-menu-->
                </div> <!--/navigation-main-->

                <Login v-if="isShowLogin" />
                <Search v-if="isShowSearch"/>
                <Cart v-if="isShowCart"/>
            </div> <!--/container-->
        </nav>
</template>
<style>

</style>
<script>
import Login from "./login"
import Search from "./search"
import Cart from "./cart"
import { mapState } from "vuex";
export default {
    components: {
        Login,
        Search,
        Cart,
    },
    data(){
        return {
            isShowLogin: false,
            isShowSearch: false,
            isShowCart: false,
            scrollPosition: null,
        }
    },
    computed: {
    ...mapState({
      listCart: state => state.cart.listCart,
    })
  },
  watch: {
    $route(){
      this.isShowCart = false
      this.isShowSearch = false
      this.isShowLogi = false
    }
  },
    methods: {
        updateScroll() {
            this.scrollPosition = window.scrollY
        }
    },

    mounted() {
        window.addEventListener('scroll', this.updateScroll);
    }
}
</script>

<style lang="scss">
nav .navigation .logo img {
    max-width: 120px !important;
}
// .menu-top li a {
//   color: #ffb701 !important;
// }
</style>
