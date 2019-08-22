<?php if (isset($data['messages']['success'])): ?>
    <div class="message-box">
        <ul class="success-list">
            <?php foreach ($data['messages']['success'] as $item): ?>
                <li class="success-item"><?= $item ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>