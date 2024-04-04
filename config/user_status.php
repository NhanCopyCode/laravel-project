<?php


return function($userStatusName) {
    $userStatus = [
        1 => 'active',
        2 => 'block',
        3 => 'pending'
    ];

    $userStatusFlip = array_flip($userStatus);

    if(array_key_exists($userStatusName, $userStatusFlip)) {
        return $userStatusFlip[$userStatusName];
    } else {
        return false; // Hoặc bạn có thể trả về null hoặc giá trị khác tùy thuộc vào nhu cầu của bạn
    }
};