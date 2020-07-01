<?php

namespace App\Helpers;

class PaginateHelper
{
    public static function paginateWithParams($data, array $params = [])
    {
        foreach ($params as $title => $value) {
            $data->appends([$title => $value]);
        }

        return $data->links();
    }
}
