@extends('admin.header')

@push('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
@endpush

    @section('home')
    active
@endsection
@section('section')
    <main class="content">
        <div class="container-fluid p-0">

            <div class="mb-3">
                <h1 class="h3 d-inline align-middle">Sertifikat yaratish</h1>

            </div>
            <div class="row">
                <div class="col-md-4 col-xl-4">
                    <div class="">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">QR code</h5>
                            </div>
                            <div class="card-body h-100">
                                <div id="qrcode"></div>
                                <button id="download" class="btn btn-primary mt-3">Yuklab olish</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-xl-8">
                    <div class="">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Sertifikat rasmi</h5>
                            </div>
                            <div class="card-body h-100">
                                <form action="{{ route('admin.upload.image') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $certificate->id }}">
                                    <div class="mb-3">
                                        <label class="form-label">Rasm yuklang (jpg, jpeg)</label>
                                        <input required name="image" type="file" class="form-control" accept="image/jpeg">
                                    </div>
                                    <div class=" text-end">
                                        <button type="submit" class="btn btn-primary">Yuklash</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


@section('js')
    <script>
        new QRCode(document.getElementById("qrcode"), {
            text: "{{ url('/certificate/' . $certificate->id) }}",
            width: 256,
            height: 256,
            colorDark: "#000",
            colorLight: "#fff",
            correctLevel: QRCode.CorrectLevel.H
        });

        document.getElementById("download").addEventListener("click", function() {
            var canvas = document.querySelector("#qrcode canvas"); // QR kodni olish
            var link = document.createElement("a");
            link.href = canvas.toDataURL("image/png"); // PNG formatga o‘girish
            link.download = "{{ $certificate->student_name }}-{{ $certificate->course_name }}"; // Fayl nomini berish
            link.click();
        });
    </script>

    <script>
        @if(session('password_error') == 1)
        const notyf = new Notyf();

        notyf.error({
            message: 'Parollar bir xil emas!',
            duration: 5000,
            dismissible: true,
            position: {
                x: 'center',
                y: 'top'
            },
        });
        @endif

        @if(session('success') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'Parol muvaffaqiyatli yangilandi!',
            duration: 5000,
            dismissible: true,
            position: {
                x: 'center',
                y: 'top'
            },
        });
        @endif

        @if(session('success_photo') == 1)
        const notyf = new Notyf();

        notyf.success({
            message: 'Profil rasmi muvaffaqiyatli yangilandi!',
            duration: 5000,
            dismissible: true,
            position: {
                x: 'center',
                y: 'top'
            },
        });
        @endif
    </script>
@endsection
