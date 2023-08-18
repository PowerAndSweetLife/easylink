<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Facture</title>
    @include('admin.components.for-pdf.utility-bootstrap')
    @include('admin.components.for-pdf.style')
</head>
<body>
    <div class="wrapper">
        @for ($nbjbdjgd = 1; $nbjbdjgd <= 2 ; $nbjbdjgd++)
            
        <div class="layout w-50">
            <div class="main">
                <div>
                    {{-- @include('admin.components.for-pdf.logo') --}}
                    <div class="logo"></div>
                    <div class="d-inline-block lh-12" style="float: right;">
                        {{-- <p class="m-0 text-right"><span>Reference {{ $item->facture->reference() }}</span></p> --}}
                        <p class="m-0 text-right text-muted fs-8"><span>Booking</span></p>
                        <p class="m-0 text-right"><span>{{ $item->facture->booking->reference }}</span></p>
                    </div>
                </div>
                <hr>
                <div class="lh-16 mt-5">
                    <p class="text-center fs-22">{{ strtoupper($item->facture->booking->agent->localization->region) }}</p>
                    <p class="text-center fs-12">{{ strtoupper($item->facture->booking->agent->localization->country) }}</p>
                </div>

                <div class="my-5"></div>
                <div>
                    <p>
                        <strong class="d-inline-block w-20">Bill of costs no.</strong>                    
                        <strong class="d-inline-block">
                            {{  sprintf("%s%s%s/%s-%s",
                                    $item->facture->booking->agent->username,
                                    date('y'), 
                                    str_replace("M","", $item->facture->booking->manifest->reference),
                                    $clientCount,
                                    $item->facture->booking->client->id
                                ) 
                            }}
                        </strong>
                    </p>
                    <p>
                        <strong class="d-inline-block w-20">Date</strong>                    
                        <span class="d-inline-block text-muted">{{ date('d/m/Y') }}</span>
                    </p>
                </div>

                <div class="my-3"></div>
                <div>
                    <p>
                        <strong class="d-inline-block w-20">CLIENT</strong>                    
                        <span class="d-inline-block">
                            {{ $item->facture->booking->client->shortName() }}
                        </span>
                    </p>
                    <p>
                        <strong class="d-inline-block w-20">S/M</strong>                    
                        <span class="d-inline-block">{{ $item->facture->booking->client->uid }}</span>
                    </p>
                    <p>
                        <strong class="d-inline-block w-20">POL POD</strong>                    
                        <span class="d-inline-block">CHINA TO MADAGASCAR</span>
                    </p>
                </div>

                <div class="my-2"></div>
                <div>
                    <p>
                        <strong class="d-inline-block w-20">Paiement date</strong>                    
                        <span class="d-inline-block text-muted">{{ shortDate($item->date_paiement) }}</span>
                    </p>
                </div>

                <div class="mt-5">
                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                            <tr>
                                <th class="w-15">TOTAL CARTON</th>
                                <th>DESCRIPTION</th>
                                <th class="w-10">CBM</th>
                                <th class="w-15">UNIT PRICE {{ $item->unit }}</th>
                                <th class="w-20">TOTAL PRICE {{ $item->unit }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (App\Helper\Facture::structuredColisList($item->facture->booking, $categories, $cbmConfig) as $colis)
                            {{-- @foreach ([] as $item) --}}
                                
                            <tr>
                                <td>{{ $colis->cartons }}</td>
                                <td>
                                    {{ $colis->description }}
                                </td>
                                <td>{{ $colis->cbm }}</td>
                                <td>{{ price($colis->unitPrice) }}</td>
                                <td>{{ price($colis->totalPrice) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="table-footer">
                        <div class="d-inline-block">
                            <p class="ml-3" style="margin-top: 5px">Total amount {{ $item->facture->booking->manifest->unit }} </p>
                        </div>
                        <div class="d-inline-block">
                            <p class="mr-3 text-right" style="margin-top: 5px">{{ price($item->facture->amount) }}</p>
                        </div>
                    </div>
                    <div class="table-footer">
                        <div class="d-inline-block">
                            <p class="ml-3" style="margin-top: 5px">Exchange rate MGA/{{ $item->facture->booking->manifest->unit }}  </p>
                        </div>
                        <div class="d-inline-block">
                            <p class="mr-3 text-right" style="margin-top: 5px">{{ price($item->facture->booking->manifest->bmoi_rate) }}</p>
                        </div>
                    </div>
                    <div class="table-footer">
                        <div class="d-inline-block">
                            <p class="ml-3" style="margin-top: 5px">Storage fee  </p>
                        </div>
                        <div class="d-inline-block">
                            <p class="mr-3 text-right" style="margin-top: 5px">{{ price($item->facture->storage_fee) }}</p>
                        </div>
                    </div>
                    <div class="table-footer">
                        <div class="d-inline-block">
                            <p class="ml-3" style="margin-top: 5px">Amount to paid MGA  </p>
                        </div>
                        <div class="d-inline-block">
                            <p class="mr-3 text-right" style="margin-top: 5px">{{ price($item->to_paid) }}</p>
                        </div>
                    </div>
                    <div class="table-footer">
                        <div class="d-inline-block">
                            <p class="ml-3" style="margin-top: 5px">Paid</p>
                        </div>
                        <div class="d-inline-block">
                            <p class="mr-3 text-right" style="margin-top: 5px">{{ price($item->paid ?? 0) }}</p>
                        </div>
                    </div>
                    <div class="table-footer">
                        <div class="d-inline-block">
                            <p class="ml-3" style="margin-top: 5px">Remains to be paid</p>
                        </div>
                        <div class="d-inline-block">
                            <p class="mr-3 text-right" style="margin-top: 5px">{{ price($item->rest ?? 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mt-0">
            <div class="footer">
                <p class="lh-10">
                    <strong>N.B : </strong>
                    <i class="text-muted">Toute réclamation doit être faite au moment de l'enlèvement ou livraison des colis, autrement nous déclinons toute responsabilité
                    en cas d'avarie et/ou perte.</i>
                </p>
                <p class="lh-10 mt-2">
                    <strong>N.B : </strong>
                    <i class="text-muted">Any complaint must be made at the time of the removal or the delivery of the parcel, otherwise we disclaim all liability in case of
                        damage and/or loss.
                    </i>
                </p>
            </div>
        </div>
        
        @endfor
    </div>
</body>
</html>