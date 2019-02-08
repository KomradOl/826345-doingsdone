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

        <label class="checkbox">
            <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
            <?php if($show_complete_tasks == 1) : ?>
                <input class="checkbox__input visually-hidden show_completed" type="checkbox" checked>
            <?php endif; ?>
            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>

    <table class="tasks">
        <tr class="">
            <th>Задачи</th>
            <th>Дата выполнения</th>
            <th>Категории</th>
            <th>Выполнен</th>
        </tr>
        <?php foreach ($tasks_list as $task): ?>
            <? extract($task); ?> 

            <? $dt_now = date_create(); ?>
            <? $dt_end = date_create($date); ?>
            <? $dt_diff = date_interval_format(date_diff($dt_end, $dt_now), "%d"); ?>   
            <? if($show_complete_tasks != 0 || !$completed) : ?>
                <tr class="tasks__item <?=$completed ? 'task--completed' : $dt_diff <= 1 ? 'task--important' :  '' ?>">
                    <td><?=$task ?></td>
                    <td class="task__date"><?=$date ?></td>
                    <td><?=$category ?></td>
                    <td><?=$completed ? 'Да' : 'Нет' ?></td>
                </tr>
            <? endif;?>        
        <?php endforeach;?>
    </table>
