# Extension "login"

This extension creates a better login-page for backend/index.php

In addition to the default login page this page contains a field "username" and some fancy "pic of the day"-background



Files & folders

* css/
    * blank.png => used as a placeholder for the captcha image
    * spinner_mid.gif => not used atm
    * styles.css => styles used
* js/
    * jquery.backstretch.js => lib to load/create a fullscreen background image
* locales/
    * *xy*.php => translation arrays
* tpl/
    * indexTpl.xhtml => template, containing all html-code used by by the login-page
    * indexTpl/
        * tpl.php => compiled template
* login_src.php => array of pictures 
* pic_of_the_day_editor.php => editor to add, delete pic references stored in login_src.php
* x_of_the_day.php => simple php function loaded as javascript to generate the "pic of the day"

Please note that the login-page needs jquery + jquery-ui located at "vendor/cmskit/jquery-ui".
In addition the theme "smoothness" is used/required!
