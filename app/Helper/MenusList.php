<?php

namespace App\Helper;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class MenusList {

    public static function admin(): array
    {
        $currentRoute = Route::getCurrentRoute()->getName();
        return [
            new Menu(__("Settings"), '<i class="fa-solid fa-screwdriver-wrench"></i>', route('admin.setting.index'), 
                str_starts_with( $currentRoute, "admin.setting") || str_starts_with( $currentRoute, "admin.unit") || str_starts_with( $currentRoute, "admin.localization")   
            ),
            new Menu(__("Agents"), 
                        '<i class="fa-solid fa-user-tag"></i>', 
                        route('admin.agent.index'), 
                        str_starts_with( $currentRoute, "admin.agent") || str_starts_with( $currentRoute, "admin.mada-agent")
                    ),
            new Menu(__("Administrators"), 
                        '<i class="fa-solid fa-user-shield"></i>', 
                        route('admin.admin.index'), 
                        str_starts_with( $currentRoute, "admin.admin") 
                    ),
            new Menu(__("Clients list"), 
                        '<i class="fa-solid fa-user-group"></i>', 
                        route('admin.client.index'), 
                        str_starts_with( $currentRoute, "admin.client") 
                    ),
            new Menu(__("List of container"), 
                        '<i class="fa-solid fa-box-open"></i>', 
                        route('admin.container.index'), 
                        str_starts_with( $currentRoute, "admin.container") 
                    ),
            new Menu(__("Facturation"), 
                        '<i class="fa-solid fa-file-invoice-dollar"></i>', 
                        route('admin.facturation.index'), 
                        str_starts_with( $currentRoute, "admin.facturation") 
                    )
        ];
    }

    public static function client(): array
    {
        $currentRoute = Route::getCurrentRoute()->getName();
        return [
            new Menu(__("New shipment"), 
                '<i class="fa-regular fa-share-from-square"></i>', 
                route('client.expedition.create'), 
                $currentRoute === "client.expedition.create"
            ),
            new Menu(__("My shipments"), 
                '<i class="fa-solid fa-list-check"></i>', 
                route('client.expedition.index'), 
                $currentRoute === "client.expedition.index" 
            ),
            new Menu(__("Invoice"), 
                '<i class="fa-solid fa-file-invoice-dollar"></i>', 
                route('client.facture.index'), 
                Str::startsWith($currentRoute, 'client.facture')
            ),
            new Menu(__("Loyalty card"), 
                '<i class="fa-regular fa-address-card"></i>', 
                route('client.fidelityCard'), 
                Str::startsWith($currentRoute, 'client.fidelityCard')
            ),
            // new Menu(__("Search"), 
            //     '<i class="fa-solid fa-magnifying-glass"></i>', 
            //     route('client.search.index'),
            //     Str::startsWith($currentRoute, 'client.search.index')
            // ),
        ];
    }

    public static function agent(): array
    {
        $currentRoute = Route::getCurrentRoute()->getName();
        return [
            new Menu(__("Receive package"), 
                '<i class="fa-regular fa-thumbs-up"></i>', 
                route('agent.colis.list', ['status' => 'not-received']), 
                str_starts_with( $currentRoute, "agent.colis")
            ),
            new Menu(__("Booking"), 
                        '<i class="fa-solid fa-book"></i>', 
                        route('agent.booking.index'), 
                        str_starts_with( $currentRoute, "agent.booking")
                    ),
            new Menu(__("Manifest"), 
                        '<i class="fa-solid fa-clipboard-list"></i>', 
                        route('agent.manifest.index'), 
                        str_starts_with( $currentRoute, "agent.manifest")
                    ),
            new Menu(__("Container"), 
                        '<i class="fa-solid fa-box-open"></i>', 
                        route('agent.container.create'), 
                        str_starts_with( $currentRoute, "agent.container")
                    ),
        ];
    }

    public static function madaAgent(): array
    {
        $currentRoute = Route::getCurrentRoute()->getName();
        return [
            new Menu(__("List of container"), 
                        '<i class="fa-solid fa-box-open"></i>', 
                        route('mada-agent.container'), 
                        str_starts_with( $currentRoute, "mada-agent.container") 
                    ),
            new Menu(__("Facturation"), 
                        '<i class="fa-solid fa-file-invoice-dollar"></i>', 
                        route('mada-agent.facturation.index'), 
                        str_starts_with( $currentRoute, "mada-agent.facturation") 
                    ),          
            new Menu(__("Package delivery"), 
                '<i class="fa-solid fa-truck-ramp-box"></i>', 
                route('mada-agent.livraison.index'), 
                str_starts_with( $currentRoute, "mada-agent.livraison") 
            ),
        ];
    }

}