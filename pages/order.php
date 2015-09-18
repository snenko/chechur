<div class="panel">
    <h1>Зробити замовлення</h1>
</div>

<?php if($_POST['select_template']) {?>


    <div class="customer">
        <div class="col subm_col">
            <form method="post">
                <div class="form_description">
                    <h2>Форма замовника</h2>
                    <p>Внесіть свої данні щоб ми могли з вами звязатись</p>
                </div>
                <ul>
                    <li>
                        <label class="description" for="firstname">Ім’я </label>
                        <div>
                            <input name="firstname" class="element text medium" type="text" maxlength="255" value="">
                        </div>
                    </li>
                    <li>
                        <label class="description" for="lastname">фамілія </label>
                        <div>
                            <input name="lastname" class="element text medium" type="text" maxlength="255" value="">
                        </div>
                    </li>
                    <li>
                        <label class="description" for="email">Email </label>
                        <div>
                            <input name="email" class="element text medium" type="text" maxlength="255" value="">
                        </div>
                    </li>
                    <li>
                        <label class="description" for="telephone">Телефон </label>
                        <div>
                            <input name="telephone" class="element text medium" type="text" maxlength="255" value="">
                        </div>
                    </li>
                    <li>
                        <label class="description" for="street1">Вулиця </label>
                        <div>
                            <input name="street1" class="element text medium" type="text" maxlength="255" value="">
                        </div>
                    </li>
                    <li>
                        <label class="description" for="city">Місто </label>
                        <div>
                            <input name="city" class="element text medium" type="text" maxlength="255" value="">
                        </div>
                    </li>
                    <li>
                        <label class="description" for="region">Регіон </label>
                        <div>
                            <input name="region" class="element text medium" type="text" maxlength="255" value="">
                        </div>
                    </li>
                    <li>
                        <label class="description" for="country_id">Країна </label>
                        <div>
                            <?= getBlock_Select_country(1); ?>
                        </div>
                    </li>

                    <li class="buttons right">
                        <input type="hidden" name="template_id" value="<?= $_POST['template_id'] ?>">
                        <input type="submit" name="insert_template" value="Зробити замовлення" class="button-order">
                    </li>
                </ul>
            </form>
        </div>
        <div class="col subm_col">
        <?php $res = get_templates($_POST['template_id']) ?>
            <?php while ($row = mysql_fetch_array($res, MYSQL_BOTH)) { ?>

                <div class="swatch">
                    <p class="title"><?= $row['title'] ?></p>
                    <p><?= $row['description'] ?></p>
                    <div class="price"><?= $row['price'] ?> грн.</div>

                    <div class="preview">
                        <a target="_blank" href="pics/<?= $row['image_preview'] ?>">
                            <img src="pics/<?= $row['image_swatch'] ?>">
                        </a>
                    </div>

                </div>

            <?php } ?>
        </div>
    </div>


    <div>
        <a href="order">< Повернутись до шаблонів</a>
    </div>

<?php } elseif($_POST['insert_template']) {

    $values = $_POST;
    unset($values['insert_template']);
    insert_customer($values);

} else { ?>

<div class="list">

    <?php $res = get_templates() ?>
    <?php while ($row = mysql_fetch_array($res, MYSQL_BOTH)) { ?>
        <div class="swatch">
            <p class="title"><?= $row['title'] ?></p>
            <p><?= $row['description'] ?></p>
            <div class="price"><?= $row['price'] ?> грн.</div>

            <div class="preview">
                <a target="_blank" href="pics/<?= $row['image_preview'] ?>">
                    <img src="pics/<?= $row['image_swatch'] ?>">
                </a>
            </div>

            <form name="templates_edit" method="post" enctype="multipart/form-data">
                <input type="hidden" name="template_id" value="<?= $row['template_id'] ?>">
                <input type="submit" name="select_template" value="Вибрати">
            </form>
        </div>
    <?php } ?>

</div>

<?php } ?>



