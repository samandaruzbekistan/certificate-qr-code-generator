@extends('admin.header')

@section('profile')
    active
@endsection
@section('section')
    <main class="content">
        <div class="container-fluid p-0">

            <div class="mb-3">
                <h1 class="h3 d-inline align-middle">Profile</h1>

            </div>
            <div class="row">
                <div class="col-md-8 col-xl-9">
                    <div class="">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Parolni yangilash</h5>
                            </div>
                            <div class="card-body h-100">
                                <form action="{{ route('admin.update') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Yangi parol</label>
                                        <input required name="password1" type="password" class="form-control"
                                               placeholder="">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Yangi parolni takrorlang</label>
                                        <input required name="password2" type="password" class="form-control"
                                               placeholder="">
                                    </div>
                                    <div class=" text-end">
                                        <button type="submit" class="btn btn-primary">Yangilash</button>
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
