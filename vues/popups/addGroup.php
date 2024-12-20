<div id="popup-add-group" class="overlay">
    <div class="popup">
        <h2>Rejoindre un groupe</h2>
        <a class="close" href="#">&times;</a>
        <div class="content">
            <p>zone de recherche pour les groupes ici</p>
        </div>
    </div>
</div>
<div id="popup-regles" class="overlay">
    <div class="popup">
        <h2>Regles de <?= $nomG?></h2>
        <a class="close" href="#">&times;</a>
        <div class="content">
            <p><?=$reglesGroupe?></p>
        </div>
    </div>
</div>
<div id="popup-invitation" class="overlay">
    <div class="popup">
        <h2>Inviter dans <?= $nomG?></h2>
        <a class="close" href="#">&times;</a>
        <div class="content">
            <p>Envoyez le lien ci contre à la personne que vous souhaitez inviter</p>
            <p><?=$lienInvit?></p>
        </div>
    </div>
</div>