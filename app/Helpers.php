<?php

use Carbon\Carbon;

if (!function_exists('parsingAlert')) {
    function parsingAlert($message)
    {
        $string = '';
        if (is_array($message)) {
            foreach ($message as $key => $value) {
                $string .= ucfirst($value) . '<br>';
            }
        } else {
            $string = ucfirst($message);
        }
        return $string;
    }
}


    if (!function_exists('explodeImplode')) {
    function explodeImplode($str, $symbol_explode = '-', $symbol_implode = ' ')
    {
        $explode = explode($symbol_explode, $str);
        $implode = implode($symbol_implode, $explode);

        return $implode;
    }
}


if (!function_exists('cutText')) {
    function cutText(String $string, $limit = 10)
    {
        $retval = $string;
        $string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $string);
        $string = str_replace("\n", " ", $string);
        $array = explode(" ", $string);
        if (count($array) <= $limit) {
            $retval = $string;
        } else {
            array_splice($array, $limit);
            $retval = implode(" ", $array) . " ...";
        }
        return $retval;
    }
}

if (!function_exists('imageExists')) {
    function imageExists($path)
    {

        if (file_exists($path)) {
            $path = asset($path);
        } else {
            $path = 'https://source.unsplash.com/500x400?';
        }

        return $path;
    }
}

if (!function_exists('baseDateFormat')) {
    function baseDateFormat(
        $date,
        $format_date = 'j F Y'
    )
    {
        $result = Carbon::parse($date)->format($format_date);
        return $result;
    }
}

if (!function_exists('toSqlWithBinding')) {
    function toSqlWithBinding($builder, $get = true)
    {
        try {
            $addSlashes = str_replace('?', "'?'", $builder->toSql());
            $query =  vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
            dd($query, $builder->get()->toArray());
        } catch (\Throwable $th) {
            //throw $th;
        }
        $builder_get = collect([]);
        if ($get) {
            $builder_get = $builder->get()->toArray();
        }
        dd($builder->toSql(), $builder->getBindings(), $builder_get);
    }
}

if (!function_exists('globalRoundCustom')) {
    function globalRoundCustom(float $number)
    {
        return round($number, 3);
    }
}

if (!function_exists('globalNumberFormat')) {
    function globalNumberFormat(float $number)
    {
        return number_format(globalRoundCustom($number), 2);
    }
}

if (!function_exists('slugCustom')) {
    function slugCustom($name)
    {
        $slug = preg_replace('~[^\pL\d]+~u', '-', $name);
        $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug); // transliterate
        $slug = preg_replace('~[^-\w]+~', '', $slug); // remove unwanted characters
        $slug = trim($slug, '-'); // trim
        $slug = preg_replace('~-+~', '-', $slug); // remove duplicate -
        $slug = strtolower($slug); // lowercase

        return $slug;
    }
}
