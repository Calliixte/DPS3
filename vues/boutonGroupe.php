<?php
echo <<<TEXT
<a class="group-button" href="\{\$groupe->getLien()\}">
    <img alt="image groupe" src="{$groupe->get('lienPhotoIcone')}" />
    <p>{$groupe->get('nomGroupe')}</p>
    <span class="caption">{$groupe->get('nbMembres')}</span>
    <img class="icon" alt="members" src="media/filled-group-100.png" />
</a>
TEXT;
?>
