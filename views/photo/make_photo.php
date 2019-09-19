<div class="container">

    <div class="row">
        <div class="col">
            <?php require 'views/includes/success_message.php' ?>

            <form action="/make_photo" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="user_file">Pick a photo from your device</label>
                    <input name="file[]" type="file" class="form-control-file"
                           id="user_file" accept="image/*" tabindex="1" required multiple>
                </div>
                <button type="submit" class="btn btn-primary btn-block" tabindex="2">Upload</button>
            </form>
        </div>
    </div>

</div>