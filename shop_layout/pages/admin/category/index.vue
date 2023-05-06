<template>
    <div class="content">
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <h4 class="m-0" style="float: left">Quản lý danh mục</h4>
                <el-button style="float: right" type="primary" @click="create">
                    Thêm mới
                </el-button>
            </div>
            <div>
                <el-table :data="categories" style="width: 100%">
                    <el-table-column prop="id" label="ID" width="150">
                    </el-table-column>
                    <el-table-column prop="name" label="Tên danh mục">
                    </el-table-column>
                    <el-table-column
                        fixed="right"
                        label="Operations"
                        width="120"
                    >
                        <template slot-scope="scope">
                            <el-button
                                type="primary"
                                icon="el-icon-edit"
                                circle
                                @click="update(scope.row.id)"
                            ></el-button>
                            <el-button
                                type="danger"
                                icon="el-icon-delete"
                                @click="delCategory(scope.row.id)"
                                circle
                            ></el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </el-card>
    </div>
</template>
<script>
import Swal from "sweetalert2";

export default {
    layout: "admin",
    data() {
        return {
            categories: [],
        };
    },
    methods: {
        async getCategories() {
            let res = await this.$axios.get("/admin/category");
            this.categories = res.data;
        },
        delCategory(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "Bạn có chắc chắn xóa k?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Có",
                cancelButtonText: "Không",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$axios
                        .delete(`/admin/category/${id}`)
                        .then((res) => {
                            this.getCategories();
                        })
                        .then((res) => {
                            Swal.fire("Deleted!", "Xóa thành công.", "success");
                        });
                }
            });
        },
        create() {
            Swal.fire({
                title: "Thêm danh mục",
                input: "text",
                inputLabel: "Tên danh mục",
                inputAttributes: {
                    autocapitalize: "off",
                },
                showCancelButton: true,
                confirmButtonText: "Thêm mới",
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                  console.log(login);
                    var data = new FormData();
                    data.append("name", login);
                    return this.$axios
                        .post("/admin/category", data)
                        .then((res) => {
                            this.getCategories();
                            Swal.fire(
                                "Created!",
                                "Thêm mới thành công.",
                                "success"
                            );
                        })
                        .catch((err) => {
                            Swal.showValidationMessage(
                                `Tên không được để trống`
                            );
                        });
                },
                allowOutsideClick: () => !Swal.isLoading(),
            });
        },
        async update(id) {
            let res = await this.$axios.get(`/admin/category/${id}`)
            Swal.fire({
                title: 'Sửa danh mục',
                html: `<input id="id" type="hidden" class="swal2-input" value="${res.data.id}">`+
                `<input id="name" class="swal2-input" value="${res.data.name}">`,
                focusConfirm: false,
                preConfirm: () => {
                    var id = document.getElementById('id').value
                    var name = document.getElementById('name').value
                    var data = new FormData()
                    data.append('name', name)
                    return this.$axios.post(`/admin/category/${id}`, data).then(res => {
                        this.getCategories();
                        Swal.fire(
                            'Updated!',
                            'Cập nhật thành công.',
                            'success'
                        )
                    }).catch(err => {
                        Swal.showValidationMessage(
                            `Tên không được để trống`
                        )
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            })
        }
    },
    created() {
        this.getCategories();
    },
};
</script>
<style lang="scss">
.content {
    padding: calc(2.2rem - 0.4rem) 2.2rem 0;
    margin-top: 9rem;
}
</style>
