<header class="main-header">
            <a href="/">
                <img src="img/logo.png" width="153" height="42" alt="Логотип Дела в порядке">
            </a>

            <div class="main-header__side">
                <a class="main-header__side-item button button--plus open-modal" href="pages/form-task.html">Добавить задачу</a>

                <div class="main-header__side-item user-menu">
                    <div class="user-menu__image">
                        <img src="img/user.png" width="40" height="40" alt="Пользователь">
                    </div>

                    <div class="user-menu__data">
                        <p><?=$user_name;?></p>

                        <a href="#">Выйти</a>
                    </div>
                </div>
            </div>
        </header>

        <div class="content">
            <section class="content__side">
                <h2 class="content__side-heading">Проекты</h2>
                

                <nav class="main-navigation">
                    <ul class="main-navigation__list">
                        <?php foreach($categories as $cat): ?>    
                        <li class="main-navigation__list-item">
                            <a class="main-navigation__list-item-link" href="index.php?tab=<?=$cat['id']?>"><?=$cat['name'];?></a>
                            <span class="main-navigation__list-item-count"><?=output_namber($tasks_list, $cat['id'])?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>

                <a class="button button--transparent button--plus content__side-button"
                   href="pages/form-project.html" target="project_add">Добавить проект</a>
            </section>

            <main class="content__main"><?=$content; ?></main>
        </div>