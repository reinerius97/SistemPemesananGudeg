<div class="flex gap-2 justify-center">
    <?php if ($pager && $pager->getPageCount() > 1): ?>
        <?= $pager->links() ?>
    <?php else: ?>
        <span class="text-gray-400 text-sm">1 halaman</span>
    <?php endif; ?>
</div>