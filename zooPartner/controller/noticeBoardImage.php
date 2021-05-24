<?php
include '../lib/model.php';
$m = new model();
$base_url=$m->base_url();

$result = '';
        $image = empty($_FILES['image']) ? '' : $_FILES['image'];

        if (!empty($image))
        {
            if ($image['size'] > 0)
            {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $md5         = md5_file($image['tmp_name']);
            echo $base_url.'img/circuler/'. $md5.'.'.$ext;
                $destination = "../../img/circuler/" . $md5.'.'.$ext;
                $upload = move_uploaded_file($image['tmp_name'], $destination);
                if (!empty($upload))
                {
                    // here is the url to locate your image, you need to change it.
                    $result = $base_url;
                }
            }
        }
?>