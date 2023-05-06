<template>
    <div>
        <el-menu
        default-active="2"
        class="el-menu-vertical"
        background-color="#FFFFFF"
        text-color="#626262"
        active-text-color="#ffd04b"
        :router="true"
        >
            <el-menu-item index="1" disabled class="logo p-0">
                <h2 class="m-0">MDWOOD</h2>
            </el-menu-item>
            <el-menu-item index="/admin" class="is-active">
                <i class="fal fa-home-lg"></i>
                <span>Trang chủ</span>
            </el-menu-item>
            <el-menu-item index="/admin/product">
                <i class="fal fa-bags-shopping"></i>
                <span>Sản phẩm</span>
            </el-menu-item>
            <el-menu-item index="/admin/type-product">
                <i class="fal fa-shopping-basket"></i>
                <span>Loại sản phẩm</span>
            </el-menu-item>
            <el-menu-item index="/admin/category">
                <i class="fal fa-cubes"></i>
                <span>Danh mục</span>
            </el-menu-item>
            <el-menu-item index="/admin/slide">
                <i class="fal fa-file-image"></i>
                <span>Slide</span>
            </el-menu-item>
            <el-menu-item index="/admin/supplier">
                <i class="fal fa-truck"></i>
                <span>Nhà cung cấp</span>
            </el-menu-item>
            <!-- <el-menu-item index="/admin/5">
                <i class="fal fa-users"></i>
                <span>Khách hàng</span>
            </el-menu-item> -->
            <el-menu-item index="/admin/news">
                <i class="fal fa-newspaper"></i>
                <span>Tin tức</span>
            </el-menu-item>
            <el-menu-item index="/admin/discount">
                <i class="fal fa-tags"></i>
                <span>Khuyến mãi</span>
            </el-menu-item>
            <el-menu-item index="/admin/order">
                <i class="fal fa-file-invoice-dollar"></i>
                <span>Đơn đặt hàng</span>
            </el-menu-item>
            <!-- <el-menu-item index="/admin/9">
                <i class="fal fa-ballot-check"></i>
                <span>Đơn nhập hàng</span>
            </el-menu-item> -->
        </el-menu>
    </div>
</template>
<script>
import Vue from 'vue';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

Vue.use(ElementUI);
export default {

}
</script>

<style lang="scss">
.el-menu-vertical {
    box-shadow: 0 0 15px 0 rgb(0 0 0 / 5%);
    position: fixed;
    width: 260px;
    height: 100%;
    top: 0;
    i {
        padding-right: 10px;
        font-weight: 500;
        font-size: 18px;
    }
    .el-menu-item {
        font-size: 16px;
    }
}
.is-active {
    a {
        color: rgb(255, 208, 75) !important;
    }
}
.logo {
    height: 80px;
    h2 {
        height: 80px;
        line-height: 80px;
        text-align: center;
        color: #ffb701;
        background-color: #000;
    }
    opacity: 1 !important;
}
</style>
