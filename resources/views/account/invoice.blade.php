<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->
<head>
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <!--begin::Global Stylesheets Bundle-->
    <link href="{{ asset_version('/css/style.bundle.css') }}" rel="stylesheet" type="text/css">
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->

<!--begin::Body-->
<body id="kt_body" class="bg-body">
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Orders-->
        <div class="d-flex flex-column gap-7 gap-lg-10">
            <!--begin::Product List-->
            <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Images-->
                    <div class="row py-20">
                        <div class="col-4">
                            <img alt="dots" src="{{ asset_version('/img/dots.png') }}" class="dots h-100px">
                        </div>
                        <div class="col-4 text-center">
                            <img alt="logo" src="{{ asset_version('/img/logo-dark.svg') }}" class="logo h-80px">
                        </div>
                        <div class="col-4"></div>
                    </div>
                    <!--end::Images-->

                    <!--begin::Addresses-->
                    <div class="row py-5">
                        <div class="col-5">
                            <!--end::Text-->
                            <div class="fw-bolder fs-1 text-dark mb-5 text-uppercase">DIVII SAS</div>
                            <!--end::Text-->
                            <!--end::Description-->
                            <div class="fw-bold fs-2 text-dark">
                                907 846 232 RCS PARIS
                                <br>Siège social : 66 Rue de Clichy
                                <br>75009 Paris
                                <br>75009 Paris
                            </div>
                            <!--end::Description-->
                        </div>
                        <div class="col-2">

                        </div>
                        <div class="col-5">
                            <!--end::Text-->
                            <div class="fw-bolder fs-1 text-dark mb-5">{{ $model->user->name }}</div>
                            <!--end::Text-->
                            <!--end::Description-->
                            <div class="fw-bold fs-2 text-dark">
                                {{ $model->user->email }}
                            </div>
                            <!--end::Description-->
                        </div>
                    </div>
                    <!--end::Addresses-->

                    <div class="row mt-10">
                        <div class="col-9 ms-auto">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table fs-6 gy-5 mb-0">
                                    <!--begin::Table head-->
                                    <thead>
                                    <tr class="text-start text-dark fw-bolder fs-1 border-dark border-bottom-5 border-top-5 gs-0">
                                        <th class="min-w-150px text-end">Qté</th>
                                        <th class="min-w-200px">DESCRIPTION</th>
                                        <th class="min-w-150px text-end">Prix</th>
                                    </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fs-2 text-dark min-h-200px h-200px">
                                    <!--begin::Products-->
                                    @foreach($model->items as $item)
                                    <tr>
                                        <!--begin::Quantity-->
                                        <td class="text-end">{{ $item->quantity }}</td>
                                        <!--end::Quantity-->
                                        <!--begin::Description-->
                                        <td>
                                            @if($item->invoiceable)
                                                @switch(true)
                                                    @case($item->invoiceable instanceof \App\Models\Catalog\Formation)
                                                    @case($item->invoiceable instanceof \App\Models\Catalog\Product)
                                                    @case($item->invoiceable instanceof \App\Models\Shop\Consultation)
                                                        <div class="d-flex align-items-center">
                                                            <!--begin::Title-->
                                                            <div class="ms-5">
                                                                <a class="fw-bolder text-dark">{{ $item->invoiceable->name }}</a>
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                    @break
                                                @endswitch
                                            @endif
                                        </td>
                                        <!--end::Description-->
                                        <!--begin::Price-->
                                        <td class="text-end">{{ $item->row_total }} {{ $item->currency }}</td>
                                        <!--end::Price-->
                                    </tr>
                                    <!--end::Products-->
                                    @endforeach
                                    </tbody>
                                    <!--end::Table head-->
                                    <tfoot>
                                    <!--begin::Grand total-->
                                    <tr class="border-dark border-top-5">
                                        <td colspan="2" class="fs-3 fw-boldest text-dark text-end">Montant dû</td>
                                        <td class="text-dark fs-3 text-end">{{ $model->total }} {{ $model->currency }}</td>
                                    </tr>
                                    <!--end::Grand total-->
                                    </tfoot>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Card body-->
                <!--begin::Card footer-->
                <div class="card-footer fs-2 text-dark text-center">
                    IBAN FR76 3000 3032 7000 0201 7056 005
                    <br>BIC : SOGEFRPP
                </div>
                <!--end::Card footer-->
            </div>
            <!--end::Product List-->
        </div>
        <!--end::Orders-->
    </div>
</body>
<!--end::Body-->
</html>
