<?php /*тут знаходиться наше меню*/ ?>
<div class="menu">
<ul>
    <?php FOREACH(Pages::getPages() as $key=>$p): ?>
        <?php IF($p['menu']): ?>
            <li><a href="/<?= $key ?>"><?= $p['label'] ?></a></li>
        <?php ENDIF; ?>
    <?php ENDFOREACH;?>
</ul>
</div>