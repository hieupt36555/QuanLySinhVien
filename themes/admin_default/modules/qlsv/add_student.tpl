<!-- BEGIN: main -->
<form id="form-news-content" class="form-inline m-bottom confirm-reload" action="" enctype="multipart/form-data"
    method="post">
    <div class="row">
        <div class="col-sm-24 col-md-18">
            <table class="table table-striped table-bordered">
                <col class="w200" />
                <col />
                <tbody>
                    <tr>
                        <td colspan="2" class="text-success">
                            {SUCCESS_MESSAGE}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tên Sinh Viên</strong>: <sup class="required">(∗)</sup></td>
                        <td>
                            <input type="text" name="name" class="form-control" style="width:100%"
                                value="{DATA.name}" />
                            <div class="text-danger">{ERROR_NAME}</div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Ngày Sinh</strong>: <sup class="required">(∗)</sup></td>
                        <td>
                            <input type="date" name="birth" class="form-control" style="width:100%"
                                value="{DATA.birth}" />
                            <div class="text-danger">{ERROR_BIRTH}</div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Địa Chỉ</strong>: <sup class="required">(∗)</sup></td>
                        <td>
                            <input type="text" name="address" class="form-control" style="width:100%"
                                value="{DATA.address}" />
                            <div class="text-danger">{ERROR_ADDRESS}</div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong>: <sup class="required">(∗)</sup></td>
                        <td>
                            <input type="text" name="email" class="form-control" style="width:100%"
                                value="{DATA.email}" />
                            <div class="text-danger">{ERROR_EMAIL}</div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Lớp Học</strong>: <sup class="required">(∗)</sup></td>
                        <td>
                            <select name="id_class" class="form-control">
                                <option value="0">-- Chọn Lớp --</option>
                                <!-- BEGIN: class -->
                                <option value="{CLASS.id}" {CLASS.selected}>{CLASS.name}</option>
                                <!-- END: class -->
                            </select>
                            <div class="text-danger">{ERROR_CLASS}</div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Ảnh Sinh Viên</strong>:</td>
                        <td>
                            <input type="file" name="image" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="submit" name="submit1" value="Lưu" class="btn btn-primary" />
        </div>
    </div>
</form>
<!-- END: main -->