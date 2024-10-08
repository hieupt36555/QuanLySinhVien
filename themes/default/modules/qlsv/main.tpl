<!-- BEGIN: main -->
<div class="table-responsive">
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
                <td class="text-nowrap">{DATA.birth}</td>
                <td class="text-nowrap">{DATA.address}</td>
                <td class="text-nowrap">{DATA.email}</td>
                <td class="text-nowrap"><img src="{DATA.image}" alt="{DATA.image}" style="width: 100px; height: auto;"></td>
                <td class="text-nowrap"><a href="{DATA.url_detail}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Chi Tiết</a></td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>

    
</div>
<!-- END: main -->
