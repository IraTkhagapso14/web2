<form action="" method="POST">
 <label>Введите имя <br/>
<input type="text" placeholder="Введите свое имя" name="thename">
</label><br>
<label>Введите свой телефон<br/>
<input type="tel" placeholder="Введите свой телефон" name="thephone">
</label><br>
<label> Введите свой e-mail<br/>
<input type="email" placeholder="Введите e-mail" name="youremail"></label><br/>
<label>Введите дату рождения<br/>
<input type="data" placeholder="Введите дату рождения" name="givebirth"></label><br/>
<label>Выберите пол<br/>
<input type="radio" name="sex" value="female">Женский<br/>
<input type="radio" name="sex" value="male">Мужской<br/></label><br/>
<label>Выберите ЯП<br/></label>
<select multiple="multiple" name="choosing">
<option>C++</option>
<option>Pascal</option>
<option>JavaScript</option>
</select></br>
<label>Биография<br/>
<textarea placeholder="Напишите биографию" name="biography"></textarea>
</label></br>
<label>Чекбокс</label><br/>
<input type="checkbox" name="checkboxx"><label> С контрактом ознакомлен(а)
</label><br/>
<button>Сохранить</button>
  <input name="fio" />
  <select name="year">
    <?php 
    for ($i = 1922; $i <= 2022; $i++) {
      printf('<option value="%d">%d год</option>', $i, $i);
    }
    ?>
  </select>

  
  <input type="submit" value="ok" />
</form>
