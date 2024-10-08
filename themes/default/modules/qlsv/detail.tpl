<!-- BEGIN: main -->
<div class="container mt-5" style="background-color: #f9f9f9; padding: 20px; border-radius: 8px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);">
    <div class="row">
        <!-- Hình ảnh sinh viên -->
        <div class="col-md-4 text-center">
            <img src="{DATA.image}" alt="Ảnh của {DATA.name}" class="img-fluid rounded-circle shadow" style="width: 200px; height: auto; object-fit: cover; border-radius: 20px; border: 2px solid #ddd; " />
        </div>

        <!-- Thông tin chi tiết sinh viên -->
        <div class="col-md-8" style="margin: 0px 40px ;">
            <h1 class="display-4" style="font-size: 28px; color: #333; margin-bottom: 10px; ">{DATA.name}</h1>
            <ul class="list-unstyled mt-4" style="font-size: 18px; color: #555;">
                <li style="margin-bottom: 10px;"><strong style="color: #333;">Ngày sinh:</strong> {DATA.birth}</li>
                <li style="margin-bottom: 10px;"><strong style="color: #333;">Địa chỉ:</strong> {DATA.address}</li>
                <li style="margin-bottom: 10px;"><strong style="color: #333;">Email:</strong> <a href="mailto:{DATA.email}" style="color: #007bff; text-decoration: none;">{DATA.email}</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- END: main -->
