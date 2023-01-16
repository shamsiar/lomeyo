<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Lomeyo</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>

<body class="antialiased">
    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        {{-- navbar start --}}
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Lomeyo</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Page 1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Page 2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Page 3</a>
                        </li>

                    </ul>
                </div>

                <div class="float-end">
                    <select class="form-select" id="country"aria-label="Default select example">
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}"
                                @if ($country->status) {{ 'selected' }} @endif>{{ $country->name }}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>
        </nav>
        {{-- navbar End --}}

        {{-- Main Content Start --}}
        <div class="text-center ">
            <h1>Page 1</h1>

            {{-- Upload Image --}}
            <div class="card" style="max-height: 500px;">
                <div class="card-body">

                    <div class="row">
                        {{-- <div class="col-md-4">
                            <div id="preview-crop-image"
                                style="position:relative;background:#9d9d9d;width:200px;height:200px;border-radius:100%;">
                                <div class="camera_icon" style="position: absolute;bottom:14px;right:40px;z-index:1">
                                    <label for="image"><i class="fa fa-camera"
                                            style="font-size: 24px; cursor:pointer;"></i></label>
                                    <input type="file" id="image" style="display: none;">
                                </div>
                                <div id="img-wrapper"></div>
                            </div>
                        </div> --}}

                        <div class="col-md-4">
                            <label class="cabinet center-block">
                                <figure>
                                    <img src="" class="gambar img-responsive img-thumbnail"
                                        id="item-img-output" />
                                    <figcaption class="img-icon"><i class="fa fa-camera"></i></figcaption>
                                </figure>
                                <input type="file" class="item-img file center-block" name="file_photo" />
                            </label>
                        </div>
                    </div>

                </div>
            </div>
            {{-- Upload Image End --}}
        </div>

        {{-- Crop Image Modal Popup --}}
        <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit Photo</h4>
                    </div>
                    <div class="modal-body">
                        <div id="upload-demo" class="center-block"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Main Content End --}}
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    {{-- croppie JS CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Start upload preview image
        $(".gambar").attr("src", "https://user.gadjian.com/static/images/personnel_boy.png");
        var $uploadCrop, tempFilename, rawImg, imageId;

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.upload-demo').addClass('ready');
                    $('#cropImagePop').modal('show');
                    rawImg = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                swal("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        $uploadCrop = $('#upload-demo').croppie({
            viewport: {
                width: 200,
                height: 200,
                type: 'circle'
            },
            boundary: {
                width: 200,
                height: 200
            },
            enforceBoundary: false,
            // enableOrientation: true,
            enableExif: true
        });
        $('#cropImagePop').on('shown.bs.modal', function() {
            // alert('Shown pop');
            $uploadCrop.croppie('bind', {
                url: rawImg
            }).then(function() {
                console.log('jQuery bind complete');
            });
        });

        $('.item-img').on('change', function() {
            imageId = $(this).data('id');
            tempFilename = $(this).val();
            $('#cancelCropBtn').data('id', imageId);
            readFile(this);
        });
        $('#cropImageBtn').on('click', function(ev) {
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
                // type: 'base64',
                // format: 'jpeg',
                // size: {
                //     width: 200,
                //     height: 200
                // }
            }).then(function(resp) {
                $.ajax({
                    url: "{{ route('home.uploadImage') }}",
                    type: "POST",
                    data: {
                        "image": resp
                    },
                    success: function(data) {
                        $('#item-img-output').attr('src', resp);
                        $('#cropImagePop').modal('hide');
                        // html = '<img src="' + img + '" />';
                        // $("#img-wrapper").html(html);
                    }
                });
                // $('#item-img-output').attr('src', resp);
                // $('#cropImagePop').modal('hide');
            });
        });

        // End upload preview image
        // $('#country').on('change', function() {
        //     // alert(this.value);
        //     var id = this.value;
        //     $.ajax({
        //         url: "route('home.changeCountryStatus') }}",
        //         type: "POST",
        //         data: {
        //             "id": id
        //         },
        //         success: function(data) {
        //             // alert(data);
        //         }
        //     });
        // });
    </script>
</body>

</html>
