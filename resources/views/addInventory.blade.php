<form id="inventoryFormAdd" data-route="{{ route('inventory.store') }}">
    @csrf
    <input type="number" id ="filmId" name="filmId" placeholder="Entrez l'id du film" required>
    <label for="storeSelectDropdown">Choisissez une un stock :</label>
<select id="storeDropdown" name="storeId">
  <option value="">-- Sélectionnez un stock--</option>
  <option value="1">1</option>
  <option value="2">2</option>
</select>

    <button type="submit">Ajouter</button>
</form>
<div id="messageAdd" class="message_area"></div>
