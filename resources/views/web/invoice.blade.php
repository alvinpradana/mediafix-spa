<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Media Fix</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/fontawesome-all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/aos.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/swiper.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('admin/assets/images/logo-mf.jpg') }}">
</head>
<body>
        @include('web.layouts.navbar')

        <section class="plans d-flex align-items-center py-3">
            <div class="container text-light">

                @if($invoices->isEmpty())
                    <div class="row justify-content-center">
                        <div class="text-center py-3 mt-4"  data-aos="fade-down">
                            <h3 class="pb-2">Masukkan Token Nota Anda!</h3>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center" data-aos="fade-down">
                            <form action="{{ route('invoice') }}" method="get" class="input-group my-3">
                                <input type="text" class="form-control p-2" name="stripe_token" value="{{ old('stripe_token') }}" placeholder="Enter your stripe token">
                                <button class="btn-secondary text-light" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="text-center py-3 mt-4">
                        <small class="pb-2 d-md-none d-lg-none">Recomended use PC or landscape mode.</small>
                        <h3 class="pb-2">Detail Unit Repair</h3>
                    </div>

                    @foreach ($invoices as $invoice)                    
                        <div class="row pb-5">
                            @if ($invoice->order_status == 'Diagnosa')
                                <div class="col-sm-2 px-0">
                                    <div class="dropdown-divider border border-success"></div>
                                    <div class="row">
                                        <small class="text-center"><i><strong>Diagnosa</strong></i></small>
                                    </div>
                                </div>
                                <div class="col-sm-1 text-center px-0 fas fa-circle text-success"></div>
                            @elseif($invoice->order_status == 'Process Repair')
                                <div class="col-sm-2 px-0">
                                    <div class="dropdown-divider border border-success"></div>
                                    <div class="row">
                                        <small class="text-center"><i><strong>Diagnosa</strong></i></small>
                                    </div>
                                </div>
                                <div class="col-sm-1 text-center px-0 fas fa-circle text-success"></div>
                            @elseif($invoice->order_status == 'Testing Unit')
                                <div class="col-sm-2 px-0">
                                    <div class="dropdown-divider border border-success"></div>
                                    <div class="row">
                                        <small class="text-center"><i><strong>Diagnosa</strong></i></small>
                                    </div>
                                </div>
                                <div class="col-sm-1 text-center px-0 fas fa-circle text-success"></div>
                            @elseif($invoice->order_status == 'Selesai')
                                <div class="col-sm-2 px-0">
                                    <div class="dropdown-divider border border-success"></div>
                                    <div class="row">
                                        <small class="text-center"><i><strong>Diagnosa</strong></i></small>
                                    </div>
                                </div>
                                <div class="col-sm-1 text-center px-0 fas fa-circle text-success"></div>
                            @else
                                <div class="col-sm-2 px-0">
                                    <div class="dropdown-divider border"></div>
                                    <div class="row">
                                        <small class="text-center">Diagnosa</small>
                                    </div>
                                </div>
                                <div class="col-sm-1 text-center px-0 fas fa-circle"></div>
                            @endif
                            @if ($invoice->order_status == 'Process Repair')
                                <div class="col-sm-2 px-0">
                                    <div class="dropdown-divider border border-success"></div>
                                    <div class="row">
                                        <small class="text-center"><i><strong>Process</strong></i></small>
                                    </div>
                                </div>
                                <div class="col-sm-1 text-center px-0 fas fa-circle text-success"></div>
                            @elseif ($invoice->order_status == 'Testing Unit')
                                <div class="col-sm-2 px-0">
                                    <div class="dropdown-divider border border-success"></div>
                                    <div class="row">
                                        <small class="text-center"><i><strong>Process</strong></i></small>
                                    </div>
                                </div>
                                <div class="col-sm-1 text-center px-0 fas fa-circle text-success"></div>
                            @elseif ($invoice->order_status == 'Selesai')
                                <div class="col-sm-2 px-0">
                                    <div class="dropdown-divider border border-success"></div>
                                    <div class="row">
                                        <small class="text-center"><i><strong>Process</strong></i></small>
                                    </div>
                                </div>
                                <div class="col-sm-1 text-center px-0 fas fa-circle text-success"></div>
                            @else
                                <div class="col-sm-2 px-0">
                                    <div class="dropdown-divider border"></div>
                                    <div class="row">
                                        <small class="text-center">Process</small>
                                    </div>
                                </div>
                                <div class="col-sm-1 text-center px-0 fas fa-circle"></div>
                            @endif
                            @if ($invoice->order_status == 'Testing Unit')
                                <div class="col-sm-2 px-0">
                                    <div class="dropdown-divider border border-success"></div>
                                    <div class="row">
                                        <small class="text-center"><i><strong>Testing</strong></i></small>
                                    </div>
                                </div>
                                <div class="col-sm-1 text-center px-0 fas fa-circle text-success"></div>
                            @elseif ($invoice->order_status == 'Selesai')
                                <div class="col-sm-2 px-0">
                                    <div class="dropdown-divider border border-success"></div>
                                    <div class="row">
                                        <small class="text-center"><i><strong>Testing</strong></i></small>
                                    </div>
                                </div>
                                <div class="col-sm-1 text-center px-0 fas fa-circle text-success"></div>
                            @else
                                <div class="col-sm-2 px-0">
                                    <div class="dropdown-divider border"></div>
                                    <div class="row">
                                        <small class="text-center">Testing</small>
                                    </div>
                                </div>
                                <div class="col-sm-1 text-center px-0 fas fa-circle"></div>
                            @endif
                            @if ($invoice->order_status == 'Selesai')
                                <div class="col-sm-2 px-0">
                                    <div class="dropdown-divider border border-success"></div>
                                    <div class="row">
                                        <small class="text-center"><i><strong>Done</strong></i></small>
                                    </div>
                                </div>
                                <div class="col-sm-1 text-center px-0 fas fa-circle text-success"></div>
                            @else
                                <div class="col-sm-2 px-0">
                                    <div class="dropdown-divider border"></div>
                                    <div class="row">
                                        <small class="text-center">Done</small>
                                    </div>
                                </div>
                                <div class="col-sm-1 text-center px-0 fas fa-circle"></div>
                            @endif
                        </div>
                    @endforeach

                    @foreach($invoices as $invoice)
                        <div class="row gy-4" data-aos="zoom-in">
                            <div class="card bg-transparent px-4">
                                <div class="d-flex justify-content-between">
                                    <h4 class="py-2 text-capitalize">{{ $invoice->customer_name }}</h4>
                                    <h4 class="py-2">{{ $invoice->invoice_code }}</h4>
                                </div>
                                <div class="dropdown-divider border-success"></div>
                                <div class="row pt-2">
                                    <div class="form-group col-md-3">
                                        <strong>Telepon / WA</strong>
                                        <div class="mr-1 mb-1 px-3 py-2 border border-success rounded">0{{ $invoice->customer_phone }}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <strong>Tanggal Masuk</strong>
                                        <div class="mr-1 mb-1 px-3 py-2 border border-success rounded">{{ \Carbon\Carbon::parse($invoice->date_in)->format('d M Y') }}</div>
                                    </div>

                                    @if ($invoice->date_taken == null)
                                        <div class="form-group col-md-3">
                                            <strong>Pengambilan</strong>
                                            <div class="mr-1 mb-1 px-3 py-2 border border-success rounded"> - </div>
                                        </div>
                                    @else
                                        <div class="form-group col-md-3">
                                            <strong>Pengambilan</strong>
                                            <div class="mr-1 mb-1 px-3 py-2 border border-success rounded">{{ \Carbon\Carbon::parse($invoice->date_taken)->format('d M Y') }}</div>
                                        </div>
                                    @endif

                                    <div class="form-group col-md-3">
                                        <strong>Garansi</strong>
                                        <div class="mr-1 mb-1 px-3 py-2 border border-success rounded">{{ $invoice->guarantee }} Hari</div>
                                    </div>
                                </div>
                                <table class="table table-responsive table-bordered border-success text-white my-4">
                                    <tr class="text-center">
                                        <th class="text-center" width="5%">Qty</th>
                                        <th width="15%">Unit</th>
                                        <th width="15%">Tipe</th>
                                        <th width="20%">Keterangan</th>
                                        <th width="25%">Kelengkapan</th>
                                        <th width="10%">Biaya</th>
                                        <th width="20%">Total</th>
                                    </tr>
                                    @foreach($invoice->units as $unit)
                                        <tr>
                                            <td class="text-center">{{ $unit->unit_quantity }}</td>
                                            <td class="text-capitalize">{{ $unit->unit_type }}</td>
                                            <td class="text-capitalize">{{ $unit->unit_name }}</td>
                                            <td class="text-capitalize">{{ $unit->unit_description }}</td>
                                            <td class="text-capitalize">{{ $unit->unit_completeness }}</td>
                                            <td>Rp. {{ $unit->unit_cost }}</td>
                                            <td>Rp. {{ $unit->total_cost }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                                <div class="row justify-content-between pb-2">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <strong>Status Order</strong>
                                                <div class="mr-1 mb-1 px-4 py-2 text-sm border border-success rounded text-capitalize">{{ $invoice->order_status }}</div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <strong>Status Pembayaran</strong>
                                                <div class="mr-1 mb-1 px-4 py-2 text-sm border border-success rounded text-capitalize">{{ $invoice->payment_status }}</div>
                                            </div>
                                            <div class="form-group col-md-12 mt-3">
                                                <div class="mr-1 mb-1 px-4 py-3 mb-1 text-sm border border-success rounded">
                                                    <small>
                                                        {{-- <ol> --}}
                                                            <u class="fw-bolder">Perhatian :</u>
                                                            <li>Unit barang yang sudah dibeli tidak dapat ditukar / dikembalikan</li>
                                                            <li>Tidak bertanggung jawab atas kerusakan / kehilangan barang setelah 2 bulan terhitung sejak tanggal direparasi</li>
                                                            <li>Sebelum ada pelunasan barang <i>repair</i> tidak dapat diambil</li>
                                                            <li>Tidak bertanggung jawab apabila terjadi <i>force majeur</i> (Bencana alam, kebakaran, pencurian, huru-hara, dll)</li>
                                                        {{-- </ol> --}}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <div class="form-group row mb-1">
                                            <strong class="col-sm-5 col-form-label">Subtotal</strong>
                                            <div class="col-sm-7">
                                                <div class="mr-1 mb-1 px-3 py-2 text-sm border border-success rounded">Rp. {{ $invoice->subtotal }}</div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-1">
                                            <strong class="col-sm-5 col-form-label">Discount</strong>
                                            <div class="col-sm-7">
                                                <div class="mr-1 mb-1 px-3 py-2 text-sm border border-success rounded">{{ $invoice->discount }} %</div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-1">
                                            <strong class="col-sm-5 col-form-label">Total</strong>
                                            <div class="col-sm-7">
                                                <div class="mr-1 mb-1 px-3 py-2 text-sm border border-success rounded">Rp. {{ $invoice->total_payment }}</div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-1">
                                            <strong class="col-sm-5 col-form-label">DP / Bayar</strong>
                                            <div class="col-sm-7">
                                                <div class="mr-1 mb-1 px-3 py-2 text-sm border border-success rounded">Rp. {{ $invoice->down_payment }}</div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <strong class="col-sm-5 col-form-label">Sisa Bayar</strong>
                                            <div class="col-sm-7">
                                                <div class="mr-1 mb-1 px-3 py-2 text-sm border border-success rounded">Rp. {{ $invoice->dependents }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </section>

        @include('web.layouts.footer')

    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/purecounter.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper.min.js') }}"></script>
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>