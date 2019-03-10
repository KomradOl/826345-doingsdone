
  <main class="content__main">
    <h2 class="content__main-heading">Добавление проекта</h2>

    <form class="form"  action="project_add.php" method="post">
      <div class="form__row">
        <label class="form__label" for="project_name">Название <sup>*</sup></label>
        <?php if(isset($errors['name'])) : ?>
        <p class="form__message"><?=$errors['name']?></p>
        <?php endif ?>
        <?php $classname = isset($errors['name']) ? "form__input--error" : "" ; $value_name = isset($project['name'])? $project['name'] : "";?>
        <input class="form__input <?=$classname ?>" type="text" name="name" id="project_name" value="<?=$value_name ?>" placeholder="Введите название проекта">
      </div>

      <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Добавить">
      </div>
    </form>
  </main>
   
