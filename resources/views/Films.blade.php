<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Films</title>
  <link rel="stylesheet" href="{{ asset('css/films.css') }}">
</head>
<body>

  <!-- Navigation -->
  <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('films')" :active="request()->routeIs('films')">
      {{ __('films') }}
    </x-nav-link>
    <x-nav-link :href="route('catalogue')" :active="request()->routeIs('catalogue')">
      {{ __('catalogue') }}
    </x-nav-link>
  </div>

  <h1>Liste des films</h1>
  <div id="film-list">
    @include('filmsList', ['films' => $films])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).on('click', '.pagination a', function(event) {
          event.preventDefault();
          let url = $(this).attr('href');
          $.get(url, function(data){
              $('#film-list').html(data);
          });
      });
    </script>
  </div>

  <!-- Filtres -->
  <div class="listFilter">
    <label for="filter">Filtrer par genre</label>
    <select name="filterList" id="filter">
      <option value="">Choisir un genre</option>
      <option value="action">Action</option>
      <option value="adventure">Aventure</option>
      <option value="romantic">Romantique</option>
      <option value="comedy">Comédie</option>
      <option value="suspens">Suspens</option>
      <option value="horror">Horreur</option>
    </select>
  </div>

  <div>
    <label for="yearList">Année de sortie</label>
    <select name="realeaseYear" id="yearList">
      <option value="">Choisir une année de sortie</option>
      <!-- Liste des années -->
      <option value="2024">2024</option>
      <option value="2023">2023</option>
      <!-- etc... -->
    </select>
  </div>

  <!-- Boutons et modals -->
  <button onclick="openmodal('addmodal')" class="addFilm">
    Ajouter un film
  </button>
  <div id="addmodal" style="display:none;">
    <div class="modal-content">
      <span class="close" onclick="closeModal('addmodal')">&times;</span>
      @include('addFilm', ['films' => $films])
    </div>
  </div>

  <button class="deleteFilm" id="deleteFilm">
    Supprimer un film
  </button>

  <button onclick="openmodal('editmodal')" class="editFilm">
    Éditer un film
  </button>

  <div id="editmodal"
     @if(! isset($editFilm)) style="display:none" @endif>
  <div class="modal-content">
    <span class="close" onclick="closeModal('editmodal')">&times;</span>
    @include('editFilm', ['editFilm' => $editFilm ?? null])
  </div>
</div>

  <button class="rentalFollowing">
    Suivi des locations
  </button>

  <!-- Script centralisé -->
  <script>
    function openmodal(modalId) {
      let modal = document.getElementById(modalId);
      if (modal) {
        modal.style.display = "block";
      } else {
        console.error("Le modal '" + modalId + "' n'existe pas !");
      }
    }

    function closeModal(modalId) {
      let modal = document.getElementById(modalId);
      if (modal) {
        modal.style.display = "none";
      } else {
        console.error("Le modal '" + modalId + "' n'existe pas !");
      }
    }

    document.addEventListener("DOMContentLoaded", function() {
      // Par exemple, pour le formulaire d'ajout de film
      let addForm = document.getElementById("filmFormAdd");
      if (addForm) {
        addForm.addEventListener("submit", function(event) {
          event.preventDefault();
          let formData = new FormData(this);
          let url = this.getAttribute("data-route");

          fetch(url, {
              method: "POST",
              body: formData,
              headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
              }
          })
          .then(response => response.json())
          .then(data => {
              document.getElementById("message").innerText = data.message;
              setTimeout(() => {
                  closeModal('addmodal');
                  location.reload();
              }, 1500);
          })
          .catch(error => console.error("Erreur:", error));
        });
      }

      // Idem pour le formulaire d'édition (filmFormEdit)
      let editForm = document.getElementById("filmFormEdit");
      if (editForm) {
        editForm.addEventListener("submit", function(event) {
          event.preventDefault();
          let formData = new FormData(this);
          let url = this.getAttribute("data-route");

          fetch(url, {
              method: "POST",
              body: formData,
              headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
              }
          })
          .then(response => response.json())
          .then(data => {
              document.getElementById("message").innerText = data.message;
              setTimeout(() => {
                  closeModal('editmodal');
                  location.reload();
              }, 1500);
          })
          .catch(error => console.error("Erreur:", error));
        });
      }
    });

    // Gestion de la suppression
    document.addEventListener("DOMContentLoaded", function () {
      let selectedFilms = [];
      document.querySelectorAll(".select_checkbox").forEach(checkbox => {
          checkbox.addEventListener("change", function() {
              let filmId = parseInt(this.value);
              if (this.checked) {
                  selectedFilms.push(filmId);
              } else {
                  selectedFilms = selectedFilms.filter(id => id !== filmId);
              }
              console.log(selectedFilms);
          });
      });

      document.getElementById("deleteFilm").addEventListener("click", function () {
          if (selectedFilms.length === 0) {
              alert("Veuillez sélectionner au moins un film.");
              return;
          }

          fetch("{{ route('films.delete') }}", {
              method: "POST",
              headers: {
                  "Content-Type": "application/json",
                  "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
              },
              body: JSON.stringify({ filmIds: selectedFilms })
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  alert("Films supprimés avec succès !");
                  location.reload();
              } else {
                  alert("Erreur lors de la suppression.");
              }
          })
          .catch(error => console.error("Erreur :", error));
      });
    });
  </script>

</body>
</html>
