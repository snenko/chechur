<?php
/*збереження файлів*/
function saveImage($fild_name){
    $path_to_upload_pictures = 'pics/';
    $uploadfile = $path_to_upload_pictures.basename($_FILES[$fild_name]['name']);
    if (move_uploaded_file($_FILES[$fild_name]['tmp_name'], $uploadfile)) {
        return true;
    }
    return false;
}

/*конект до бд*/
function connect()
{
    $host = 'localhost';
    $user = 'husak';
    $pass = 'husak';
    $db = 'husak';

    $g_link = mysql_connect($host , $user, $pass) or die('Не можу приєднатись до сервера.' );
    mysql_select_db($db, $g_link) or die('Не можу вибрати базу данних');
    return $g_link;
}

function get_all_orders(){
    $sql = 'Select customer_id, firstname, lastname, email, telephone, street1, city, region, date_created, co.name as country_name, status,
                   cu.template_id as template_id, te.price as price, te.title as title,
                   te.description as description, te.image_preview as image_preview, te.image_swatch as image_swatch
            from customer cu left join country co on cu.country_id=co.country_id left join template te on cu.template_id=te.template_id
            order by  date_created';



    return mysql_query($sql, connect() );
}
//*******************************************************************************//
function get_templates($id='') {
    $sql = 'select template_id, title, description, image_preview, image_swatch, price
            from template '.(($id)?" where template_id=$id ":'').' order by template_id';
    return mysql_query($sql, connect() );
}

function insert_template($title, $description, $image_preview, $image_swatch, $price) {
    $sql = "INSERT INTO template (title, description, image_preview, image_swatch, price)
            VALUES ('$title', '$description', '$image_preview', '$image_swatch', '$price' )";

    return mysql_query( $sql, connect() );
}

function edit_template($values){
    foreach($values as $k=>$v)
        $t[] =  " $k = '$v'";

    $str = implode ( ',' , $t );

    $sql = "UPDATE template  SET  $str WHERE template_id = " . $values['template_id'];//$template_id;

    return mysql_query( $sql, connect() );
}

function remote_template($id){
    $sql = "DELETE FROM template WHERE template_id = $id";

    return mysql_query( $sql, connect() );
}
/*********************************************/
function edit_customer($values){
    foreach($values as $k=>$v)
        $t[] =  " $k = '$v'";

    $str = implode ( ',' , $t );

    $sql = "UPDATE customer  SET  $str WHERE customer_id = " . $values['customer_id'];//$customer_id;

    return mysql_query( $sql, connect() );
}

/*статус замовлення*/
class OrderStatus{
    private static  $_order_status = [
        null => 'не активно',
        1 => 'переговори',
        2 => 'домовились',
        3 => 'відмовились',
        4 => 'відкладено',
    ];

    /*Повертає статус замовлення*/
    public static function get($val='') {
        if($val)
            return self::$_order_status[$val];
        return self::$_order_status;
    }
}

function getBlock_Select_templates($id=''){
    $res= get_templates();
    $options='';
    while ($row = mysql_fetch_array($res, MYSQL_BOTH)) {
        $options .= '<option '.(($row['template_id']==$id)?' selected ':'').'>'.$row['title'].'</option>';
    }

    return '<select name="templates">'.$options.'</select>';
}
/*******************************/

function insert_customer($values){
    foreach($values as $k=>$v){
        $_k[] =  $k;
        $_v[] =  "'$v'";
    }

    date_default_timezone_set('Europe/Kiev');
    $dt = new DateTime();

    $_k[] = 'date_created';
    $_v[] = "'".$dt->format('Y-m-d H:i:s')."'";


    $_k = implode ( ',' , $_k );
    $_v = implode ( ',' , $_v );

    $sql = "INSERT INTO customer($_k)VALUES($_v)";

    return mysql_query( $sql, connect() );
}
/***************************/
function get_country() {
    $sql = 'select * from country';

    return mysql_query($sql, connect() );
}
//country_id, name
function getBlock_Select_country($id=''){
    $res = get_country();
    $options='';
    while ($row = mysql_fetch_array($res, MYSQL_BOTH)) {
        $options .= '<option '.(($row['country_id']==$id)?' selected ':'').' value="'.$row['country_id'].'" >'.$row['name'].'</option>';
    }

    return '<select class="element select medium" name="country_id">'.$options.'</select>';
}



