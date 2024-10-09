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
                        <td><strong>Tên Sinh Viên</strong>: <sup class="required">(∗)</sup></td>
                        <td><input type="text" name="name" class=" form-control" style="width:100%"
                                value="{DATA.name}" /></td>
                    </tr>
                    <tr>
                        <td><strong>Ngày Tháng Năm Sinh</strong>: <sup class="required">(∗)</sup></td>
                        <td><input type="text" name="birth" class=" form-control" style="width:100%"
                                value="{DATA.birth}" /></td>
                    </tr>
                    </tr>
                    <tr>
                        <td><strong>Lớp</strong>: <sup class="required">(∗)</sup></td>
                        <td>
                            <select name="id_class" class="form-control">
                                <option value="0">Chọn lớp</option>
                                <!-- BEGIN: loop -->
                                <option value="{CLASS.id}" {CLASS.selected}>{CLASS.name}</option>
                                <!-- END: loop -->
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Ảnh Cá Nhân</strong>: <sup class="required">(∗)</sup></td>
                        <td><input type="file" name="image" class="w300 form-control" value="{DATA.image}" /></td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong>: <sup class="required">(∗)</sup></td>
                        <td>
                            <input type="email" name="email" class="form-control" style="width:100%"
                                value="{DATA.email}" />
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Địa Chỉ</strong>: <sup class="required">(∗)</sup></td>
                        <td>
                            <input type="text" name="address" class=" form-control" style="width:100%"
                                value="{DATA.address}" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <input name="submit1" type="submit" value="Lưu thông tin" class="btn btn-primary w100" />
</form>
<!-- END: main -->