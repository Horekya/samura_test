<x-layout>
<table class="table table-bordered">
    <tr>
        <th>артикул</th>
        <th>название</th>
        <th>цена из магазина озон</th>
    </tr>
    @foreach ($data as $item)
        <tr>
            <td>{{ $item['offer_id'] }}</td>
            <td>{{ $item['name'] }}</td>
            <td>{{ $item['price'] }}</td>
        </tr>
    @endforeach
</table>
    <a href="{{ route('table') }}">сырые данные</a>
</x-layout>
