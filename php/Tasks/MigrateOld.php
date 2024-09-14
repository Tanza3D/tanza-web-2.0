<?php

namespace Tasks;

use Database\Connection;

class MigrateOld extends Task
{
    public function Run(): void
    {
        Connection::execSimpleOperation("DELETE FROM Portfolio");
        $oldPortfolio = Connection::execSimpleSelect("SELECT * FROM Portfolio_old");
        foreach ($oldPortfolio as $item) {
            $newItem = ["ID" => $item['Id'], "Images" => "", "Name" => $item['Name'], "Content" => "", "Date" => $item['Date'], "Link" => $item['Link'] == "" ? null : $item['Link'], "Ratio" => $item['Ratio'], "CoverWidth" => $item['Width'], "CoverHeight" => $item['Height'], "SimpleRatio" => $item['SimpleRatio'], "Type" => "branding"];

            if ($item['Website'] == 1) $newItem['Type'] = "website";

            $content = $item['Description'] . "";
            $newimages = [];

            $images = json_decode($item['Images'], true);
            foreach ($images as $image) {
                $newimages[] = $image['path'];
            }
            if (count($images) > 1) {
                $content .= "\n\n";
                $i = -1;
                foreach ($images as $image) {
                    $i++;
                    error_log(json_encode($image));
                    if ($i == 0) continue;
                    if ($image['name'] == "" || $image['name'] == "undefined") {
                        error_log($image['name'] . " is invalid");
                        $image['name'] = "Image " . $i;
                    }
                    $content .= "### {$image['name']}\n![{$image['name']}]({IMAGE_$i})\n";
                }
            }
            $newItem['Content'] = $content;
            $newItem['Images'] = json_encode($newimages);

            Connection::execOperation("INSERT INTO `Portfolio` (`ID`, `Images`, `Name`, `Content`, `Date`, `Link`, `Ratio`, `CoverWidth`, `CoverHeight`, `SimpleRatio`, `Type`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);", "issssssiiis", array_values($newItem));
        }
    }
}