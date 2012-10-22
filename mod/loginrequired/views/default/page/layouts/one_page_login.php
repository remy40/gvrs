<?php
/**
* Layout of login page
*/
echo '<div id="login-wrapper">';
echo elgg_view('login/header');
echo "<p>Nous rencontrons actuellement un problème d'envoi d'email de validation de compte. <br> Si après avoir créé un compte vous ne recevez pas d'email de validation, vérifiez dans votre dossier spam. Si vous ne trouvez toujours pas l'email, patientez, un administrateur validera votre compte manuellement. Si vous avez trouvé le mail dans votre dossier spam, veuillez le signaler une fois sur le réseau social, merci ! <br> Désolé pour ce contre temps, nous essayons de résoudre ce problème au plus vite. </p>";
echo elgg_view('core/account/login_box');
echo '</div>';
