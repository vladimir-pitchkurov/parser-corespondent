@include('layouts.header')




<div class="container">
  @if(count($dates) > 0)
    <select name="existing-date" id="existing-date">
        @foreach($dates as $date)
          <option value="{{$date->save_at}}" >{{$date->ru_date}}</option>
        @endforeach
    </select>
  @endif
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
                method: 'POST',
                "data": function ( d ) {
                    var neededDate = $('#existing-date option:selected').attr('value');
                    return $.extend( {}, d, {
                        "date-get": neededDate
                    } );
                }
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

        $('#existing-date').on('change', function () {
            coursesTable.ajax.reload();
        });

    });


</script>

@endpush


@include('layouts.footer')
