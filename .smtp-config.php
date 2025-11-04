<?php
// .smtp-config.php   -- GUARDAR FUERA DE public_html (ej: /home/tu_usuario/.smtp-config.php)

// Datos SMTP (reemplazá por tu cuenta real)
$SMTP_HOST = 'c2741556.ferozo.com';      // servidor SMTP (DonWeb / Ferozo)
$SMTP_PORT = 465;                        // puerto (465 SSL o 587 TLS)
$SMTP_SECURE = 'ssl';                    // 'ssl' o 'tls'
$SMTP_USER = 'no-reply@estudioinfolex.com.ar';  // cuenta creada en el panel
$SMTP_PASS = 'TU_CONTRASEÑA_AQUI';               // contraseña de la casilla

// Opcional: destinatario final (puedes dejarlo aquí o en sendmail.php)
$CONTACT_TO = 'estudio.infolex@gmail.com';
?>
