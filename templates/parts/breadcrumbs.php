<?php
if (! defined('ABSPATH')) { exit; }

if (! isset($items) || ! is_array($items) || empty($items)) {
    return;
}
?>
<nav class="wdl-breadcrumbs" aria-label="Хлебные крошки">
    <?php foreach ($items as $index => $item) : ?>
        <?php if ($index > 0) : ?> / <?php endif; ?>
        <?php if (! empty($item['url'])) : ?>
            <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label'] ?? ''); ?></a>
        <?php else : ?>
            <span><?php echo esc_html($item['label'] ?? ''); ?></span>
        <?php endif; ?>
    <?php endforeach; ?>
</nav>
