<template>
    <div class="popup-main">

                    <!-- === product popup === -->

        <div class="product">

            <!-- === popup-title === -->

            <div class="popup-title">
                <div class="h1 title">{{ product.name }} <small>{{ product.category.name }}</small></div>
            </div>

            <!-- === product gallery === -->

            <b-carousel
                controls
                :interval="3000"
            >
              <b-carousel-slide v-for="image in product.images" :key="image.id"
                :img-src="image.image" :img-width="640"></b-carousel-slide>
            </b-carousel>

            <!-- === product-popup-info === -->

            <div class="popup-content">
                <div class="product-info-wrapper">
                    <div class="row">

                        <!-- === left-column === -->

                        <div class="col-sm-6">
                            <div class="info-box">
                                <strong>Xuất xứ</strong>
                                <span>{{ product.origin }}</span>
                            </div>
                            <div class="info-box">
                                <strong>Chất liệu</strong>
                                <span>{{ product.material }}</span>
                            </div>
                        </div>

                        <!-- === right-column === -->

                        <div class="col-sm-6">
                            <div class="info-box">
                                <strong>Kích thước</strong>
                                <span>{{ product.size }}</span>
                            </div>
                            <div class="info-box">
                                <strong>Bảo hành</strong>
                                <span>2 năm</span>
                            </div>
                            <div class="info-box">
                                <strong>Bảo trì</strong>
                                <span>Trọn đời sản phẩm</span>
                            </div>
                        </div>

                    </div> <!--/row-->
                </div> <!--/product-info-wrapper-->
            </div> <!--/popup-content-->
            <!-- === product-popup-footer === -->

            <div class="popup-table">
                <div class="popup-cell">
                    <div class="price">
                        <span class="h3">
                          {{ Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( product.unit_price * (100 - product.sale) / 100 ) }}
                          <small v-if="product.sale > 0">{{ Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( product.unit_price ) }}</small>
                        </span>
                    </div>
                </div>
                <div class="popup-cell">
                    <div class="popup-buttons">
                        <a href="product.html"><span class="icon icon-eye"></span> <span class="hidden-xs">Chi tiết</span></a>
                        <a href="javascript:void(0);"><span class="icon icon-cart"></span> <span class="hidden-xs">Mua</span></a>
                    </div>
                </div>
            </div>

        </div> <!--/product-->
    </div>
</template>
<script>
export default {
    props: ['product'],
    mounted() {

    }
}
</script>
