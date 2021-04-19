@extends('frontend.layouts.seller')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" />
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
                <select class="form-control aiz-selectpicker" name="select1" id="select1">
                    <option value="1">Poyabzal</option>
                    <option value="2">Kiyim</option>
                    <option value="3">Futbolka</option>
                    <option value="4">Bosh kiyim</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-control aiz-selectpicker" name="select1" id="select1">
                    <option value="1">Erkaklar Kiyimi</option>
                    <option value="2">Ayolar Kiyimi</option>
                    <option value="2">Bollalar Kiyimi</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-control aiz-selectpicker" name="select1" id="select1">
                    <option value="1">GUCCI</option>
                    <option value="2">ZARA</option>
                    <option value="3">ADIDAS</option>
                    <option value="4">NIKE</option>
                </select>
            </div>
        </div>
        <div class="row form-check ml-md-2">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                <h6>Select All</h6>
            </label>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-body bg-white overflow-auto mb-md-5">
                    <table class="table aiz-table mb-0 footable footable-1 breakpoint-lg" style="">
                        <thead>
                            <tr class="footable-header">
                                <th scope="row">Name</th>
                                <th scope="row">Description</th>
                                <th scope="row">Cherecter</th>
                                <th scope="row">Select</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="col">
                                    <a href="http://estore-one.com/product/samsung-galaxy-a51-464gb-3" target="_blank">
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <img src="http://estore-one.com/public/uploads/all/FumFBUGNDYPozjV6xdjvMCUD21ZTbPibjIvLkT6q.jpg"
                                                    alt="Image" class="w-60px">
                                            </div>
                                        </div>
                                    </a>
                                </td>
                                <td scope="col">
                                    <p>Hello world!</p>
                                </td>
                                <td scope="col">
                                    <div class="">
                                        <span class="text-muted">Samsung Galaxy A51 4/64GB</span>
                                    </div>
                                </td>
                                <td scope="col">
                                    <div class="form-check">
                                        <input class="form-check-input w-50px" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                        </label>
                                    </div>
                                </td>
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                                    <span class="page-link" aria-hidden="true">‹</span>
                                </li>
                                <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                                <li class="page-item"><a class="page-link"
                                        href="http://estore-one.com/admin/products/all?page=2">2</a></li>
                                <li class="page-item"><a class="page-link"
                                        href="http://estore-one.com/admin/products/all?page=3">3</a></li>


                                <li class="page-item">
                                    <a class="page-link" href="http://estore-one.com/admin/products/all?page=2" rel="next"
                                        aria-label="Next »">›</a>
                                </li>
                            </ul>
                        </nav>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
