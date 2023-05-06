<template>
  <div>
        <!-- ========================  Main header ======================== -->

    <section class="main-header main-header-blog">
        <header>
            <div class="container text-center">
                <h2 class="h2 title">Blog</h2>
                <ol class="breadcrumb breadcrumb-inverted" style="display: block;">
                    <li><a href="index.html"><span class="icon icon-home"></span></a></li>
                    <li><a href="blog-grid.html">Blog</a></li>
                    <li><a class="active" href="article.html">{{ blog.title }}</a></li>
                </ol>
            </div>
        </header>
    </section>

    <!-- ========================  Blog article ======================== -->

    <section class="blog">

        <!-- ========================  Blog post ======================== -->

        <div class="container">

            <div class="row">

                <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

                    <div class="blog-post">

                        <!-- === blog main image & entry info === -->

                        <div class="blog-image-main">
                            <img :src="`http://127.0.0.1:8000/storage/uploads/${blog.image}`" alt="" />
                        </div>

                        <div class="blog-post-content">

                            <!-- === blog post title === -->

                            <div class="blog-post-title">
                                <h1 class="blog-title">
                                    {{ blog.title }}
                                </h1>
                                <h2 class="blog-subtitle h5">
                                    {{ blog.summary }}
                                </h2>

                                <div class="blog-info blog-info-top">
                                    <!-- <div class="entry">
                                        <i class="fa fa-user"></i>
                                        <span>John Doe</span>
                                    </div> -->
                                    <div class="entry">
                                        <i class="fa fa-calendar"></i>
                                        <span>{{ getDateTime(blog.created_at) }}</span>
                                    </div>
                                </div> <!--/blog-info-->
                            </div>

                            <!-- === blog post text === -->

                            <div class="blog-post-text" v-html="blog.content">

                            </div>

                            <!-- === blog info === -->

                        </div>

                    </div><!--blog-post-->
                </div><!--col-sm-8-->
            </div> <!--/row-->
        </div><!--/container-->
    </section>
  </div>
</template>

<script>
import moment from 'moment'

export default {
  data() {
    return {
      blog: {}
    }
  },
  methods: {
    async getDetailBlog(slug)
    {
      let res = await this.$axios.get(`/news/${slug}`)
      this.blog = res.data
    },
    getDateTime(timestamp) {
        return moment(timestamp).calendar();
    }
  },
  created() {
    const slug = this.$route.params.slug
    this.getDetailBlog(slug)
  }
}
</script>

<style>
.main-header {
  background-image:url('http://127.0.0.1:8000/storage/uploads/banner2.jpg');
}
</style>
