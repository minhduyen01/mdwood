<template>
  <div class="content">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <h4 class="m-0" style="float: left">Thêm tin tức</h4>
        <NuxtLink :to="`/admin/news/create`" style="color: #fff">
          <el-button style="float: right" type="primary">
            Thêm mới
          </el-button>
        </NuxtLink>
      </div>
      <div>
        <el-form ref="formItemName" :model="form" label-width="140px" >
          <el-col :span="24">
            <el-form-item label="Tiêu đề" prop="title">
              <el-input v-model="form.title"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="24" class="pb-5">
            <el-form-item label="Nội dung" prop="content">
              <ckeditor :editor="editor" v-model="form.content" :config="editorConfig"></ckeditor>
            </el-form-item>
          </el-col>
          <el-col :span="24" class="pb-5">
            <el-form-item label="Mô tả" prop="summary">
              <el-input v-model="form.summary" type="textarea" :rows="2"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="24" class="pb-5">
            <el-form-item label="Ảnh" prop="image">
              <el-upload action="#" list-type="picture-card"
              :before-upload="beforeUpload"
              :on-preview="handlePictureCardPreview"
              :on-change="handleEditChange"
              :on-remove="handleRemove"
              :class="{disabled:hideUploadEdit}">
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
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import UploadAdapter from '../../../plugins/uploadadapter';

Vue.use( CKEditor );
export default {
  layout: 'admin',
  data() {
    return {
      form: {},
      editor: ClassicEditor,
      editorConfig: {
        toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'insertTable', '|', 'imageUpload', 'mediaEmbed', '|', 'undo', 'redo' ],
        table: {
            toolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ]
        },
        extraPlugins: [this.uploader],
        language: 'vi',
      },
      dialogImageUrl: '',
      dialogVisible: false,
      hideUploadEdit:false,
    }
  },
  methods: {
    uploader(editor)
    {
      editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
          return new UploadAdapter( loader );
      };
    },
    beforeUpload(file) {
      const isJPG = file.type === 'image/jpeg';
      const isLt2M = file.size / 1024 / 1024 < 10;
      if (!isJPG) {
          This.$message.error('Upload avatar image can only be JPG format!');
      }
      if (!isLt2M) {
          This.$message.error('Upload avatar image size cannot exceed 2MB!');
      }
      this.form.image = file
      return isJPG && isLt2M;
    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    },
    handleEditChange(file, fileList) {
      let vm = this
      vm.hideUploadEdit = fileList.length >= 1
    },
    handleRemove(file, fileList) {
      let vm = this
      fileList = []
      vm.hideUploadEdit = false
    },
    submitForm() {
      this.$refs.formItemName.validate((valid) => {
        if (valid) {
          const config = {
            headers: { 'content-type': 'multipart/form-data' }
          }
          let product = new FormData()
          product.append('title', this.form.title)
          product.append('content', this.form.content)
          product.append('summary', this.form.summary)
          product.append('image', this.form.image)
          this.$axios.post('/admin/news', product, config).then(res => {
            Swal.fire({
              icon: 'success',
              title: 'Thêm mới thành công',
              showConfirmButton: false,
              timer: 1500
            })
            this.$router.push('/admin/news')
          })
        }
      })
    }
  }
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
.disabled .el-upload.el-upload--picture-card {
  display: none;
}
</style>
