<div class="panel admin">
    <h1>Адміністративна панель</h1>
</div>

<div class="block customers">
    <?php
        if($_POST['edit_customer']){
            $values = $_POST;
            unset($values['edit_customer']);
            if(!edit_customer($values)){
                $error_template="Помилка збереження: ". mysql_error() ;
            }
        }
    ?>

    <h2>Список замовлень</h2>
    <div class="table">
        <div class="table-header">

        </div>
        <?php $res = get_all_orders() ?>

        <?php while ($row = mysql_fetch_array($res, MYSQL_BOTH)) { ?>

            <div class="description">
                <form method="post">
                <ul>
                    <li>
                        <select name="status">
                            <?php FOREACH( OrderStatus::get() as $k=>$v): ?>
                                <option <?= ($k==$row['status'])?'selected':''; ?> value="<?= $k ?>"><?= $v ?></option>
                            <?php ENDFOREACH;?>
                        </select>
                    </li>
                    <li><input type="hidden" name="customer_id" value="<?= $row['customer_id'] ?>"></li>
                    <li><div class="caption">Ім’я:</div> <?= $row['firstname'] ?></li>
                    <li><div class="caption">Фамилія:</div><?= $row['lastname'] ?></li>
                    <li><div class="caption">Email:</div><?= $row['email'] ?></li>
                    <li><div class="caption">Телефон:</div><?= $row['telephone'] ?></li>
                    <li><div class="caption">Вулиця:</div><?= $row['street1'] ?></li>
                    <li><div class="caption">Місто:</div><?= $row['city'] ?></li>
                    <li><div class="caption">Регіон:</div><?= $row['region'] ?></li>
                    <li><div class="caption">Дата реєстрації:</div><?= $row['date_created'] ?></li>
                    <li><div class="caption">Країна:</div><?= $row['country_name'] ?></li>
                </ul>

                <div class="preview">
                    <?= getBlock_Select_templates($row['template_id']) ?>

                    <h2><?= $row['title'] ?></h2>
                    <p><?= $row['description'] ?></p>
                    <div class="price"><?= $row['price'] ?></div>
                    <div class="preview-img">
                        <a href="<?= $row['image_preview'] ?>">
                            <img src="pics/<?= $row['image_swatch'] ?>">
                        </a>
                    </div>
                </div>

                <div class="table-footer">
                    <input type="submit" name="edit_customer" value="зберегти">
                </div>
                </form>
            </div>



        <?php } ?>


    </div>
</div>

<hr>

<div class="block templates">
    <h2>Список шаблонів</h2>
    <?php
    if ($_POST['save_template']) {
        $values=array();
        if($_FILES['image_preview']['name']) {
            if(!saveImage('image_preview')){$error_template = 'зображення велике не завантажиломь';}
            else{$values['image_preview'] =$_FILES['image_preview']['name'];}

        }

        if($_FILES['image_swatch']['name']){
            if(!saveImage('image_swatch')){$error_template = 'зображення мале не завантажився';}
            else{$values['image_swatch'] =$_FILES['image_swatch']['name'];}

        }

        $values = array_merge($values, $_POST);
        unset($values['save_template']);
        if(!edit_template($values)){
            $error_template="Помилка збереження: ". mysql_error() ;}


    }

    if($_POST['remove_template']){
        remote_template($_POST['template_id']);
        $error_template = mysql_error();
    }
    ?>

<div class="table">
    <p class="error"><?= $error_template ?></p>
    <?php $res = get_templates() ?>
    <?php while ($row = mysql_fetch_array($res, MYSQL_BOTH)) { ?>
        <div class="row">
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="template_id" value="<?= $row['template_id'] ?>">
            <div class="col">

                <div class="col2">
                    <div>
                        <label for="title">Титульна назва:</label>
                        <input type="text" name="title" style="width:350px" value="<?= $row['title'] ?>">
                    </div>
                    <div>
                        <label for="description">Опис:</label>
                        <textarea name="description" required cols="35" rows="5"><?= $row['description'] ?></textarea>
                    </div>
                    <div>
                        <label for="price">Ціна:</label>
                        <input type="number" name="price" value="<?= $row['price'] ?>">
                    </div>

                </div>
                <div class="col3">
                    <div class="subm_col">
                        <label for="image_preview">Велике зображення</label>
                        <div><input type="file" name="image_preview" value="<?= $row['image_preview'] ?>"></div>
                        <div><img src="pics/<?= $row['image_preview'] ?>"></div>
                    </div>
                    <div class="subm_col">
                        <label for="image_swatch">Мале зображення</label>
                        <div><input type="file" name="image_swatch" value="<?= $row['image_swatch'] ?>"></div>
                        <div><img src="pics/<?= $row['image_swatch'] ?>"></div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="col4">
                <div class="subm_col"><input type="submit" name="save_template" value="зберегти"></div>
                <div class="subm_col"><input type="submit" name="remove_template" value="видалити"></div>
            </div>
        </form>
    </div>

    <?php } ?>
</div>



    <?php


    if (isset($_POST['insert_template'])) {

        if (insert_template($_POST['title'], $_POST['description'], $_FILES['image_preview']['name'], $_FILES['image_swatch']['name'], $_POST['price']))
        {
                $title = '';
                $description = '';
                $image_preview = '';
                $image_swatch = '';
                $price = '';

                if(!saveImage('image_preview')){$error = 'зображення велике не завантажиломь';}
                if(!saveImage('image_swatch')){$error = 'зображення мале не завантажився';}
        } else {
            $error = "Помилка перехоплена $sql. " . mysqli_error($link);
        }

    }
    ?>

    <div class="insert">
        <p class="error"><?= $error ?></p>

        <form method="post"  enctype="multipart/form-data">
            <h2>Добавити шаблон</h2>
            <ul>
            <li>
                <div><label for="title">Титульний надпис</label></div>
                <div><input type="text" name="title" value="<?= $title ?>"></div>
            </li>
            <li>
                <div><label for="description">Опис</label></div>
                <div><textarea name="description" required><?= $description ?></textarea></div>
            </li>
                <li>
                    <div><label for="description">Ціна за шаблон</label></div>
                    <div><input type="number" name="price" required value="<?= $price ?>"></div>
                </li>
            <li>
                <div><label for="image_preview">Завантажте велике зображення</label></div>
                <div><input type="file" name="image_preview" required title="Завантажте велике зображення"></div>
            </li>
            <li>
                <div><label for="image_swatch">Завантажте мале зображення</label></div>
                <div><input type="file" name="image_swatch" required title="Завантажте мале зображення"></div>
            </li>

            <hr>
            <li><input type="submit" name="insert_template" value="зберегти"></li>
            </ul>
        </form>
    </div>
</div>
