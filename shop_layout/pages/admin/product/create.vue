<template>
    <div class="content">
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <h4 class="m-0" style="float: left">Thêm sản phẩm</h4>
            </div>
            <div>
                <el-form ref="formItemName" :model="form" label-width="140px" :rules="rules">
                    <el-col :span="11" class="pr-5">
                        <el-form-item label="Tên sản phẩm" prop="name">
                            <el-input v-model="form.name"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="Loại sản phẩm" prop="typeProduct">
                            <el-select v-model="form.typeProduct" placeholder="Loại sản phẩm">
                                <el-option v-for="typeProduct in typeProducts.data" :key="typeProduct.id"
                                :label="typeProduct.name" :value="typeProduct.id"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="Danh mục" prop="category">
                            <el-select v-model="form.category" placeholder="Danh mục">
                                <el-option v-for="category in categories.data" :key="category.id"
                                :label="category.name" :value="category.id"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item label="Nhà cung cấp" prop="supplier">
                            <el-select v-model="form.supplier" placeholder="Nhà cung cấp">
                                <el-option v-for="supplier in suppliers.data" :key="supplier.id"
                                :label="supplier.name" :value="supplier.id"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="11">
                        <el-form-item label="Nơi sản xuất" prop="origin">
                            <el-input v-model="form.origin"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="24" class="pb-5">
                        <el-form-item label="Mô tả">
                          <ckeditor :editor="editor" v-model="form.description" :config="editorConfig"></ckeditor>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12" class="pr-5">
                        <el-form-item label="Vật liệu chế tạo" prop="material">
                            <el-input v-model="form.material"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12" class="pl-5">
                        <el-form-item label="Kích thước" prop="size">
                            <el-input v-model="form.size"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12" class="pr-5">
                        <el-form-item label="Giá tiền" prop="unitPrice">
                            <el-input v-model="form.unitPrice"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12" class="pl-5">
                        <el-form-item label="Sale" prop="sale">
                            <el-input v-model="form.sale"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12" class="pr-5">
                        <el-form-item label="Đơn vị" prop="unit">
                            <el-input v-model="form.unit"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="24" class="pb-5">
                        <el-form-item label="Ảnh">
                            <el-upload action="#" list-type="picture-card" :before-upload="beforeUpload">
                                <i slot="default" class="el-icon-plus"></i>
                            </el-upload>
                            <el-dialog :visible.sync="dialogVisible">
                                <img width="100%" :src="dialogImageUrl" alt="">
                            </el-dialog>
                        </el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item style="float: right">
                            <el-button type="primary" @click="submitForm()">Thêm mới</el-button>
                        </el-form-item>
                    </el-col>
                </el-form>
            </div>
        </el-card>
    </div>
</template>
<script>
import Vue from 'vue';
import CKEditor from '@ckeditor/ckeditor5-vue2';
import Swal from 'sweetalert2'
import { Upload } from 'element-ui';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import UploadAdapter from '../../../plugins/uploadadapter';

Vue.use( CKEditor );
export default {
    layout: 'admin',
    data() {
        return {
            form: {},
            dialogImageUrl: '',
            dialogVisible: false,
            disabled: false,
            typeProducts: [],
            suppliers: [],
            categories: [],
            images: [],
            editor: ClassicEditor,
            rules: {
                name: [
                    { required: true, message: 'Tên không được để trống', trigger: 'blur' },
                ],
                typeProduct: [
                    { required: true, message: 'Loại sản phẩm không được để trống', trigger: 'change' },
                ],
                category: [
                    { required: true, message: 'Danh mục không được để trống', trigger: 'change' },
                ],
                supplier: [
                    { required: true, message: 'Nhà cung cấp không được để trống', trigger: 'change' },
                ],
                origin: [
                    { required: true, message: 'Nơi sản xuất không được để trống', trigger: 'blur' },
                ],
                material: [
                    { required: true, message: 'Vật liệu chế tạo không được để trống', trigger: 'blur' },
                ],
                size: [
                    { required: true, message: 'Size không được để trống', trigger: 'blur' },
                ],
                unitPrice: [
                    { required: true, message: 'Giá tiền không được để trống', trigger: 'blur' },
                ],
                sale: [
                    { required: true, message: 'Khuyến mãi không được để trống', trigger: 'blur' },
                ],
                unit: [
                    { required: true, message: 'Đợn vị không được để trống', trigger: 'blur' },
                ],
            },
            editorConfig: {
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'insertTable', '|', 'imageUpload', 'mediaEmbed', '|', 'undo', 'redo' ],
                table: {
                    toolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ]
                },
                extraPlugins: [this.uploader],
                language: 'vi',
            }
        }
    },
    methods: {
        beforeUpload(file) {
            const isJPG = file.type === 'image/jpeg';
            const isLt2M = file.size / 1024 / 1024 < 10;
            if (!isJPG) {
                This.$message.error('Upload avatar image can only be JPG format!');
            }
            if (!isLt2M) {
                This.$message.error('Upload avatar image size cannot exceed 2MB!');
            }
            this.images.push(file)
            return isJPG && isLt2M;
        },
        async submitForm() {
            this.$refs.formItemName.validate((valid) => {
                if (valid) {
                    const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    }
                    let product = new FormData()
                    product.append('name', this.form.name)
                    product.append('category_id', this.form.category)
                    product.append('supplier_id', this.form.supplier)
                    product.append('type_product_id', this.form.typeProduct)
                    product.append('origin', this.form.origin)
                    product.append('description', this.form.description)
                    product.append('material', this.form.material)
                    product.append('size', this.form.size)
                    product.append('unit_price', this.form.unitPrice)
                    product.append('sale', this.form.sale)
                    product.append('unit', this.form.unit)
                    this.images.forEach(element => {
                        product.append('images[]', element)
                    });
                    this.$axios.post("/admin/product", product, config).then((result) => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thêm mới thành công',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.$router.push('/admin/product')
                    }).catch((err) => {
                        Swal.fire({
                            icon: 'cancel',
                            title: 'Thêm mới không thành công',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    });
                } else {
                    return false;
                }
            });
        },
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        uploader(editor)
        {
            editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                return new UploadAdapter( loader );
            };
        },
    },
    async created() {
        this.typeProducts = await this.$axios.get('/admin/type_product')
        this.suppliers = await this.$axios.get('/admin/supplier')
        this.categories = await this.$axios.get('/admin/category')
    },
}
</script>
<style>
.content {
    padding: calc(2.2rem - 0.4rem) 2.2rem 0;
    margin-top: 9rem;
}
.el-upload__input {
    display: none !important;
}
</style>
