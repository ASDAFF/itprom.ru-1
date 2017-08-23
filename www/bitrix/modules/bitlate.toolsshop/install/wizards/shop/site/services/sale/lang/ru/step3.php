<?
$MESS["BUY1CLICK_CART"] = "Купить в 1 клик из корзины";
$MESS["BUY1CLICK"] = "Купить в 1 клик";


$MESS["BUY1CLICK_CART_DESC"] = "#USER_NAME# - Имя пользователя
#USER_PHONE# - Телефон
#CART_ITEMS# - Заказы";

$MESS["BUY1CLICK_DESC"] = "#ID# - Ид
#IBLOCK_ID# - Ид инфоблока 
#NAME#  - Имя
#DETAIL_PAGE_URL# - Детальная страница
#OFFER_ID#  - Ид заказа
#OFFER_NAME#  - Название заказа
#PRICE# - Цена
#USER_NAME# - Имя пользователя
#USER_PHONE# - Телефон пользователя";

$MESS["BUY1CLICK_CART_MESS"] = "
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='ru' lang='ru'>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=UTF-8'/>
	<style>
		body
		{
			font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style>
</head>
<body>
<table cellpadding='0' cellspacing='0' width='850' style='background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;' border='1' bordercolor='#d1d1d1'>
	<tr>
		<td height='83' width='850' bgcolor='#eaf3f5' style='border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;'>
			<table cellpadding='0' cellspacing='0' border='0' width='100%'>
				<tr>
					<td bgcolor='#ffffff' height='75' style='font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;'>Произведена покупка в 1 клик из корзины на сайте #SITE_NAME#</td>
				</tr>
				<tr>
					<td bgcolor='#bad3df' height='11'></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width='850' bgcolor='#f7f7f7' valign='top' style='border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;'>
			<p style='margin-top: 0; margin-bottom: 20px; line-height: 20px;'>Пользователь: #USER_NAME# <br />
<br />
Телефон: #USER_PHONE#.<br />
<p style='margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;'>Состав корзины:</a></p>
#CART_ITEMS#
		</td>
	</tr>
</table>
</body>
</html>";

$MESS["BUY1CLICK_CART_SUBJECT"] = "#SITE_NAME#:  Покупка в 1 клик в корзине";

$MESS["BUY1CLICK_SUBJECT"] = "#SITE_NAME#:  Покупка в 1 клик";
$MESS["BUY1CLICK_MESS"] = "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='ru' lang='ru'>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=UTF-8'/>
	<style>
		body
		{
			font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
			font-size: 14px;
			color: #000;
		}
	</style>
</head>
<body>
<table cellpadding='0' cellspacing='0' width='850' style='background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;' border='1' bordercolor='#d1d1d1'>
	<tr>
		<td height='83' width='850' bgcolor='#eaf3f5' style='border: none; padding-top: 23px; padding-right: 17px; padding-bottom: 24px; padding-left: 17px;'>
			<table cellpadding='0' cellspacing='0' border='0' width='100%'>
				<tr>
					<td bgcolor='#ffffff' height='75' style='font-weight: bold; text-align: center; font-size: 26px; color: #0b3961;'>Произведена покупка в 1 клик  на сайте #SITE_NAME#</td>
				</tr>
				<tr>
					<td bgcolor='#bad3df' height='11'></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width='850' bgcolor='#f7f7f7' valign='top' style='border: none; padding-top: 0; padding-right: 44px; padding-bottom: 16px; padding-left: 44px;'>
			<p style='margin-top:30px; margin-bottom: 28px; font-weight: bold; font-size: 19px;'>Товар: <a href='http://#SERVER_NAME##DETAIL_PAGE_URL#'>#NAME#</a>,</p>
			<p style='margin-top: 0; margin-bottom: 20px; line-height: 20px;'>Пользователь: #USER_NAME# <br />
<br />
Телефон: #USER_PHONE#.<br />
<br />
Стоимость товара: #PRICE#<br />
Название торгового предложения: #OFFER_NAME#<br />
ID товара: #ID#<br />
ID торгового предложения: #OFFER_ID#<br />
ID инфобока:#IBLOCK_ID#<br />
<br />
Ссылка на товар в административной панели: <a href='http://#SERVER_NAME#/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=#IBLOCK_ID#&type=catalog&ID=#ID#&lang=ru#'>#NAME#</a><br />
<br />
</p>
		</td>
	</tr>
</table>
</body>
</html>";

?>