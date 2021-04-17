@extends('frontend.layouts.seller')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://kit-pro.fontawesome.com/releases/v5.15.1/css/pro.min.css" rel="stylesheet">
    <style>
        .hoverEffect
    </style>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var $select1 = $('#select1'),
            $select2 = $('#select2'),
            $options = $select2.find('option');

        $select1.on('change', function() {
            $select2.html($options.filter('[value="' + this.value + '"]'));
        }).trigger('change');
        const searchFocus = document.getElementById('search-focus');
        const keys = [{
                keyCode: 'AltLeft',
                isTriggered: false
            },
            {
                keyCode: 'ControlLeft',
                isTriggered: false
            },
        ];

        window.addEventListener('keydown', (e) => {
            keys.forEach((obj) => {
                if (obj.keyCode === e.code) {
                    obj.isTriggered = true;
                }
            });

            const shortcutTriggered = keys.filter((obj) => obj.isTriggered).length === keys.length;

            if (shortcutTriggered) {
                searchFocus.focus();
            }
        });

        window.addEventListener('keyup', (e) => {
            keys.forEach((obj) => {
                if (obj.keyCode === e.code) {
                    obj.isTriggered = false;
                }
            });
        });

    </script>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4 offset-8">
                <div class="input-group rounded">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                        aria-describedby="search-addon" />
                    <button class="input-group-text border-2 btn btn-primary" id="search-addon">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row mt-5 mb-4">
            <div class="col-md-4">
                <select class="form-control" name="select1" id="select1">
                    <option value="1">Poyabzal</option>
                    <option value="2">Kiyim</option>
                    <option value="3">Futbolka</option>
                    <option value="4">Bosh kiyim</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-control" name="select1" id="select1">
                    <option value="1">Erkaklar Kiyimi</option>
                    <option value="2">Ayolar Kiyimi</option>
                    <option value="2">Bollalar Kiyimi</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-control" name="select1" id="select1">
                    <option value="1">GUCCI</option>
                    <option value="2">ZARA</option>
                    <option value="3">ADIDAS</option>
                    <option value="4">NIKE</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <p class="card-text">
                            With supporting text below as a natural lead-in to additional content.
                        </p>
                        <button type="button" class="btn btn-lg btn-primary">Primary button</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
