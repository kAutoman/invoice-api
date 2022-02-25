<div class="container">
    <div style="text-align: right;">
        <h5>Invoice</h3>
        <h5>Invoice Date: {{$invoiceData->invoice_date}}</h5>
        <h5>Invoice No: {{$invoiceData->invoice_no}}</h5>
    </div>
    <div style="display: inline-block;">
        <img src="{{public_path('/assets/images/logo.jpg')}}"width="170" height="100">
        <img src="{{public_path('/assets/images/logo2.jpg')}}" width="170" height="100">
    </div>
    <div style="text-align: left;">
        <h4>{{$invoiceData->from_address}}</h4>
        <h4>{{$invoiceData->to}}</h4>
        <h4>{{$invoiceData->excluding_vat}}</h4>
        <br>
        <h4>Mail : {{$invoiceData->email}}</h4>
        <h4>Mobile : {{$invoiceData->mobile_num}}</h4>
        <h4>To : {{$invoiceData->to}}</h4>
    </div>
    <table class="table table-bordered table-striped">
        <tr>
            <th style="text-align:center;"><b>QTY</b></th>
            <th style="text-align:center;"><b>DESCRIPTION</b></th>
            <th style="text-align:center;"><b>PRICE</b></th>   
            <th style="text-align:center;"><b>TOTAL</b></th>   
        </tr>
        @foreach(json_decode($invoiceData->items) as $item)
            <tr>
                <td style="text-align:center;">{{ $item->quality }}</td>
                <td style="text-align:center;">{{ $item->description }}</td>
                <td style="text-align:center;">{{ $item->price }}</td>
                <td style="text-align:center;">{{ $item->quality * $item->price  }}</td>
            </tr>
        @endforeach
    </table>
    <div style="width: 100%;">
        <div style="height: 100px;">
            <h4>Comments:<br>{{$invoiceData->comment}}</h4>
        </div>
        <div style="width: 100px;">
            <h4>Excluding VAT: {{$invoiceData->excluding_vat}}</h4>
            <h4>VAT Amount: {{$invoiceData->vat_amount}}</h4>
            <h4>Invoice Total: {{$invoiceData->invoice_total}}</h4>
            <h4>Paid Amount: {{$invoiceData->payed_amount}}</h4>
            <h4>Due Total: {{$invoiceData->due_total}}</h4>
        </div>
    </div>
</div>  