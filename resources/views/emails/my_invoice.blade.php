<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoys forma</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <style>
        .wrap{
            padding-top: 1rem;
        }
        .wrapper{
            margin: 0 auto;
            padding: 1rem;
        }
        .inner{
            position: relative;
            left: 650px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="wrapper">
        <img style="width: 15%" src="{{ static_asset('assets/img/LogoTinfi.png') }}" alt="">
        <div class="row wrap">
            <div class="col-md-8">
                <h6 class="text-black-50">Инвойс: №</h6>
                <h6 class="text-black-50">Дата:</h6>
            </div>
            <div class="col-md-4">
                <h6 class="text-black-50"><strong>ООО «BMG Venture Investments»</strong></h6>
                <h6 class="text-black-50"><strong>Адрес:</strong></h6>
                <h6 class="text-black-50"><strong>Горячая линия:</strong></h6>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <h6 class="text-black-50"><strong>ФИО покупателя:</strong>Name</h6>
                <h6 class="text-black-50"><strong>Адрес покупателя:</strong> Adres</h6>
                <h6 class="text-black-50"><strong>Телефон:</strong>+998991234567</h6>
            </div>
            <div class="col-md-4">
                <h6 class="text-black-50"><strong>Название магазина:</strong>Lorem ipsum</h6>
                <h6 class="text-black-50"><strong>Адрес магазина:</strong>Artem</h6>
                <h6 class="text-black-50"><strong>Телефон:</strong>1234567</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="h4">Информация о заказе</h4>
                    </div>
                    <div class="card-title">
                        <div class="row p-md-2">
                            <div class="col-md-3">
                                <h5 class="text-black-50">Фото товара</h5>
                            </div>
                            <div class="col-md-3">
                                <h5 class="text-black-50">Данные товара</h5>
                            </div>
                            <div class="col-md-4">
                                <h5 class="text-black-50">Статус заказа</h5>
                            </div>
                            <div class="col-md-2">
                                <h5 class="text-black-50">Сумма и количество</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <img class="w-100"
                                     src="data:image/jpeg;base64,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"
                                     alt="">
                            </div>
                            <div class="col-md-3">
                                <h6 class="text-black-50"><strong>Название товара:</strong>кроссовки</h6>
                                <h6 class="text-black-50"><strong>Артикул:</strong>кожа</h6>
                                <h6 class="text-black-50"><strong>Цвет:</strong>белый</h6>
                                <h6 class="text-black-50"><strong>Размер:</strong>38</h6>
                                <h6 class="text-black-50"><strong>Бренд:</strong>ADIDAS</h6>
                            </div>
                            <div class="col-md-4">
                                <h6>Подтвержден/Отправлен:</h6>
                                <h6>№ отслеживания отправки:</h6>
                            </div>
                            <div class="col-md-2">
                                <h6 class=""><strong>Количество: </strong>ХХ штук</h6>
                                <h6 class=""><strong>Количество: </strong>ХХ сум</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <h5 class=""><strong>Количество товаров: </strong>ХХ штук</h5>
                                <h5 class=""><strong>Сумма:</strong>ХХ сум</h5>
                                <h5 class=""><strong>Цена доставки:</strong>ХХ сум</h5>
                                <h4 class="text-danger"><strong>Итоговая сумма:</strong>ХХ сум</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-right p-md-3" onclick="hidden()">
    <a href="chrome://print/34/0/print.pdf" download="chrome://print/34/0/print.pdf" class="btn btn-primary" onclick="print()">Print</a>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/jsPDF/dist/jspdf.min.js">
    function print() {
        const filename = 'ThisIsYourPDFFilename.pdf';

        html2canvas(document.querySelector('#nodeToRenderAsPDF')).then(canvas => {
            let pdf = new jsPDF('p', 'mm', 'a3');
            pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 0, 0, 211, 298);
            pdf.save(filename);
        });
    }
    function print(quality = 4) {
        const filename = 'ThisIsYourPDFFilename.pdf';

        html2canvas(document.querySelector('#nodeToRenderAsPDF'),
            {scale: quality}
        ).then(canvas => {
            let pdf = new jsPDF('p', 'mm', 'a4');
            pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 0, 0, 211, 298);
            pdf.save(filename);
        });
    }
</script>
</body>
</html>
