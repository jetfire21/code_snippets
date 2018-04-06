#1------------
	Masked Input plugin for jQuery
	Copyright (c) 2007-2013 Josh Bush (digitalbush.com)
	Licensed under the MIT license (http://digitalbush.com/projects/masked-input-plugin/#license)
  валидация форм, провретка по маске,пример телефон (999) 999-99-99 postcode (999999) итд

#2-----------
	Как узнать, есть ли обработчик на элементе (теге) ?
	Если речь идет именно об инструментах разработчика, то в Хроме делаем так:
1.Кликаем правой кнопкой мыши по нужному элементу => Inspect element (или же F12, а затем находим и выделяем нужный элемент в дереве).
2.Далее в правой нижней колонке есть вкладка Event Listeners, там можно найти все обработчики
Соответственно для клика ищем событие click.
Если необходимо найти только обработчики событий текущего элемента, снимаем галочку Ancestors, если же возможно, что клик идет
по какому-то родителю (что довольно часто бывает), то галку оставляем.

#3-----------------
онлайн-сервис генерирующий продвинутый таймер
<script src="http://megatimer.ru/s/ffd43e767719884852dd978a8e4b9032.js"></script>

http://keith-wood.name/countdownRef.html
http://hilios.github.io/jQuery.countdown/

глянуть таймер здесь http://potolki.expert/

#4-----------------
Скрипт плавной прокрутки без якоря в адресной строке

http://smartlanding.biz/skript-plavnoj-prokrutki.html

<script>
  $(document).ready(function(){
    $("a[href*=#]").on("click", function(e){
        var anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $(anchor.attr('href')).offset().top
        }, 777);
        e.preventDefault();
        return false;
    });
});
</script>