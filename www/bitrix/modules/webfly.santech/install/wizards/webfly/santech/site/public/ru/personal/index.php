<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Персональный раздел");
?>
<div class="wrapper">
  <div class="container">
    <div class="container-hold">
      <div class="myContent">
        <div class="bx_page">
			<h1>Личный кабинет</h1>
          <p>В личном кабинете Вы можете проверить текущее состояние корзины, ход выполнения Ваших заказов, просмотреть или изменить личную информацию, а также подписаться на новости и другие информационные рассылки. </p>
          <div>
            <h2 class="h2norm">Личная информация</h2>
            <a href="profile/">Изменить регистрационные данные</a>
          </div>
          <div>
            <h2 class="h2norm">Заказы</h2>
            <a href="order/">Ознакомиться с состоянием заказов</a><br/>
            <a href="cart/">Посмотреть содержимое корзины</a><br/>
            <a href="order/">Посмотреть историю заказов</a><br/>
          </div>
          <div>
            <h2 class="h2norm">Подписка</h2>
            <a href="subscribe/">Изменить подписку</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
