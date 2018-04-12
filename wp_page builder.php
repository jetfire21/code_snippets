#1=======
TEMPLATERA TEMPLATE MANAGER Powerful Template Manager for WPBakery Page Builder
дополнение, любую секцию с елементами можно сохранить как template а потом вставлять в любую страницу,
а потом изменяя один template он изменится на всех страницах! Волшебно просто!



/* ************* WPBakery page builder get user custom templates and display it any place ************** */

 //  original code wpbakery page builder for get user custom templates, only need known template_id  
 $template = 'alex-testimonials_949';
 var_dump(vc_frontend_editor()->setTemplateContent($template));

$wpdb_user_custom_templates = get_option('wpb_js_templates'); // wp by default unserialize all data
// print_r($wpdb_user_custom_templates);
// echo '<hr>';
// echo $wpdb_user_custom_templates[$name_template]['template'];
echo $wpdb_user_custom_templates['as21-famous-quotes_1352136749']['template'];
echo do_shortcode($wpdb_custom_templates['as21-famous-quotes_1352136749']['template']);
// maybe_unserialize($wpdb_custom_templates)

/* ************* WPBakery page builder get user custom templates and display it any place ************** */