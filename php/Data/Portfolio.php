<?php

namespace Data;

use Database\Connection;
use General;
use Image\Transform;

class Portfolio
{
    static function UploadNew($files, $id)
    {
        $files_names = [];

        $folder = $_SERVER['DOCUMENT_ROOT'] . "/img/portfolio/" . $id;

        mkdir($folder);

        $image = imagecreatefromstring(file_get_contents($files[0]["tmp_name"]));

        $medium = Transform::ResizeStr($image, 640, "height", 3);
        $small = Transform::ResizeStr($image, 250, "height", 3);

        $originalHeight = imagesy($image);
        $originalWidth = imagesx($image);

        $gcd = General::gcd($originalWidth, $originalHeight);

        $aspectRatioString = ($originalWidth / $gcd) . ":" . ($originalHeight / $gcd);

        $image_names = [];
        $markdown = "";

        $first = true;
        foreach($files as $key => $value) {
            $extension = pathinfo($value['name'], PATHINFO_EXTENSION);

            $newpath = $key . "." . $extension;
            $image_names[] = $newpath;

            $newpath_full = $folder . "/" . $newpath;

            move_uploaded_file($value['tmp_name'], $newpath_full);

            if(!$first) {
                $markdown .= "### Image $key\n![Image $key]({IMAGE_$key})\n\n";
            }

            $first = false;
        }

        file_put_contents($folder . "/" . "medium.png", $medium);
        file_put_contents($folder . "/" . "small.png", $small);



        Connection::execOperation("INSERT INTO Portfolio (ID, Images, Name, Content, Date, Link, Ratio, CoverWidth, CoverHeight, SimpleRatio, Type) 
        VALUES (?, ?, 'unset', ?, NOW(), NULL, ?, ?, ?, 0, 'branding')", "isssii", [$id, json_encode($image_names), $markdown, $aspectRatioString, $originalWidth, $originalHeight]);

        echo $id;
    }

    public static function Update(array $data, $id)
    {
        $values = array_values($data);
        $values[] = $id;

        Connection::execOperation("UPDATE Portfolio SET Name = ?, Link = ?, Content = ?, Type = ?, Date = ?, Visible = ? WHERE ID = ?",
        "sssssii", $values);

        echo json_encode("OK");
    }
}