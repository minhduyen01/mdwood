<template>
    <div class="content">
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <h4 class="m-0" style="float: left">Quản lý sản phẩm</h4>
                <NuxtLink :to="`/admin/product/create`" style="color: #fff">
                    <el-button style="float: right" type="primary">
                        Thêm mới
                    </el-button>
                </NuxtLink>
            </div>
            <div class="row py-3">
              <div class="col-12">
                <el-input placeholder="Tìm kiếm" v-model="search" class="w-75"></el-input>
                <el-button type="primary" @click="searchpr()">Tìm kiếm</el-button>
                <el-button type="primary" @click="resetFilterProduct">reset</el-button>
              </div>
              <div class="col-6">
                Chọn danh mục
                <FormSelect :options="listCategory" @input="handleSelectCategory" />
              </div>
              <div class="col-6">
                Chọn loại sản phẩm
                <FormSelect :options="listType" @input="handleSelectType" />
              </div>
            </div>
            <div>
                <el-table :data="products" style="width: 100%">
                    <el-table-column
                        fixed
                        prop="id"
                        label="ID"
                        width="50">
                    </el-table-column>
                    <el-table-column
                        fixed
                        prop="name"
                        label="Tên sản phẩm"
                        width="150">
                    </el-table-column>
                    <el-table-column
                        prop="type_product.name"
                        label="Loại sản phẩm"
                        width="140">
                    </el-table-column>
                    <el-table-column
                        prop="category.name"
                        label="Danh mục"
                        width="100">
                    </el-table-column>
                    <el-table-column
                        prop="supplier.name"
                        label="Nhà cung cấp"
                        width="140">
                    </el-table-column>
                    <el-table-column
                        prop="origin"
                        label="Xuất xứ"
                        width="140">
                    </el-table-column>
                    <el-table-column
                        prop="material"
                        label="Chất liệu"
                        width="140">
                    </el-table-column>
                    <el-table-column
                        prop="size"
                        label="Kích thước"
                        width="140">
                    </el-table-column>
                    <el-table-column
                        prop="unit_price"
                        label="Giá bán"
                        width="140">
                    </el-table-column>
                    <el-table-column
                        prop="sale"
                        label="Khuyến mại"
                        width="140">
                    </el-table-column>
                    <el-table-column
                        prop="unit"
                        label="Đơn vị"
                        width="140">
                    </el-table-column>
                    <el-table-column
                        fixed="right"
                        label="Operations"
                        width="120">
                        <template slot-scope="scope">
                            <NuxtLink :to="`/admin/product/${scope.row.id}/update`">
                                <el-button type="primary" icon="el-icon-edit" circle></el-button>
                            </NuxtLink>
                            <el-button type="danger" icon="el-icon-delete" @click="open(scope.row.id)" circle></el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
            <!-- <CustomPagination :pageCount="pageCount" align="center" class="mt-5" /> -->
            <b-pagination
              v-model="currentPage"
              :total-rows="pagination.total"
              :per-page="pagination.perPage"
              aria-controls="my-table"
            ></b-pagination>
        </el-card>
    </div>
</template>
<script>
import Swal from 'sweetalert2'
import FormSelect from "~/components/form/FormSelect.vue"
export default {
    layout: 'admin',
    components: {
      FormSelect,
    },
    data() {
        return {
            products: [],
            pageCount: 0,
            search: "",
            listCategory: null,
            category: null,
            listType: null,
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
      // let res = await this.$axios.get(`/admin/product?page=${to.query.page}`);
      // this.products = res.data.data
      // console.log('after', res);
      // let res = await this.$axios.get('/admin/product', {params: {page: to.query.page, category: to.query.category}});
      // console.log(res, 'res');
      // this.products = res.data.data
      // this.currentPage = res.data.current_page;
      // this.pagination.pageCount = res.data.last_page;
      // this.pagination.total = res.data.total;
      // this.pagination.perPage = res.data.per_page;
      next();
    },
    watch: {
      category(newVal) {
        this.$router.push({path: '/admin/product', query: {
          ...this.$route.query,
          category: newVal,
        }})
      },
      currentPage(newVal) {
          this.$router.push({path: '/admin/product', query: {
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
        async getProducts() {
            let res = await this.$axios.get('/admin/product')
            this.products = res.data.data
            this.pageCount = res.data.last_page
            this.currentPage = res.data.current_page;
            this.pagination.total = res.data.total;
            this.pagination.lastPage = res.data.last_page;
            this.pagination.perPage = res.data.per_page;
        },
        open(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Bạn có chắc chắn xóa k?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có',
                cancelButtonText: "Không"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$axios.delete('/admin/product/' + id).then(res => {
                        this.getProducts()
                    })
                    Swal.fire(
                        'Deleted!',
                        'Xóa thành công.',
                        'success'
                    )
                }
            })
        },
        getListCategory() {
          this.$axios.get('/category').then(res => {
            this.listCategory = res.data.map(item => {return {value: item.id, text: item.name}} )
          })
        },
        async searchpr() {
          this.$router.push({
            path: '/admin/product',
            query: {
              ...this.$route.query,
              search: this.search,
            }
          })
        },
        handleSelectCategory(val) {
          this.category = val;
        },
        getListType() {
          this.$axios.get('/type').then(res => {
            this.listType = res.data.map(item => {return {value: item.id, text: item.name}} )
          })
        },
        handleSelectType(val) {
          this.type = val;
          this.$router.push({path: '/admin/product', query: {
            ...this.$route.query,
            type: val,
          }})
        },
      resetFilterProduct() {
        this.search = null;
        this.category = null;
        this.$router.push('/admin/product')
      }
    },
    async created() {
        this.getProducts()
        this.getListCategory();
        this.getListType();
    }
}
</script>
<style lang="scss">
.content {
    padding: calc(2.2rem - 0.4rem) 2.2rem 0;
    margin-top: 9rem;
}
.text-long {
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
nav {
  background-color: #fff;
  position: inherit;
}
</style>
