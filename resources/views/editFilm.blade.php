<form id="filmForm" action="{{ route('films.update') }}" method="POST">
  @csrf
  {{-- hidden id --}}
  <input type="hidden" name="id" value="{{ $editFilm->id ?? '' }}">

  <input type="text"
         name="title"
         placeholder="Titre"
         required
         value="{{ old('title', $editFilm->title ?? '') }}">

  <input type="text"
         name="description"
         placeholder="Description"
         required
         value="{{ old('description', $editFilm->description ?? '') }}">

  <input type="number"
         name="releaseYear"
         placeholder="Année de sortie"
         required
         value="{{ old('releaseYear', $editFilm->release_year ?? '') }}">

  <input type="number"
         name="languageId"
         placeholder="Langue ID"
         required
         value="{{ old('languageId', $editFilm->language_id ?? '') }}">

  <input type="number"
         name="originalLanguageId"
         placeholder="Langue Originale ID"
         value="{{ old('originalLanguageId', $editFilm->original_language_id ?? '') }}">

  <input type="number"
         name="rentalDuration"
         placeholder="Durée de location"
         required
         value="{{ old('rentalDuration', $editFilm->rental_duration ?? '') }}">

  <input type="number" step="0.01"
         name="rentalRate"
         placeholder="Tarif de location"
         required
         value="{{ old('rentalRate', $editFilm->rental_rate ?? '') }}">

  <input type="number"
         name="length"
         placeholder="Durée du film (min)"
         value="{{ old('length', $editFilm->length ?? '') }}">

  <input type="number" step="0.01"
         name="replacementCost"
         placeholder="Coût de remplacement"
         required
         value="{{ old('replacementCost', $editFilm->replacement_cost ?? '') }}">

  <input type="text"
         name="rating"
         placeholder="Classification"
         required
         value="{{ old('rating', $editFilm->rating ?? '') }}">

  <input type="hidden"
         name="lastUpdate"
         value="{{ now() }}">

  <input type="number"
         name="idDirector"
         placeholder="ID du Réalisateur"
         required
         value="{{ old('idDirector', $editFilm->director_id ?? '') }}">

  <button type="submit">Mettre à jour</button>
</form>

@if(session('success'))
  <div id="message" class="success">{{ session('success') }}</div>
@endif
