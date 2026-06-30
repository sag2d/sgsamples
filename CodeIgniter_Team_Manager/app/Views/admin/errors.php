<?php if (! empty($errors)): ?>
    <span class="error">
        <?php foreach ($errors as $error): ?>
            <?= esc($error) ?><br>
        <?php endforeach; ?>
    </span>
<?php endif; ?>
