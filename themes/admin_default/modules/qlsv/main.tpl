<!-- BEGIN: main -->
<div class="table-responsive">
    <form action="{NV_BASE_ADMINURL}index.php" method="get" class="search-form">
        <input type="hidden" name="language" value="{NV_LANG_DATA}">
        <input type="hidden" name="nv" value="qlsv">
        <input type="text" name="keyword" placeholder="Nhập tên để tìm kiếm..." value="{KEYWORD}">
        <button type="submit">Tìm kiếm</button>
        <select name="id_class" class="form-control" onchange="this.form.submit();">
            <option value="0">-- Chọn Lớp --</option>
            <!-- BEGIN: class -->
            <option value="{CLASS.id}" {CLASS.selected}>{CLASS.name}</option>
            <!-- END: class -->
        </select>
    </form>



    <table class="table table-striped table-bordered table-hover">
        <colgroup>
            <col class="w100">
            <col span="1">
            <col span="2" class="w150">
        </colgroup>
        <thead>
            <tr class="text-center">
                <th class="text-nowrap">STT</th>
                <th class="text-nowrap">Name</th>
                <th class="text-nowrap">Class</th>
                <th class="text-nowrap">Birth</th>
                <th class="text-nowrap">Address</th>
                <th class="text-nowrap">Email</th>
                <th class="text-nowrap">Image</th>
                <th class="text-nowrap">Option</th>
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
                <td class="text-nowrap"><img src="{DATA.image}" alt="{DATA.image}" style="width: 50px; height: auto;">
                </td>
                <td class="text-nowrap">
                    <a href="{DATA.url_edit}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i> {GLANG.edit}</a>
                    <a class="btn btn-danger" href="{DATA.url_delete}"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này không?');">Xóa</a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
    <div class="pagination">
        <a href="{PREV_PAGE_URL}" class="prev" {if CURRENT_PAGE == 1}style="display:none;" {/if}>Trang trước</a>

        <span>Trang {CURRENT_PAGE} / {TOTAL_PAGES}</span>

        <a href="{NEXT_PAGE_URL}" class="next" {if CURRENT_PAGE == TOTAL_PAGES}style="display:none;" {/if}>Trang sau</a>
    </div>
</div>

<!-- END: main -->