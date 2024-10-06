<!-- BEGIN: main -->
<div class="table-responsive">
    <form class="navbar-form" method="post" action="" enctype="multipart/form-data" >
    <input type="hidden" name="id" class="w300 form-control" value="{DATA.id}"/>
        <table>
                <tr>
                    <td><strong>Name</strong><sup class="required">(*)</sup></td>
                    <td><input type="text" name="name" class="w300 form-control" value="{DATA.name}"/></td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td><strong>Birth</strong><sup class="required">(*)</sup></td>
                    <td><input type="text" name="birth"  class="w300 form-control" value="{DATA.birth}"/></td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td><strong>Address</strong><sup class="required">(*)</sup></td>
                    <td><input type="text" name="address" class="w300 form-control" value="{DATA.address}"/></td>
                    <td>&nbsp;</td>
                </tr>
                 <tr>
                    <td><strong>Email</strong><sup class="required">(*)</sup></td>
                    <td><input type="email" name="email" class="w300 form-control" value="{DATA.email}"/></td>
                    <td>&nbsp;</td>
                </tr>
                 <tr>
                    <td><strong>Image</strong><sup class="required">(*)</sup></td>
                    <td><input type="file" name="image" class="w300 form-control" value="{DATA.image}"/></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center"><input name="submit1" type="submit" value="{LANG.save}" class="btn btn-primary w100" /></td>
                </tr>
        </table>
    </form>
</div>
<!-- END: main -->
