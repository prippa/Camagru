<div class="container">

    <div class="row">
        <div class="col-lg-9">
            <main>
                <?php require 'views/includes/success_message.php' ?>

                <form action="/make_photo" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="user_file">Pick a photo from your device</label>
                        <input name="file[]" type="file" class="form-control-file"
                               id="user_file" accept="image/*" tabindex="1" required multiple>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" tabindex="2">Make</button>
                </form>
            </main>
        </div>
        <div class="col-lg-3">
            <aside>
                <div class="row">
                    <div class="col-12 pb-3">
                        <img class="img-fluid" src="/uploads/5d5e9aa02ac92.png" alt="">
                    </div>
                    <div class="col-12 pb-3">
                        <img class="img-fluid" src="/uploads/5d5edd19a1f8a.jpg" alt="">
                    </div>
                    <div class="col-12 pb-3">
                        <img class="img-fluid" src="/uploads/5d5ffd8d17a2d.png" alt="">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block" tabindex="3">Upload</button>
                    </div>
                </div>
            </aside>
        </div>
    </div>

</div>