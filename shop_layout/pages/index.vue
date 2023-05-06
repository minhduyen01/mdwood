<template>
  <div>
    <Slider />
    <section class="products">
      <div class="container">

        <!-- === header title === -->

        <header>
            <div class="row">
                <div class="col-md-offset-2 col-md-8 text-center">
                    <h2 class="title">Sản phẩm nổi bật</h2>
                </div>
            </div>
        </header>

        <ListProduct :products="products"/>
        <!-- === button more === -->

        <div class="wrapper-more">
            <Nuxt-link to="/san-pham" class="btn btn-main">Xem thêm</Nuxt-link>
        </div>
        <!-- <modal name="product-modal" :height="830" :width="640">
          <Product/>
        </modal> -->
      </div> <!--/container-->
    </section>

    <!-- ========================  Icons ======================== -->

        <section class="info-icons info-icons-frontpage">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-md-3">
                        <figure>
                            <figcaption>
                                <span><i class="icon icon-gift"></i></span>
                                <span>
                                    <strong>Tặng quà ưu đãi</strong>
                                    <small>Uu đãi cho người dùng mới</small>
                                </span>
                            </figcaption>
                        </figure>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <figure>
                            <figcaption>
                                <span><i class="icon icon-rocket"></i></span>
                                <span>
                                    <strong>Chuyển phát nhanh</strong>
                                    <small>Giao hàng tận nhà toàn quốc</small>
                                </span>
                            </figcaption>
                        </figure>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <figure>
                            <figcaption>
                                <span><i class="icon icon-history"></i></span>
                                <span>
                                    <strong>Chính sách hoàn tiền</strong>
                                    <small>Hoàn tiền sản phẩm lên đến 30 ngày</small>
                                </span>
                            </figcaption>
                        </figure>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <figure>
                            <figcaption>
                                <span><i class="icon icon-store"></i></span>
                                <span>
                                    <strong>Nhiều chi nhanh</strong>
                                    <small>Có mặt trên 30 tỉnh thành</small>
                                </span>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
        </section>

    <section class="products">
      <div class="container">

        <!-- === header title === -->

        <header>
            <div class="row">
                <div class="col-md-offset-2 col-md-8 text-center">
                    <h2 class="title">Sản phẩm mới</h2>
                </div>
            </div>
        </header>

        <ListProduct :products="newProducts"/>
        <!-- === button more === -->

        <div class="wrapper-more">
            <Nuxt-link to="/san-pham" class="btn btn-main">Xem thêm</Nuxt-link>
        </div>
        <!-- <modal name="product-modal" :height="830" :width="640">
          <Product/>
        </modal> -->
      </div> <!--/container-->
    </section>

    <!-- ========================  Banner ======================== -->

        <section class="banner" style="background-image:url('http://127.0.0.1:8000/storage/uploads/banner4.jpg')">
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-2 col-md-8 text-center">
                        <h2 class="title">Câu chuyện của cúng tôi</h2>
                        <p>
                            Chúng tôi tin rằng sự sáng tạo là một trong những động lực chính của sự tiến bộ. Với ý tưởng này, chúng tôi đã đi khắp nước Ý để tìm kiếm những nghệ nhân xuất chúng và mang những đồ vật thủ công độc đáo của họ đến với những người sành sỏi ở khắp mọi nơi.
                        </p>
                        <p><a href="about.html" class="btn btn-clean">Xem thêm</a></p>
                    </div>
                </div>
            </div>
        </section>

    <!-- ========================  Blog ======================== -->

        <section class="blog">

            <div class="container">

                <!-- === blog header === -->

                <header>
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8 text-center">
                            <h1 class="h2 title">Bài viết</h1>
                            <div class="text">
                                <p>Tin tức mới nhất</p>
                            </div>
                        </div>
                    </div>
                </header>

                <div class="row">

                    <!-- === blog item === -->

                    <div class="col-sm-4" v-for="item in news" :key="item.id">
                        <article>
                            <Nuxt-Link :to="`/blog/${item.slug}`">
                                <div class="image" :style="`background-image:url('http://127.0.0.1:8000/storage/uploads/${item.image}')`">
                                    <img :src="`http://127.0.0.1:8000/storage/uploads/${item.image}`" alt="" />
                                </div>
                                <div class="entry entry-table">
                                    <div class="date-wrapper">
                                        <div class="date">
                                            {{ item.created_at | moment }}
                                        </div>
                                    </div>
                                    <div class="title hidden-text">
                                        <h2 class="h5">{{ item.title }}</h2>
                                    </div>
                                </div>
                                <div class="show-more">
                                    <span class="btn btn-main btn-block">Đọc thêm</span>
                                </div>
                            </Nuxt-Link>
                        </article>
                    </div>

                </div> <!--/row-->
                <!-- === button more === -->

                <div class="wrapper-more">

                    <Nuxt-Link :to="`/blog`" class="btn btn-main">Xem thêm</Nuxt-Link>
                </div>

            </div> <!--/container-->
        </section>

  </div>
</template>

<script>
import moment from 'moment'

export default {
  data() {
    return {
      products: [],
      news: [],
      newProducts: [],
    }
  },
  methods: {
    async getTopProduct() {
      let res = await this.$axios.get('/top_product')
      console.log(res);
      this.products = res.data
    },
    async getNewProduct() {
      let res = await this.$axios.get('/new_product')
      console.log(res);
      this.newProducts = res.data
    },
    async getNewBlog() {
      let res = await this.$axios.get('/news')
      this.news = res.data
    },
  },
  created() {
    this.getTopProduct()
    this.getNewBlog()
    this.getNewProduct()
  },
  filters: {
    moment: function (date) {
      return moment(date).lang("vi").format('MMM DD YYYY');
    }
  }
}
</script>

<style>
.info-icons.info-icons-frontpage{
  margin-top: -30px !important;
}
.hidden-text {
  word-break: break-all;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -moz-box-orient: vertical;
  -ms-box-orient: vertical;
  box-orient: vertical;
  -webkit-line-clamp: 3;
  -moz-line-clamp: 3;
  -ms-line-clamp: 3;
  line-clamp: 3;
  overflow: hidden;
}
</style>
