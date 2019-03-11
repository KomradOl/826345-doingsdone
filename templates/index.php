<h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="index.php" method="post">
        <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
            <a href="/" class="tasks-switch__item">Повестка дня</a>
            <a href="/" class="tasks-switch__item">Завтра</a>
            <a href="/" class="tasks-switch__item">Просроченные</a>
        </nav>

        <a>
            <label class="checkbox">
                <input class="checkbox__input visually-hidden show_completed" name="show" type="checkbox" <?= $show_complete_tasks ? 'checked' : '' ?> >
                <span class="checkbox__text">Показывать выполненные</span>
            </label>
        </a>
    </div>

    <table class="tasks">
        
        <?php foreach ($tasks_list as $task): ?>
            <? if ($task['status'] == 1) : ?>
                <? $checked = "checked" ?>
            <? else : $checked = "unchecked" ?> 
            <?endif ?>
            <? if($show_complete_tasks != 0 || $task['status'] != 1) : ?>
                <?$complected = "task--completed"?>
            <tr class="tasks__item task <?print(warn_date($tasks_list, $task['date_exec']))?>">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1" <?=$checked ?>>
                        <span class="checkbox__text <?=$complected ?>"><a class="main-navigation__list-item-link" href="index.php?tabl=<?=$task['id']?>"><?=htmlspecialchars($task['name'])?></a></span>
                    </label>
                </td>
                <? if ($task['file'] !== 'NULL') : ?>
                <td class="task__file">  
                    <a class="download-link" href="<?=$task['file']?>"><?=$task['file']?>
                    </a>
                </td>
                <?else :?>
                <td class="task__file">              
                </td>
                <?endif?>
                <td class="task__date"><?=$task['date_exec']?></td>
            </tr>
            <? endif;?>       
        <?php endforeach;?>
    </table>
