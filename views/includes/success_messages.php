<?php if (!empty($this->success)) : ?>
    <div class="message-box">
        <ul class="success-list">
            <?php foreach ($this->success as $item) : ?>
                <li class="success-item"><?= $item ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>
