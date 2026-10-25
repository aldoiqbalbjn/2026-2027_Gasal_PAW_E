<?php
function validateName(&$errors, $field_list, $field_name){
    $pattern = "/^[a-zA-Z'-]+$/";
    if (!isset($field_list[$field_name]) || !is_string($field_list[$field_name]) || trim($field_list[$field_name]) === ''){
        $errors[$field_name] = 'Nama belakang wajib diisi.';
    } else if (!preg_match($pattern, $field_list[$field_name])){
        $errors[$field_name] = 'Nama belakang hanya boleh berisi huruf, tanda petik, dan tanda hubung.';
    }
}

function validateForm(&$errors, $field_list){
    if (!isset($field_list['email']) || !is_string($field_list['email']) || trim($field_list['email']) === ''){
        $errors['email'] = 'Alamat email wajib diisi.';
    } else if (filter_var(trim($field_list['email']), FILTER_VALIDATE_EMAIL) === false){
        $errors['email'] = 'Format alamat email tidak valid.';
    }

    if (!isset($field_list['password']) || !is_string($field_list['password']) || trim($field_list['password']) === ''){
        $errors['password'] = 'Password wajib diisi.';
    }

    if (!isset($field_list['address']) || !is_string($field_list['address']) || trim($field_list['address']) === ''){
        $errors['address'] = 'Alamat wajib diisi.';
    }

    if (!isset($field_list['state']) || !is_string($field_list['state']) || !in_array($field_list['state'], array('1', '2', '3', '4', '5', '6', '7', '8'), true)){
        $errors['state'] = 'Silakan pilih state.';
    }

    if (!isset($field_list['sex']) || !is_string($field_list['sex']) || !in_array($field_list['sex'], array('male', 'female'), true)){
        $errors['sex'] = 'Silakan pilih gender.';
    }

    if (isset($field_list['vegetarian']) && (!is_string($field_list['vegetarian']) || $field_list['vegetarian'] !== 'yes')){
        $errors['vegetarian'] = 'Pilihan vegetarian tidak valid.';
    }
}

function fieldValue($field_list, $field_name){
    if (!isset($field_list[$field_name]) || !is_string($field_list[$field_name])){
        return '';
    }

    return htmlspecialchars($field_list[$field_name], ENT_QUOTES, 'UTF-8');
}

function fieldError($errors, $field_name){
    if (!isset($errors[$field_name])){
        return '';
    }

    return '<span class="error" id="' . $field_name . '-error">' .
        htmlspecialchars($errors[$field_name], ENT_QUOTES, 'UTF-8') .
        '</span>';
}
?>
