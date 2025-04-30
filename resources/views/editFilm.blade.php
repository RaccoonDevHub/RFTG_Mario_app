<form id="filmFormEdit" data-route="{{ route('films.update') }}" method="POST">
  @csrf
  {{-- hidden id --}}
  <input type="hidden" id="filmIdInput" name="id" value="{{ $editFilm->id ?? '' }}">

  <input type="text"
       id="titleInput"
       name="title"
       placeholder="Titre"
       required
       value="{{ old('title', $editFilm->title ?? '') }}">

  <input type="text"
       id="descriptionInput"
       name="description"
       placeholder="Description"
       required
       value="{{ old('description', $editFilm->description ?? '') }}">

  <input type="number"
       id="releaseYearInput"
       name="releaseYear"
       placeholder="Année de sortie"
       required
       value="{{ old('releaseYear', $editFilm->release_year ?? '') }}">

  <input type="number"
       id="languageIdInput"
       name="languageId"
       placeholder="Langue ID"
       required
       value="{{ old('languageId', $editFilm->language_id ?? '') }}">

  <input type="number"
       id="originalLanguageIdInput"
       name="originalLanguageId"
       placeholder="Langue Originale ID"
       value="{{ old('originalLanguageId', $editFilm->original_language_id ?? '') }}">

  <input type="number"
       id="rentalDurationInput"
       name="rentalDuration"
       placeholder="Durée de location"
       required
       value="{{ old('rentalDuration', $editFilm->rental_duration ?? '') }}">

  <input type="number" step="0.01"
       id="rentalRateInput"
       name="rentalRate"
       placeholder="Tarif de location"
       required
       value="{{ old('rentalRate', $editFilm->rental_rate ?? '') }}">

  <input type="number"
       id="lengthInput"
       name="length"
       placeholder="Durée du film (min)"
       value="{{ old('length', $editFilm->length ?? '') }}">

  <input type="number" step="0.01"
       id="replacementCostInput"
       name="replacementCost"
       placeholder="Coût de remplacement"
       required
       value="{{ old('replacementCost', $editFilm->replacement_cost ?? '') }}">

  <input type="text"
       id="ratingInput"
       name="rating"
       placeholder="Classification"
       required
       value="{{ old('rating', $editFilm->rating ?? '') }}">

  <input type="hidden"
       id="lastUpdateInput"
       name="lastUpdate"
       value="{{ now() }}">


  <button type="submit">Mettre à jour</button>
</form>

@if(session('success'))
  <div id="message" class="success">{{ session('success') }}</div>
@endif
