<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<nav class="pagination">
    <?php if ($pager->hasPreviousPage()): ?>
        <a href="<?= $pager->getPreviousPage(); ?>"
           aria-label="<?= lang('Pager.previous'); ?>"
           class="page-btn">
            <i class="fa-solid fa-angles-left"></i>
        </a>
    <?php endif; ?>

    <?php foreach ($pager->links() as $link): ?>
        <a href="<?= $link['uri']; ?>"
           class="page-btn <?= $link['active'] ? 'active' : ''; ?>">
            <?= $link['title']; ?>
        </a>
    <?php endforeach; ?>

    <?php if ($pager->hasNextPage()): ?>
        <a href="<?= $pager->getNextPage(); ?>"
           aria-label="<?= lang('Pager.next'); ?>"
           class="page-btn">
            <i class="fa-solid fa-angles-right"></i>
        </a>
    <?php endif; ?>
</nav>