<x-layout>
<table class="table table-bordered">
    <tr>
        @foreach ($data['keys'] as $key)
            <th>{{$key}}</th>
        @endforeach
    </tr>
    @foreach ($data['goods'] as $item)
        <tr>
            @foreach ($data['keys'] as $key)
                <td>{{ json_encode($item[$key]) }}</td>
            @endforeach
        </tr>
    @endforeach
</table>
</x-layout>
