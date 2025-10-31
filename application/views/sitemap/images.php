<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    <?php
    function create_image_urls($map, $base_url) {
        foreach ($map as $key => $value) {
            if (is_array($value)) {
                create_image_urls($value, $base_url . $key);
            } else {
                echo "<url>\n";
                echo "<loc>" . $base_url . $value . "</loc>\n";
                echo "<image:image>\n";
                echo "<image:loc>" . $base_url . $value . "</image:loc>\n";
                echo "</image:image>\n";
                echo "</url>\n";
            }
        }
    }
    create_image_urls($map, base_url('uploads/images/'));
    ?>
</urlset>
