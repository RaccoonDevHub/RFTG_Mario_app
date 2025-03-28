<table class="table">
    <thead class="table-header">
        <tr>
            <th>selct_film</th>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Release_Year</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($films as $film)
            <tr class="table-row">
                <td><input type="checkbox" class="select_checkbox" value="{{ $film['filmId'] }}" id="slect_film" name="selectfilm"/></td>
                <td>{{ $film['filmId'] }}</td>
                <td class="flame-text">{{ $film['title'] }}</td>
                <td>{{ $film['description'] }}</td>
                <td>{{ $film['releaseYear'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $films->links() }}