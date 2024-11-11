<!-- BEGIN: main -->
<div class="card shadow-sm border-0">
    <div class="card-header  ">
        <h5 class="mb-0">Quản lý sinh viên</h5>
    </div>
    <div class="card-body">
        <form action="{NV_BASE_ADMINURL}index.php" method="get" class="search-form">
            <input type="hidden" name="language" value="{NV_LANG_DATA}">
            <input type="hidden" name="nv" value="qlsv">

            <div class="row mb-3 ">
                <div class="col-md-8">
                    <input type="text" name="keyword" class="form-control" placeholder="Nhập tên để tìm kiếm..."
                        value="{KEYWORD}">
                </div>
                <div class="col-md-4">
                    <select name="id_class" class="form-control" onchange="this.form.submit();">
                        <option value="0">-- Chọn Lớp --</option>
                        <!-- BEGIN: class -->
                        <option value="{CLASS.id}" {CLASS.selected}>{CLASS.name}</option>
                        <!-- END: class -->
                    </select>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success"><i class="fa fa-search me-1"></i>Tìm kiếm</button>
                </div>
            </div>


        </form>

        <div class="table-responsive mt-4">
            <table class="table table-striped table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="text-nowrap">STT</th>
                        <th class="text-nowrap">Tên</th>
                        <th class="text-nowrap">Lớp</th>
                        <th class="text-nowrap">Ngày sinh</th>
                        <th class="text-nowrap">Địa chỉ</th>
                        <th class="text-nowrap">Email</th>
                        <th class="text-nowrap">Hình ảnh</th>
                        <th class="text-nowrap">Tuỳ chọn</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- BEGIN: loop -->
                    <tr class="text-center">
                        <td class="text-nowrap">{DATA.stt}</td>
                        <td class="text-nowrap">{DATA.name}</td>
                        <td class="text-nowrap">{DATA.class_name}</td>
                        <td class="text-nowrap">{DATA.birth}</td>
                        <td class="text-nowrap">{DATA.address}</td>
                        <td class="text-nowrap">{DATA.email}</td>
                        <td class="text-nowrap">
                            <img src="{DATA.image}" alt="{DATA.image}" class="rounded-circle img-thumbnail"
                                style="width: 50px; height: 50px;">
                        </td>
                        <td class="text-nowrap">
                            <a href="{DATA.url_edit}" class="btn btn-warning"><i
                                    class="fa fa-pencil-alt"></i> Sửa</a>
                            <a href="{DATA.url_delete}" class="btn btn-danger"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này không?');"><i
                                    class="fa fa-trash"></i> Xóa</a>
                        </td>
                    </tr>
                    <!-- END: loop -->
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{PREV_PAGE_URL}" class="btn btn-outline-secondary btn-sm"
                {if CURRENT_PAGE == 1}style="display:none;" {/if}><i class="fa fa-angle-left"></i> Trang trước</a>
            <span>Trang {CURRENT_PAGE} / {TOTAL_PAGES}</span>
            <a href="{NEXT_PAGE_URL}" class="btn btn-outline-secondary btn-sm"
                {if CURRENT_PAGE == TOTAL_PAGES}style="display:none;" {/if}>Trang sau <i
                    class="fa fa-angle-right"></i></a>
        </div>
    </div>
</div>
<!-- END: main -->