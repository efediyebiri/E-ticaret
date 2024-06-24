@extends('backend.layout.app')
@section('customcss')
<style>
    body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #fafafa;
        font-family: system-ui;
    }

    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .page {
        width: 210mm;
        min-height: 297mm;
        padding: 20mm;
        margin: 10mm auto;
        border: 1px #d3d3d3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    @page {
        size: A4;
        margin: 0;
    }

    @media print {
        html,
        body {
            width: 210mm;
            height: 297mm;
        }

        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }

    .center {
        text-align: center;
    }

    h2 {
        font-size: 36px;
        font-weight: 500;
    }

    .header-img {
        width: 100px;
        height: 100px;
    }

    .invoice {
        display: flex;
        justify-content: space-between;
    }

    .invoice-header {
        font-size: 24px;
    }

    .font-size-14 {
        font-size: 14px;
        line-height: 4px;
    }

    .bold-text {
        font-weight: 800;
    }

    table.unstyledTable {
        width: 100%;
    }

    table {
        border-collapse: collapse;
        border-spacing: 0 5px;
        table-layout: fixed;
    }

    thead tr th {
        border-bottom: 2px solid #DCDCDC;
        font-weight: 800;
    }

    tbody tr {
        border-bottom: 1px solid #DCDCDC;
        text-align: end;
    }

    tbody tr td {
        padding: 8px;
    }

    .last-row{
        border: 0;
    }

    .footer {
        text-align: end;
    }

    .font-weight-400{
        font-weight: 400;
    }

</style>
@endsection
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Sipariş</h4>
                @if ($errors)
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$errors}}
                </div>
                @endforeach
                @endif
                @if (session()->get('success'))
                <div class="alert alert-success">
                    {{session()->get('success')}}
                </div>
                @endif
            </div>



            <div class="page">
                <div class="col-md-12">
                    <div class="row" style="align-items: center;">
                        <div class="col-md-6 bold-text"><h2>FATURA<h2></div>
                            <div class="col-md-6" style="text-align:right;"><img class="header-img" src="images1.png" /></div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="font-size-14 text-align:left;">
                                    <h2 class="font-weight-400" >{{$invoice->name ?? ''}}</h2>
                                    <p>{{$invoice->email}}</p>
                                    <p>{{$invoice->order_no ?? ''}}</p>
                                    <p>{{$invoice->address}}</p>
                                    <p>{{$invoice->phone}}</p>
                                </div>
                            </div>
                            <div class="font-size-14 col-md-6" style="text-align:right;">
                                <p class="bold-text">Sipariş Tarihi: {{isset($invoice->created_at) ? ($invoice->created_at)->format('d.m.Y H:i') : ''}}</p>
                                <p>Güncelleme Saati: {{isset($invoice->updated_at) ? ($invoice->updated_at)->format('d.m.Y H:i') : ''}}</p>
                                <p class="Text">Sipariş No: {{$invoice->order_no ?? ''}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="content">
                        <div>
                            <h2 class="center font-weight-400">Fatura Bilgileri</h2>
                            <br>
                            <p class="font-size-14"><b>Şirket Adı:</b> {{$invoice->company_name}}</p>
                            <hr>
                            <p class="font-size-14"><b>Ülke:</b> {{$invoice->country}}</p>
                            <hr>
                            <p class="font-size-14"><b>İl:</b> {{$invoice->city}}</p>
                            <hr>
                            <p class="font-size-14"><b>İlçe:</b> {{$invoice->district}}</p>
                            <hr>
                            <p class="font-size-14"><b>Sipariş Notu:</b> {{$invoice->note}}</p>
                            <hr>
                        </div>

                        <table class="unstyledTable">
                            <thead>
                                <tr>
                                    <th>Ürün Adı</th>
                                    <th>Adet</th>
                                    <th>Fiyat</th>
                                    <th>kdv</th>
                                    <th>Toplam Tutar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $alltotal = 0;
                                @endphp
                                @if (!empty($invoice->orders))
                                @foreach ($invoice->orders as $item)
                                @php
                                $kdvOrani = $item['kdv'] ?? 0;
                                $fiyat = $item['price'];
                                $adet = $item['qty'];

                                $kdvtutar = ($fiyat * $adet) * ($kdvOrani / 100);
                                $toplamTutar = $fiyat * $adet + $kdvtutar;
                                @endphp
                                <tr>
                                    <td style="text-align: left;">{{$item['name']}}</td>
                                    <td style="text-align: left;">{{$item['qty']}}</td>
                                    <td style="text-align: left;">{{$item['price']}}</td>
                                    <td style="text-align: left;">% {{$item['kdv']}}</td>
                                    <td style="text-align: left;">{{$toplamTutar}}</td>
                                    @php
                                    $alltotal += $toplamTutar;
                                    @endphp
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </tr>
                    </table>
                    <div class="footer" style="height: 20px"><h4 class="font-weight-100" >İndirim : {{session()->get('coupon_price') ?? 0}} ₺</h4></div>
                    <div class="footer" style="height: 20px"><h4 class="font-weight-100">Toplam : {{$alltotal}} ₺</h4></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
