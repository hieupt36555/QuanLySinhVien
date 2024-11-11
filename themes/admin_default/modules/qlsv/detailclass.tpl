<!-- BEGIN: main -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Chi tiết lớp: {CLASS_INFO.name}</h2>
        <a href="index.php?language=vi&nv=qlsv&op=add_student&id_class={CLASS_INFO.id}" class="btn btn-success">Thêm Sinh Viên</a>
    </div>

    <h3 class="mb-3">Danh sách sinh viên</h3>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th class="text-nowrap">STT</th>
                    <th class="text-nowrap">Tên</th>
                    <th class="text-nowrap">Ngày sinh</th>
                    <th class="text-nowrap">Địa chỉ</th>
                    <th class="text-nowrap">Email</th>
                    <th class="text-nowrap">Hình ảnh</th>
                    <th class="text-nowrap">Tuỳ chọn</th>
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN: students -->
                <!-- BEGIN: student_loop -->
                <tr class="text-center">
                    <td class="text-nowrap">{STUDENT.stt}</td>
                    <td class="text-nowrap">{STUDENT.name}</td>
                    <td class="text-nowrap">{STUDENT.birth}</td>
                    <td class="text-nowrap">{STUDENT.address}</td>
                    <td class="text-nowrap">{STUDENT.email}</td>
                    <td class="text-nowrap">
                        <img src="{STUDENT.image}" alt="{STUDENT.name}" class="rounded-circle img-thumbnail"
                            style="width: 50px; height: 50px;">
                    </td>
                    <td class="text-nowrap">
                        <a href="{STUDENT.url_detail}" class="btn btn-sm btn-outline-danger">Chi Tiết</a>
                    </td>
                </tr>
                <!-- END: student_loop -->

                <!-- BEGIN: no_students -->
                <tr>
                    <td colspan="7" class="text-center">{NO_STUDENTS}</td>
                </tr>
                <!-- END: no_students -->
                <!-- END: students -->
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center mt-4">
        {PAGINATION}
    </div>
<!-- END: main -->
