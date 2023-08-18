<?php

namespace App\Helper;

use App\Models\Category;
use App\Models\Metadata;
use DateTime;
use DateTimeImmutable;

class Facture {

    public static function price($booking, $rate = null)
    {
        // if($rate === null)
        // {
        //     return null;
        // }
        $price = 0;

        $cbm = Metadata::where('key', 'cbm_min')->get()->first();

        $categories = Category::all();

        $dataColis = [];
        foreach($booking->colis as $colis)
        {
            foreach($categories as $category)
            {
                if($colis->category_id === $category->id)
                {
                    $dataColis[$category->id][] = $colis;
                }
            }
        }

        $totalDimensions = [];
        foreach($dataColis as $k => $data)
        {
            $volume = 0;
            foreach($data as $colis)
            {
                $volume += $colis->volume();
            }
            $totalDimensions[$k] = $volume;
        }

        $categoriesPrice = [];
        foreach($categories as $category)
        {
            $categoriesPrice[$category->id] = (float)$category->price;
        }

        foreach($totalDimensions as $k => $dim)
        {
            $price += $dim * $categoriesPrice[$k];
        }
       
        $price_ariary = $price * (float)$rate;
        if($price_ariary < (float)$cbm->value)
        {
            $price_ariary = (float)$cbm->value;
        }

        /**
         * Frais storage
         */
        $storagePrice = 0; // total frais à payer
        $foc = new DateTime($booking->manifest->foc);
        if(date('Y-m-d') > $foc->format('Y-m-d'))
        {
            $originalTime = new DateTimeImmutable(date('Y-m-d'));
            $targedTime = new DateTimeImmutable($foc->format('Y-m-d'));
            $interval = $originalTime->diff($targedTime, true);
            
            $days = (int)$interval->format("%a"); // Nombre de jour de stockage
            $storagePrice = ((int)($booking->volume() * $days * 9000 / 1000)) * 1000;

            if($storagePrice < 10000)
            {
                $storagePrice = 10000;
            }
        }
        // die() ;
        return (object) [
            "storage_price" => $storagePrice ,
            "foreign" => round($price, 2),
            "ariary" => round($price_ariary, 2)
        ];
    }

    public static function structuredColisList($booking, $categories, $cbmConfig): array
    {
        $categorized = [];
        $data = [];
        $mappedCategories = $categories->pluck('name', 'id');
        $unitPriceCategories = $categories->pluck('price', 'id');

        $cbm = 0;
        $cartons = 0;

        foreach($booking->colis as $colis)
        {
            $categorized[$colis->description][] = $colis;
        }
        
        foreach($categorized as $category_id => $colisList)
        {
           
            foreach ($colisList as $colis)
            {
                $cartons += $colis->number();
                $cbm = $colis->volume();
            }
            
            $unitPrice = $unitPriceCategories[$category_id];
            // if($cbm < (float)$cbmConfig->value)
            // {
            //     $cbm = (float)$cbmConfig->value;
            // }
            
            $data[] = (object) [
                "cartons" => $cartons,
                "description" => $mappedCategories[$category_id],
                "unitPrice" => $unitPrice,
                "cbm" => $cbm,
                "totalPrice" => round($cbm * $unitPrice, 2)
            ];
        }
        return $data;
    }

}