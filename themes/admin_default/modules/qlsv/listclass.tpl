<!-- BEGIN: main -->
<div class="table-responsive">
    <form action="" method="get" class="search-form d-flex mb-3">
        <input type="hidden" name="language" value="{NV_LANG_DATA}">
        <input type="hidden" name="nv" value="qlsv">

        <input type="text" class="form-control" name="keyword" placeholder="Nhập tên để tìm kiếm..."
            value="{KEYWORD}">

        <button type="submit" class="btn btn-success">Tìm kiếm</button>
    </form>

    <table class="table table-striped table-bordered table-hover">
        <colgroup>
            <col class="w100">
            <col span="1">
            <col span="2" class="">
        </colgroup>
        <thead>
            <tr class="text-center">
                <th class="text-nowrap">STT</th>
                <th class="text-nowrap">Tên Lớp</th>
                <th class="text-nowrap">Option</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr class="text-center">
                <td class="text-nowrap">{DATA.stt}</td>
                <td class="text-nowrap">{DATA.name}</td>
                <td class="text-nowrap">
                    <a href="{DATA.url_edit}" class="btn btn-warning ">
                        <iclass="fa fa-edit"></i> {GLANG.edit}
                    </a>
                    <a class="btn btn-danger" href="{DATA.url_delete}">Xóa</a>
                    <a href="{DATA.url_detail}" class="btn btn-primary ">Chi tiết</a>

                </td>
            </tr>
            <!-- Hiển thị danh sách sinh viên trong lớp -->
            <tr>
                <td colspan="4">
                    <strong>Danh sách sinh viên:</strong>
                    <ul>
                        <!-- BEGIN: student_loop -->
                        <li>
                            <b>{STUDENT.name}</b> - Email: {STUDENT.email} - Birth: {STUDENT.birth}
                        </li>
                        <!-- END: student_loop -->

                        <!-- BEGIN: no_students -->
                        <li>Không có sinh viên trong lớp này.</li>
                        <!-- END: no_students -->
                    </ul>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
</div>

<!-- END: main -->