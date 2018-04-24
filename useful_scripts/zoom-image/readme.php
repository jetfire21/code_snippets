<?php
/*
ZOOM ИЗОБРАЖЕНИЯ до оригинальных размеров и удобный его просмотр (1-вариант с увеличением,2-вариант с увеличением и перетаскиванием)
у wp шаблона indacity есть 2 вида простых зума изображения по умолчанию,но них один из них не подходит под наши цели
(take about 5 yours на поиск лучшего и простого решения с интеграцией в wp в виде шорткода)

альтернативы:

ilightbox
magnific-popup
fancybox
http://photoswipe.com/ - классный плагин

можно еще готовые плагины wp поискать

---------- использовани плагина ---------------------

https://desmonding.me/zooming/
хороший плагин,с очень нужными функциями, только вот странности в нем некоторые имеются, долго (часа 2 искал решение,в чем проблема)
*/

// add_action("induscity_before_footer", "as21_tmp_zoom");
function as21_tmp_zoom()
{
    ?>
<!--     
    <style>
        .grid {
            max-width: 600px;
            text-align: center;
        }

        img {
            width: 100%;
            height: auto;
            text-align: center;
        }
    </style>
 -->
    <div class='grid'>
        <img id="as21_img_zoom" src="http://optm.loc/BP/tmp/tcp-zoom-thumb.jpg" data-action="zoom"
             data-original="http://optm.loc/wp-content/uploads/2018/04/tcp-zoom.jpg">
    </div>

    <!-- Load Zooming library -->
    <!-- <script src="https://unpkg.com/zooming/build/zooming.min.js"></script> -->
    <!-- <script src="https://desmonding.me/zooming/build/zooming.js"></script> -->
    <!-- full unminify version -->
    <script src="<?php get_stylesheet_directory_uri();?>/libs/zooming/zooming.js"></script>

    <script>
        // Listen to images after DOM content is fully loaded
        // #1 - работает в minify версии,в unminify  почему-то нет!
        /*
        document.addEventListener('DOMContentLoaded', function () {
            new Zooming({
                // customSize: { width: 1300, height: 700 }
                // customSize: '100%',
                bgColor: 'black',
                zIndex: 99999999,
                scaleExtra: 1.3,
                scaleBase: 1.5
                // }).listen('.img-zoomable')
            }).listen('.img-default')
        })
		*/
		// #2 - работает в unminify версии,использовать только его (нет глюков с изображением, когда добавляешь атрибут к img data-original)
        const defaultZooming = new Zooming({
            bgColor: 'black',
            zIndex: 99999999,
            // customSize: { width: 800, height: 900 },
            scaleExtra: 1.3,
            // scaleBase:1.5
        })
        document.addEventListener('DOMContentLoaded', function () {
            defaultZooming.listen('#as21_img_zoom')
            defaultZooming.listen('#as21_img_zoom img')
        })
    </script>
    <?php
}
