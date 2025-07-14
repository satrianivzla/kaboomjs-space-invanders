<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach($tags as $tag) { ?>
    <url>
        <loc><?php echo site_url('en/tag/' . $tag['slug']); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc><?php echo site_url('es/tag/' . $tag['slug']); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.5</priority>
    </url>
    <?php } ?>
</urlset>
