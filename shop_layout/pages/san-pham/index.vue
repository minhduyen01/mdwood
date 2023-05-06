<template>
  <div>
    <!-- ======================== Main header ======================== -->

    <section class="main-header">
      <header>
        <div class="container">
          <h1 class="h2 title">Cửa hàng</h1>
          <ol class="breadcrumb breadcrumb-inverted">
            <li><Nuxt-link to="/"><span class="icon icon-home"></span></Nuxt-link></li>
            <li><Nuxt-link to="/san-pham" class="active">Sản phẩm</Nuxt-link></li>
          </ol>
        </div>
      </header>
    </section>

    <section class="products">
      <div class="container">
        <header class="hidden">
          <h3 class="h3 title">Danh sách sản phẩm</h3>
        </header>

        <div class="row">
          <!-- === product-filters === -->
          <div class="col-md-3 col-xs-12">
            <span>Tìm kiếm</span>
            <form action="" @submit.prevent="handleSearch">
            <input type="text" class="form-control" v-model="filter.search">
            </form>
            <span>Loại sản phẩm</span>
            <FormSelect :options="listCategory" @input="handleSelectCategory" />
            <span>Danh mục sản phẩm</span>
            <FormSelect :options="listType" @input="handleSelectType" />
            <div class="bar-filter">
              <div class="row">
                <div class="col-2">Giá: </div>
                <div class="col-10">{{Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(rangePrice[0]) + ' - ' + Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(rangePrice[1])}}</div>
              </div>
              <VueSimpleRangeSlider
                    :min="0"
                    :max="10000000"
                    v-model="rangePrice"
            />
            </div>
            <button @click="handleFilterPrice" class="toggle-filters-close btn btn-main w-100 mt-3">
              Loc
            </button>
            <button @click="resetFilterProduct"  class="toggle-filters-close btn btn-main w-100 mt-3">
              reset
            </button>
          </div>

          <!--product items-->

          <div class="col-md-9 col-xs-12">

            <div class="sort-bar clearfix">
              <!--Sort options-->
              <div class="sort-options pull-right">
                <span class="hidden-xs">Sắp xếp theo</span>
                <select>
                  <option value="1">Tên</option>
                  <option value="3">Giá tăng dần</option>
                  <option value="4">Giá giản dần</option>
                </select>
              </div>
            </div>

            <ListProduct :products="products"/>
            <!-- <CustomPagination @handleSetPage="handleSetPage" :pageCount="pageCount" align="center" class="mt-5" /> -->
            <b-pagination
              v-if="this.pagination.pageCount > 1"
              v-model="currentPage"
              :total-rows="pagination.total"
              :per-page="pagination.perPage"
              aria-controls="my-table"
            ></b-pagination>
          </div>

        </div>
      </div>
    </section>

  </div>
</template>

<script>
import VueSimpleRangeSlider from 'vue-simple-range-slider';
import 'vue-simple-range-slider/dist/vueSimpleRangeSlider.css'
import FormSelect from "~/components/form/FormSelect.vue"
export default {
  components: {
    FormSelect,
    VueSimpleRangeSlider
  },
  data() {
    return {
      filter: {
        search: null,
      },
      activeNames: ['1', '2', '3', '4'],
      products: [],
      listCategory: null,
      listType: null,
      pageCount: 0,
      category: null,
      type: null,
      rangePrice: [0, 10000000],
      currentPage: null,
      pagination: {
        total: null,
        perPage: null,
        pageCount: null,
      }

    }
  },
  async beforeRouteUpdate(to, from, next) {
    console.log('before');
    var api = "/product?"
    // if(to.query.category) {
    //   let res = await this.$axios.get(`/product?category=${to.query.category}`);
    //   this.products = res.data.data
    //   this.pageCount = res.data.last_page
    // }
    // if(to.query.page) {
      let res = await this.$axios.get('/product', {params: {page: to.query.page, category: to.query.category}});
      console.log(res, 'res');
      this.products = res.data.data
      this.currentPage = res.data.current_page;
      this.pagination.pageCount = res.data.last_page;
      this.pagination.total = res.data.total;
      this.pagination.perPage = res.data.per_page;

    // }

    next();
  },
  watch: {
    category(newVal) {
      this.$router.push({path: '/san-pham', query: {
        ...this.$route.query,
        category: newVal,
      }})
    },
    currentPage(newVal) {
      this.$router.push({path: '/san-pham', query: {
        ...this.$route.query,
        page: newVal,
      }})
    },
    async $route(newVal, oldVal) {
      const res = await this.$axios.get('/product', {params: {...this.$route.query}});
      console.log(res);
      this.products = res.data.data;
      this.currentPage = res.data.current_page;
      this.pagination.total = res.data.total;
      this.pagination.lastPage = res.data.last_page;
      this.pagination.perPage = res.data.per_page;
      console.log("route change", res);
    },

  },
  methods: {
    handleChange(val) {
      console.log(val);
    },
    getListProduct() {
      this.$axios.get('/product').then(res => {
        console.log(res, 'res');

        this.products = res.data.data
        this.pageCount = res.data.last_page
        this.currentPage = res.data.current_page;
        this.pagination.total = res.data.total;
        this.pagination.lastPage = res.data.last_page;
        this.pagination.perPage = res.data.per_page;
      })
    },
    getListCategory() {
      this.$axios.get('/category').then(res => {
        this.listCategory = res.data.map(item => {return {value: item.id, text: item.name}} )
      })
    },
    getListType() {
      this.$axios.get('/type').then(res => {
        this.listType = res.data.map(item => {return {value: item.id, text: item.name}} )
      })
    },
    handleSelectCategory(val) {
      this.category = val;
    },
    handleSelectType(val) {
      this.type = val;
      this.$router.push({path: '/san-pham', query: {
        ...this.$route.query,
        type: val,
      }})
      console.log('handleseecttype', val);
    },
    handleSearch() {
      console.log(this.filter.search, '123');
      this.$router.push({
        path: '/san-pham',
        query: {
          ...this.$route.query,
          search: this.filter.search,
        }
      })
    },
    handleFilterPrice() {
      this.$router.push({
        path: "/san-pham",
        query: {
          ...this.$route.query,
          min: this.rangePrice[0],
          max: this.rangePrice[1]
        }
      });
    },
    resetFilterProduct() {
      this.filter.search = null;
      this.rangePrice = [0, 10000000];
      this.category = null;
      this.$router.push('san-pham')
    },
    handleSetPage(val) {
        console.log(val, '123');
    }
  },
  created() {
    this.getListProduct();
    this.getListCategory();
    this.getListType();
  }
}
</script>

<style lang="scss">
.el-card__body{
  padding: 0 10px;
}
.main-header {
  background-image:url('http://127.0.0.1:8000/storage/uploads/banner3.jpg');
}
nav.mt-5 {
  background-color: #eee;
  position: inherit;
}
.bar-filter {
    .simple-range-slider {
      .simple-range-slider-popover,
      .simple-range-slider-popover-arrow {
        display: none;
      }
      .simple-range-slider-bg-bar {
        margin-top: 1.5rem;
      }
      // .simple-range-slider-bar {
      //   width: 100% !important;
      // }
    }
  }
</style>
