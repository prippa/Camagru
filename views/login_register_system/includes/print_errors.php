<?php if ($data['errors']): ?>
    <div class="error-box">
        <ul class="error-list">
            <?php foreach ($data['errors'] as $item): ?>
                <li class="error-item"><?= $item ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>