@extends('base')

@section('content')
<h2 class="fs-18 py-2 text-primary">{{ __('China shipping address for sea freight') }}</h2>
<div class="main-content">

    {{-- <p class="m-0">{{ __("You're welcome") }}</p> --}}
    <p class="m-0">{{ __("Please observe the following instructions when delivering your parcels to our warehouse in China") }}</p>
    <ol>
        <li>{{ __('Your shipping mark') }} : <strong>{{ user('uid') }}</strong> {{ __('must be indicated on each parcel') }}</li>
        <li>{{ __('Your telephone number to be mentioned on the slip') }}</li>
        <li>{{ __('Here are the delivery addresses') }}</li>
    </ol>

    
    <div class="accordion" id="accordionExample">
        @foreach ($agents as $k => $agent)
        <div class="accordion-item">
            <div class="accordion-header">
                <div class="accordion-button py-3 expedition-accordion-header {{ $k > 0 ? 'collapsed' : null }}" role="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $k + 1 }}" aria-expanded="true" aria-controls="collapseOne">
                    <div class="d-flex justify-content-between pe-4 w-100">
                        <div class="d-flex align-items-center" style="line-height: 14px">
                            <span class="label fs-12">{{ __("Localization") }} :</span>
                            <span class="fw-400 ms-2">{{ $agent->localization->region }}</span>
                        </div>
                        <div class="d-flex align-items-center" style="line-height: 14px">
                            <span class="label fs-12">{{ __("Agent name") }} :</span>
                            <span class="fw-400 ms-2">{{ $agent->fullname() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="collapse-{{ $k + 1 }}" class="accordion-collapse collapse {{ $k === 0 ? 'show' : null }}" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-light">
                    <h6 class="text-danger">{{ __('Small parcel') }} ( < 1 m³)</h6>
                    <p class="m-0 fw-500">{{ __('Delivery address') }} :</p>
                    <table class="table-text-left">
                        <tr>
                            <td class="w-25">地址 :</td>
                            <td>{{ $agent->address('small') }}{{ user('uid') }}{{ $agent->contact }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">联系人 :</td>
                            <td>{{ user('uid') }}{{ strtoupper($agent->contact) }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">联系电话 :</td>
                            <td>{{ $agent->phone }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">备注 :</td>
                            <td>以上地址栏文字不可删除，不然没有唛头仓库拒收！</td>
                        </tr>
                    </table>
                    <p class="m-0 fw-500">{{ __('Please send the following message to the sender / supplier') }} :</p>
                    <p class="m-0">
                        备注：以上地址栏文字不可删除，不然没有唛头仓库拒收！<br>
                        入仓号和唛头: {{ user('uid') }} (此入仓唛头需要在每一箱上贴唛，没有唛头的货仓库拒收退回，如是快递货，地址栏务必备注此唛头，有任何问题请联系仓库人员）
                    </p>

                    <h6 class="text-danger mt-5">{{ __('Regular parcel') }}</h6>
                    <p class="m-0 fw-500">{{ __('Delivery address') }} :</p>
                    <table class="table-text-left">
                        <tr>
                            <td class="w-25">海运仓库地址 :</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="w-25">地址 :</td>
                            <td>{{ $agent->address('regular') }}{{ user('uid') }}</td>
                        </tr>
                        <tr>
                            <td class="w-25">邮编 :</td>
                            <td>510000</td>
                        </tr>
                        <tr>
                            <td class="w-25">联系电话 :</td>
                            <td>李小姐 13728694671</td>
                        </tr>
                    </table>
                    <p class="m-0 fw-500">{{ __('Please send the following message to the sender / supplier') }} :</p>
                    <p class="m-0">
                        备注：以上地址栏文字不可删除，不然没有唛头仓库拒收！<br>
                        入仓号和唛头: {{ user('uid') }} (此入仓唛头需要在每一箱上贴唛，没有唛头的货仓库拒收退回，如是快递货，地址栏务必备注此唛头，有任何问题请联系仓库人员）
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    </div>
    
@endsection