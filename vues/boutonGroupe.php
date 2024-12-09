<a class="group-button" href="routeur.php?controleur=controleurGroupe&action=afficherGrandGroupe&id=<?=$groupe->get('idGroupe'); ?>">
    <img alt="image groupe" src="<?=$groupe->get('lienPhotoIcone')?>" />
    <p><?=$groupe->get('nomGroupe')?></p>
    <span class="caption"><?=$groupe->get('nbMembres')?></span>
    <img class="icon" alt="members" src="media/filled-group-100.png" />
</a>
