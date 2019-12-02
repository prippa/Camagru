<?php if (!empty($this->errors)) : ?>
    <div class="message-box">
        <ul class="error-list">
            <?php foreach ($this->errors as $item) : ?>
                <li class="error-item"><?= $item ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>
