<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/films.css') }}">
  <title>inventory</title>
</head>

<body>

  <!-- Navigation -->
  <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('films')" :active="request()->routeIs('films')">
      {{ __('films') }}
    </x-nav-link>
    <x-nav-link :href="route('inventory.getInventory')" :active="request()->routeIs('inventory.getInventory')">
      {{ __('inventaire') }}
    </x-nav-link>
  </div>

  <h1>Inventaire</h1>
  <div id="inventory-list">
    @include('inventoryList', ['stock' => $stock])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).on('click', '#inventory-list .pagination a', function(event) {
          event.preventDefault();
          let url = $(this).attr('href');
          $.get(url, function(data){
              $('#inventory-list').html(html);
          });
      });
    </script>
  </div>
  <button onclick="openModal('addmodal')" class="addFilm">
    Ajouter un film dans l'inventaire
  </button>
  <div id="addmodal" style="display:none;">
    <div class="modal-content">
      <span class="close" onclick="closeModal('addmodal')">&times;</span>
      @include('addInventory', ['stock' => $stock])
    </div>
  </div>

  <button class="deleteInventory" id="deleteInventory">
    Supprimer un film de l'inventaire
  </button>

  <script>
  // Ouvre/Ferme un modal (identique à films)
  function openModal(id)  { document.getElementById(id).style.display = 'block';  }
  function closeModal(id) { document.getElementById(id).style.display = 'none'; }

  document.addEventListener("DOMContentLoaded", function() {
    // 1) Gestion du formulaire d'ajout stock
    const addForm = document.getElementById("inventoryFormAdd");
    if (addForm) {
      addForm.addEventListener("submit", function(e) {
        e.preventDefault();
        const url  = this.dataset.route;
        const data = new FormData(this);

        fetch(url, {
          method: "POST",
          credentials: "same-origin",
          headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "X-Requested-With": "XMLHttpRequest",
            "Accept": "application/json"
          },
          body: data
        })
        .then(resp => resp.json()
          .then(json => ({ ok: resp.ok, json }))
        )
        .then(({ ok, json }) => {
          // Affiche le message dans le <div id="messageAdd">
          document.getElementById("messageAdd").innerText = json.message;
          if (ok) {
            setTimeout(() => {
              closeModal('addmodal');
              location.reload();
            }, 1200);
          }
        })
        .catch(err => {
          console.error("AJAX error:", err);
          document.getElementById("messageAdd").innerText = "Erreur réseau";
        });
      });
    }

          // sélection/suppression en masse
          let selectedFilms = [];
      document.querySelectorAll(".select_checkbox").forEach(cb => {
        cb.addEventListener("change", function() {
          const id = parseInt(this.value);
          if (this.checked) selectedFilms.push(id);
          else selectedFilms = selectedFilms.filter(x => x !== id);
        });
      });

      const deleteButton = document.getElementById("deleteInventory");
      if (deleteButton) {
        deleteButton.addEventListener("click", function() {
          if (selectedFilms.length === 0) {
            alert("Veuillez sélectionner au moins un film.");
            return;
          }
          const deleteBtn = document.getElementById("deleteInventory");
  if (deleteBtn) {
    deleteBtn.addEventListener("click", function() {
      if (selectedFilms.length === 0) {
        return alert("Sélectionnez au moins un film.");
      }
      fetch("{{ route('inventory.delete') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ filmIds: selectedFilms })
      })
      .then(r => r.json())
      .then(json => {
        alert(json.message);
        if (json.success) location.reload();
      })
      .catch(err => console.error(err));
    });
  }
        });
      }
    });
</script>



</body>
</html>
