<template>
  <div class="content">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <h4 class="m-0" style="float: left">Thêm mới slide</h4>
      </div>
      <div>
        <el-form ref="formItemName" :model="slide" label-width="80px">
          <el-col :span="24" class="pr-5">
            <el-form-item label="Tiêu đề" prop="name">
              <el-input v-model="slide.name"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="24" class="pr-5">
            <el-form-item label="Mô tả" prop="name">
              <ckeditor :editor="editor" v-model="slide.description" :config="editorConfig"></ckeditor>
            </el-form-item>
          </el-col>
          <el-col :span="24" class="pb-5">
            <el-form-item label="Ảnh">
              <el-upload action="#" list-type="picture-card" :file-list="list"
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

Vue.use( CKEditor );
export default {
  layout: 'admin',
  data() {
    return {
      slide: {},
      image: {},
      list: [],
      dialogImageUrl: '',
      dialogVisible: false,
      hideUploadEdit:false,
      editor: ClassicEditor,
      editorConfig: {
          toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo' ],
          table: {
              toolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ]
          },
          language: 'vi',
      }
    }
  },
  methods: {
    beforeUpload(file) {
      const isJPG = file.type === 'image/jpeg';
      const isLt2M = file.size / 1024 / 1024 < 100;
      if (!isJPG) {
          This.$message.error('Upload avatar image can only be JPG format!');
      }
      if (!isLt2M) {
          This.$message.error('Upload avatar image size cannot exceed 10MB!');
      }
      this.image = file
      return isJPG && isLt2M;
    },
    async submitForm() {
      this.$refs.formItemName.validate((valid) => {
        if (valid) {
          const config = {
            headers: { 'content-type': 'multipart/form-data' }
          }
          let product = new FormData()
          product.append('name', this.slide.name)
          product.append('description', this.slide.description)
          if (Object.keys( this.image ).length > 0) {
            product.append('image', this.image)
          }
          this.$axios.post(`/admin/slide/${this.slide.id}`, product, config).then((result) => {
            Swal.fire({
              icon: 'success',
              title: 'Cập nhật thành công',
              showConfirmButton: false,
              timer: 1500
            })
            this.$router.push('/admin/slide')
          }).catch((err) => {
            Swal.fire({
              icon: 'error',
              title: 'Cập nhật không thành công',
              showConfirmButton: false,
              timer: 1500
            })
          });
        } else {
            return false;
        }
      });
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
      this.image = null
      vm.hideUploadEdit = false
    }
  },
  async created() {
    const id = this.$route.params.id
    let res = await this.$axios.get(`/admin/slide/${id}`)
    this.slide = res.data
    this.list.push({
      name: res.data.image,
      url: `http://127.0.0.1:8000/storage/uploads/${res.data.image}`
    })
    console.log(this.list);
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
