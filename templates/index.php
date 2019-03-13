<h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="index.php" method="post">
        <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="index.php?task_choice=<?=1?>" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
            <a href="index.php?task_choice=<?=2?>" class="tasks-switch__item">Повестка дня</a>
            <a href="index.php?task_choice=<?=3?>" class="tasks-switch__item">Завтра</a>
            <a href="index.php?task_choice=<?=4?>" class="tasks-switch__item">Просроченные</a>
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
            
            <?if ($task_choice !== NULL && $tab == NULL) : ?>
            <?$show_tasks = choice_date($task['date_exec'], $task_choice)?>
            <?else : $show_tasks = 0 ?>
            <?endif?>
            
            <? if($show_complete_tasks == 1 || $task['status'] == 0 && $show_tasks !== 1) : ?>
                <?$complected = "task--completed"?>
            <tr class="tasks__item task <?print(warn_date($task['date_exec']))?>">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <a href="index.php?stat_task=<?=$task['id']?>">
                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1" <?=$checked ?>>
                        <span class="<?=$complected ?> checkbox__text main-navigation__list-item-link "><?=htmlspecialchars($task['name'])?></span></a>
                    </label>
                </td>
                <? if ($task['file'] !== NULL) : ?>
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
