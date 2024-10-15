<!-- BEGIN: main -->
<form id="form-class-content" class="form-inline m-bottom confirm-reload" action="" method="post">
    <!-- Thẻ input ẩn để lưu trữ ID lớp học -->
    <input type="hidden" name="id" value="{DATA.id}" />

    <div class="row">
        <div class="col-sm-24 col-md-18">
            <table class="table table-striped table-bordered">
                <col class="w200" />
                <col />
                <tbody>
                    <!-- Hiển thị thông báo thành công -->
                    <tr>
                        <td colspan="2" class="text-success">
                            {SUCCESS_MESSAGE}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tên Lớp</strong>: <sup class="required">(∗)</sup></td>
                        <td>
                            <input type="text" name="name" class="form-control" style="width:100%"
                                value="{DATA.name}" />
                            <div class="text-danger">{ERROR_NAME}</div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="submit" name="submit1" value="Lưu"
                class="btn btn-primary" />
        </div>
    </div>
</form>
<!-- END: main -->