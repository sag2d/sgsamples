<?php if (! empty($errors)): ?>
    <div class="error error-list">
        <?php foreach ($errors as $error): ?>
            <div class="error-item"><?= esc($error) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
