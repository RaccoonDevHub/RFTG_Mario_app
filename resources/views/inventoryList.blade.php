<table class="table">
    <thead class="table-header">
        <tr>
            <th>select_film</th>
            <th>ID</th>
            <th>Title</th>
            <th>exemplaires disponibles</th>
            <th>sotck total</th>
            <th>nombre d'exemplaires louée</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($stock as $item)
            <tr class="table-row">
                <td><input type="checkbox" class="select_checkbox" value="{{ $item['filmId'] }}" id="slect_film" name="selectfilm"/></td>
                <td>{{ $item['filmId'] }}</td>
                <td class="flame-text">{{ $item['title'] }}</td>
                <td>{{ $item['filmsDisponibles'] }}</td>
                <td>{{ $item['totalStock'] }}</td>
                <td>{{ $item['totalLoues'] }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
{{ $stock->links() }}