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
        <div class="row">
            <div class="col-md-12">
                <div class="card-body bg-white">
                    <table class="table aiz-table mb-0 footable footable-1 breakpoint-lg" style="">
                        <thead>
                            <tr class="footable-header">
                                <th class="footable-first-visible" style="display: table-cell;">#</th>
                                <th width="20%" style="display: table-cell;">Name</th>
                                <th style="display: table-cell;">Added By</th>
                                <th style="display: table-cell;">Num of Sale</th>
                                <th style="display: table-cell;">Total Stock</th>
                                <th style="display: table-cell;">Base Price</th>
                                <th style="display: table-cell;">Todays Deal</th>
                                <th style="display: table-cell;">Rating</th>
                                <th style="display: table-cell;">Published</th>
                                <th style="display: table-cell;">Featured</th>
                                <th class="text-right footable-last-visible" style="display: table-cell;">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="footable-first-visible" style="display: table-cell;">1</td>
                                <td style="display: table-cell;">
                                    <a href="http://estore-one.com/product/samsung-galaxy-a51-464gb-3" target="_blank">
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <img src="http://estore-one.com/public/uploads/all/FumFBUGNDYPozjV6xdjvMCUD21ZTbPibjIvLkT6q.jpg"
                                                    alt="Image" class="w-50px">
                                            </div>
                                            <div class="col-lg-8">
                                                <span class="text-muted">Samsung Galaxy A51 4/64GB</span>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                                <td style="display: table-cell;">Ilyos</td>
                                <td style="display: table-cell;">1 times</td>
                                <td style="display: table-cell;">
                                    0 </td>
                                <td style="display: table-cell;">250.00</td>
                                <td style="display: table-cell;">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_todays_deal(this)" value="70" type="checkbox" checked="">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td style="display: table-cell;">0</td>
                                <td style="display: table-cell;">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_published(this)" value="70" type="checkbox" checked="">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td style="display: table-cell;">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_featured(this)" value="70" type="checkbox" checked="">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="text-right footable-last-visible" style="display: table-cell;">
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        href="http://estore-one.com/admin/products/70/characteristics?type=All"
                                        title="Product Attributes">
                                        <i class="las la-list"></i>
                                    </a>
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="http://estore-one.com/admin/products/admin/70/edit" title="Edit">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        href="http://estore-one.com/products/duplicate/70?type=All" title="Duplicate">
                                        <i class="las la-copy"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="http://estore-one.com/products/destroy/70" title="Delete">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="footable-first-visible" style="display: table-cell;">2</td>
                                <td style="display: table-cell;">
                                    <a href="http://estore-one.com/product/samsung-galaxy-a51-464gb-2" target="_blank">
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <img src="http://estore-one.com/public/uploads/all/FumFBUGNDYPozjV6xdjvMCUD21ZTbPibjIvLkT6q.jpg"
                                                    alt="Image" class="w-50px">
                                            </div>
                                            <div class="col-lg-8">
                                                <span class="text-muted">Samsung Galaxy A51 4/64GB</span>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                                <td style="display: table-cell;">Ilyos</td>
                                <td style="display: table-cell;">1 times</td>
                                <td style="display: table-cell;">
                                    0 </td>
                                <td style="display: table-cell;">250.00</td>
                                <td style="display: table-cell;">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_todays_deal(this)" value="68" type="checkbox" checked="">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td style="display: table-cell;">0</td>
                                <td style="display: table-cell;">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_published(this)" value="68" type="checkbox" checked="">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td style="display: table-cell;">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_featured(this)" value="68" type="checkbox" checked="">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="text-right footable-last-visible" style="display: table-cell;">
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        href="http://estore-one.com/admin/products/68/characteristics?type=All"
                                        title="Product Attributes">
                                        <i class="las la-list"></i>
                                    </a>
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="http://estore-one.com/admin/products/admin/68/edit" title="Edit">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        href="http://estore-one.com/products/duplicate/68?type=All" title="Duplicate">
                                        <i class="las la-copy"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="http://estore-one.com/products/destroy/68" title="Delete">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="footable-first-visible" style="display: table-cell;">3</td>
                                <td style="display: table-cell;">
                                    <a href="http://estore-one.com/product/odekolon-dior-homme-cologne-2" target="_blank">
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <img src="http://estore-one.com/public/uploads/all/D5Uibc8P6dLqSTHd78YqeKj9riLatVnMslg5DqHm.jpg"
                                                    alt="Image" class="w-50px">
                                            </div>
                                            <div class="col-lg-8">
                                                <span class="text-muted">Одеколон "Dior Homme Cologne"</span>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                                <td style="display: table-cell;">Ilyos</td>
                                <td style="display: table-cell;">2 times</td>
                                <td style="display: table-cell;">
                                    0 </td>
                                <td style="display: table-cell;">100.00</td>
                                <td style="display: table-cell;">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_todays_deal(this)" value="67" type="checkbox" checked="">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td style="display: table-cell;">0</td>
                                <td style="display: table-cell;">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_published(this)" value="67" type="checkbox" checked="">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td style="display: table-cell;">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_featured(this)" value="67" type="checkbox" checked="">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="text-right footable-last-visible" style="display: table-cell;">
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        href="http://estore-one.com/admin/products/67/characteristics?type=All"
                                        title="Product Attributes">
                                        <i class="las la-list"></i>
                                    </a>
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="http://estore-one.com/admin/products/admin/67/edit" title="Edit">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        href="http://estore-one.com/products/duplicate/67?type=All" title="Duplicate">
                                        <i class="las la-copy"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="http://estore-one.com/products/destroy/67" title="Delete">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="footable-first-visible" style="display: table-cell;">4</td>
                                <td style="display: table-cell;">
                                    <a href="http://estore-one.com/product/samsung-galaxy-a51-464gb-1" target="_blank">
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <img src="http://estore-one.com/public/uploads/all/FumFBUGNDYPozjV6xdjvMCUD21ZTbPibjIvLkT6q.jpg"
                                                    alt="Image" class="w-50px">
                                            </div>
                                            <div class="col-lg-8">
                                                <span class="text-muted">Samsung Galaxy A51 4/64GB</span>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                                <td style="display: table-cell;">Ilyos</td>
                                <td style="display: table-cell;">1 times</td>
                                <td style="display: table-cell;">
                                    0 </td>
                                <td style="display: table-cell;">250.00</td>
                                <td style="display: table-cell;">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_todays_deal(this)" value="66" type="checkbox" checked="">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td style="display: table-cell;">0</td>
                                <td style="display: table-cell;">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_published(this)" value="66" type="checkbox" checked="">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td style="display: table-cell;">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_featured(this)" value="66" type="checkbox" checked="">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="text-right footable-last-visible" style="display: table-cell;">
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        href="http://estore-one.com/admin/products/66/characteristics?type=All"
                                        title="Product Attributes">
                                        <i class="las la-list"></i>
                                    </a>
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="http://estore-one.com/admin/products/admin/66/edit" title="Edit">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        href="http://estore-one.com/products/duplicate/66?type=All" title="Duplicate">
                                        <i class="las la-copy"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="http://estore-one.com/products/destroy/66" title="Delete">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="footable-first-visible" style="display: table-cell;">10</td>
                                <td style="display: table-cell;">
                                    <a href="http://estore-one.com/product/4k-uhd-televizor-philips-50pus750560-50"
                                        target="_blank">
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <img src="http://estore-one.com/public/uploads/all/1Mhdi7wrggjety7PAlKJFmupuMNrSV4qmNa5vIjE.jpg"
                                                    alt="Image" class="w-50px">
                                            </div>
                                            <div class="col-lg-8">
                                                <span class="text-muted">4K UHD Телевизор Philips 50PUS7505/60 50"</span>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                                <td style="display: table-cell;">Mr. Seller</td>
                                <td style="display: table-cell;">6 times</td>
                                <td style="display: table-cell;">
                                    0 </td>
                                <td style="display: table-cell;">450.00</td>
                                <td style="display: table-cell;">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_todays_deal(this)" value="60" type="checkbox" checked="">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td style="display: table-cell;">0</td>
                                <td style="display: table-cell;">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_published(this)" value="60" type="checkbox" checked="">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td style="display: table-cell;">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_featured(this)" value="60" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="text-right footable-last-visible" style="display: table-cell;">
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        href="http://estore-one.com/admin/products/60/characteristics?type=All"
                                        title="Product Attributes">
                                        <i class="las la-list"></i>
                                    </a>
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="http://estore-one.com/admin/products/admin/60/edit" title="Edit">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        href="http://estore-one.com/products/duplicate/60?type=All" title="Duplicate">
                                        <i class="las la-copy"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="http://estore-one.com/products/destroy/60" title="Delete">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
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
