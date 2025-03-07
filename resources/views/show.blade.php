
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="RichBoss">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />


    <title>Certificate | RichBoss</title>

    <link href="../css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand navbar-light navbar-bg fixed-top">
    <b class="sidebar-toggle">
       RichBoss
    </b>
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            @if($status == 1)
            <a href="{{ route('admin.certificate.download', ['id' => $certificate->id]) }}" class="btn btn-primary"><i class="align-middle" data-feather="download"></i> Yuklab olish</a>
            @endif
        </ul>
    </div>
</nav>
<main class="d-flex w-100">
    <div class="container">
        @if($status == 1)
            <div class="mt-2"> </div>
            <image src="{{ asset($certificate->file_path) }}" width="100%" class="mt-5"></image>
        @else
            <h2>Hujjat topilmadi</h2>
        @endif
    </div>
</main>
</body>

</html>
