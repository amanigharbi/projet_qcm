<?php
require_once __DIR__ . '/../bdd/Database.php';
require_once __DIR__ . '/../models/QCM.php';

function obtenirQCM($categorie_id = null)
{
    $qcm = new ListQCM();

    if ($categorie_id) {
        return $qcm->recupereQCMCate($categorie_id);
    } else {
        return $qcm->recupereQCM();
    }
}
