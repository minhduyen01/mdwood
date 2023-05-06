<template>
  <div>
    <section class="main-header">
        <header>
            <div class="container">
                <h1 class="h2 title">Blog</h1>
                <ol class="breadcrumb breadcrumb-inverted">
                    <li><a href="index.html"><span class="icon icon-home"></span></a></li>
                    <li><a class="active" href="blog-1.html">Blog</a></li>
                </ol>
            </div>
        </header>
    </section>

    <!-- ========================  Blog ======================== -->

    <section class="blog">

        <div class="container">

            <div class="pre-header">
                <div>
                    <h2 class="h3 title">
                        Blog của chúng tôi
                    </h2>
                </div>
            </div>

            <div class="row">

                <!-- === blog-item === -->

                <div class="col-sm-4" v-for="item in newsList" :key="item.id">
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
                                <div class="title">
                                    <h2 class="h5">{{ item.title }}</h2>
                                </div>
                            </div>
                        </Nuxt-Link>
                    </article>
                </div>

            </div> <!--/row-->
            <!-- === pagination === -->

            <!-- <div class="pagination-wrapper">
                <ul class="pagination">
                    <li>
                        <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li>
                        <a href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div> /pagination -->

        </div><!--/container-->
    </section>
  </div>
</template>

<script>
import moment from 'moment'

export default {
  data() {
    return {
      newsList: [],
    }
  },
  created() {
    this.$axios.get('/all_news').then(res => {
      this.newsList = res.data.data
    })
  },
  filters: {
    moment: function (date) {
      return moment(date).lang("vi").format('MMM DD YYYY');
    }
  }
}
</script>

<style>
.main-header {
  background-image:url('http://127.0.0.1:8000/storage/uploads/banner2.jpg');
}
</style>
