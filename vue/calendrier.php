<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tuto+ | Gestion des disponibilités</title>
  <link rel="stylesheet" href="../assets/calendrier.css">
</head>
<body>

  <div class="calendar">

    <!-- Colonne gauche -->
    <div class="col leftCol">
      <div class="content">
        <h1 class="date">Jour<span>Mois</span></h1>

        <div class="rendezvous">
          <h3>Rendez-vous du jour</h3>

          <!-- Liste -->
          <ul class="rdv-list" id="rdvList">
            <li><span class="heure">09h00</span> — Mathématiques avec Étudiant A 
              <button class="edit">modifier</button> 
              <button class="delete">✕</button>
            </li>
            <li><span class="heure">13h30</span> — Révision de Physique avec Étudiant B 
              <button class="edit"></button> 
              <button class="delete">✕modifier</button>
            </li>
            <li><span class="heure">15h00</span> — Tutoriel en ligne avec Étudiant C 
              <button class="edit">modifier</button> 
              <button class="delete">✕</button>
            </li>
          </ul>

          <!-- Formulaire d’ajout -->
          <div class="ajout-rdv">
            <input type="text" id="heureInput" placeholder="Heure (ex: 10h30)">
            <input type="text" id="descInput" placeholder="Description du rendez-vous">
            <button id="ajouterBtn">Ajouter</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Colonne droite -->
    <div class="col rightCol">
      <div class="content">
        <h2 class="year">2025</h2>

        <ul class="months">
          <li><a href="#" data-value="1">Jan</a></li>
          <li><a href="#" data-value="2">Fév</a></li>
          <li><a href="#" data-value="3">Mar</a></li>
          <li><a href="#" data-value="4">Avr</a></li>
          <li><a href="#" data-value="5">Mai</a></li>
          <li><a href="#" data-value="6">Juin</a></li>
          <li><a href="#" data-value="7">Juil</a></li>
          <li><a href="#" data-value="8">Août</a></li>
          <li><a href="#" data-value="9" class="selected">Sep</a></li>
          <li><a href="#" data-value="10">Oct</a></li>
          <li><a href="#" data-value="11">Nov</a></li>
          <li><a href="#" data-value="12">Déc</a></li>
        </ul>

        <div class="clearfix"></div>

        <ul class="weekday">
          <li><span>Lun</span></li>
          <li><span>Mar</span></li>
          <li><span>Mer</span></li>
          <li><span>Jeu</span></li>
          <li><span>Ven</span></li>
          <li><span>Sam</span></li>
          <li><span>Dim</span></li>
        </ul>

        <div class="clearfix"></div>

        <ul class="days" id="daysList">
          <?php
          $premierJour = 1;
          $joursDansMois = 31;

          for ($i = 1; $i <= $joursDansMois; $i++) {
            $class = ($i === (int)date('j')) ? ' class="selected"' : '';
            echo "<li><a href='#'$class>$i</a></li>";
          }
          ?>
        </ul>
      </div>
    </div>
  </div>


  <script>
    // -------- Date automatique
    const jours = ["Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"];
    const mois = ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"];
    const now = new Date();
    const dateTitle = document.querySelector(".date");
    dateTitle.innerHTML = `${jours[now.getDay()].toUpperCase()}<span>${now.getDate()} ${mois[now.getMonth()]}</span>`;

    // -------- Ajout / Suppression / Modification locale
    const rdvList = document.getElementById("rdvList");
    const ajouterBtn = document.getElementById("ajouterBtn");

    ajouterBtn.addEventListener("click", () => {
      const heure = document.getElementById("heureInput").value.trim();
      const desc = document.getElementById("descInput").value.trim();

      if (heure && desc) {
        const li = document.createElement("li");
        li.innerHTML = `<span class='heure'>${heure}</span> — ${desc} 
                        <button class='edit'>✎</button> 
                        <button class='delete'>✕</button>`;
        rdvList.appendChild(li);
        document.getElementById("heureInput").value = "";
        document.getElementById("descInput").value = "";
      }
    });

    rdvList.addEventListener("click", (e) => {
      const li = e.target.closest("li");
      if (e.target.classList.contains("delete")) li.remove();

      if (e.target.classList.contains("edit")) {
        const heure = prompt("Nouvelle heure :", li.querySelector(".heure").textContent);
        const desc = prompt("Nouvelle description :", li.textContent.split("—")[1].trim());
        if (heure && desc) {
          li.innerHTML = `<span class='heure'>${heure}</span> — ${desc} 
                          <button class='edit'>✎</button> 
                          <button class='delete'>✕</button>`;
        }
      }
    });

    // -------- Sélection dynamique des jours
    const days = document.querySelectorAll("#daysList li a");
    days.forEach(day => {
      day.addEventListener("click", (e) => {
        e.preventDefault();
        days.forEach(d => d.classList.remove("selected"));
        day.classList.add("selected");

        // Mise à jour du titre à gauche
        const jourIndex = new Date().getDay(); // jour actuel (ex : vendredi)
        const jourNom = jours[jourIndex];
        const moisNom = mois[new Date().getMonth()];
        dateTitle.innerHTML = `${jourNom.toUpperCase()}<span>${day.textContent} ${moisNom}</span>`;
      });
    });
  </script>

</body>
</html>
