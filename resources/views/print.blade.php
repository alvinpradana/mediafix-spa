<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>{{ $invoices->invoice_code }}</title>
</head>
{{-- <body> --}}
<body onload="window.print()">
    <div class="container text-success fs-6 py-4 px-4">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="rounded text-center border border-success p-2 pb-1">
                    <h3><strong>MEDIAFIX</strong></h3>
                    <h4><i>Repair Service Center</i></h4>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row text-center mt-3">
                    <small>Workshop Cirebon :</small>
                    <small>Jl. Kutagara No. 40 C, Jagasatru, Pekalipan - Cirebon 45115 (Telp: 0231-8339852 / WA: 0838-1775-9139)</small>
                </div>
                <div class="row text-center mt-3">
                    <small>Workshop Yogyakarta :</small>
                    <small>Jl. Kaliurang KM. 7,3 No. 28, Condongcatur, Depok, Sleman - Yogyakarta 55283 (Telp: 0274-7371243 / WA: 0822-9931-7878)</small>
                </div>
            </div>
        </div>
        <div class="card mt-3 mb-1">
            <div class="card-body py-1 bg-success rounded"></div>
        </div>
        <hr class="border border-success">
        <div class="row">
            <div class="form-group col-md-2">
                <strong>Invoice Code</strong>
                <div class="mr-1 mb-1 px-3 py-2 border border-success rounded">{{ $invoices->invoice_code }}</div>
            </div>
            <div class="form-group col-md-2">
                <strong>Nama Customer</strong>
                <div class="mr-1 mb-1 px-3 py-2 border border-success rounded">{{ strtoupper($invoices->customer_name) }}</div>
            </div>
            <div class="form-group col-md-2">
                <strong>Telepon / WA</strong>
                <div class="mr-1 mb-1 px-3 py-2 border border-success rounded">0{{ $invoices->customer_phone }}</div>
            </div>
            <div class="form-group col-md-2">
                <strong>Tanggal</strong>
                <div class="mr-1 mb-1 px-3 py-2 border border-success rounded">{{ $invoices->date_in }}</div>
            </div>
            <div class="form-group col-md-2">
                <strong>Pengambilan</strong>
                <div class="mr-1 mb-1 px-3 py-2 border border-success rounded">{{ $invoices->date_taken }}</div>
            </div>
            <div class="form-group col-md-2">
                <strong>Garansi</strong>
                <div class="mr-1 mb-1 px-3 py-2 border border-success rounded">{{ $invoices->guarantee }} Hari</div>
            </div>
        </div>
        <table class="table table-bordered border-success rounded text-success my-3">
            <tr class="text-center">
                <th width="5%">Qty</th>
                <th width="15%">Unit</th>
                <th width="15%">Tipe</th>
                <th width="20%">Keterangan</th>
                <th width="25%">Kelengkapan</th>
                <th width="10%">Biaya</th>
                <th width="20%">Total</th>
            </tr>
            @foreach($invoices->units as $unit)
                <tr>
                    <td class="text-center">{{ $unit->unit_quantity }}</td>
                    <td>{{ strtoupper($unit->unit_type) }}</td>
                    <td>{{ strtoupper($unit->unit_name) }}</td>
                    <td>{{ strtoupper($unit->unit_description) }}</td>
                    <td>{{ strtoupper($unit->unit_completeness) }}</td>
                    <td>Rp. {{ $unit->unit_cost }}</td>
                    <td>Rp. {{ $unit->total_cost }}</td>
                </tr>
            @endforeach
        </table>
        <div class="row justify-content-between pl-2 mt-3">
            <div class="col-md-8">
                <div class="row">
                    <div class="form-group col-md-6">
                        <strong>Status Order</strong>
                        <div class="mr-1 mb-1 px-4 py-2 text-sm border border-success rounded">{{ strtoupper($invoices->order_status) }}</div>
                    </div>
                    <div class="form-group col-md-6">
                        <strong>Status Pembayaran</strong>
                        <div class="mr-1 mb-1 px-4 py-2 text-sm border border-success rounded">{{ strtoupper($invoices->payment_status) }}</div>
                    </div>
                    <div class="form-group col-md-12 mt-2">
                        <div class="mr-1 mb-1 px-2 pt-3 pb-1 text-sm border border-success rounded">
                            <ol>
                                <small class="fw-bolder">
                                    <u>Perhatian :</u>
                                    <li>Unit barang yang sudah dibeli tidak dapat ditukar / dikembalikan</li>
                                    <li>Tidak bertanggung jawab atas kerusakan / kehilangan barang setelah 2 bulan terhitung sejak tanggal direparasi</li>
                                    <li>Sebelum ada pelunasan barang <i>repair</i> tidak dapat diambil</li>
                                    <li>Tidak bertanggung jawab apabila terjadi <i>force majeur</i> (Bencana alam, kebakaran, pencurian, huru-hara, dll)</li>
                                </small>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mt-2">
                <div class="form-group row mb-1">
                    <strong class="col-sm-5 col-form-label">Subtotal</strong>
                    <div class="col-sm-7">
                        <div class="mr-1 mb-1 px-3 py-2 text-sm border border-success rounded">Rp. {{ $invoices->subtotal }}</div>
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <strong class="col-sm-5 col-form-label">Discount</strong>
                    <div class="col-sm-7">
                        <div class="mr-1 mb-1 px-3 py-2 text-sm border border-success rounded">{{ $invoices->discount }} %</div>
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <strong class="col-sm-5 col-form-label">Total</strong>
                    <div class="col-sm-7">
                        <div class="mr-1 mb-1 px-3 py-2 text-sm border border-success rounded">Rp. {{ $invoices->total_payment }}</div>
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <strong class="col-sm-5 col-form-label">DP / Bayar</strong>
                    <div class="col-sm-7">
                        <div class="mr-1 mb-1 px-3 py-2 text-sm border border-success rounded">Rp. {{ $invoices->down_payment }}</div>
                    </div>
                </div>
                <div class="form-group row">
                    <strong class="col-sm-5 col-form-label">Sisa Bayar</strong>
                    <div class="col-sm-7">
                        <div class="mr-1 mb-1 px-3 py-2 text-sm border border-success rounded">Rp. {{ $invoices->dependents }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-between mt-4">
            <div class="col-md-5 text-center"><strong>Customer</strong></div>
            <div class="col-md-5 text-center"><strong>Hormat Kami,</strong></div>
        </div>
        <div class="row justify-content-between mt-4">
            <div class="col-md-5 text-center mt-3"><strong>( ............................. )</strong></div>
            <div class="col-md-5 text-center mt-3"><strong>( ............................. )</strong></div>
        </div>
        <div class="row my-4">
            <div class="col-md-12 text-center">
                <span class="badge rounded-pill bg-success"><i>"Gadget Spesialist"</i></span>
            </div>
        </div>
    </div>
</body>
</html>