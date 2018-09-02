@include('layouts.header')







<h1>Some content</h1>

<div class="container">
    <table id="courses" class="table table-hover table-condensed" style="width:100%">
        <thead>
        <tr>
            <th>Валюта</th>
            <th>Банк</th>
            <th>Покупка</th>
            <th>Продажа</th>
            <th>Дата</th>
        </tr>
        </thead>
    </table>
</div>

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {

        var filters = {};
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        coursesTable = $('#courses').DataTable({
            "processing": true,
            pageLength: 100,
            "serverSide": true,

            "ajax": {
                url: "{{ $uri }}",
                method: 'POST'
            },
            "columns": [
                {
                    data: 'currency', name: 'currency'
                },
                {
                    data: 'title', name: 'title'
                },
                {
                    data: 'purchase_price', name: 'purchase_price'
                },
                {
                    data: 'sale_price', name: 'sale_price'
                },
                {
                    data: 'ru_date', name: 'ru_date'
                }

            ]


        });




    });


</script>

@endpush


@include('layouts.footer')
