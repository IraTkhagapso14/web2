<form action="" method="POST">
  <label for="fio">ФИО:</label>
  <input type="text" id="fio" name="fio" required /><br>

  <label for="tel">Телефон:</label>
  <input type="tel" id="tel" name="tel" pattern="[0-9]{10}" required /><br>

  <label for="email">Email:</label>
  <input type="email" id="email" name="email" required /><br>
<label>Выберите ЯП<br/></label> 
<select multiple="multiple" name="choosing"> 
<option>C++</option> 
<option>Pascal</option> 
<option>JavaScript</option> 
</select></br> 

  
  <label>Пол:</label>
  <input type="radio" id="male" name="gender" value="male">
  <label for="male">Мужской</label>
  <input type="radio" id="female" name="gender" value="female">
  <label for="female">Женский</label><br>

  <label for="bio">О себе:</label>
  <textarea id="bio" name="bio"></textarea><br>

  <input type="checkbox" id="contract" name="contract" value="1" required>
  <label for="contract">С контрактом ознакомлен(а)</label><br>

  <select id="year" name="year">
    <?php 
    for ($i = 1922; $i <= 2022; $i++) {
      printf('<option value="%d">%d год</option>', $i, $i);
    }
    ?>
  </select><br>

  <button type="submit">Сохранить</button>
</form>
