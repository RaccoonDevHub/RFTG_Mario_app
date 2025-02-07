<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>catalogue</title>
    <link rel="stylesheet" href="{{ asset('css/catalogue.css') }}">
</head>
<body>
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-nav-link>
        <x-nav-link :href="route('films')" :active="request()->routeIs('films')">
            {{__('films') }}
        </x-nav-link>
        <x-nav-link :href="route('catalogue')" :active="request()->routeIs('catalogue')">
            {{__('catalogue') }}
        </x-nav-link>
    </div>
    <h1>catalogue</h1>
    <div id="film-list">
        @include('filmsList', ['films' => $films])
        
<script src="https://code.jquery.com/jquery-3.6.0.min.js">
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        let url = $(this).attr('href');

        $.get(url, function(data){
            $('#film-list').html(data);
        });
    });
</script>
    </div>
    <div class="listFilter">
        <label for="filter">filtrer par genre</label>
        <select name="filterList" id="filter">
            <option value="">choisir un genre</option>
            <option value="action">Action</option>
            <option value="adventure">Aventure</option>
            <option value="romantic">Romantique</option>
            <option value="comedy">comédie</option>
            <option value="suspens">suspens</option>
            <option value="horror">horreur</option>
        </select>
    </div>
    <div>
        <label for="yearList">année de sortie</label>
        <select name="realeaseYear" id ="yearList">
            <option value="">choisir une année de sortie</option>
            <option value="2024">2024</option>
            <option value="2024">2023</option>
            <option value="2024">2022</option>
            <option value="2024">2021</option>
            <option value="2024">2020</option>
            <option value="2024">2019</option>
            <option value="2024">2018</option>
            <option value="2024">2017</option>
            <option value="2024">2016</option>
            <option value="2024">2015</option>
            <option value="2024">2014</option>
            <option value="2024">2013</option>
            <option value="2024">2012</option>
            <option value="2024">2011</option>
            <option value="2024">2010</option>
            <option value="2024">2009</option>
            <option value="2024">2008</option>
            <option value="2024">2007</option>
            <option value="2024">2006</option>
            <option value="2024">2005</option>
            <option value="2024">2004</option>
            <option value="2024">2003</option>
            <option value="2024">2002</option>
            <option value="2024">2001</option>
            <option value="2024">2000</option>
            <option value="2024">1999</option>
        </select>
    </div>
</body>
</html>

