
<main class="content__main">
  <h2 class="content__main-heading">Добавление задачи</h2>

  <form class="form"  action="add.php" method="post" enctype="multipart/form-data">
    <div class="form__row">
      <label class="form__label" for="name">Название <sup>*</sup></label>    
    <?php if(isset($errors['name'])) : ?>
      <p class="form__message"><?=$errors['name']?></p>
    <?php endif ?>
    <?php $classname = isset($errors['name']) ? "form__input--error" : "" ; $value_name = isset($task['name'])? $task['name'] : "";?>
      <input class="form__input <?=$classname?>" type="text" name="name" id="name" value="<?=$value_name?>" placeholder="Введите название">
    </div>

    <div class="form__row">
      <label class="form__label" for="project">Проект</label>
      <?php if(isset($errors['project'])) : ?>
      <p class="form__message"><?=$errors['project']?></p>
      <?php endif ?>
      <?php $classproject = isset($errors['project']) ? "form__input--error" : "" ; $value_project = isset($task['project'])? $task['project'] : "";?>
      <select class="form__input form__input--select <?=$classproject?>" name="project" id="project">
        <option><?=$value_project?></option>
        <option>Работа</option>
        <option>Учеба</option>
        <option>Авто</option>
        <option>Входящие</option>
        <option>Домашние дела</option>
      </select>
    </div>

    <div class="form__row">
      <label class="form__label" for="date_exec">Дата выполнения</label>
      <?php if(isset($errors['date_exec'])) : ?>
      <p class="form__message"><?=$errors['date_exec']?></p>
      <?php endif ?>
      <?php $classdate = isset($errors['date_exec']) ? "form__input--error" : "" ; $value_date = isset($task['date_exec'])? $task['date_exec'] : "";?>
      <input class="form__input form__input--date <?=$classdate?>" type="date" name="date_exec" id="date_exec" value="<?=$value_date?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
    </div>

    <div class="form__row">
      <label class="form__label" for="preview">Файл</label>
      <?php if(isset($errors['preview'])) : ?>
      <p class="form__message"><?=$errors['preview']?></p>
      <?php endif ?>
      <div class="form__input-file">
        <input class="visually-hidden" type="file" name="preview" id="preview" value="">

        <label class="button button--transparent" for="preview">
          <span>Выберите файл</span>
        </label>
      </div>
    </div>

    <div class="form__row form__row--controls">
      <input class="button" type="submit" name="" value="Добавить">
    </div>
  </form>
</main>
   
