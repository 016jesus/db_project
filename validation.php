<?php
// validation.php

function validateText($text) {
    return preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $text);
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateNumber($number) {
    return filter_var($number, FILTER_VALIDATE_INT);
}

function validatePassword($password) {
    // Add your password validation logic here (e.g., minimum length, complexity)
    return strlen($password) >= 8;
}