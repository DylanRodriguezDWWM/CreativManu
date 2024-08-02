<?php
    function sanitize($input) {
        // retirer les espaces avant et après : " mo t " devient "mo t"
        $sanitized = trim($input);
        // retirer les tags HTML => retirer JS
        $sanitized = strip_tags($sanitized);
        // Encoder les caractères spéciaux
        $sanitized = htmlspecialchars($sanitized);

        return $sanitized;
    }

?>

