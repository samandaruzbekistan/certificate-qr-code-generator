@extends('admin.header')

@push('css')
    <style>
        .pagination{height:36px;margin:0;padding: 0;}
        .pager,.pagination ul{margin-left:0;*zoom:1}
        .pagination ul{padding:0;display:inline-block;*display:inline;margin-bottom:0;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 2px rgba(0,0,0,.05);-moz-box-shadow:0 1px 2px rgba(0,0,0,.05);box-shadow:0 1px 2px rgba(0,0,0,.05)}
        .pagination li{display:inline}
        .pagination a{float:left;padding:0 12px;line-height:30px;text-decoration:none;border:1px solid #ddd;border-left-width:0}
        .pagination .active a,.pagination a:hover{background-color:#f5f5f5;color:#94999E}
        .pagination .active a{color:#94999E;cursor:default}
        .pagination .disabled a,.pagination .disabled a:hover,.pagination .disabled span{color:#94999E;background-color:transparent;cursor:default}
        .pagination li:first-child a,.pagination li:first-child span{border-left-width:1px;-webkit-border-radius:3px 0 0 3px;-moz-border-radius:3px 0 0 3px;border-radius:3px 0 0 3px}
        .pagination li:last-child a{-webkit-border-radius:0 3px 3px 0;-moz-border-radius:0 3px 3px 0;border-radius:0 3px 3px 0}
        .pagination-centered{text-align:center}
        .pagination-right{text-align:right}
        .pager{margin-bottom:18px;text-align:center}
        .pager:after,.pager:before{display:table;content:""}
        .pager li{display:inline}
        .pager a{display:inline-block;padding:5px 12px;background-color:#fff;border:1px solid #ddd;-webkit-border-radius:15px;-moz-border-radius:15px;border-radius:15px}
        .pager a:hover{text-decoration:none;background-color:#f5f5f5}
        .pager .next a{float:right}
        .pager .previous a{float:left}
        .pager .disabled a,.pager .disabled a:hover{color:#999;background-color:#fff;cursor:default}
        .pagination .prev.disabled span{float:left;padding:0 12px;line-height:30px;text-decoration:none;border:1px solid #ddd;border-left-width:0}
        .pagination .next.disabled span{float:left;padding:0 12px;line-height:30px;text-decoration:none;border:1px solid #ddd;border-left-width:0}
        .pagination li.active, .pagination li.disabled {
            float:left;padding:0 12px;line-height:30px;text-decoration:none;border:1px solid #ddd;border-left-width:0
        }
        .pagination li.active {
            background: #364E63;
            color: #fff;
        }
        .pagination li:first-child {
            border-left-width: 1px;
        }
    </style>
@endpush

@section('home')
    active
@endsection
@section('section')

    <main class="content forma" style="padding-bottom: 0; display: none">
        <div class="container-fluid p-0">
            <div class="col-md-8 col-xl-9">
                <div class="">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Yangi sertifikat qo'shish</h5>
                        </div>
                        <div class="card-body h-100">
                            <form action="{{ route('admin.newCertificate') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Talaba ismi <span class="text-danger">*</span></label>
                                    <input name="student_name" required type="text" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kurs nomi <span class="text-danger">*</span></label>
                                    <input name="course_name" required type="text" class="form-control" placeholder="">
                                </div>
                                <div class=" text-end">
                                    <button type="button" class="btn btn-danger cancel">Bekor qilish</button>
                                    <button type="submit" class="btn btn-success">Qo'shish</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <main class="content exams">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col d-flex">
                    <div class="w-100">
                        <div class="d-flex justify-content-between">
                            <h3 class="mb-3">Sertifikatlar</h3>
                            <button class="btn btn-primary align-middle add">Yangi sertifikat</button>
                        </div>
                        <table class="table table-striped table-hover table-responsive">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>F.I.Sh</th>
                                <th>Kurs</th>
                                <th>Holat</th>
                                <th>O'chirish</th>
                            </tr>
                            </thead>
                            <tbody id="tbody">
                            @foreach($certificates as $id => $certificate)
                                <tr>
                                    <td>
                                        {{ $id+1 }}
                                    </td>
                                    <td>{{ $certificate->student_name }}</td>
                                    <td>{{ $certificate->course_name }}</td>
                                    @if($certificate->status == 'pending')
                                        <td><a href="{{ route('admin.certificate', ['id' => $certificate->id]) }}" class="text-white btn btn-info">Yakunlash</a></td>
                                    @else
                                        <td><a href="{{ route('show', ['id' => $certificate->id]) }}" class="text-white btn btn-success">Ko'rish</a></td>
                                    @endif
                                    <td><a href="{{ route('admin.certificate.delete', ['id' => $certificate->id]) }}"
                                           onclick="return confirm('Haqiqatan ham ushbu sertifikatni o‘chirmoqchimisiz?')"
                                           class="btn btn-danger">
                                            O‘chirish
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection


@section('js')
    <script>
        @if(session('success') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'Sertifikat yaratilmoqda',
            duration: 10000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif

        @if(session('image') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'Sertifikat tayyor',
            duration: 10000,
            dismissible : true,
            position: {
                x : 'center',
                y : 'top'
            },
        });
        @endif

        $(".add").on("click", function() {
            $('.forma').show();
            $('.exams').hide();
        });

        $(".cancel").on("click", function() {
            event.stopPropagation();
            $('.forma').hide();
            $('.exams').show();
        });
    </script>
@endsection
