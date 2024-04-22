<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>



    <?php
    if (!empty($massages))
    {
print('<div id="messages">');
foreach($messages as $message)
{
    print($message);
}
print('</div>');
    }
    
    ?>
    <body>
    <div class="fon1 tab mt-4 mb-4 shadow rounded" id="quf">
        <form action="index.php" method="POST" class="row mx-5 my-2 gy-1">
            <div class="form_item form-group">
                <label for="formName" style="color: black;">ФИО:<br> <input name="fio" <?php if ($errors['fio'] || $errors['symbolfio_error']) {
                                      print 'class="error"';
                                    } ?> value="<?php print $values['fio']; ?>"> 
                </label>
            </div>
            <div class="form_item form-group">
                <label>Номер телефона:<br/>
                <input name="tel" <?php if ($errors['tel'] || $errors['symboltel_error']) {
                                    print 'class="error"';
                                } ?> value="<?php print $values['tel']; ?>"> 
                </label>
            </div>

            <div class="form_item form-group">
                <label>Email:<br/>
                <input name="email" <?php if ($errors['email']) {
                                    print 'class="error"';  
                                    } ?> value="<?php print $values['email']; ?>" type="email">
                </label>
            </div>
            <div class="form_item form-group">
                <label for="formDate" style="color: black;">Дата рождения:<br/>
                <input name="date" <?php if ($errors['date']) {
                              print 'class="error"';
                            } ?> value="<?php print $values['date']; ?>" type="date">
                </label>
            </div>


            <div class="form_item form-group">
                <label style="color: black;">Пол:</label><br>
                <div class="form-check1 form-check-inline">
                    <input type="radio"  name="gen" <?php 
                    if ($errors['gen']) {print 'class="error"' ;} 
                    if( $values['gen'] == 'm') {print "checked='checked'";}?> value="m"> мужской</label>
                </div>
                <div class="form-check1 form-check-inline">
                    <input type="radio" name="gen" <?php 
                    if ($errors['gen']) {print 'class="error"' ;} 
                    if( $values['gen'] == 'f') {print "checked='checked'";}?> value="f"> женский</label>
                </div>
            </div>            

            <div class="form_item form-group">
                <label style="color: black;">Любимый язык программирования:</label><br/>
                <select name="languages[]" multiple="multiple" <?php if ($errors['languages_error']) {
                                  print 'class="error"';
                                } ?>>
                    <option value="Pascal"<?php echo is_array($languages) &&  in_array('1', $languages) ? 'selected' : ''; ?>>Pascal</option>
                    <option value="C" <?php echo is_array($languages) && in_array('2', $languages) ? 'selected' : ''; ?> >C</option>
                    <option value="C_plus_plus" <?php echo is_array($languages) && in_array('3', $languages) ? 'selected' : ''; ?>>C++</option>
                    <option value="JavaScript" <?php echo is_array($languages) && in_array('4', $languages) ? 'selected' : ''; ?>>JavaScript</option>
                    <option value="PHP" <?php echo is_array($languages) && in_array('5', $languages) ? 'selected' : ''; ?>>PHP</option>
                    <option value="Python" <?php echo is_array($languages) &&in_array('6', $languages) ? 'selected' : ''; ?>>Python</option>
                    <option value="Java" <?php echo is_array($languages) && in_array('7', $languages) ? 'selected' : ''; ?>>Java</option>
                    <option value="Haskel" <?php echo is_array($languages) && in_array('8', $languages) ? 'selected' : ''; ?>>Haskel</option>
                    <option value="Clojure" <?php echo is_array($languages) && in_array('9', $languages) ? 'selected' : ''; ?>>Clojure</option>
                    <option value="Prolog" <?php echo is_array($languages) && in_array('10', $languages) ? 'selected' : ''; ?>>Prolog</option>
                    <option value="Scala" <?php echo is_array($languages) && in_array('11', $languages) ? 'selected' : ''; ?>>Scala</option>
                </select> 
            </div>


            <div class="form_item form-group">
                <label for="formMessage" style="color: black;">Биография:</label><br/>
                <textarea name="bio" <?php if ($errors['bio']) {
                                  print 'class="error"';
                                } ?>><?php print $values['bio']; ?></textarea>
            </div>

            <div class="form_item form-group">
                <div class="form-check">
                    <label class="checkbox_label form-check-label" for="agree">С контрактом ознакомлен(а)</label>
                    <input id="agree" type="checkbox" name="agree" class="checkbox_input form-check-input">
                </div>
            </div>

            
        <div class="form_item form-group">
                <label class="col-12"><input type="submit" value="Сохранить" name="submit" class="submit btn-dark"></label>
            </div>
        </form>
    </div>
</body>
