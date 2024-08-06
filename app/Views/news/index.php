<h2>News List</h2>
<?php if (!empty($news_list) && is_array($news_list)): ?>
    <?php foreach ($news_list as $news_item): ?>
        <h3><?= esc($news_item['title']) ?></h3>
        <div>
            <a href="/news/<?= esc($news_item['slug'], 'url') ?>">View article</a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No news available.</p>
<?php endif; ?>
