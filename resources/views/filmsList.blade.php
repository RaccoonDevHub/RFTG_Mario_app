<table class="table">
    <thead class="table-header">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Release_Year</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($films as $film)
            <tr class="table-row">
                <td>{{ $film['filmId'] }}</td>
                <td class="flame-text">{{ $film['title'] }}</td>
                <td>{{ $film['description'] }}</td>
                <td>{{ $film['releaseYear'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $films->links() }}