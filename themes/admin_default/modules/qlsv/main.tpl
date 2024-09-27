<!-- BEGIN: main -->
<div class="table-responsive">
<form action="{NV_BASE_ADMINURL}index.php" method="get" class="search-form">
  <input type="hidden" name="language" value="{NV_LANG_DATA}">
  <input type="hidden" name="nv" value="qlsv">
<input type="text" name="keyword" placeholder="Nhập tên để tìm kiếm..." value="{KEYWORD}">
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
                <th class="text-nowrap">id</th>
                <th class="text-nowrap">name</th>
                <th class="text-nowrap">birth</th>
                <th class="text-nowrap">address</th>
                <th class="text-nowrap">option</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
             <tr class="text-center">
                <td class="text-nowrap">{DATA.id}</td>
                <td class="text-nowrap">{DATA.name}</td>
                <td class="text-nowrap">{DATA.birth}</td>
                <td class="text-nowrap">{DATA.address}</td>
                <td class="text-nowrap"><a href="{DATA.url_edit}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i> {GLANG.edit}</a>
                
                <a class="btn btn-danger" href="{DATA.url_delete}">Xóa</a></td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
<div class="pagination">
  <a href="{PREV_PAGE_URL}" class="prev" {if CURRENT_PAGE == 1}style="display:none;"{/if}>Trang trước</a>

  <span>Trang {CURRENT_PAGE} / {TOTAL_PAGES}</span>

  <a href="{NEXT_PAGE_URL}" class="next" {if CURRENT_PAGE == TOTAL_PAGES}style="display:none;"{/if}>Trang sau</a>
</div>
</div>
<!-- END: main -->
