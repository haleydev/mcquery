<?php  
    header("Content-type: text/xml");
    echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?=ROOT?></loc>        
        <lastmod>2022-04-09</lastmod>
        <priority>1.0</priority>
    </url>

    <?php            
        // foreach($this->query->result as $sitemap){
        // echo
        // "<url>
        //     <loc>".ROOT."/post?p=".$sitemap['titulo']."</loc>        
        //     <lastmod>".$sitemap['data']."</lastmod>
        //     <priority>1.0</priority>
        // </url>";
        // }          
    ?>
</urlset>