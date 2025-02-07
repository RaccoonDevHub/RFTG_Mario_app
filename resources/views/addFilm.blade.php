<form id="filmForm">
    <input type="text" name="title" placeholder="Titre" required>
    <input type="text" name="description" placeholder="Description" required>
    <input type="number" name="releaseYear" placeholder="Année de sortie" required>
    <input type="number" name="languageId" placeholder="Langue ID" required>
    <input type="number" name="originalLanguageId" placeholder="Langue Originale ID">
    <input type="number" name="rentalDuration" placeholder="Durée de location" required>
    <input type="number" step="0.01" name="rentalRate" placeholder="Tarif de location" required>
    <input type="number" name="length" placeholder="Durée du film (min)">
    <input type="number" step="0.01" name="replacementCost" placeholder="Coût de remplacement" required>
    <input type="text" name="rating" placeholder="Classification" required>
    <input type="hidden" name="lastUpdate" value="{{ now() }}">
    <input type="number" name="idDirector" placeholder="ID du Réalisateur" required>s
</form>
<div id="message"></div>
