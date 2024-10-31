<!-- BEGIN: main -->
<div class="table-responsive">
    <form action="{NV_BASE_ADMINURL}index.php" method="get" class="search-form">
        <input type="hidden" name="language" value="{NV_LANG_DATA}">
        <input type="hidden" name="nv" value="qlsv">
        <input type="text" name="keyword" placeholder="Nhập từ khóa tìm kiếm..." value="{KEYWORD}">
        <button type="submit">Tìm kiếm</button>
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
                <th class="text-nowrap">Tên</th>
                <th class="text-nowrap">Ngày sinh</th>
                <th class="text-nowrap">Hình ảnh</th>
                <th class="text-nowrap">Lớp</th>
                <th class="text-nowrap">Chi tiết</th>
                
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr class="text-center">
                <td class="text-nowrap">{DATA.stt}</td>
                <td class="text-nowrap">{DATA.name}</td>
                <td class="text-nowrap">{DATA.birth}</td>
                <td class="text-nowrap" >{DATA.class_name}</td>
                <td class="text-nowrap"><img src="{DATA.image}" alt="{DATA.name}" style="width: 50px; height: auto;"></td>
                <td class="text-nowrap"><a href="{DATA.url_detail}" class="btn btn-success btn-sm">Xem chi tiết</a></td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>

    <div class="pagination">
    {PAGINATION}
    </div>
</div>
<!-- END: main -->
