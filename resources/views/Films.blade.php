<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>films</title>
    <link rel="stylesheet" href="{{ asset('css/films.css') }}">
</head>
<body>
    
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <x-nav-link :href="route('films')" :active="request()->routeIs('films')">
            {{__('films') }}
        </x-nav-link>
        <x-nav-link :href="route('catalogue')" :active="request()->routeIs('catalogue')">
            {{__('catalogue') }}
        </x-nav-link>
    </div>
    <h1>Liste des films</h1>
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
    <button onclick="openmodal()" class="addFilm">
        Ajouter un film
    </button>
    <div id="modal" style="display:none;">
        <div class="modal-content">
            @include('addFilm', ['films' => $films])
        </div>
    
    <script>
    function openmodal() {
        let modal = document.getElementById("modal");
        if (modal) {
            modal.style.display = "block";
        } else {
            console.error("Le modal n'existe pas !");
        }
    }

    function closeModal() {
        let modal = document.getElementById("modal");
        if (modal) {
            modal.style.display = "none";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        let form = document.getElementById("filmForm");
        if (form) {
            form.addEventListener("submit", function(event) {
                event.preventDefault();
                let formData = new FormData(this);
                let url = this.getAttribute("data-route");

                fetch(url, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("message").innerText = data.message;
                    setTimeout(() => {
                        closeModal();
                        location.reload();
                    }, 1500);
                })
                .catch(error => console.error("Erreur:", error));
            });
        }
    });
</script>

</div>
<button class="deleteFilm" id="deleteFilm">
    supprimer un film
</button>
<button onclick="openmodal()" class="addFilm">
        Editer un film
</button>
<div id="modal" style="display:none;">
        <div class="modal-content">
            @include('editFilm', ['films' => $films])
        </div>
    
    <script>
    function openmodal() {
        let modal = document.getElementById("modal");
        if (modal) {
            modal.style.display = "block";
        } else {
            console.error("Le modal n'existe pas !");
        }
    }

    function closeModal() {
        let modal = document.getElementById("modal");
        if (modal) {
            modal.style.display = "none";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        let form = document.getElementById("filmForm");
        if (form) {
            form.addEventListener("submit", function(event) {
                event.preventDefault();
                let formData = new FormData(this);
                let url = this.getAttribute("data-route");

                fetch(url, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("message").innerText = data.message;
                    setTimeout(() => {
                        closeModal();
                        location.reload();
                    }, 1500);
                })
                .catch(error => console.error("Erreur:", error));
            });
        }
    });
</script>

<button class="rentalFollowing">
    suivi des locations
</button>
<script> 
    document.addEventListener("DOMContentLoaded", function (){
        let selectedFilms = [];
        console.log("selected film chargé");
        document.querySelectorAll(".select_checkbox").forEach(checkbox => {
            checkbox.addEventListener("change", function() {
                let filmId = parseInt(this.value);

                if (this.checked) {
                    selectedFilms.push(filmId);
                } else {
                    selectedFilms =selectedFilms.filter(id => id !== filmId);
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
            console.log("Réponse du serveur :", data);
            if (data.success) {
                alert("Films supprimés avec succès !");
                location.reload(); // Recharge la page après suppression
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

