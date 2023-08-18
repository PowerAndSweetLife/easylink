<?php

namespace App\Helper;

class Dimension {

    public static function encode(array $dimensions): string
    {
        $encoded = [];
        foreach($dimensions as $dimension)
        {
            $count = (int)$dimension[0];
            $len = (float)$dimension[1];
            $wid = (float)$dimension[2];
            $hei = (float)$dimension[3];
            $wei = (float)$dimension[4];

            if($count <= 0)
            {
                $count = null;
            }

            $hasCBM = true;
            if($len <= 0 || $wid <= 0 && $hei <= 0)
            {
                $len = null;
                $wid = null;
                $hei = null;
                $hasCBM = false;
            }
            else
            {
                if($count === null)
                {
                    $count = 1;
                }
            }

            if($wei <= 0) {
                $wei = null;
            }

            if($hasCBM || ($count !== null) || ($wei !== null))
            {
                $encoded[] = [
                    "count" => $count,
                    "length" => $len,
                    "width" => $wid,
                    "height" => $hei,
                    "weight" => $wei
                ];
            }
        }
        return json_encode($encoded);
    }

    public static function volumeStr(object $dim): ?string
    {
        $cbm = (int)$dim->count * (float)$dim->width * (float)$dim->height * (float)$dim->length;
        if($cbm <= 0)
        {
            return null;
        }
        return round( $cbm * pow(10, -6) , 2) . " m³";
    }

    public static function volumesStr(array $dimensions): ?string
    {
        $cbm = 0;
        foreach($dimensions as $dim)
        {
            $cbm += (int)$dim->count * (float)$dim->width * (float)$dim->height * (float)$dim->length;
        }
        if($cbm <= 0)
        {
            return null;
        }
        return round( $cbm * pow(10, -6) , 2) . " m³";
    }

    public static function hasVolume(array $dimensions): bool
    {
        $cbm = 0;
        foreach($dimensions as $dim)
        {
            $cbm += (int)$dim->count * (float)$dim->width * (float)$dim->height * (float)$dim->length;
        }
        if($cbm > 0)
        {
            return true;
        }
        return false;
    }

    public static function weightStr(float $weight): ?string
    {
        if($weight <= 0)
        {
            return null;
        }
        if($weight < 1000)
        {
            return $weight . " Kg";
        }
        return ($weight / 1000) . " T";
    }
}