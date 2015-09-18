<?php

class Pages {
    private static $pages = [
        'admin'     => ['link'=>'admin.php',   'menu'=>0, 'admin'=>1, 'label'=>'Admin panel'],//адміністративна сторінка
        'home'      => ['link'=>'home.php',    'menu'=>1, 'admin'=>0, 'label'=>'Головна'],//головна сторінка
        'login'     => ['link'=>'login.php',   'menu'=>1, 'admin'=>0, 'label'=>'Логін'],//сторінка авторизації
        'order'     => ['link'=>'order.php',   'menu'=>1, 'admin'=>0, 'label'=>'Замовлення\Роботи'],//сторінка замовлення
        'success'   => ['link'=>'success.php', 'menu'=>0, 'admin'=>0, 'label'=>'Success'],//сторінка підтвердження успішності замовлення
        '403'       => ['link'=>'403.php',     'menu'=>0, 'admin'=>0, 'label'=>'Access denie. Error 403'],//доступ заборонено
        '404'       => ['link'=>'404.php',     'menu'=>0, 'admin'=>0, 'label'=>'Page not found. Error 404'],//такої сторінки немає
        ];
    public static function getPages($index='') {
        if($index){
            return self::$pages[$index];
        }
        return self::$pages;
    }
}

/*індекс сторінки - визначаємо сторінку на якій ми  знаходимось*/
function getIndex() {
    $index = getRequest()['path'];
    return str_replace('/', '', $index);
}

function isAccess($index) {
    if(isAdmin($index)){
        if(!isset($_SESSION['admin'])){
            return false;
        }
    }
    return true;
}

/* чи користувач авторизований*/
function isAuthoriz(){
    return isset($_SESSION['admin']);
}

/*чи являється сторінка адміністративною*/
function isAdmin($index) {
    return Pages::getPages($index)['admin'];
}

/*чи є така сторінка в списку сторінок*/
function isPage($index) {
    $p = Pages::getPages($index);
    return isset( $p );
}

/*підгружаємо сторінку із списка сторінок, в залежності від індекса сторінки*/
function getContent() {
    $index = getIndex();
    if(!$index){
        $index = 'home';
    }

    if(!isPage($index)){
        $index = '404';
    }
    else if(!isAccess($index)){
        $index = '403';
    }

    $p = Pages::getPages($index)['link'];
    include "/pages/$p";
}

/*отримуємо url-рядок на якому ми знаходимось*/
function request_url()
{
    $result = ''; // Пока результат пуст
    $default_port = 80; // Порт по-умолчанию

    // А не в защищенном-ли мы соединении?
    if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on')) {
        // В защищенном! Добавим протокол...
        $result .= 'https://';
        // ...и переназначим значение порта по-умолчанию
        $default_port = 443;
    } else {
        // Обычное соединение, обычный протокол
        $result .= 'http://';
    }
    // Имя сервера, напр. site.com или www.site.com
    $result .= $_SERVER['SERVER_NAME'];

    // А порт у нас по-умолчанию?
    if ($_SERVER['SERVER_PORT'] != $default_port) {
        // Если нет, то добавим порт в URL
        $result .= ':'.$_SERVER['SERVER_PORT'];
    }
    // Последняя часть запроса (путь и GET-параметры).
    $result .= $_SERVER['REQUEST_URI'];
    // Уфф, вроде получилось!
    return $result;
}

/*розбиваємо url-ряядок на блоки(масив)*/
function getRequest(){
    $current_url = request_url();
    return parse_url($current_url);
}