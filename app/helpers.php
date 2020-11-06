<?php

if (! function_exists('gravatar_url')) {
    function gravatar_url($email = null) {
        $email = md5($email);
        // 'https://drive.google.com/uc?export=view&id=1KYB4VX-TCzzkkG2UC1WeF6Ktfi7okLIC'

        return "https://gravatar.com/avatar/{$email}" . http_build_query([
            's' => 60,
            'd' => 'https://res.cloudinary.com/dcs3zcs3v/image/upload/v1598252824/profile.jpg'
        ]);
    }
}